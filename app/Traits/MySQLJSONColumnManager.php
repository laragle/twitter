<?php

namespace App\Traits;

use App\Managers\MySQLJSONColumnManager as BaseManager;

trait MySQLJSONColumnManager
{
    public function __call($method, $arguments)
    {
        if (property_exists($this, 'casts')) {
            if (array_key_exists($method, $this->casts)) {
                return new BaseManager($this, $method);
            }
        }

        return parent::__call($method, $arguments);
    }
}