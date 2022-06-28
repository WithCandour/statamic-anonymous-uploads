<?php

namespace WithCandour\StatamicAnonymousUploads\Http\Controllers\Actions;

use Statamic\Facades\AssetContainer;
use Statamic\Http\Controllers\Controller;
use WithCandour\StatamicAnonymousUploads\Http\Requests\Actions\DownloadRequest;

class DownloadController extends Controller
{
    /**
     * Download an anonymized file
     */
    public function download(DownloadRequest $request)
    {
        $this->authorize('download anonymized files');

        $fileId = $request->fileId();

        if (!$fileId) {
            return abort(404);
        }

        [$container_id, $path] = explode('::', $fileId);

        $parts = explode('/', $path);
        $filename = end($parts);

        /**
         * @var \Statamic\Contracts\Assets\AssetContainer|null
         */
        $container = AssetContainer::find($container_id);

        if (!$container) {
            return abort(404);
        }

        $disk = $container->disk();

        $assetExists = $disk->exists($path);

        if (!$assetExists) {
            return abort(404);
        }

        $headers = [
            'Content-type' => $disk->mimeType($path),
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        return response($disk->get($path), 200, $headers);

    }
}
