<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ClientService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientCrudController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(
        private readonly ClientService $clientService
    )
    {
        $this->middleware("advance")->except('show');
    }

    public function index(Request $request): View|JsonResponse
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
    public function create(): View
    {
        return view("admin.operations.create", [
            'entry' => $this->clientService->setupCreateOperation()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        return $this->clientService->create($request->all());
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
    public function edit(string $id): View
    {
        return \view("admin.operations.edit", [
            'entry' => $this->clientService->setupEditOperation($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        return $this->clientService->update($request->all(), $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        return $this->clientService->delete($id);
    }
}
