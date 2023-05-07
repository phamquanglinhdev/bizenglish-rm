@extends("layouts.app")
@section("title")
    Không tìm thấy trang
@endsection
@section("content")
    <div class="container-xxl container-p-y text-center">
        <div class="misc-wrapper">
            <h1 class="mb-2 mx-2">Không tìm thấy trang</h1>
            <p class="mb-4 mx-2">Có vẻ như bạn đã truy cập nhầm địa chỉ</p>
            <a href="{{url("/")}}" class="btn btn-primary">Về trang chủ</a>
            <div class="mt-3">
                <img src="{{asset("img/illustrations/page-misc-error-light.png")}}" alt="page-misc-error-light" width="500" class="img-fluid">
            </div>
        </div>
    </div>
@endsection
