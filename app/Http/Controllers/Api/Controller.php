<?php

namespace App\Http\Controllers\Api;

use App\DTO\PaginateData;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    protected function getPaginateData(Request $request): PaginateData
    {
        return new PaginateData(
            $request->get('page', 1),
            $request->get('per_page', 10),
            $request->get('filters', []),
        );
    }
}
