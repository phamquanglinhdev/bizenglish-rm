<?php

namespace App\Services;

use App\Models\Log;
use App\Repositories\ClientRepository;
use App\Repositories\GradeRepository;
use App\Repositories\LogRepository;
use App\Repositories\StudentRepository;
use App\Repositories\TeacherRepository;
use App\Untils\DataBroTable;
use App\ViewModels\Entry\CrudEntry;
use App\ViewModels\Log\LogListViewModel;
use App\ViewModels\Log\Object\LogListObject;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class LogService implements \App\Contract\CrudServicesInterface
{
    public function __construct(
        private readonly GradeRepository   $gradeRepository,
        private readonly LogRepository     $logRepository,
        private readonly StudentRepository $studentRepository,
        private readonly TeacherRepository $teacherRepository,
        private readonly ClientRepository  $clientRepository,
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
            'assessments' => 'Nhận xét của giáo viên',
            'attachments' => 'Đính kèm',
            'confirm' => 'HS Xác nhận',
        ];
    }

    public
    function setupFilterOperation($attributes = []): array
    {
        return [];
        // TODO: Implement setupFilterOperation() method.
    }

    public
    function setupCreateOperation(): CrudEntry
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
            'name' => 'date',
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
            'name' => 'hour_salarary',
            'label' => 'Lương / Giờ',
            'class' => 'col-md-6',
            'value' => $old["end"] ?? null,
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
                    'value' => $old["teacher_video"] ?? null,
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
    function setupEditOperation($id)
    {
        // TODO: Implement setupEditOperation() method.
    }

    /**
     * @throws \Exception
     */
    public function getEntriesAsJsonForDatatables($draw, $rows, $totalRows, $filteredRows): array
    {

        return [
            'draw' => $draw,
            'recordsTotal' => $totalRows,
            'recordsFiltered' => $filteredRows,
            'data' => $rows,
        ];
    }

    public function list($attributes): JsonResponse
    {
        $logCollections = $this->logRepository->index($attributes);
        $count = $this->logRepository->count($attributes);
        $logListViewModel = new LogListViewModel(
            logs: $logCollections->map(
                fn(Log $log) => (new LogListObject(
                    id: $log['id'],
                    grade: $log->grade()->first()->name,
                    date: $log['date'],
                    start: $log['start'],
                    end: $log['end'],
                    teacher: "-",
                    students: [],
                    clients: [],
                    partner: "-",
                    lesson: $log['lesson'],
                    teacher_video: $log['teacher_video'],
                    drive: $log['drive'],
                    duration: $log['duration'],
                    hour_salary: $log['hour_salary'],
                    log_salary: $log['log_salary'],
                    status: Str::limit($log->StatusShow(), 40),
                    assessments: $log['assessments'],
                    attachments: [],
                    confirm: "-"
                ))->toArray()
            )->toArray(), label: "Nhật ký lớp học");
        return DataBroTable::collect($logListViewModel->getLogs(), $count, $attributes);
    }
}
