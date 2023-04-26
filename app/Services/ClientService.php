<?php

namespace App\Services;

use App\Untils\DataBroTable;
use Illuminate\Http\JsonResponse;

class ClientService implements \App\Contract\CrudServicesInterface
{

    public function setupListOperation(): array
    {
        return [
            'code' => 'Mã đối tác',
            'name' => 'Tên đối tác',
            'email' => 'Email của đối tác',
            'phone' => 'Số điện thoại',
            'client_status' => 'Tình trạng hợp tác',
        ];
    }

    public function list($attributes): JsonResponse
    {
        return DataBroTable::collect([], 0, $attributes);
    }

    public function setupFilterOperation(): array
    {
        return [];
    }

    public function setupCreateOperation()
    {
        // TODO: Implement setupCreateOperation() method.
    }

    public function setupEditOperation($id)
    {
        // TODO: Implement setupEditOperation() method.
    }
}
