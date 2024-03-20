<?php

namespace App\Http\Resources\Permission;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;

class PermissionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => PermissionResource::collection($this->collection),
            // 'paginate' => $this->mergeWhen($this->resource instanceof LengthAwarePaginator, [
            //     'current_page' => $this->resource->currentPage(),
            //     'num_page' => $this->resource->lastPage(),
            //     'total' => $this->resource->total(),
            // ]),
        ];
    }
}
