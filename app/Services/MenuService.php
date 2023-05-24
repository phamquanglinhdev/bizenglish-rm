<?php

namespace App\Services;

use App\Models\Menu;
use App\Repositories\MenuRepository;
use App\Untils\DataBroTable;
use App\ViewModels\Entry\CrudEntry;
use App\ViewModels\Entry\SetupEntry;
use App\ViewModels\Menu\MenuListViewModel;
use App\ViewModels\Menu\Object\MenuStoreObject;
use Illuminate\Http\JsonResponse;

class MenuService implements \App\Contract\CrudServicesInterface
{

    public function __construct(
        private readonly MenuRepository $menuRepository
    )
    {
    }


    public function setupListOperation(): array
    {
        return [
            'name' => 'Tên',
            'parent' => 'Danh mục cha',
        ];
    }

    public function list($attribute): JsonResponse
    {
        $menuCollection = $this->menuRepository->indexNoDisable($attribute);
        $count = $this->menuRepository->countNoDisable($attribute);

        $menuListViewModel = new MenuListViewModel(
            menus: $menuCollection, label: "Menu sách"
        );
        return DataBroTable::collect($menuListViewModel->getMenus(), $count, $attribute);
    }

    public function setupFilterOperation($old = null): array
    {
        return [
            [
                'name' => 'name',
                'label' => 'Tên',
                'value' => $old["name"] ?? null,
                'type' => 'text'
            ],
            [
                'name' => 'parent',
                'label' => 'Danh mục cha',
                'value' => $old['parent'] ?? null,
                'type' => 'text'
            ]
        ];
    }

    public function setupCreateOperation($old = null): CrudEntry
    {
        $entry = new CrudEntry("menus", $old->id ?? null, "Menu sách");
        $entry->addField([
            'name' => 'name',
            'value' => $old["name"] ?? null,
            'type' => 'text',
            'label' => 'Tên sách'
        ]);
        $entry->addField([
            'name' => 'parent_id',
            'type' => 'select2',
            'value' => $old['parent_id'] ?? null,
            'label' => 'Menu cha',
            'nullable' => true,
            'options' => $this->menuRepository->getForSelect(trash: false)
        ]);
        return $entry;
    }

    public function setupEditOperation($id): CrudEntry
    {
        /**
         * @var Menu $oldMenu
         */
        $oldMenu = $this->menuRepository->show($id);
        return $this->setupCreateOperation($oldMenu);
    }

    public function create(array $attributes): void
    {
        $this->menuRepository->create((new MenuStoreObject(name: $attributes["name"], parent_id: $attributes["parent_id"]))->toArray());
    }

    public function update(array $attribute, $id): void
    {
        /**
         * @var Menu $menu
         */
        $menu = $this->menuRepository->show($id);
        $menu->name = $attribute["name"];
        $menu->parent_id = $attribute["parent_id"] ?? null;
        $menu->save();
    }

    public function delete($id): void
    {
        $this->menuRepository->forceDelete($id);
    }
}
