@php
    use App\ViewModels\Log\LogShowViewModel;
    /**
    * @var LogShowViewModel $logShowViewModel
    */
    $log = $logShowViewModel->getLog();
    $comments = $logShowViewModel->getComments();
    $recommend = $logShowViewModel->getRecommendLog();
@endphp
@extends("layouts.app")
@section("title")
    Bizenglish::{{$log->getTitle()}}
@endsection
@section("content")
    <div class="container-fluid">
        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-dark fw-light">
                <a onclick="window.history.back()" style="cursor: pointer"><i class="bx bx-arrow-back"></i></a>
              Nhật ký bài học : {{$log->getTitle()}}
            </span>
        </h4>
        <div class="row">
            <div class="col-lg-8 col-12">
                <div class="ratio-16x9 ratio rounded">
                    <iframe class="rounded card"
                            src="{{$log->getEmbed()}}"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen
                            title="">
                    </iframe>
                </div>
                <div class="mt-3">
                    <div class="h4 fw-bold">{{$log->getTitle()}}</div>
                    <div class="card p-3 ">
                        <div class="d-flex mb-2">
                            <i class="bx bx-calendar"></i> <span class="px-1">{{$log->getDate()}}</span>
                            <i class="bx bx-time"></i> <span class="px-1">{{$log->getTime()}}</span>
                        </div>
                        <div class="d-flex mb-2">
                            <i class="bx bx-chalkboard"></i>
                            <span class="px-1">Lớp :
                                <a href="{{$log->getGrade()->getId()}}">
                                    {{$log->getGrade()->getName()}}
                                </a>
                            </span>
                        </div>
                        <div class="d-flex mb-2">
                            <i class="bx bx-user"></i>
                            @if($log->getTeacher())
                                <span class="px-1">Giáo viên :
                                <a href="{{url("teachers/".$log->getTeacher()->getId())}}">
                                    {{$log->getTeacher()->getName()}}
                                </a>
                            </span>
                            @endif
                        </div>
                        <div class="d-flex mb-2">
                            <i class="bx bx-user"></i> <span class="px-1">Học viên :
                            @foreach($log->getStudents() as $student)
                                    <a href="{{url("students/".$student->getId())}}">{{$student->getName()}}</a>
                                @endforeach
                            </span>
                        </div>
                        <div class="d-flex mb-2 flex-column">
                            <div>
                                <i class="bx bx-comment"></i> <span class="px-1">Giáo viên đã nhận xét :</span>
                            </div>
                            <div>
                                {{$log->getAssessment()}}
                            </div>
                        </div>
                    </div>
                    <div class="card p-3 mt-2">
                        <div class="mb-3">
                            <form>
                                <div class="input-group">
                                    @csrf
                                    <input type="hidden" name="user_id"
                                           value="{{\Illuminate\Support\Facades\Auth::id()}}">
                                    <input type="text" name="message" class="form-control border-0 border-bottom"
                                           placeholder="Viết bình luận">
                                    <button class="btn border-bottom border-0" type="submit">
                                        <i class="bx bx-send"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        @foreach($comments as $comment)
                            <div class="comment d-flex flex-wrap my-2">
                                <div class="avatar me-3">
                                    <img
                                        src="{{$comment->getAvatar()}}"
                                        alt="Avatar" class="rounded-circle">
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">{{$comment->getUsername()}}</h6>
                                    <span>
                                    {{$comment->getMessage()}}
                                </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-12">
                @foreach($recommend as $log)
                    <div class="recommend row mb-2">
                        <div class="col-md-6">
                            <div class="ratio-16x9 ratio">
                                <a href="{{url("/logs/".$log->getId())}}">
                                    <img
                                        src="https://www.englishexplorer.com.sg/wp-content/uploads/2017/02/english-course.jpg"
                                        class="w-100">
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="fw-bold">
                                <a href="{{url("/logs/".$log->getId())}}" class="text-dark">{{$log->getTitle()}}</a>
                            </div>
                            <div class="mt-2">
                                <i class="bx bxs-check-circle"></i>
                                @if($log->getTeacher())
                                    <a href="{{url("teachers/".json_decode($log->getTeacher())->id)}}">
                                        <span
                                            class="ml-1 text-secondary">{{json_decode($log->getTeacher())->name}}</span>
                                    </a>
                                @endif
                            </div>
                            <div class="mt-2">
                                <i class="bx bx-alarm"></i>
                                {{$log->getDate()}}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
