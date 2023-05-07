@extends("layouts.app")
@section("title")
    Không có quyền truy cập
@endsection
@section("content")
    <div class="container-xxl container-p-y">
        <div class="misc-wrapper">
            <h1 class="mb-2 mx-2">Không có quyền truy cập</h1>
            <p class="mb-4 mx-2">Vui lòng liên hệ admin nếu bạn nghĩ đây là lỗi</p>
            <a href="{{url("/")}}" class="btn btn-primary">Về trang chủ</a>
            <div class="mt-5">
                <img src="{{asset("img/illustrations/girl-hacking-site-light.png")}}" alt="page-misc-not-authorized-light" width="450" class="img-fluid">
            </div>
        </div>
    </div>
@endsection
