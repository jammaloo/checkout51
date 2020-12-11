<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

/**
 * @method private|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder listModels()
 */
trait Listable
{
    /*
     * Automatically handles pagination for the provided model
     */
    private function listModels($model_class, Request $request): LengthAwarePaginator {

        // Sort direction can be asc or desc
        $sort_dir = $request->get('sortDir') ?? 'asc';
        if ($sort_dir !== 'asc') {
            $sort_dir = 'desc';
        }

        // Sort by any allowed fields
        $sort_by = $request->get('sortBy') ?? 'id';
        if (!in_array($sort_by, $model_class::$sortable)) {
            $sort_by = 'id';
        }

        // Get current page for pagination
        $currentPage = $request->get('page') ?? 1;

        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });

        return $model_class::orderBy($sort_by, $sort_dir)->paginate(20);
    }
}
