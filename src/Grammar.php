<?php

namespace phalouvas\Httpquery;

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\Grammars\Grammar as GrammarBase;

class Grammar extends GrammarBase
{
    private $config = [];

    /**
     * @param array $config
     * @return Grammar
     */
    public function setConfig(array $config): self
    {
        $this->config = $config;

        return $this;
    }

    /**
     * @param Builder $query
     * @return string|false
     */
    public function compileSelect(Builder $query): string
    {
        $strQuery = parent::compileSelect($query);
        return $strQuery;
    }

}
