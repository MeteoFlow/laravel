<?php

namespace MeteoFlow\Laravel\Facades;

use Illuminate\Support\Facades\Facade;
use MeteoFlow\Location\Location;
use MeteoFlow\Options\ForecastOptions;
use MeteoFlow\Response\CitiesResponse;
use MeteoFlow\Response\CountriesResponse;
use MeteoFlow\Response\CurrentWeatherResponse;
use MeteoFlow\Response\DailyForecastResponse;
use MeteoFlow\Response\HourlyForecastResponse;
use MeteoFlow\Response\ThreeHourlyForecastResponse;
use MeteoFlow\WeatherClientInterface;

/**
 * @method static CurrentWeatherResponse current(Location $location)
 * @method static HourlyForecastResponse forecastHourly(Location $location, ForecastOptions $options = null)
 * @method static ThreeHourlyForecastResponse forecast3Hourly(Location $location, ForecastOptions $options = null)
 * @method static DailyForecastResponse forecastDaily(Location $location, ForecastOptions $options = null)
 * @method static CountriesResponse countries()
 * @method static CitiesResponse citiesByCountry(string $countryCode)
 * @method static CitiesResponse searchCities(string $query, int|null $limit = null)
 *
 * @see \MeteoFlow\WeatherClient
 */
class MeteoFlow extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return WeatherClientInterface::class;
    }
}
