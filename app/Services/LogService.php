<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Grade;
use App\Models\Log;
use App\Models\Student;
use App\Models\Teacher;
use App\Repositories\ClientRepository;
use App\Repositories\CommentRepository;
use App\Repositories\GradeRepository;
use App\Repositories\LogRepository;
use App\Repositories\StudentRepository;
use App\Repositories\TeacherRepository;
use App\Untils\DataBroTable;
use App\Untils\EzUpload;
use App\ViewModels\Entry\CrudEntry;
use App\ViewModels\Log\LogListViewModel;
use App\ViewModels\Log\LogShowViewModel;
use App\ViewModels\Log\Object\LogCommentsObject;
use App\ViewModels\Log\Object\LogGradeObject;
use App\ViewModels\Log\Object\LogListObject;
use App\ViewModels\Log\Object\LogShowObject;
use App\ViewModels\Log\Object\LogStoreObject;
use App\ViewModels\Log\Object\RecommendLogObject;
use App\ViewModels\Log\Object\StudentLogObject;
use App\ViewModels\Log\Object\TeacherLogObject;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\FileBag;
use Yajra\DataTables\Facades\DataTables;

class LogService implements \App\Contract\CrudServicesInterface
{
    public function __construct(
        private readonly GradeRepository   $gradeRepository,
        private readonly LogRepository     $logRepository,
        private readonly TeacherRepository $teacherRepository,
        private readonly CommentRepository $commentRepository,
    )
    {
    }

    public
    function setupListOperation(): array
    {
        // TODO: Implement setupListOperation() method.
        return [
            'grade' => 'Lớp',
            'date' => 'Ngày',
            'start' => 'Bắt đầu',
            'end' => 'Kết thúc',
            'students' => 'Học sinh',
            'teacher' => 'Giáo viên',
            'clients' => 'Đối tác',
            'partner' => 'Đối tác cung cấp',
            'lesson' => 'Bài học',
            'teacher_video' => 'Video',
            'drive' => 'Video(Drive)',
            'duration' => 'Thời lượng',
            'hour_salary' => 'Lương theo giờ',
            'log_salary' => 'Lương buổi học',
            'status' => 'Tình trạng lớp học',
            'assessment' => 'Nhận xét của giáo viên',
            'attachments' => 'Đính kèm',
            'confirm' => 'HS Xác nhận',
        ];
    }

    public
    function setupFilterOperation($old = []): array
    {
        return [
            [
                'name' => 'grade',
                'label' => 'Lớp',
                'type' => 'text',
                'value' => $old['grade'] ?? null,
            ],
            [
                'name' => 'student',
                'label' => 'Học sinh',
                'type' => 'text',
                'value' => $old['student'] ?? null,
            ],
            [
                'name' => 'teacher',
                'label' => 'Giáo viên',
                'type' => 'text',
                'value' => $old['teacher'] ?? null,
            ],
            [
                'name' => 'client',
                'label' => 'Đối tác',
                'type' => 'text',
                'value' => $old['client'] ?? null,
            ],
            [
                'name' => 'partner',
                'label' => 'Đối tác cung cấp',
                'type' => 'text',
                'value' => $old['partner'] ?? null,
            ],
            [
                'name' => 'status',
                'label' => 'Tình trạng lớp học',
                'type' => 'select2',
                'value' => $old['status'] ?? null,
                'options' => [
                    'all' => null,
                    0 => 'Học viên và giáo viên vào đúng giờ',
                    1 => 'Học sinh muộn',
                    2 => 'Giáo viên muộn',
                    3 => 'Học sinh hủy buổi học',
                    4 => 'Giáo viên hủy buổi học',
                ],

            ],
            [
                'name' => 'date',
                'label' => 'Ngày',
                'type' => 'date-range',
                'value' => $old['date'] ?? null,
            ],

        ];
        // TODO: Implement setupFilterOperation() method.
    }

