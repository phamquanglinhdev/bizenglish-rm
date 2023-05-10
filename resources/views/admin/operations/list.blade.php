@php
    /**
 * @var $label
 * @var $columns
 * @var $filters
 * @var $leftFix
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
    <link rel="stylesheet" href="{{asset("vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css")}}"/>
    <link rel="stylesheet" href="{{asset("vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css")}}"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.2.2/css/fixedColumns.dataTables.min.css"/>

    <link rel="stylesheet" href="{{asset("vendor/libs/typeahead-js/typeahead.css")}}"/>
    <style>
        .dataTables_wrapper .dataTables_processing {
            background: none;
            border: none;
        }

        .dtfc-right-top-blocker {
            background: #5a8dee!important;
        }
        .dtfc-fixed-left {
            border-right: 2px solid!important;
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
    <div class="card border-0">
        <div class="h2 p-2"><b>{{$label}}</b>
        </div>
        <div class="mx-2">
            <a class="btn btn-primary text-uppercase" href="{{$currentRoute."/create"}}">
                <i class='bx bxs-plus-circle'></i>
            </a>
            <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#filter"
                    aria-controls="filter"><i class='bx bx-filter'></i>
            </button>
            <a class="btn btn-primary" href="{{$currentRoute}}"><i class='bx bx-reset'></i>
            </a>
        </div>
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
    <script src="{{asset("vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js")}}"></script>
    <script src="{{asset("vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js")}}"></script>
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
                    data: data,
                },
                processing: true,
                serverSide: true,
                columns: columns,
                scrollY: '50vh',
                scrollX: true,
                fixedHeader: true,
                fixedColumns: {
                    left: {{$leftFix??1}},
                    right: {{$rightFix??0}}
                },
                searching: false,
                sorting: false,
                scrollCollapse: true,
                lengthMenu: [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"]]
            })

            $(document).ajaxComplete(function () {
                "use strict";
                [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]')).map(function (e) {
                    return new bootstrap.Popover(e, {html: !0, sanitize: !1})
                });
            });
        })
    </script>

@endpush
