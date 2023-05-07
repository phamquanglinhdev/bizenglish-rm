@php
    use App\ViewModels\Student\StudentShowViewModel;
    /**
    * @var StudentShowViewModel $studentShowViewModel
    */
    $studentObject  =  $studentShowViewModel->getStudent();
    $logs = $studentShowViewModel->getStudentLogs();
@endphp
@extends("layouts.app")
@section("title")
    {{$studentObject->getName()}}
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
            <span class="text-muted fw-light">Học sinh /</span> {{$studentObject->getName()}}
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
                            <img src="{{$studentObject->getAvatar()}}" alt="user image"
                                 class="d-block h-auto ms-0 ms-sm-4 rounded-3 user-profile-img">
                        </div>
                        <div class="flex-grow-1 mt-3 mt-sm-5">
                            <div
                                class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                                <div class="user-profile-info">
                                    <h4>{{$studentObject->getName()}}</h4>
                                    <ul class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                        <li class="list-inline-item fw-semibold">
                                            <i class='bx bx-pen'></i> Học sinh
                                        </li>
                                        <li class="list-inline-item fw-semibold">
                                            <i class='bx bx-phone'></i> {{$studentObject->getPhone()}}
                                        </li>
                                        <li class="list-inline-item fw-semibold">
                                            <i class='bx bx-home'></i> Giám hộ: {{$studentObject->getParent()}}
                                        </li>
                                    </ul>
                                </div>
                                <a href="javascript:void(0)" class="btn btn-primary text-nowrap">
                                    <i class='bx bx-user-check me-1'></i>Connected
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Header -->

        <!-- Navbar pills -->
        {{--        <div class="row">--}}
        {{--            <div class="col-md-12">--}}
        {{--                <ul class="nav nav-pills flex-column flex-sm-row mb-4">--}}
        {{--                    <li class="nav-item"><a class="nav-link active" href="javascript:void(0);"><i--}}
        {{--                                class='bx bx-user me-1'></i> Profile</a></li>--}}
        {{--                    <li class="nav-item"><a class="nav-link" href="pages-profile-teams.html"><i--}}
        {{--                                class='bx bx-group me-1'></i> Teams</a></li>--}}
        {{--                    <li class="nav-item"><a class="nav-link" href="pages-profile-projects.html"><i--}}
        {{--                                class='bx bx-grid-alt me-1'></i> Projects</a></li>--}}
        {{--                    <li class="nav-item"><a class="nav-link" href="pages-profile-connections.html"><i--}}
        {{--                                class='bx bx-link-alt me-1'></i> Connections</a></li>--}}
        {{--                </ul>--}}
        {{--            </div>--}}
        {{--        </div>--}}
        <!--/ Navbar pills -->

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
                                <span>{{$studentObject->getName()}}</span></li>
                            <li class="d-flex align-items-center mb-3"><i class="bx bx-code"></i><span
                                    class="fw-semibold mx-2">Mã HV:</span>
                                <span>{{$studentObject->getCode()}}</span></li>
                            <li class="d-flex align-items-center mb-3"><i class="bx bx-check"></i><span
                                    class="fw-semibold mx-2">Tình trạng:</span>
                                <span>{{$studentObject->getStatus()}}</span></li>
                            <li class="d-flex align-items-center mb-3"><i class="bx bx-star"></i><span
                                    class="fw-semibold mx-2">Phân quyền :</span> <span>Học sinh</span></li>
                            <li class="d-flex align-items-center mb-3"><i class="bx bx-flag"></i><span
                                    class="fw-semibold mx-2">Địa chỉ:</span>
                                <span>{{$studentObject->getAddress()}}</span></li>
                        </ul>
                        <small class="text-muted text-uppercase">Liên hệ</small>
                        <ul class="list-unstyled mb-4 mt-3">
                            <li class="d-flex align-items-center mb-3"><i class="bx bx-phone"></i><span
                                    class="fw-semibold mx-2">Số điện thoại:</span>
                                <span>{{$studentObject->getPhone()}}</span></li>
                            <li class="d-flex align-items-center mb-3"><i class="bx bx-chat"></i><span
                                    class="fw-semibold mx-2">Facebook:</span>
                                <span>{{$studentObject->getFacebook()}}</span></li>
                            <li class="d-flex align-items-center mb-3"><i class="bx bx-envelope"></i><span
                                    class="fw-semibold mx-2">Email:</span> <span>{{$studentObject->getEmail()}}</span>
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
                <div class="card mb-4">
                    <div class="card-body">
                        <small class="text-muted text-uppercase">Tổng quan</small>
                        <ul class="list-unstyled mt-3 mb-0">
                            <li class="d-flex align-items-center mb-3"><i class="bx bx-check"></i><span
                                    class="fw-semibold mx-2">Số phút đã học:</span> <span>{{$studentObject->getMinutes()}} phút</span>
                            </li>
                            <li class="d-flex align-items-center mb-3"><i class='bx bx-customize'></i><span
                                    class="fw-semibold mx-2">Số phút còn lại:</span> <span>{{$studentObject->getRemaining()}} phút</span>
                            </li>
                            <li class="d-flex align-items-center"><i class="bx bx-history"></i><span
                                    class="fw-semibold mx-2">Số buổi đã học:</span>
                                <span>{{$studentObject->getLogCount()}}</span></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 col-lg-7 col-md-7">
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
                                                <a href="{{url("/logs/".$log->getId())}}" class="text-dark">{{$log->getTitle()}}</a>
                                            </h5>
                                            <small class="text-muted">{{$log->getDate()}}</small>
                                        </div>
                                        <a href="{{url("/teachers/".$log->getTeacher()->getId())}}" class="mb-2">Upload
                                            by {{$log->getTeacher()->getName()}}
                                            <img src="{{asset($log->getTeacher()->getAvatar())}}"
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
