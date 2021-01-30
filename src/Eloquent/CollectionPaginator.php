<?php

namespace MallardDuck\LaravelTraits\Eloquent;

use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Request;

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
            /**
             * @var Collection $this
             */
            $total = $this->count();
            $page = $page ?: Paginator::resolveCurrentPage($pageName);

            $results = $this->slice(($page - 1) * $perPage, $perPage)->all();

            /**
             * @var Request $currentQuery
             */
            $currentRequest = app('request');

            return new LengthAwarePaginator($results, $total, $perPage, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'query' => $currentRequest->query(),
            'pageName' => $pageName,
            ]);
        });

        Collection::macro('simplePaginate', function ($perPage = 5, $pageName = 'page', $page = null) {
            $page = $page ?: Paginator::resolveCurrentPage($pageName);

            $results = $this->slice(($page - 1) * $perPage, $perPage + 1)->all();

            /**
             * @var Request $currentQuery
             */
            $currentRequest = app('request');

            return new Paginator($results, $perPage, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'query' => $currentRequest->query(),
            'pageName' => $pageName,
            ]);
        });
    }
}
