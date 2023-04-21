<?php

namespace App\Untils;

use Illuminate\Http\JsonResponse;

class DataBroTable
{
    public static function collect($rows, $total, $attributes): JsonResponse
    {
        return response()->json([
            'data' => $rows,
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'input' => $attributes
        ]);
    }

    public static function cView($value,$params): string
    {
        return view("admin.operations.columns." . $value,$params);
    }
}
