<?php

namespace MeteoFlow\Laravel;

use Illuminate\Support\ServiceProvider;
use MeteoFlow\ClientConfig;
use MeteoFlow\WeatherClient;
use MeteoFlow\WeatherClientInterface;

class MeteoFlowServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/meteoflow.php',
            'meteoflow'
        );

        $this->app->singleton(ClientConfig::class, function ($app) {
            $config = $app['config']['meteoflow'];

            $clientConfig = new ClientConfig($config['api_key']);

            if (!empty($config['base_url'])) {
                $clientConfig = $clientConfig->withBaseUrl($config['base_url']);
            }

            if (isset($config['timeout'])) {
                $clientConfig = $clientConfig->withTimeout($config['timeout']);
            }

            if (isset($config['connect_timeout'])) {
                $clientConfig = $clientConfig->withConnectTimeout($config['connect_timeout']);
            }

            if (isset($config['debug'])) {
                $clientConfig = $clientConfig->withDebug($config['debug']);
            }

            return $clientConfig;
        });

        $this->app->singleton(WeatherClientInterface::class, function ($app) {
            return new WeatherClient($app->make(ClientConfig::class));
        });

        $this->app->alias(WeatherClientInterface::class, WeatherClient::class);
        $this->app->alias(WeatherClientInterface::class, 'meteoflow');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/meteoflow.php' => $this->configPath('meteoflow.php'),
            ], 'meteoflow-config');
        }
    }

    /**
     * Get the config path.
     *
     * @param string $path
     * @return string
     */
    protected function configPath($path = '')
    {
        if (function_exists('config_path')) {
            return config_path($path);
        }

        return $this->app->basePath() . '/config' . ($path ? '/' . $path : '');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            ClientConfig::class,
            WeatherClientInterface::class,
            WeatherClient::class,
            'meteoflow',
        ];
    }
}
