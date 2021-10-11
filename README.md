# Laravel Http Driver
The library allows to create and assign an API connection to Laravel 8 Eloquent models and use Laravel query builder to build a query string and get data as if you get data from a database connection. It also allows to use Eloquent relationships.

Once developers define the configuration of a new API connection and make the related model classes use that connection, they don't need to think about API calls, authentication, etc. They just work with those models as if they are regular models that have a MySQL connection. However, the library only supports retrieving data from an API service.

The package must be installed both on the source and destination Laravel instance.

# Configuration
In file `config\database.php` add below entry in connections and setup accordingly. Below is an example

```
'connections' => [
  ...
  'http_msms' => [
        'driver' => 'httpquery',
        'database' => env('APP_MSMS_URL', 'https://api.sms.to/'),
        'port' => env('APP_MSMS_PORT', ''),
        'api_key' => env('APP_MSMS_API_KEY', 'api_key'),
        'connection' => env('APP_MSMS_CONNECTION', 'mysql'),
    ],
],
```

In order to accept routes.
Add in your route file below entry:
`Route::post('/query', '\phalouvas\Httpquery\QueryController@query');`
