<?php

namespace App\Http\Controllers\Request;
use Illuminate\Http\Request;
use App\Core\Application\Service\Pagination\PaginationRequest;

class PaginationValidateRequest
{
    public static function execute(Request $request, ?string $order): PaginationRequest
    {
        $request->validate([
            'page' => 'integer',
            'per_page' => 'integer',
            'sort' => 'string|in:' . $order,
            'desc' => 'bool',
            'search' => 'string',
            'start_date' => 'string',
            'end_date' => 'string'
        ]);

        return new PaginationRequest(
            $request->input('page') ?? 1,
            $request->input('per_page') ?? 5,
            $request->input('sort'),
            $request->input('desc'),
            $request->input('search'),
            $request->input('filter'),
            $request->input('start_date'),
            $request->input('end_date')
        );
    }
}
