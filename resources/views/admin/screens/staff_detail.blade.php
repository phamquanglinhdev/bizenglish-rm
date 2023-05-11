@php
    use App\ViewModels\Staff\StaffShowViewModel;
    /**
    * @var StaffShowViewModel $staffShowViewModel;
    */
    $staffObject  =  $staffShowViewModel->getStaff();
    $logs = $staffShowViewModel->getLogs();
    $calendar  = $staffShowViewModel->getCalendarObject();
@endphp
@extends("layouts.app")
@section("title")
    {{$staffObject->getName()}}
@endsection
@push("page_css")
    <style>
        .user-profile-header-banner img {
            height: 250px;
            -o-object-fit: cover;
            object-fit: cover;
            width: 100%
        }

        .user-profile-header {
            margin-top: -2rem
        }

        .user-profile-header .user-profile-img {
            border: 5px solid;
            width: 120px
        }

        .light-style .user-profile-header .user-profile-img {
            border-color: #fff
        }

        .dark-style .user-profile-header .user-profile-img {
            border-color: #283144
        }

        .dataTables_wrapper .card-header .dataTables_filter label {
            margin-bottom: 0 !important;
            margin-top: 0 !important
        }

        @media (max-width: 767.98px) {
            .user-profile-header-banner img {
                height: 150px
            }

            .user-profile-header .user-profile-img {
                width: 100px
            }
        }

    </style>
