<?php

namespace phalouvas\Httpquery;

use Illuminate\Database\Connection as ConnectionBase;

class Connection extends ConnectionBase
{
    /**
     * The http client
     *
     * @author Panayiotis Halouvas <phalouvas@kainotomo.com>
     *
     * @var Http
     */
    protected $http;

    public function __construct($pdo, $database = '', $tablePrefix = '', array $config = [])
    {
        $this->http = new Http($config);
        return parent::__construct($pdo, $database, $tablePrefix, $config);
    }

    protected function getDefaultQueryGrammar()
    {
        $grammar = app(Grammar::class);
        $grammar->setConfig($this->getConfig());

        return $this->withTablePrefix($grammar);
    }

    public function select($query, $bindings = [], $useReadPdo = true)
    {
        return $this->execute($query, $bindings);
    }

    public function update($query, $bindings = []) {
        return $this->execute($query, $bindings);
    }

    public function delete($query, $bindings = []) {
        return $this->execute($query, $bindings);
    }

    public function insert($query, $bindings = []) {
        return $this->execute($query, $bindings);
    }

    public function statement($query, $bindings = []) {
        return $this->execute($query, $bindings);
    }

    /**
     * Inject bindings in sql statement
     *
     * @author Panayiotis Halouvas <phalouvas@kainotomo.com>
     *
     * @param string $query
     * @param array $bindings
     * @return string
     */
    protected function prepareQuery(string $query, array $bindings)
    {
        $query = str_replace('"', '`', $query);
        $arr = explode('?', $query);
        $statement = '';
        foreach ($arr as $key => $value) {
            $binding = isset($bindings[$key]) ? $bindings[$key] : '';
            if ($binding !== '') {
                $binding = is_string($binding) ? "'" . $binding . "'" : $binding;
            }
            $statement .= $value . $binding;
        }
        return $statement;
    }

    /**
     * Execute the query
     *
     * @param string $query
     * @param array $bindings
     * @return mixed
     */
    public function execute(string $query, array $bindings = [])
    {
        return $this->run($query, $bindings, function ($query, $bindings) {
            if ($this->pretending()) {
                return [];
            }

            $statement = $this->prepareQuery($query, $this->prepareBindings($bindings));
            $response = $this->http->execute($statement);
            return $response;
        });
    }
}
