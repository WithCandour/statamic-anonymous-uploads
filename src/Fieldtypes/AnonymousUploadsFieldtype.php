<?php

namespace WithCandour\StatamicAnonymousUploads\Fieldtypes;

use Illuminate\Support\Facades\Crypt;
use Statamic\Fieldtypes\Assets\Assets as AssetsFieldtype;
use Statamic\Support\Arr;
use Statamic\Facades\Url;

class AnonymousUploadsFieldtype extends AssetsFieldtype
{
    protected $canCreate = false;

    public function preProcess($values)
    {
        return $values;
    }

    /**
     * @inheritDoc
     */
    public function process($data)
    {
        $actionRoute = config('statamic.routes.action', '!');

        $urls = \collect($data)
            ->map(fn($id) => '/' . $actionRoute . '/statamic-anonymous-uploads/download?key=' . Crypt::encryptString($id));

        return $this->config('max_files') === 1 ? $urls->first() : $urls->all();
    }

    /**
     * @inheritDoc
     */
    public function augment($values)
    {
        $values = collect(Arr::wrap($values))
            ->map(function($value) {
                return Url::makeAbsolute($value);
            });

        return $this->config('max_files') === 1 ? $values->first() : $values->all();
    }

    /**
     * @inheritDoc
     */
    public function shallowAugment($values)
    {
        $values = collect(Arr::wrap($values));

        return $this->config('max_files') === 1 ? $values->first() : $values->all();
    }

    /**
     * @inheritDoc
     */
    public function view()
    {
        $default = 'statamic-anonymous-uploads::forms.fields.anonymous_uploads';

        return view()->exists($default)
            ? $default
            : 'statamic::forms.fields.default';
    }
}
