<?php

namespace MeteoFlow\Laravel\Tests;

use MeteoFlow\Laravel\Facades\MeteoFlow;
use MeteoFlow\WeatherClient;
use PHPUnit\Framework\Attributes\Test;

class FacadeTest extends TestCase
{
    #[Test]
    public function facade_resolves_to_weather_client(): void
    {
        $resolved = MeteoFlow::getFacadeRoot();

        $this->assertInstanceOf(WeatherClient::class, $resolved);
    }

    #[Test]
    public function facade_provides_access_to_client_config(): void
    {
        $client = MeteoFlow::getFacadeRoot();

        $this->assertEquals('test-api-key', $client->getConfig()->getApiKey());
    }

    #[Test]
    public function facade_exposes_geography_methods(): void
    {
        $client = MeteoFlow::getFacadeRoot();

        $this->assertTrue(method_exists($client, 'countries'));
        $this->assertTrue(method_exists($client, 'citiesByCountry'));
        $this->assertTrue(method_exists($client, 'searchCities'));
    }
}
