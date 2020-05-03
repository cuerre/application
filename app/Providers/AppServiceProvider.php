<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Paginate a standard Laravel Collection
         *
         * @param int $perPage
         * @param int $total
         * @param int $page
         * @param string $pageName
         * @return array
         */
        Collection::macro('paginate', function($perPage, $total = null, $page = null, $pageName = 'page') {
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
        });
        
        
        
        /**
         * Convert all dimensions which are arrays in multidimensional arrays 
         * into standard Laravel Collections
         *
         * @return collection
         */
        Collection::macro('recursive', function () {
            return $this->map(function ($value) {
                if (is_array($value) || is_object($value)) {
                    return collect($value)->recursive();
                }
                return $value;
            });
        });



        /**
         * Validate as negative approach
         * It rejects items that are NOT valid
         * 
         * 
         */
        Collection::macro('validate', function (array $rules) {
            /** @var $this Collection */
            return $this->values()->reject(function ($array) use ($rules) {
                return Validator::make($array, $rules)->fails();
            });
        });



        /**
         * Validate as positive approach
         * Only keep items that pass validation
         * 
         * 
         */
        Collection::macro('positiveValidate', function (array $rules) {
            /** @var $this Collection */
            return $this->values()->filter(function ($item) use ($rules) {
                return Validator::make($item, $rules)->passes();
            });
        });
    }
}
