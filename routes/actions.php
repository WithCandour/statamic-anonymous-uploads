<?php

use Illuminate\Support\Facades\Route;

Route::namespace('\WithCandour\StatamicAnonymousUploads\Http\Controllers\Actions')
    ->group(function () {

        // /!/statamic-anonymous-uploads/forms/{form}
        Route::post('forms/{anonymizedUploadForm}', 'FormController@submit');

        // /!/statamic-anonymous-uploads/download
        Route::get('download', 'DownloadController@download');

    });

