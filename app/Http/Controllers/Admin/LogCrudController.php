<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\LogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LogCrudController extends Controller
{
    private LogService $logService;

    /**
     * @param LogService $logService
     */
    public function __construct(LogService $logService)
    {
        $this->logService = $logService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
//            dd($this->logService->list($request->input()));
            return $this->logService->list($request->input());
        }
        return view("admin.operations.list", [
            'label' => 'Nhật ký buổi học',
            'columns' => $this->logService->setupListOperation(),
            'filters' => $this->logService->setupFilterOperation($request->input()),
            'leftFix' => 2,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view("admin.operations.create", [
            'entry' => $this->logService->setupCreateOperation()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {

        return $this->logService->store($request->input(), $request->file());
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        return view("admin.operations.edit", [
            'entry' => $this->logService->setupEditOperation($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        return $this->logService->update($request->input(), $request->file(), $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