    public
    function setupCreateOperation($old = null): CrudEntry
    {
        $entry = new CrudEntry("logs", $old->id ?? null, "Nhật ký");
        $entry->addField([
            'name' => 'grade_id',
            'label' => 'Lớp học',
            'value' => $old["grade_id"] ?? null,
            'type' => 'select2',
            'options' => $this->gradeRepository->getForSelect()
        ]);
        $entry->addField([
            'name' => 'teacher_id',
            'label' => 'Giáo viên',
            'value' => $old["teacher_id"] ?? null,
            'type' => 'select2',
            'options' => $this->teacherRepository->getForSelect()
        ]);
        $entry->addField([
            'name' => 'date',
            'label' => 'Ngày',
            'class' => 'col-md-4',
            'value' => $old["date"] ?? null,
            'type' => 'date',
        ]);
        $entry->addField([
            'name' => 'start',
            'label' => 'Bắt đầu',
            'class' => 'col-md-4',
            'value' => $old["start"] ?? null,
            'type' => 'time',
        ]);
        $entry->addField([
            'name' => 'end',
            'label' => 'Kết thúc',
            'class' => 'col-md-4',
            'value' => $old["end"] ?? null,
            'type' => 'time',
        ]);
        $entry->addField([
            'name' => 'duration',
            'label' => 'Thời lượng ( phút )',
            'class' => 'col-md-6',
            'value' => $old["duration"] ?? null,
            'type' => 'numbers',
        ]);
        $entry->addField([
            'name' => 'hour_salary',
            'label' => 'Lương / Giờ',
            'class' => 'col-md-6',
            'value' => $old["hour_salary"] ?? null,
            'type' => 'numbers',
        ]);
        $entry->addField([
            'name' => 'lesson',
            'label' => 'Bài học',
            'value' => $old["lesson"] ?? null,
            'type' => 'text',
        ]);
        $entry->addField([
            'type' => 'tab',
            'fields' => [
                [
                    'name' => 'teacher_video',
                    'icon' => 'https://cdn-icons-png.flaticon.com/512/3670/3670147.png',
                    'label' => 'Youtube Video',
                    'type' => 'text',
                    'value' => $old["teacher_video"] ?? null,
                ],
                [
                    'icon' => "https://freepngimg.com/download/gmail/66620-begins-google-attend-class;class-drive-upload-video.png",
                    'name' => 'drive',
                    'label' => 'Google Drive Video',
                    'type' => 'text',
                    'value' => $old["drive"] ?? null,
                ],
            ]
        ]);
        $entry->addField([
            'name' => 'information',
            'label' => 'Nội dung',
            'value' => $old["information"] ?? null,
            'type' => 'textarea',
        ]);
        $entry->addField([
            'name' => "status",
            'single' => true,
            'label' => 'Tình trạng lớp học',
            'type' => 'repeatable',
            'value' => $old["status"] ?? null,
            'sub_fields' => [
                [
                    'name' => 'name',
                    'class' => 'col-md-6',
                    'type' => 'select',
                    'label' => 'Ngày',
                    'options' => [
                        0 => 'Học viên và giáo viên vào đúng giờ',
                        1 => 'Học sinh muộn (Phút)',
                        2 => 'Giáo viên muộn (Phút)',
                        3 => 'Học sinh hủy trước (Giờ)',
                        4 => 'Giáo viên hủy trước (Giờ)',
                        5 => 'Khác',
                    ]
                ],
                [
                    'name' => 'time',
                    'type' => 'numbers',
                    'label' => 'Thời gian tương ứng (Nếu có)',
                    'class' => 'col-md-6',
                ],
                [
                    'name' => 'message',
                    'type' => 'textarea',
                    'label' => 'Ghi chú (Nếu có)',
                    'class' => 'col-md-12',
                ]
            ]

        ]);
        $entry->addField([
            'name' => 'assessment',
            'label' => 'Nhận xét của giáo viên về buổi học',
            'value' => $old["assessment"] ?? null,
            'type' => 'textarea',
        ]);
        $entry->addField([
            'name' => 'question',
            'label' => 'Bài tập',
            'value' => $old["question"] ?? null,
            'type' => 'textarea',
        ]);
        $entry->addField([
            'name' => 'attachments',
            'label' => 'Đính kèm',
            'value' => $old["attachments"] ?? null,
            'type' => 'upload_multiple',
        ]);

        return $entry;
    }

    public
    function setupEditOperation($id): CrudEntry
    {
        $old = $this->logRepository->show($id);
        if (!isset($old->id)) {
            return abort("404");
        }
        return $this->setupCreateOperation($old);
    }

    public function list($attributes): JsonResponse
    {
        $logCollections = $this->logRepository->index($attributes);
        $count = $this->logRepository->count($attributes);
        $logListViewModel = new LogListViewModel(
            logs: $logCollections->map(
                fn(Log $log) => (new LogListObject(
                    id: $log['id'],
                    grade: json_encode($log->grade()->first()),
                    date: $log['date'],
                    start: $log['start'],
                    end: $log['end'],
                    teacher: json_encode($log->Teacher()->first()),
                    students: $log->Students(),
                    clients: $log->Clients(),
                    partner: $log->Partner() ?? null,
                    lesson: $log['lesson'],
                    teacher_video: $log['teacher_video'],
                    drive: $log['drive'],
                    duration: $log['duration'],
                    hour_salary: $log['hour_salary'],
                    log_salary: $log['log_salary'],
                    status: Str::limit($log->StatusShow(), 40),
                    assessment: $log['assessment'],
                    attachments: json_decode($log['attachments']),
                    confirm: $log->StudentAccept()
                ))->toArray()
            )->toArray(), label: "Nhật ký lớp học");

        return DataBroTable::collect($logListViewModel->getLogs(), $count, $attributes);
    }

    public function validate($attributes): \Illuminate\Validation\Validator
    {
        return Validator::make($attributes,
            [
                'date' => 'required',
                'start' => 'required',
                'end' => 'required',
                'duration' => 'numeric|required|min:0',
                'hour_salary' => 'numeric|required|min:0',
                'lesson' => 'required',
                'status' => 'required',
            ],
            [
                'date.required' => 'Ngày không được để trống',
                'start.required' => 'Không được để trống',
                'end.required' => 'Không được để trống',
                'duration.numeric' => 'Nên ở dạng số',
                'duration.required' => 'Không được để trống',
                'duration.min' => 'Không được phép âm',
                'hour_salary.numeric' => 'Nên ở dạng số',
                'hour_salary.required' => 'Không được để trống',
                'hour_salary.min' => 'Không được phép âm',
                'lesson.required' => 'Bài học không được để trống',
                'status.required' => 'Trạng thái không được để trống',

            ]);
    }

