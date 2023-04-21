<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\GradeService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GradeCrudController extends Controller
{
    protected GradeService $gradeService;

    /**
     * @param GradeService $gradeService
     */
    public function __construct(GradeService $gradeService)
    {
        $this->gradeService = $gradeService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            return $this->gradeService->list($request->input());
        }
//        dd($this->gradeService->list($request->input()));
        return view("admin.operations.list", [
            'label' => 'Lớp học',
            'columns' => $this->gradeService->setupListOperation(),
            'filters' => $this->gradeService->setupFilterOperation($request->input()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view("admin.operations.create", [
            'entry' => $this->gradeService->setupCreateOperation()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->gradeService->store($request->input());
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
        return view("admin.operations.edit", [
            'entry' => $this->gradeService->setupEditOperation($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return $this->gradeService->update($request->input(), $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): ?RedirectResponse
    {
        return $this->gradeService->delete($id);
    }
}
