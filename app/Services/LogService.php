<?php

namespace App\Services;

use App\Models\Log;
use App\Repositories\ClientRepository;
use App\Repositories\GradeRepository;
use App\Repositories\LogRepository;
use App\Repositories\StudentRepository;
use App\Repositories\TeacherRepository;
use App\ViewModels\Log\LogListViewModel;
use App\ViewModels\Log\Object\LogListObject;
use Illuminate\Http\JsonResponse;
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
//            'grade' => 'Lớp',
            'date' => 'Ngày',
            'start' => 'Bắt đầu',
            'end' => 'Kết thúc',
//            'students' => 'Học sinh',
//            'teacher' => 'Giáo viên',
//            'clients' => 'Đối tác',
//            'partner' => 'Đối tác cung cấp',
            'lesson' => 'Bài học',
            'teacher_video' => 'Video',
            'drive' => 'Video(Drive)',
            'duration' => 'Thời lượng',
            'hour_salary' => 'Lương theo giờ',
            'log_salary' => 'Lương buổi học',
            'status' => 'Tình trạng lớp học',
            'assessments' => 'Nhận xét của giáo viên',
            'attachments' => 'Đính kèm',
//            'confirm' => 'HS Xác nhận',
        ];
    }

    public
    function setupFilterOperation($attributes = []): array
    {
        return [];
        // TODO: Implement setupFilterOperation() method.
    }

    public
    function setupCreateOperation()
    {

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
                    status: $log['status'],
                    assessments: $log['assessments'],
                    attachments: [],
                    confirm: "-"
                ))->toArray()
            )->toArray(), label: "Nhật ký lớp học");
        return DataTables::collection($logListViewModel->getLogs())
            ->addColumn("action", function ($grade) {
                return view("admin.operations.columns.actions", ['entry' => 'grades', 'id' => $grade['id']]);
            })
            ->addColumn("teacher_video", function ($grade) {
                return view("admin.operations.columns.video", ['video' => $grade["teacher_video"]]);
            })
            ->addColumn("drive", function ($grade) {
                return view("admin.operations.columns.drive", ['link' => $grade["drive"]]);
            })
            ->rawColumns(["action", "teacher_video"])
            ->toJson();
    }
}
