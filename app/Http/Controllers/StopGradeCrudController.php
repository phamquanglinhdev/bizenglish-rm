<?php

namespace App\Http\Controllers;

use App\Export\LogExport;
use App\Http\Controllers\Admin\GradeCrudController;
use App\Services\GradeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Nette\Utils\Json;

class StopGradeCrudController extends Controller
{
    public function __construct(
        readonly private GradeService        $gradeService,
        readonly private GradeCrudController $gradeCrudController
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public
    function index(Request $request): View|JsonResponse
    {
        $attr = $request->input();
        $attr["status"] = 1;
        if ($request->ajax()) {
            return $this->gradeService->list($attr);
        }
//        dd($this->gradeService->list($request->input()));
        return view("admin.operations.list", [
            'label' => 'Lớp học đã kết thúc',
            'columns' => $this->gradeService->setupListOperation(),
            'filters' => $this->gradeService->setupFilterOperation($attr),
            'setup' => $this->gradeService->setup()->getSetup(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public
    function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public
    function store(Request $request): RedirectResponse
    {
        return to_route("stop-grades.index");
    }

    /**
     * Display the specified resource.
     */
    public
    function show(string $id): \Illuminate\Contracts\View\View
    {
       return $this->gradeCrudController->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public
    function edit(string $id): \Illuminate\Contracts\View\View
    {
        return $this->gradeCrudController->edit($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public
    function update(Request $request, string $id): RedirectResponse
    {
        return $this->gradeCrudController->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public
    function destroy(string $id): ?RedirectResponse
    {
        return $this->gradeCrudController->destroy($id);
    }

    public
    function export(Request $request)
    {
        $name = "lop-hoc-da-ket-thuc" . Carbon::now()->isoFormat("D-M-Y") . "-" . Str::random(5) . ".xlsx";
        $attributes = $request->except("_cols");
        $attributes["status"] = 1;
        $data = $this->gradeService->export($attributes);
        Excel::store(new LogExport($data), $name, "excel", null);
        return url("uploads/excel/" . $name);
    }
}
