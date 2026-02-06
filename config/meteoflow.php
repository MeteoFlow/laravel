<?php

return [
    /*
    |--------------------------------------------------------------------------
    | MeteoFlow API Key
    |--------------------------------------------------------------------------
    |
    | Your MeteoFlow API key for authentication. You can obtain an API key
    | by registering at https://meteoflow.com
    |
    */
    'api_key' => env('METEOFLOW_API_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Base URL
    |--------------------------------------------------------------------------
    |
    | The base URL for MeteoFlow API requests. You typically don't need to
    | change this unless you're using a custom or staging endpoint.
    |
    */
    'base_url' => env('METEOFLOW_BASE_URL', 'https://api.meteoflow.com'),

    /*
    |--------------------------------------------------------------------------
    | Request Timeout
    |--------------------------------------------------------------------------
    |
    | The maximum number of seconds to wait for API responses.
    |
    */
    'timeout' => env('METEOFLOW_TIMEOUT', 10),

    /*
    |--------------------------------------------------------------------------
    | Connection Timeout
    |--------------------------------------------------------------------------
    |
    | The maximum number of seconds to wait when establishing a connection.
    |
    */
    'connect_timeout' => env('METEOFLOW_CONNECT_TIMEOUT', 5),

    /*
    |--------------------------------------------------------------------------
    | Debug Mode
    |--------------------------------------------------------------------------
    |
    | Enable debug mode to log API requests and responses.
    |
    */
    'debug' => env('METEOFLOW_DEBUG', false),
];
