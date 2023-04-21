@php
    /**
 * @var $label
 * @var $columns
 * @var $filters
 **/
    use \Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Request;
    $currentRoute = \route(Route::current()->getName());
    $request = Request::input()
@endphp
@section("title")
    Bizenglish::{{$label}}
@endsection
@extends("layouts.app")
@push("page_css")
    <link rel="stylesheet" href="{{asset("vendor/libs/perfect-scrollbar/perfect-scrollbar.css")}}"/>
    <link rel="stylesheet" href="{{asset("vendor/libs/typeahead-js/typeahead.css")}}"/>
    <link rel="stylesheet" href="{{asset("vendor/libs/datatables-bs5/datatables.bootstrap5.css")}}">
    <link rel="stylesheet" href="{{asset("vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css")}}">
    <link rel="stylesheet" href="{{asset("vendor/libs/flatpickr/flatpickr.css")}}"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.2.2/css/fixedColumns.dataTables.min.css"/>
    <style>
        .dataTables_wrapper .dataTables_processing {
            background: none;
            border: none;
        }
    </style>
@endpush
@push("offcanvas")
    <div class="col-lg-3 col-md-6">
        <small class="text-light fw-semibold mb-3"></small>
        <div class="mt-3">
            {{--            <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasStart"--}}
            {{--                    aria-controls="offcanvasStart">Toggle Start--}}
            {{--            </button>--}}
            <div class="offcanvas offcanvas-start" tabindex="-1" id="filter" aria-labelledby="offcanvasStartLabel">
                <div class="offcanvas-header">
                    <h5 id="offcanvasStartLabel" class="offcanvas-title">Lọc::{{$label}}</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                </div>
                <div class="offcanvas-body my-auto mx-0">
                    <form action="#">
                        @foreach($filters as $filter)
                            @include("admin.operations.fields.".$filter['type'],['field'=>$filter])
                        @endforeach
                        <button class="w-100 mt-3 btn btn-primary" type="submit">Lọc</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endpush
@section("content")
    <!-- Ajax Sourced Server-side -->
    <div class="card">
        <div class="card-header"><b>{{$label}}</b>
        </div>
        <div class="mx-2">
            <a class="btn btn-primary text-uppercase" href="{{$currentRoute."/create"}}">Thêm mới :: {{$label}}
            </a>
            <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#filter"
                    aria-controls="filter">Lọc
            </button>
        </div>
        <hr>
        <div class="card-datatable text-nowrap">
            <table class="datatables-ajax table table-bordered">
                <thead>
                <tr>
                    @foreach($columns as $key => $labelName)
                        <td class="bg-primary text-white">{{$labelName}}</td>
                    @endforeach
                                        <td class="bg-primary text-white">Hành động</td>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    @foreach($columns as $key => $labelName)
                        <td class="bg-primary text-white">{{$labelName}}</td>
                    @endforeach
                                        <td class="bg-primary text-white">Hành động</td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection

@push("page_js")
    <!-- Vendors JS -->
    <script src="{{asset("vendor/libs/datatables-bs5/datatables-bootstrap5.js")}}"></script>
    <!-- Flat Picker -->
    <script src="{{asset("vendor/libs/moment/moment.js")}}"></script>
    <script src="{{asset("vendor/libs/flatpickr/flatpickr.js")}}"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/4.2.2/js/dataTables.fixedColumns.min.js"></script>
    <!-- Page JS -->
    <script>
        $(document).ready(function () {
            let data = {!! json_encode($request) !!};
            const columnsObject = {!! json_encode($columns) !!};
            let columns = []
            $.each(columnsObject, function (key, value) {
                const item = {data: key, label: value}
                columns.push(item)
            })
            columns.push({data: "action", label: "Hành động"})
            $(".datatables-ajax").DataTable({
                ajax: {
                    url: '{{$currentRoute}}',
                    // data: data,
                },
                processing: true,
                serverSide: true,
                columns: columns,
                scrollY: '50vh',
                scrollX: true,
                fixedHeader: true,
                fixedColumns: {
                    left: 1,
                    right: 0
                },
                searching: false,
                sorting: false,
                scrollCollapse: true,
            })
        })
    </script>
@endpush
