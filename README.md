# MeteoFlow Laravel

Laravel integration for the MeteoFlow Weather API SDK.

## Requirements

- PHP 7.1+
- Laravel 5.5 - 12.x

## Installation

```bash
composer require meteoflow/laravel
```

The package uses Laravel's auto-discovery, so the service provider and facade will be registered automatically.

## Configuration

Publish the configuration file:

```bash
php artisan vendor:publish --tag=meteoflow-config
```

Add your API key to your `.env` file:

```env
METEOFLOW_API_KEY=your-api-key-here
```

### Available Configuration Options

| Option | Environment Variable | Default |
|--------|---------------------|---------|
| `api_key` | `METEOFLOW_API_KEY` | (required) |
| `base_url` | `METEOFLOW_BASE_URL` | `https://api.meteoflow.com` |
| `timeout` | `METEOFLOW_TIMEOUT` | `10` |
| `connect_timeout` | `METEOFLOW_CONNECT_TIMEOUT` | `5` |
| `debug` | `METEOFLOW_DEBUG` | `false` |

## Usage

### Using the Facade

```php
use MeteoFlow\Laravel\Facades\MeteoFlow;
use MeteoFlow\Location\LocationSlug;
use MeteoFlow\Location\LocationCoords;

// Get current weather by location slug
$location = new LocationSlug('london-gb');
$weather = MeteoFlow::current($location);

echo $weather->getWeather()->getTemperature(); // 15.5
echo $weather->getWeather()->getDescription(); // "Partly cloudy"

// Get current weather by coordinates
$location = new LocationCoords(51.5074, -0.1278);
$weather = MeteoFlow::current($location);

// Get daily forecast
$forecast = MeteoFlow::forecastDaily($location);

foreach ($forecast->getForecasts() as $day) {
    echo $day->getDate() . ': ' . $day->getTemperatureMax() . '°C';
}
```

### Using Dependency Injection

```php
use MeteoFlow\WeatherClientInterface;
use MeteoFlow\Location\LocationSlug;

class WeatherController extends Controller
{
    public function show(WeatherClientInterface $client)
    {
        $location = new LocationSlug('london-gb');
        $weather = $client->current($location);

        return view('weather', [
            'temperature' => $weather->getWeather()->getTemperature(),
            'description' => $weather->getWeather()->getDescription(),
        ]);
    }
}
```

### Available Methods

```php
// Current weather
MeteoFlow::current(Location $location): CurrentWeatherResponse

// Hourly forecast
MeteoFlow::forecastHourly(Location $location, ?ForecastOptions $options = null): HourlyForecastResponse

// 3-hourly forecast
MeteoFlow::forecast3Hourly(Location $location, ?ForecastOptions $options = null): ThreeHourlyForecastResponse

// Daily forecast
MeteoFlow::forecastDaily(Location $location, ?ForecastOptions $options = null): DailyForecastResponse
```

### Forecast Options

```php
use MeteoFlow\Options\ForecastOptions;
use MeteoFlow\Options\Units;

$options = new ForecastOptions();
$options = $options
    ->withDays(14)
    ->withUnits(Units::IMPERIAL)
    ->withLang('de');

$forecast = MeteoFlow::forecastDaily($location, $options);
```

## Testing

```bash
composer test
```

## License

MIT License. See [LICENSE](LICENSE) for more information.
