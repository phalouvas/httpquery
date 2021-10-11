<?php

namespace phalouvas\Httpquery;

use Illuminate\Support\Facades\Http as FacadesHttp;

class Http extends FacadesHttp {

    /**
     * Host
     *
     * @author Panayiotis Halouvas <phalouvas@kainotomo.com>
     *
     * @var string
     */
    protected $host;

    /**
     * Api key
     *
     * @author Panayiotis Halouvas <phalouvas@kainotomo.com>
     *
     * @var string
     */
    protected $api_key;

    /**
     * The database connection for the statement
     *
     * @author Panayiotis Halouvas <phalouvas@kainotomo.com>
     *
     * @var string
     */
    protected $connection;

    /**
     * Constructor
     *
     * @author Panayiotis Halouvas <phalouvas@kainotomo.com>
     *
     * @param string $host
     * @param array $options
     */
    public function __construct(array $options)
    {
        if (isset($options['port']) && !empty($options['port'])) {
            $this->host = trim($options['database'], "/") . "/query:" . $options['port'] . "/";
        } else {
            $this->host = trim($options['database'], "/") . "/query/";
        }

        if (isset($options['api_key'])) {
            $this->api_key = $options['api_key'];
        }

        $this->connection = $options['connection'];

    }

    /**
     * Execute the statement on remote service
     *
     * @author Panayiotis Halouvas <phalouvas@kainotomo.com>
     *
     * @param string $statement
     * @return mixed
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function execute(string $statement) {
        $response = self::withToken($this->api_key)->post($this->host, ['connection' => $this->connection, 'statement' => $statement]);
        $response->throw();
        return $response->json();
    }
}
