<?php

namespace WithCandour\StatamicAnonymousUploads;

use Illuminate\Support\Facades\Route;
use Statamic\Exceptions\NotFoundHttpException;
use Statamic\Facades\Form;
use Statamic\Facades\Permission;
use Statamic\Providers\AddonServiceProvider;
use Statamic\Support\Str;
use WithCandour\StatamicAnonymousUploads\Fieldtypes\AnonymousUploadsFieldtype;

class ServiceProvider extends AddonServiceProvider
{

    /**
     * @inheritDoc
     */
    protected $fieldtypes = [
        AnonymousUploadsFieldtype::class
    ];

    /**
     * @inheritDoc
     */
    protected $routes = [
        'actions' => __DIR__ . '/../routes/actions.php',
    ];

    /**
     * @inheritDoc
     */
    protected $scripts = [
        __DIR__ . '/../resources/public/js/statamic-anonymous-uploads.js',
    ];

    /**
     * Boot everything for this addon.
     *
     * @return void
     */
    public function bootAddon()
    {
        $this
            ->bootViews()
            ->bootPermissions()
            ->bootTranslations();

        $this->bindFormRoute();
    }

    /**
     * Load the views required for this addon.
     *
     * @return self
     */
    public function bootViews(): self
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'statamic-anonymous-uploads');
        return $this;
    }

    /**
     * Configure the permissions settings for this addon.
     *
     * @return self
     */
    public function bootPermissions(): self
    {
        Permission::group('statamic-anonymous-uploads', __('statamic-anonymous-uploads::general.name.short'), function () {
            Permission::register('download anonymized files')
                ->label(__('statamic-anonymous-uploads::files.permissions.download'));
        });
        return $this;
    }

    /**
     * Configure the translations for this addon.
     *
     * @return self
     */
    public function bootTranslations(): self
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'statamic-anonymous-uploads');
        return $this;
    }

    /**
     * Bind the forms route to resolve the form parameter of our controller
     * to an instance of a Statamic form if it exists.
     */
    protected function bindFormRoute()
    {
        Route::bind('anonymizedUploadForm', function ($handle, $route = null) {
            if (!Str::startsWith($route->uri(), '!/statamic-anonymous-uploads/')) {
                return $handle;
            }

            throw_unless(
                $form = Form::find($handle),
                new NotFoundHttpException("Form [$handle] not found.")
            );

            return $form;
        });
    }
}
