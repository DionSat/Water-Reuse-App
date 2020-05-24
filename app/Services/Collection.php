<?php

//Code below is from: https://gist.github.com/simonhamp/549e8821946e2c40a617c85d2cf5af5e

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection as BaseCollection;

class Collection extends BaseCollection
{
    public function paginate($perPage, $total = null, $page = null, $pageName = 'page')
    {
        $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);

        return new LengthAwarePaginator(
            $this->forPage($page, $perPage),
            $total ?: $this->count(),
            $perPage,
            $page,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'pageName' => $pageName,
            ]
        );
    }
}