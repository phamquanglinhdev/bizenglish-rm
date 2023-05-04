@php
    use App\ViewModels\Grade\GradeShowViewModel;
    use App\Untils\Transable;
    /**
    * @var GradeShowViewModel $gradeShowViewModel
    */
    $grade = $gradeShowViewModel->getGrade();
    $logs = $gradeShowViewModel->getLogs();
@endphp
@extends("layouts.app")
@section("title")
    Bizenglish::Chi tiết lớp {{$grade->getName()}}
@endsection
@section("content")
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">
                <a onclick="window.history.back()" style="cursor: pointer"><i class="bx bx-arrow-back"></i></a>
                Thông tin lớp học:</span> {{$grade->getName()}}
        </h4>
        <div class="row gy-4">
            <!-- User Sidebar -->
            <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
                <!-- User Card -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="user-avatar-section">
                            <div class=" d-flex align-items-center flex-column">
                                <img class="img-fluid rounded my-4"
                                     src="https://png.pngtree.com/png-vector/20190521/ourlarge/pngtree-school-icon-for-personal-and-commercial-use-png-image_1044880.jpg"
                                     height="110" width="110" alt="User avatar"/>
                                <div class="user-info text-center">
                                    <h5 class="mb-2">{{$grade->getName()}}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-around flex-wrap my-4 py-3">
                            <div class="d-flex align-items-start me-4 mt-3 gap-3">
                                            <span class="badge bg-label-primary p-2 rounded"><i
                                                    class='bx bx-check bx-sm'></i></span>
                                <div>
                                    <h5 class="mb-0">{{count($logs)}}</h5>
                                    <span>Buổi học</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-start mt-3 gap-3">
                                            <span class="badge bg-label-primary p-2 rounded"><i
                                                    class='bx bx-customize bx-sm'></i></span>
                                <div>
                                    <h5 class="mb-0">{{count($grade->getStudents())}}</h5>
                                    <span>Học sinh</span>
                                </div>
                            </div>
                        </div>
                        <h5 class="pb-2 border-bottom mb-4">Thông tin chi tiết </h5>
                        <div class="info-container">
                            <ul class="list-unstyled">
                                <li class="mb-3">
                                    <span class="fw-bold me-2">Giáo viên:</span>
                                    @foreach($grade->getTeachers() as $key => $teacher)
                                        <a class="badge bg-label-success"
                                           href="{{url('teachers/'.$key)}}">{{$teacher}}</a>
                                    @endforeach
                                </li>
                                <li class="mb-3">
                                    <span class="fw-bold me-2">Link lớp:</span>
                                    <a href="{{$grade->getZoom()}}">Click để mở</a>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-bold me-2">Học sinh:</span>
                                    @foreach($grade->getStudents() as $key => $student)
                                        <a class="badge bg-label-success"
                                           href="{{url('students/'.$key)}}">{{$student}}</a>
                                    @endforeach
                                </li>
                                <li class="mb-3">
                                    <span class="fw-bold me-2">Đối tác:</span>
                                    @foreach($grade->getClients() as $key => $clients)
                                        <a class="badge bg-label-success"
                                           href="{{url('clients/'.$key)}}">{{$clients}}</a>
                                    @endforeach
                                </li>
                                <li class="mb-3">
                                    <span class="fw-bold me-2">Nhân viên quản lý:</span>
                                    @foreach($grade->getStaffs() as $key => $staffs)
                                        <a class="badge bg-label-success"
                                           href="{{url('staffs/'.$key)}}">{{$staffs}}</a>
                                    @endforeach
                                </li>
                                <li class="mb-3">
                                    <span class="fw-bold me-2">Số phút học:</span>
                                    <span>{{number_format($grade->getMinutes())}}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-bold me-2">Số phút còn lại:</span>
                                    <span>{{number_format($grade->getRemaining())}}</span>
                                </li>
                                <li class="mb-3">
                                    <div class="fw-bold me-2">Thông tin chi tiết:</div>
                                    <q>{!! $grade->getInformation() !!}</q>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-bold me-2">Gói học phí:</span>
                                    <span>{{number_format($grade->getPricing())}} đ</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-bold me-2">Tài liệu:</span>
                                    <a href="{{$grade->getAttachment()}}">Click để xem</a>
                                </li>
                            </ul>
                            <div class="d-flex justify-content-center pt-3">
                                <a href="{{url("grades/".$grade->getId()."/edit")}}" class="btn btn-primary me-3">Chỉnh
                                    sửa</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ User Sidebar -->


            <!-- User Content -->
            <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
                <!-- User Pills -->

                <!-- Activity Timeline -->
                <div class="card mb-2">
                    <h5 class="card-header">Lịch học</h5>
                    <div class="card-body pt-2 pb-4">
                        <ul class="list-group list-group-timeline">
                            @foreach($grade->getTime() as $time)
                                <li class="list-group-item list-group-timeline-primary">
                                    <span class="badge bg-label-primary">
                                        {{Transable::WeekTranslate($time['day'])}}
                                    </span> : <span class="badge bg-label-primary">
                                        {{$time['value']}}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="card mb-4">
                    <h5 class="card-header">Nhật ký học</h5>
                    <div class="card-body pt-2 pb-4" style="overflow-y: scroll;max-height: 60vh">
                        <ul class="timeline">
                            @foreach($logs as $log)
                                <li class="timeline-item timeline-item-transparent">
                                    <span class="timeline-point timeline-point-primary"></span>
                                    <div class="timeline-event">
                                        <div class="timeline-header mb-1">
                                            <div class="mb-0 text-uppercase fw-bold">{{$log->getLesson()}}</div>
                                            <small class="text-muted">
                                                <div>
                                                    {{$log->getDate()}} {{$log->getStart()}}
                                                    -{{$log->getEnd()}}
                                                </div>
                                                <div>
                                                    <span class="bx bx-upload"></span>
                                                    <a class="badge bg-label-primary"
                                                       href="{{url("teachers/".$log->getTeacher()->id)}}">
                                                        Giáo viên: {{$log->getTeacher()->name}}
                                                    </a>
                                                </div>
                                            </small>

                                        </div>
                                        <div class="d-flex">
                                            @if($log->getTeacherVideo())
                                                <a class="badge bg-label-danger me-1"
                                                   href="{{$log->getTeacherVideo()->url}}"><i
                                                        class="bx bxl-youtube "></i>Youtube</a>
                                            @endif
                                            @if($log->getDrive())
                                                <a class="badge bg-label-primary me-1" href="{{$log->getDrive()}}"><i
                                                        class="bx  bx-video"></i>Google Drive</a>
                                            @endif

                                            <a class="badge bg-label-success me-1"
                                               href="{{url("logs/".$log->getId())}}"><i
                                                    class="bx  bx-info-circle "></i>Chi tiết</a>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                            <li class="timeline-end-indicator">
                                <i class="bx bx-check-circle"></i>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
            <!--/ User Content -->
        </div>
    </div>
@endsection
