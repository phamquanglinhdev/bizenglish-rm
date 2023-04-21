@php
    /**
     * @var \App\ViewModels\Entry\CrudEntry $entry
     */
@endphp
@extends("layouts.app")
@section("title")
    Thêm :: {{$entry->getLabel()}}
@endsection
@section("content")
    <div class="container-fluid">
        <div class="h3 text-uppercase ql-font-serif bold">Thêm {{$entry->getLabel()}}</div>

        <div class="bg-white p-1">
            <div class="row">
                <div class="col-md-9">
                    <div class="rounded shadow-lg p-3">
                        <form action="{{route($entry->getEntity().".store")}}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                @foreach($entry->getFields() as $field)
                                    @include("admin.operations.fields.".$field['type'],['field'=>$field])
                                @endforeach
                            </div>
                            <button class="btn btn-success mt-3">Tạo mới {{$entry->getLabel()}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