@endpush
@section("content")
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">Nhân viên /</span> {{$staffObject->getName()}}
        </h4>
        <!-- Header -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="user-profile-header-banner">
                        <img src="{{asset("/img/pages/profile-banner.png")}}" alt="Banner image" class="rounded-top">
                    </div>
                    <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                        <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                            <img src="{{$staffObject->getAvatar()}}" alt="user image"
                                 class="d-block h-auto ms-0 ms-sm-4 rounded-3 user-profile-img">
                        </div>
                        <div class="flex-grow-1 mt-3 mt-sm-5">
                            <div
                                class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                                <div class="user-profile-info">
                                    <h4>{{$staffObject->getName()}}</h4>
                                    <ul class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                        <li class="list-inline-item fw-semibold">
                                            <i class='bx bx-pen'></i> Nhân viên
                                        </li>
                                        <li class="list-inline-item fw-semibold">
                                            <i class='bx bx-phone'></i> {{$staffObject->getPhone()}}
                                        </li>
                                    </ul>
                                </div>
                                {{--                                <a href="javascript:void(0)" class="btn btn-primary text-nowrap">--}}
                                {{--                                    <i class='bx bx-user-check me-1'></i>Connected--}}
                                {{--                                </a>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Header -->

        <!-- User Profile Content -->
        <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-5">
                <!-- About User -->
                <div class="card mb-4">
                    <div class="card-body">
                        <small class="text-muted text-uppercase">Thông tin cơ bản</small>
                        <ul class="list-unstyled mb-4 mt-3">
                            <li class="d-flex align-items-center mb-3"><i class="bx bx-user"></i><span
                                    class="fw-semibold mx-2">Họ và tên:</span>
                                <span>{{$staffObject->getName()}}</span></li>
                            <li class="d-flex align-items-center mb-3"><i class="bx bx-code"></i><span
                                    class="fw-semibold mx-2">Mã NV:</span>
                                <span>{{$staffObject->getCode()}}</span></li>
                            <li class="d-flex align-items-center mb-3"><i class="bx bx-star"></i><span
                                    class="fw-semibold mx-2">Phân quyền :</span> <span>Nhân viên</span></li>
                        </ul>
                        <small class="text-muted text-uppercase">Liên hệ</small>
                        <ul class="list-unstyled mb-4 mt-3">
                            <li class="d-flex align-items-center mb-3"><i class="bx bx-phone"></i><span
                                    class="fw-semibold mx-2">Số điện thoại:</span>
                                <span>{{$staffObject->getPhone()}}</span></li>
                            <li class="d-flex align-items-center mb-3"><i class="bx bx-envelope"></i><span
                                    class="fw-semibold mx-2">Email:</span> <span>{{$staffObject->getEmail()}}</span>
                            </li>
                        </ul>
                        {{--                        <small class="text-muted text-uppercase">Teams</small>--}}
                        {{--                        <ul class="list-unstyled mt-3 mb-0">--}}
                        {{--                            <li class="d-flex align-items-center mb-3"><i class="bx bxl-github text-primary me-2"></i>--}}
                        {{--                                <div class="d-flex flex-wrap"><span--}}
                        {{--                                        class="fw-semibold me-2">Backend Developer</span><span>(126 Members)</span>--}}
                        {{--                                </div>--}}
                        {{--                            </li>--}}
                        {{--                            <li class="d-flex align-items-center"><i class="bx bxl-react text-info me-2"></i>--}}
                        {{--                                <div class="d-flex flex-wrap"><span--}}
                        {{--                                        class="fw-semibold me-2">React Developer</span><span>(98 Members)</span></div>--}}
                        {{--                            </li>--}}
                        {{--                        </ul>--}}
                    </div>
                </div>
                <!--/ About User -->
                <!-- Profile Overview -->
            </div>
            <div class="col-xl-8 col-lg-7 col-md-7">
{{--                <div class="card card-action mb-4">--}}
{{--                    <div class="card-header align-items-center">--}}
{{--                        <h5 class="card-action-title mb-0"><i class='bx bx-calendar bx-sm me-2'></i>Lịch theo dõi lớp--}}
{{--                        </h5>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        @if(!empty($calendar->getMonday()))--}}
{{--                            <div class="day">--}}
{{--                                <div class="fw-bold">Thứ hai</div>--}}
{{--                                <ul class="list-group list-group-timeline">--}}
{{--                                    @foreach($calendar->getMonday() as $time)--}}
{{--                                        <li class="list-group-item list-group-timeline-danger">--}}
{{--                                            <a class="fw-bold"--}}
{{--                                               href="{{url("/grades/".$time->getId())}}">{{$time->getGrade()}}</a>--}}
{{--                                            : {{$time->getTime()}}--}}
{{--                                        </li>--}}
{{--                                    @endforeach--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                        @endif--}}
{{--                        @if(!empty($calendar->getTuesday()))--}}
{{--                            <div class="day">--}}
{{--                                <div class="fw-bold">Thứ ba</div>--}}
{{--                                <ul class="list-group list-group-timeline">--}}
{{--                                    @foreach($calendar->getTuesday() as $time)--}}
{{--                                        <li class="list-group-item list-group-timeline-danger">--}}
{{--                                            <a class="fw-bold"--}}
{{--                                               href="{{url("/grades/".$time->getId())}}">{{$time->getGrade()}}</a>--}}
{{--                                            : {{$time->getTime()}}--}}
{{--                                        </li>--}}
{{--                                    @endforeach--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                        @endif--}}
{{--                        @if(!empty($calendar->getWednesday()))--}}
{{--                            <div class="day">--}}
{{--                                <div class="fw-bold">Thứ tư</div>--}}
{{--                                <ul class="list-group list-group-timeline">--}}
{{--                                    @foreach($calendar->getWednesday() as $time)--}}
{{--                                        <li class="list-group-item list-group-timeline-danger">--}}
{{--                                            <a class="fw-bold"--}}
{{--                                               href="{{url("/grades/".$time->getId())}}">{{$time->getGrade()}}</a>--}}
{{--                                            : {{$time->getTime()}}--}}
{{--                                        </li>--}}
{{--                                    @endforeach--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                        @endif--}}
{{--                        @if(!empty($calendar->getThursday()))--}}
{{--                            <div class="day">--}}
{{--                                <div class="fw-bold">Thứ năm</div>--}}
{{--                                <ul class="list-group list-group-timeline">--}}
{{--                                    @foreach($calendar->getThursday() as $time)--}}
{{--                                        <li class="list-group-item list-group-timeline-danger">--}}
{{--                                            <a class="fw-bold"--}}
{{--                                               href="{{url("/grades/".$time->getId())}}">{{$time->getGrade()}}</a>--}}
{{--                                            : {{$time->getTime()}}--}}
{{--                                        </li>--}}
{{--                                    @endforeach--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                        @endif--}}
{{--                        @if(!empty($calendar->getFriday()))--}}
{{--                            <div class="day">--}}
{{--                                <div class="fw-bold">Thứ sáu</div>--}}
{{--                                <ul class="list-group list-group-timeline">--}}
{{--                                    @foreach($calendar->getFriday() as $time)--}}
{{--                                        <li class="list-group-item list-group-timeline-danger">--}}
{{--                                            <a class="fw-bold"--}}
{{--                                               href="{{url("/grades/".$time->getId())}}">{{$time->getGrade()}}</a>--}}
{{--                                            : {{$time->getTime()}}--}}
{{--                                        </li>--}}
{{--                                    @endforeach--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                        @endif--}}
{{--                        @if(!empty($calendar->getSaturday()))--}}
{{--                            <div class="day">--}}
{{--                                <div class="fw-bold">Thứ bảy</div>--}}
{{--                                <ul class="list-group list-group-timeline">--}}
{{--                                    @foreach($calendar->getSaturday() as $time)--}}
{{--                                        <li class="list-group-item list-group-timeline-danger">--}}
{{--                                            <a class="fw-bold"--}}
{{--                                               href="{{url("/grades/".$time->getId())}}">{{$time->getGrade()}}</a>--}}
{{--                                            : {{$time->getTime()}}--}}
{{--                                        </li>--}}
{{--                                    @endforeach--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                        @endif--}}
{{--                        @if(!empty($calendar->getSunday()))--}}
{{--                            <div class="day">--}}
{{--                                <div class="fw-bold">Chủ nhật</div>--}}
{{--                                <ul class="list-group list-group-timeline">--}}
{{--                                    @foreach($calendar->getSunday() as $time)--}}
{{--                                        <li class="list-group-item list-group-timeline-danger">--}}
{{--                                            <a class="fw-bold"--}}
{{--                                               href="{{url("/grades/".$time->getId())}}">{{$time->getGrade()}}</a>--}}
{{--                                            : {{$time->getTime()}}--}}
{{--                                        </li>--}}
{{--                                    @endforeach--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="card card-action mb-4">
                    <div class="card-header align-items-center">
                        <h5 class="card-action-title mb-0"><i class='bx bx-list-ul bx-sm me-2'></i>Nhật ký buổi học
                        </h5>
                        <div class="card-action-element btn-pinned">
                            <div class="dropdown">
                                <button type="button" class="btn dropdown-toggle hide-arrow p-0"
                                        data-bs-toggle="dropdown" aria-expanded="false"><i
                                        class="bx bx-dots-vertical-rounded"></i></button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="javascript:void(0);">Đi tới chi tiết</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="max-height: 70vh;overflow-y: scroll">
                        <ul class="timeline ms-2">
                            @foreach($logs as $log)
                                <li class="timeline-item timeline-item-transparent">
                                    <span class="timeline-point timeline-point-primary"></span>
                                    <div class="timeline-event">
                                        <div class="timeline-header mb-1">
                                            <h5 class="mb-0 fw-bold">
                                                <a href="{{url("/logs/".$log->getId())}}"
                                                   class="text-dark">{{$log->getTitle()}}</a>
                                            </h5>
                                            <small class="text-muted">{{$log->getDate()}}</small>
                                        </div>
                                        <a href="{{url("/teachers/".$log->getTeacher()->getId())}}" class="mb-2">Upload
                                            by {{$log->getTeacher()->getName()}}
                                            <img src="{{$log->getTeacher()->getAvatar()}}"
                                                 class="rounded-circle ms-3" alt="avatar"
                                                 height="20" width="20"></a>
                                        <div>Bài tập : {{$log->getQuestion()}}</div>
                                        @foreach($log->getAttachments() as $attachment)
                                            <div class="d-flex flex-wrap gap-2">
                                                <a href="{{url("/uploads/".$attachment)}}" class="me-3">
                                                    <img src="{{asset("img/icons/misc/pdf.png")}}"
                                                         width="20" class="me-2">
                                                    <span class="h6">{{$attachment}}</span>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
