<?php
namespace Worfect\Notice;

use Illuminate\Support\ServiceProvider;

class NoticeServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('notice', function () {
            return $this->app->make('Worfect\Notice\Notifier');
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'notice');

        $this->publishes([
            __DIR__ . '/resources/views/' => resource_path('views/vendor/notice/'),
            __DIR__ . '/resources/js/messages.js' => resource_path('js/vendor/notice/messages.js'),
        ]);
    }
}
