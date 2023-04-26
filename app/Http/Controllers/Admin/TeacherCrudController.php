<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\TeacherService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeacherCrudController extends Controller
{
    public function __construct(
        readonly private TeacherService $teacherService
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->teacherService->list($request->input());
        }
        return view("admin.operations.list", [
            'label' => 'Giáo viên',
            'columns' => $this->teacherService->setupListOperation(),
            'filters' => $this->teacherService->setupFilterOperation($request->input()),
            'leftFix' => 2,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.operations.create", [
            'entry' => $this->teacherService->setupCreateOperation(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        return $this->teacherService->create($request->except("_token"));
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
        return view("admin.operations.edit", ['entry' => $this->teacherService->setupEditOperation($id)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return $this->teacherService->update($request->except("_token"), $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        return $this->teacherService->delete($id);
    }
}
