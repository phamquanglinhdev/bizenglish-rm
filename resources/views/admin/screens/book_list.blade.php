@php
    use App\ViewModels\Menu\Object\MenuRecursiveObject;
    /**
* @var MenuRecursiveObject $MenuRecursiveObject
 */
@endphp
@extends("layouts.app")
@section("content")
    <div>
        <button class="btn btn-primary">
            <i class="bx bx-plus"></i> Thêm sách
        </button>
        <div class="accordion mt-3 accordion-header-primary" id="accordionWithIcon">
            @include("admin.screens.book_recursive",["menuRecursiveObject"=>$MenuRecursiveObject,'show'=>true])
        </div>
    </div>
@endsection
