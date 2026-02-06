<?php

namespace MeteoFlow\Laravel\Tests;

use MeteoFlow\ClientConfig;
use MeteoFlow\WeatherClient;
use MeteoFlow\WeatherClientInterface;
use PHPUnit\Framework\Attributes\Test;

class ServiceProviderTest extends TestCase
{
    #[Test]
    public function it_registers_client_config(): void
    {
        $config = $this->app->make(ClientConfig::class);

        $this->assertInstanceOf(ClientConfig::class, $config);
        $this->assertEquals('test-api-key', $config->getApiKey());
    }

    #[Test]
    public function it_registers_weather_client_interface(): void
    {
        $client = $this->app->make(WeatherClientInterface::class);

        $this->assertInstanceOf(WeatherClientInterface::class, $client);
        $this->assertInstanceOf(WeatherClient::class, $client);
    }

    #[Test]
    public function it_registers_weather_client_as_singleton(): void
    {
        $client1 = $this->app->make(WeatherClientInterface::class);
        $client2 = $this->app->make(WeatherClientInterface::class);

        $this->assertSame($client1, $client2);
    }

    #[Test]
    public function it_resolves_weather_client_by_alias(): void
    {
        $client = $this->app->make('meteoflow');

        $this->assertInstanceOf(WeatherClient::class, $client);
    }

    #[Test]
    public function it_applies_config_values(): void
    {
        $this->app['config']->set('meteoflow.base_url', 'https://custom.api.com');
        $this->app['config']->set('meteoflow.timeout', 30);
        $this->app['config']->set('meteoflow.connect_timeout', 15);
        $this->app['config']->set('meteoflow.debug', true);

        // Clear singleton to force re-creation
        $this->app->forgetInstance(ClientConfig::class);

        $config = $this->app->make(ClientConfig::class);

        $this->assertEquals('https://custom.api.com', $config->getBaseUrl());
        $this->assertEquals(30, $config->getTimeoutSeconds());
        $this->assertEquals(15, $config->getConnectTimeoutSeconds());
        $this->assertTrue($config->isDebug());
    }
}
