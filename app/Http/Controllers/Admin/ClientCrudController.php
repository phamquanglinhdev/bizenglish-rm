<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ClientService;
use Illuminate\Http\Request;

class ClientCrudController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(
        private readonly ClientService $clientService
    )
    {
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->clientService->list($request->input());
        }
        return view("admin.operations.list", [
            'label' => 'Đối tác',
            'columns' => $this->clientService->setupListOperation(),
            'filters' => $this->clientService->setupFilterOperation($request->input()),
            'leftFix' => 2,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
