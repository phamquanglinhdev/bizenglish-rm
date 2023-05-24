<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\MenuService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenuCrudController extends Controller
{
    public function __construct(
        private readonly MenuService $menuService
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            return $this->menuService->list($request->input());
        }
        return view("admin.operations.list", [
            'label' => 'Menu sách',
            'columns' => $this->menuService->setupListOperation(),
            'filters' => $this->menuService->setupFilterOperation($request->input()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return \view("admin.operations.create", [
            'entry' => $this->menuService->setupCreateOperation()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->menuService->create($request->except("_token"));
        return to_route("menus.index")->with("success", "Thêm thành công");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): RedirectResponse
    {
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        return \view("admin.operations.edit", [
            'entry' => $this->menuService->setupEditOperation($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->menuService->update($request->except("_token", "_method"), $id);
        return to_route("menus.index")->with("success", "Cập nhật thành công");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->menuService->delete($id);
        return to_route("menus.index")->with("success", "Xóa thành công");
    }
}
