<?php

namespace phalouvas\Httpquery;

use Illuminate\Database\Connection as ConnectionBase;
use Illuminate\Support\ServiceProvider as ServiceProviderBase;

class ServiceProvider extends ServiceProviderBase
{
    public function register()
    {
        $this->app->bind(QueryController::class, function ($app) {
            return new QueryController();
        });

        ConnectionBase::resolverFor('httpquery', static function ($connection, $database, $prefix, $config) {
            if (app()->has(Connection::class)) {
                return app(Connection::class);
            }

            return new Connection($connection, $database, $prefix, $config);
        });
    }
}
