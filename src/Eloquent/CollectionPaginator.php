<?php

namespace MallardDuck\LaravelTraits\Eloquent;

use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Allows you to utilize the Eloquent\Builder's paginate methods on regular Eloquent Collections.
 */
trait CollectionPaginator
{

  /**
   * Boots the trait to setup the pagination macros.
   */
    public function bootCollectionPaginator()
    {
        Collection::macro('paginate', function ($perPage = 5, $pageName = 'page', $page = null) {
            $total = $this->count();
            $page = $page ?: Paginator::resolveCurrentPage($pageName);

            $results = $this->slice(($page - 1) * $perPage, $perPage)->all();

            $currentQuery = app('request')->query();

            return new LengthAwarePaginator($results, $total, $perPage, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'query' => app('request')->query(),
            'pageName' => $pageName,
            ]);
        });

        Collection::macro('simplePaginate', function ($perPage = 5, $pageName = 'page', $page = null) {
            $page = $page ?: Paginator::resolveCurrentPage($pageName);

            $results = $this->slice(($page - 1) * $perPage, $perPage + 1)->all();

            $currentQuery = app('request')->query();

            return new Paginator($results, $perPage, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'query' => app('request')->query(),
            'pageName' => $pageName,
            ]);
        });
    }
}
