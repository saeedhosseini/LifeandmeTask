<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\MergeValue;
use Illuminate\Http\Resources\MissingValue;

class LifeandmeResourceCollection extends ResourceCollection
{

    protected string $message = 'successfully load list';
    protected string $unSuccessMessage = 'not found any item';

    public function with($request): array
    {
        return [
            'status' => true,
            'message' => ($this->collection->count() > 0
                ? $this->message :
                $this->unSuccessMessage)];
    }

    protected function preparePaginatedResponse($request): JsonResponse
    {
        if ($this->preserveAllQueryParameters) {
            $this->resource->appends($request->query());
        } elseif (! is_null($this->queryParameters)) {
            $this->resource->appends($this->queryParameters);
        }

        return (new PaginatedLifeandmeResourceResponse($this))->toResponse($request);
    }

    public static $wrap = null;

}
