<?php

namespace App\Actions;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

class ExecuteCacheData
{

    protected string $key;

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function executeCacheStore($query)
    {

        if (Cache::has($this->key)) {

            $query = Cache::get($this->key);
        } else {

            Cache::forever($this->key,  $query);
        }

        return $query;
    }

    public function executeCacheClear()
    {
        Cache::forget($this->key);
    }
}
