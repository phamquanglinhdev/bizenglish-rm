<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\StaffService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StaffCrudController extends Controller
{
    private StaffService $staffServices;

    /**
     * @param StaffService $staffServices
     */
    public function __construct(StaffService $staffServices)
    {
        $this->staffServices = $staffServices;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
//            dd($this->logService->list($request->input()));
            return $this->staffServices->list($request->input());
        }
        return view("admin.operations.list", [
            'label' => 'Nhân viên',
            'columns' => $this->staffServices->setupListOperation(),
            'filters' => $this->staffServices->setupFilterOperation($request->input()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return \view("admin.operations.create", [
            'entry' => $this->staffServices->setupCreateOperation()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->staffServices->store($request->input());
        return to_route("staffs.index")->with("success", "Thêm thành công");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        return \view("admin.screens.staff_detail", [
            "staffShowViewModel" => $this->staffServices->show($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        return view("admin.operations.edit", [
            'entry' => $this->staffServices->setupEditOperation($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return $this->staffServices->update($request->input(), $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        return $this->staffServices->delete($id);
    }
}
