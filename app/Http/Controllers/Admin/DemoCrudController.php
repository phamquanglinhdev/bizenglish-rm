<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DemoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Psy\Util\Json;

/**
 *
 */
class DemoCrudController extends Controller
{
    public function __construct(
        private readonly DemoService $demoService
    )
    {
    }

    /**
     * @param Request $request
     * @return View|JsonResponse
     */
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            return $this->demoService->list($request->input());
        }
        return \view("admin.operations.list", [
            'label' => 'Lớp học Demo',
            'columns' => $this->demoService->setupListOperation(),
            'filters' => $this->demoService->setupFilterOperation($request->input()),
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return \view("admin.operations.create", [
            'entry' => $this->demoService->setupCreateOperation()
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $this->demoService->createDemo($request->all());
        return to_route("demos.index")->with("success", "Thêm thành công");
    }

    /**
     * @param $id
     * @return View
     */
    public function edit($id): View
    {
        return \view("admin.operations.edit", [
            "entry" => $this->demoService->setupEditOperation($id)
        ]);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $this->demoService->updateDemo($request->all(), $id);
        return to_route("demos.index")->with("success", "Cập nhật thành công");
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->demoService->deleteDemo($id);
        return to_route("demos.index")->with("success", "Xóa thành công");
    }
}
