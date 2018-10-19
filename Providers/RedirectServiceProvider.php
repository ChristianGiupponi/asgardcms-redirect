<?php

namespace Modules\Redirect\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Redirect\Events\Handlers\RegisterRedirectSidebar;
use Modules\Redirect\Http\Middleware\CheckForRedirect;

class RedirectServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration;
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
    * @var array
    */
    protected $middleware = [
        'check-redirect' => CheckForRedirect::class,
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
        $this->app['events']->listen(BuildingSidebar::class, RegisterRedirectSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('redirects', array_dot(trans('redirect::redirects')));
            // append translations
        });
    }

    public function boot()
    {
        $this->registerMiddleware();

        $this->publishConfig('redirect', 'permissions');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Redirect\Repositories\RedirectRepository',
            function () {
                $repository = new \Modules\Redirect\Repositories\Eloquent\EloquentRedirectRepository(new \Modules\Redirect\Entities\Redirect());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Redirect\Repositories\Cache\CacheRedirectDecorator($repository);
            }
        );
        // add bindings
    }

    private function registerMiddleware()
    {
        foreach ($this->middleware as $name => $class) {
            $this->app['router']->aliasMiddleware($name, $class);
        }
    }
}
