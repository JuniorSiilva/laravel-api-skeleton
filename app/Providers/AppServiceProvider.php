<?php

namespace App\Providers;

use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        JsonResource::withoutWrapping();

        Response::macro('withResource', function (string $resource) {
            $serializer = null;

            if ($this->original instanceof Model) {
                $serializer = new $resource($this->original);
            } elseif ($this->original instanceof Collection || $this->original instanceof Paginator) {
                $serializer = $resource::collection($this->original);
            }

            $response = $serializer->response();

            $response->setStatusCode($this->getStatusCode());

            $response->withHeaders($this->headers);

            return $response;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
