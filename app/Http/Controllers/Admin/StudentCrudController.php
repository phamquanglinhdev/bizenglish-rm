<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\StudentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentCrudController extends Controller
{
    private StudentService $studentService;

    /**
     * @param StudentService $studentService
     */
    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
        $this->middleware("advance")->except("show");
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            return $this->studentService->list($request->input());
        }
        return view("admin.operations.list", [
            'label' => 'Học sinh',
            'columns' => $this->studentService->setupListOperation(),
            'filters' => $this->studentService->setupFilterOperation($request->input()),
            'leftFix' => 2
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view("admin.operations.create", [
            'entry' => $this->studentService->setupCreateOperation()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        return $this->studentService->store($request->input(), $request->file());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        return \view("admin.screens.student_detail", [
            'studentShowViewModel' => $this->studentService->showStudentProfile($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        return view("admin.operations.edit", [
            'entry' => $this->studentService->setupEditOperation($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return $this->studentService->update($request->input(), $request->file(), $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        return $this->studentService->delete($id);
    }
}