    public function uploadFile(UploadedFile $file): string
    {
        return EzUpload::uploadToStorage($file, $file->getClientOriginalName(), "/logs");
    }

    public function store($attributes, array $files): RedirectResponse
    {

        $validate = $this->validate($attributes);
        if ($validate->fails()) {

            return redirect()->back()->withErrors($validate->errors());
        }
        $attributes['attachments'] = [];
        if (count($files) > 0) {
            foreach ($files['attachments'] as $file) {
                $attributes['attachments'][] = $this->uploadFile($file);
            }
        }
        $this->logRepository->create(
            (new LogStoreObject(
                grade_id: $attributes['grade_id'],
                teacher_id: $attributes['teacher_id'],
                date: $attributes['date'],
                start: $attributes['start'],
                end: $attributes['end'],
                duration: $attributes['duration'],
                hour_salary: $attributes['hour_salary'],
                log_salary: ($attributes['duration'] / 60) * $attributes['hour_salary'],
                lesson: $attributes['lesson'],
                teacher_video: $attributes['teacher_video'],
                drive: $attributes['drive'],
                information: $attributes['information'],
                status: json_encode($attributes['status']),
                assessment: $attributes['assessment'],
                question: $attributes['question'],
                attachments: json_encode($attributes['attachments'])
            ))->toArray()
        );
        return to_route("logs.index")->with("success", "Thêm thành công");
    }

    public function update(array $attributes, array $files, string $id): RedirectResponse
    {
        $validate = $this->validate($attributes);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->errors());
        }
        if (count($files) > 0) {
            $attributes['attachments'] = [];
            foreach ($files['attachments'] as $file) {
                $attributes['attachments'][] = $this->uploadFile($file);
            }
        } else {
            $attributes['attachments'] = json_decode($attributes['attachments-old']);
        }
        $this->logRepository->update((new LogStoreObject(
            grade_id: $attributes['grade_id'],
            teacher_id: $attributes['teacher_id'],
            date: $attributes['date'],
            start: $attributes['start'],
            end: $attributes['end'],
            duration: $attributes['duration'],
            hour_salary: $attributes['hour_salary'],
            log_salary: ($attributes['duration'] / 60) * $attributes['hour_salary'],
            lesson: $attributes['lesson'],
            teacher_video: $attributes['teacher_video'],
            drive: $attributes['drive'],
            information: $attributes['information'],
            status: json_encode($attributes['status']),
            assessment: $attributes['assessment'],
            question: $attributes['question'],
            attachments: $attributes['attachments'][0] ? json_encode($attributes['attachments']) : null
        ))->toArray(), $id);
        return to_route('logs.index')->with("success", "Cập nhập thành công");

    }

    public function delete($id): int
    {
        return $this->logRepository->delete($id);
    }

    public function showLog($id): LogShowViewModel
    {
        /**
         * @var Log $logCollection
         * @var Collection $students
         * @var Teacher $teacher
         * @var Grade $grade
         * @var Collection $comments
         * @var Collection $relationLogs
         */
        $logCollection = $this->logRepository->show($id);
        $teacher = $logCollection->Teacher()->first();
        $students = $logCollection->StudentsObject();
        $grade = $logCollection->Grade()->first();
        $comments = $this->commentRepository->getCommentByLogId($id);
        $relationLogs = $this->logRepository->getLogByGrade($grade["id"]);
        return new LogShowViewModel(
            log: new LogShowObject(
                id: $logCollection['id'],
                embed: $logCollection->getEmbed(),
                date: Carbon::parse($logCollection['date'])->isoFormat("DD-MM-YYYY"),
                time: $logCollection["start"] . "-" . $logCollection["end"],
                title: $logCollection['lesson'], grade: new LogGradeObject(id: $grade['id'], name: $grade["name"]),
                teacher: new TeacherLogObject($teacher["id"], $teacher["name"]),
                students: $students->map(
                    fn(Student $student) => new StudentLogObject(
                        id: $student["id"], name: $student['name']
                    )
                )->toArray(), assessment: $logCollection['assessment']
            ), recommendLog: $relationLogs->map(
            fn(Log $log) => new RecommendLogObject(
                id: $log["id"],
                teacher: $log->Teacher()->first(),
                title: $log["lesson"],
                date: $log["date"]
            )
        )->toArray(), comments: $comments->map(
            fn(Comment $comment) => new LogCommentsObject(
                id: $comment['id'],
                username: $comment->User()->first()->name,
                message: $comment["message"],
                avatar: $comment->User()->first()->avatar ?? "https://i.pinimg.com/736x/c1/9d/13/c19d1358a9f89027798c326898b22820.jpg"
            )
        )->toArray()
        );
    }
}
