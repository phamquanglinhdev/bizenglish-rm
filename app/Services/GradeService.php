<?php

namespace App\Services;

use App\Contract\CrudServicesInterface;
use App\Models\Grade;
use App\Models\Log;
use App\Repositories\ClientRepository;
use App\Repositories\GradeRepository;
use App\Repositories\MenuRepository;
use App\Repositories\StaffRepository;
use App\Repositories\StudentRepository;
use App\Repositories\SupporterRepository;
use App\Repositories\TeacherRepository;
use App\Untils\DataBroTable;
use App\ViewModels\Entry\CrudEntry;
use App\ViewModels\Entry\SetupEntry;
use App\ViewModels\Grade\GradeListViewModel;
use App\ViewModels\Grade\GradeShowViewModel;
use App\ViewModels\Grade\Object\GradeListObject;
use App\ViewModels\Grade\Object\GradeShowObject;
use App\ViewModels\Grade\Object\GradeStoreObject;
use App\ViewModels\Grade\Object\LogGradeObject;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class GradeService implements CrudServicesInterface
{
    /**
     * @param GradeRepository $gradeRepository
     * @param StaffRepository $staffRepository
     * @param TeacherRepository $teacherRepository
     * @param StudentRepository $studentRepository
     * @param ClientRepository $clientRepository
     * @param SupporterRepository $supporterRepository
     * @param MenuRepository $menuRepository
     */
    public function __construct(
        private readonly GradeRepository     $gradeRepository,
        private readonly StaffRepository     $staffRepository,
        private readonly TeacherRepository   $teacherRepository,
        private readonly StudentRepository   $studentRepository,
        private readonly ClientRepository    $clientRepository,
        private readonly SupporterRepository $supporterRepository,
        private readonly MenuRepository      $menuRepository,
    )
    {
    }

    public function setup(): SetupEntry
    {
        $entry = new SetupEntry();
        return $entry;
    }

    public function setupListOperation(): array
    {
        return [
            'name' => 'Tên lớp',
            'students' => 'Học sinh',
            'teachers' => 'Giáo viên',
            'staffs' => 'Nhân viên quản lý',
            'supporters' => 'Nhân viên hỗ trợ',
            'clients' => 'Đối tác',
            'link' => 'Link lớp',
            'pricing' => 'Gói học phí',
            'minutes' => 'Số phút',
            'remaining' => 'Số phút còn lại',
            'attachment' => 'Tài liệu',
            'status' => 'Trạng thái',
            'created_at' => 'Ngày tạo lớp',
        ];
    }

    public function setupFilterOperation($old = []): array
    {
        return [
            [
                'name' => 'name',
                'label' => 'Tên lớp',
                'type' => 'text',
                'value' => $old['name'] ?? null,
            ],
            [
                'name' => 'staffs',
                'label' => 'Nhân viên',
                'type' => 'text',
                'value' => $old['staffs'] ?? null,
            ],
            [
                'name' => 'supporters',
                'label' => 'Nhân viên hỗ trợ',
                'type' => 'text',
                'value' => $old['supporters'] ?? null,
            ],
            [
                'name' => 'students',
                'label' => 'Học sinh',
                'type' => 'text',
                'value' => $old['students'] ?? null,
            ],
            [
                'name' => 'teachers',
                'label' => 'Giáo viên',
                'type' => 'text',
                'value' => $old['teachers'] ?? null,
            ],
            [
                'name' => 'clients',
                'label' => 'Đối tác',
                'type' => 'text',
                'value' => $old['clients'] ?? null,
            ],
            [
                'name' => 'status',
                'label' => 'Trạng thái lớp',
                'type' => 'select2',
                'options' => [
                    0 => 'Đang học',
                    2 => 'Đang bảo lưu'
                ],
                'nullable' => true,
                'value' => $old['status'] ?? null,
            ],
            [
                'name' => 'remaining',
                'label' => 'Số phút còn lại',
                'type' => 'select2',
                'options' => [
                    0 => 'Trên 90',
                    1 => 'Dưới 90 phút',
                    2 => 'Đã quá hạn'
                ],
                'nullable' => true,
                'value' => $old['remaining'] ?? null,
            ],

        ];
    }

    /**
     * @param Grade|null $old
     * @return CrudEntry
     */
    public function setupCreateOperation(Grade $old = null): CrudEntry
    {
        $entry = new CrudEntry("grades", $old->id ?? null, "Lớp học");
        $entry->addField([
            'name' => 'name',
            'label' => 'Tên lớp học',
            'class' => 'col-md-6',
            'value' => $old["name"] ?? null,
            'type' => 'text',
        ]);
        $entry->addField([
            'name' => 'zoom',
            'label' => 'Link lớp học',
            'class' => 'col-md-6',
            'value' => $old["zoom"] ?? null,
            'type' => 'text',
        ]);
        $entry->addField([
            'name' => 'pricing',
            'label' => 'Gói học phí',
            'class' => 'col-md-6',
            'value' => $old["pricing"] ?? null,
            'type' => 'numbers',
        ]);
        $entry->addField([
            'name' => 'minutes',
            'label' => 'Số phút',
            'class' => 'col-md-6',
            'value' => $old["minutes"] ?? null,
            'type' => 'numbers',
        ]);
        if (principal()->getType() == 0) {
            $entry->addField([
                'name' => "staffs",
                'label' => 'Nhân viên',
                'class' => 'col-md-6',
                'type' => 'select2_relation',
                'value' => [principal()->getId()],
                'options' => $this->staffRepository->getForSelect(),
                'disable' => true,
            ]);
        } else {
            $entry->addField([
                'name' => "staffs",
                'label' => 'Nhân viên',
                'class' => 'col-md-6',
                'type' => 'select2_relation',
                'value' => $old?->Staffs()->allRelatedIds()->toArray(),
                'options' => $this->staffRepository->getForSelect()
            ]);
        }
        $entry->addField([
            'name' => "supporters",
            'label' => 'Nhân viên hỗ trợ',
            'color' => 'primary',
            'class' => 'col-md-6',
            'type' => 'select2_relation',
            'value' => $old?->Supporters()->allRelatedIds()->toArray(),
            'options' => $this->supporterRepository->getForSelect()
        ]);
        $entry->addField([
            'name' => "students",
            'label' => 'Học sinh',
            'class' => 'col-md-6',
            'color' => 'danger',
            'type' => 'select2_relation',
            'value' => $old?->Students()->allRelatedIds()->toArray() ?? null,
            'options' => $this->studentRepository->getForSelect()
        ]);
        $entry->addField([
            'name' => "teachers",
            'label' => 'Giáo viên',
            'color' => 'secondary',
            'class' => 'col-md-6',
            'type' => 'select2_relation',
            'value' => $old?->Teachers()->allRelatedIds()->toArray() ?? null,
            'options' => $this->teacherRepository->getForSelect()
        ]);

        $entry->addField([
            'name' => "clients",
            'label' => 'Đối tác',
            'color' => 'dark',
            'class' => 'col-md-6',
            'type' => 'select2_relation',
            'value' => $old?->Clients()->allRelatedIds()->toArray() ?? null,
            'options' => $this->clientRepository->getForSelect()
        ]);
        $entry->addField([
            'name' => "status",
            'label' => 'Trạng thái lớp',
            'color' => 'dark',
            'class' => 'col-md-6',
            'type' => 'select2',
            'options' => [
                0 => 'Đang hoạt động',
                1 => 'Đã kết thúc',
                2 => 'Đã bảo lưu',
            ]
        ]);
        $entry->addField([
            'name' => 'attachment',
            'type' => 'text',
            'label' => 'Tài liệu',
            'value' => $old['attachment'] ?? null,
            'class' => 'col-md-6',
        ]);
        $entry->addField([
            'name' => 'lessons',
            'type' => 'numbers',
            'label' => 'Số buổi học',
            'value' => $old['lessons'] ?? null,
            'class' => 'col-md-6',
        ]);
        $entry->addField([
            'name' => "time",
            'label' => 'Lịch học',
            'color' => 'dark',
            'type' => 'repeatable',
            'value' => $old["time"] ?? null,
            'sub_fields' => [
                [
                    'name' => 'day',
                    'class' => 'col-md-5',
                    'type' => 'select',
                    'label' => 'Ngày',
                    'options' => [
                        'mon' => 'Thứ hai',
                        'tue' => 'Thứ ba',
                        'wed' => 'Thứ tư',
                        'thu' => 'Thứ năm',
                        'fri' => 'Thứ sáu',
                        'sat' => 'Thứ bảy',
                        'sun' => 'Chủ nhật'
                    ]
                ],
                [
                    'name' => 'value',
                    'type' => 'text',
                    'label' => 'Thời gian',
                    'class' => 'col-md-5',
                ]
            ]

        ]);
        $entry->addField([
            'name' => 'information',
            'type' => 'textarea',
            'label' => 'Thông tin chi tiết'
        ]);

        $entry->addField([
            'name' => 'menus',
            'type' => 'select2_relation',
            'label' => 'Bộ sách được sử dụng',
            'color' => 'warning',
            'value' => $old?->Menus()->allRelatedIds()->toArray(),
            'options' => $this->menuRepository->getForSelect(false)
        ]);
        return $entry;
    }

    /**
     * @param $id
     * @return CrudEntry
     */
    public function setupEditOperation($id): CrudEntry
    {
        /**
         * @var Grade $grade
         */
        $grade = $this->gradeRepository->show($id);
        return $this->setupCreateOperation($grade);
    }

    public function validate($attributes): \Illuminate\Validation\Validator
    {

        return Validator::make($attributes, [
            'name' => 'required',
            'pricing' => 'numeric|required|min:0',
            'minutes' => 'numeric|required|min:0',
            'staffs' => 'required',
        ], [
            'name.required' => 'Tên lớp không được để trống',
            'pricing.required' => 'Gói học phí không được để trống',
            'pricing.numeric' => 'Vui lòng nhập số',
            'pricing.min' => 'Gói học phí không được âm',
            'minutes.required' => 'Số phút không được để trống',
            'minutes.numeric' => 'Vui lòng nhập số',
            'minutes.min' => 'Số phút không được âm',
            'staffs.required' => 'Cần ít nhất 1 nhân viên quản lý',

        ]);
    }

    public function sync($grade, $attributes): void
    {
        $this->gradeRepository->syncRelation($grade, "Staffs", $attributes["staffs"] ?? []);
        $this->gradeRepository->syncRelation($grade, "Supporters", $attributes["supporters"] ?? []);
        $this->gradeRepository->syncRelation($grade, "Teachers", $attributes["teachers"] ?? []);
        $this->gradeRepository->syncRelation($grade, "Students", $attributes["students"] ?? []);
        $this->gradeRepository->syncRelation($grade, "Clients", $attributes["clients"] ?? []);
        $this->gradeRepository->syncRelation($grade, "Menus", $attributes["menus"] ?? []);
    }

    public function list($attributes): JsonResponse
    {
        $gradesCollections = $this->gradeRepository->index($attributes);
        $count = $this->gradeRepository->count($attributes);
        $gradesViewModel = new GradeListViewModel(
            grades: $gradesCollections->map(
                fn(Grade $grade) => (new GradeListObject(
                    id: $grade['id'],
                    name: $grade['name'],
                    students: implode(",", $grade->Students()->get()->pluck("name")->toArray()),
                    teachers: implode(",", $grade->Teachers()->get()->pluck("name")->toArray()),
                    staffs: implode(",", $grade->Staffs()->get()->pluck("name")->toArray()),
                    supporters: implode(",", $grade->Supporters()->get()->pluck("name")->toArray()),
                    clients: implode(",", $grade->Clients()->get()->pluck("name")->toArray()),
                    link: $grade['zoom'] ?? "-",
                    pricing: $grade["pricing"],
                    minutes: $grade["minutes"] ?? 0,
                    remaining: $grade->minutes - $grade->Logs()->sum("duration"),
                    attachment: $grade['attachment'] ?? "-",
                    status: $grade->getStatus(),
                    created_at: $grade['created_at'],
                ))->toArray()
            )->toArray(), label: "Lớp học");
        return DataBroTable::collect($gradesViewModel->getGrades(), $count, $attributes);
    }

    public function store($attributes): RedirectResponse
    {
        if (principal()->getType() == 0) {
            $attributes["staffs"] = [principal()->getId()];
        }
        $validate = $this->validate($attributes);
        if ($validate->fails()) {
            return redirect()->back()->withInput($attributes)->withErrors($validate->errors());
        }
        $storeObject = new GradeStoreObject(
            name: $attributes['name'],
            zoom: $attributes["zoom"],
            pricing: $attributes['pricing'],
            minutes: $attributes['minutes'],
            status: $attributes['status'],
            time: json_encode($attributes['time']),
            lessons: $attributes["lessons"],
            information: $attributes['information'],
            attachment: $attributes['attachment'],
        );
        $grade = $this->gradeRepository->create($storeObject->toArray());
        $this->sync($grade, $attributes);
        return to_route("grades.index")->with("success", "Thêm thành công");
    }

    public function update($attributes, $id)
    {
        if (principal()->getType() == 0) {
            $attributes["staffs"] = [principal()->getId()];
        }
        $old = $this->gradeRepository->show($id);
        if (!isset($old->id)) {
            return to_route("grade.index");
        }
        $validate = $this->validate($attributes);
        if ($validate->fails()) {
            return redirect()->back()->withInput($attributes)->withErrors($validate->errors());
        }
        $storeObject = new GradeStoreObject(
            name: $attributes['name'],
            zoom: $attributes["zoom"],
            pricing: $attributes['pricing'],
            minutes: $attributes['minutes'],
            status: $attributes['status'],
            time: json_encode($attributes['time']),
            lessons: $attributes["lessons"],
            information: $attributes['information'],
            attachment: $attributes['attachment'],
        );
        $this->gradeRepository->update($storeObject->toArray(), $id);
        $this->sync($old, $attributes);
        return to_route("grades.index")->with("success", "Cập nhật thành công");
    }

    public function delete($id)
    {
        $old = $this->gradeRepository->show($id);
        if (!isset($old->id)) {
            return to_route("grade.index");
        }
        $this->sync($old, []);
        $this->gradeRepository->update(['disable' => 1], $id);

    }

    public function showGrade($id): GradeShowViewModel|RedirectResponse
    {
        /**
         * @var Grade $gradeModel
         */
        $gradeModel = $this->gradeRepository->show($id);
        if (!isset($gradeModel->id)) {
            return to_route("grades.index")->with("success", "Không tìm thấy");
        }
        $logs = $gradeModel->Logs()->orderBy("created_at", "DESC")->where("teacher_id", "!=", null)->get();
        return new GradeShowViewModel(grade: new GradeShowObject(
            id: $gradeModel['id'],
            name: $gradeModel['name'],
            teachers: $gradeModel->Teachers()->pluck("name", "id")->toArray(),
            zoom: $gradeModel['zoom'],
            students: $gradeModel->Students()->get()->pluck("name", "id")->toArray(),
            clients: $gradeModel->Clients()->get()->pluck("name", "id")->toArray(),
            staffs: $gradeModel->Staffs()->get()->pluck("name", "id")->toArray(),
            minutes: $gradeModel['minutes'],
            remaining: $gradeModel->getRs(),
            information: $gradeModel['information'],
            pricing: $gradeModel['pricing'],
            attachment: $gradeModel['attachment'],
            created_at: $gradeModel['created_at'],
            time: $gradeModel['time']
        ), logs: $logs->map(
            fn(Log $log) => (new LogGradeObject(
                id: $log['id'],
                date: $log['date'],
                start: $log["start"],
                end: $log['end'],
                teacher: $log->Teacher()->first(),
                lesson: $log['lesson'],
                teacher_video: $log['teacher_video'],
                drive: $log['drive'],
            ))
        ));
    }

    public function export($attributes, $cols = [])
    {
        $title = $this->setupListOperation();
        $collection = $this->gradeRepository->index($attributes);
        $exportData = $collection->map(function (Grade $grade) {
            return [
                'name' => $grade["name"],
                'students' => implode($grade->Students()->get()->pluck('name', "id")->toArray()),
                'teachers' => implode($grade->Teachers()->get()->pluck('name', "id")->toArray()),
                'staffs' => implode($grade->Staffs()->get()->pluck('name', "id")->toArray()),
                'supporters' => implode($grade->Supporters()->get()->pluck('name', "id")->toArray()),
                'clients' => implode($grade->Clients()->get()->pluck('name', "id")->toArray()),
                'link' => $grade["zoom"],
                'pricing' => $grade["pricing"],
                'minutes' => $grade["minutes"],
                'remaining' => $grade["remaining"],
                'attachment' => $grade["attachment"],
                'status' => $grade->getStatus(),
                'created_at' => $grade["created_at"],
            ];
        })->toArray();
        return array($title, $exportData);
    }
}
