<?php

namespace App\Services;

use App\Contract\CrudServicesInterface;
use App\Models\Demo;
use App\Models\Teacher;
use App\Repositories\ClientRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\DemoRepository;
use App\Repositories\GradeRepository;
use App\Repositories\StaffRepository;
use App\Repositories\StudentRepository;
use App\Repositories\SupporterRepository;
use App\Repositories\TeacherRepository;
use App\Untils\DataBroTable;
use App\Untils\EzUpload;
use App\ViewModels\Demo\DemoListViewModel;
use App\ViewModels\Demo\Object\DemoStoreObject;
use App\ViewModels\Entry\CrudEntry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;

class DemoService implements CrudServicesInterface
{
    public function __construct(
        private readonly DemoRepository      $demoRepository,
        private readonly StaffRepository     $staffRepository,
        private readonly SupporterRepository $supporterRepository,
        private readonly TeacherRepository   $teacherRepository,
        private readonly CustomerRepository  $customerRepository,
        private readonly ClientRepository    $clientRepository,
        private readonly StudentRepository   $studentRepository,
        private readonly GradeRepository     $gradeRepository,
    )
    {
    }

    public function setupListOperation(): array
    {
        return [
            "date" => 'Ngày',
            "start" => "Bắt đầu",
            "end" => "Kết thúc",
            "grade" => "Lớp",
            "students" => "Học sinh",
            "teacher_id" => "Giáo viên",
            "staff_id" => "Nhân viên",
            "supporter_id" => "Hỗ trợ viên",
            "client_id" => "Đối tác",
            "customers" => "Khách hàng",
            "student_phone" => "Số điện thoại",
            "facebook" => "Facebook",
            "lesson" => "Bài học",
            "teacher_video" => "Youtube Video",
            "drive" => "Drive Video",
            "duration" => "Thời lượng",
            "hour_salary" => "Lương theo giờ",
            "log_salary" => "Lương buổi học",
            "assessment" => "Nhận xét của giáo viên",
            "attachments" => "Đính kèm",
            "status" => "Tình trạng lớp học",
        ];
    }

    public function list($attributes): JsonResponse
    {
        $count = $this->demoRepository->count($attributes);
        $demoCollection = $this->demoRepository->index($attributes);
        $demoListViewModel = new DemoListViewModel(demos: $demoCollection);
        return DataBroTable::collect($demoListViewModel->getDemos(), $count, $attributes);
    }

    public function setupFilterOperation($old = []): array
    {
        return [
            [
                'name' => 'grade',
                'label' => 'Tên lớp',
                'type' => 'text',
                'value' => $old['grade'] ?? null,
            ],
            [
                'name' => 'staff',
                'label' => 'Nhân viên',
                'type' => 'text',
                'value' => $old['staff'] ?? null,
            ],
            [
                'name' => 'supporter',
                'label' => 'Nhân viên hỗ trợ',
                'type' => 'text',
                'value' => $old['supporter'] ?? null,
            ],
            [
                'name' => 'student',
                'label' => 'Học sinh',
                'type' => 'text',
                'value' => $old['student'] ?? null,
            ],
            [
                'name' => 'customer',
                'label' => 'Khách hàng',
                'type' => 'text',
                'value' => $old['customer'] ?? null,
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
                'name' => 'date',
                'label' => 'Ngày',
                'type' => 'date-range',
                'value' => $old['date'] ?? null,
            ],

        ];
    }

    public function setupCreateOperation($old = null): CrudEntry
    {
        /**
         * @var Demo $old
         */
        $entry = new CrudEntry("demos", $old->id ?? null, "Lớp học demo");
        $entry->addField([
            'name' => 'grade',
            'label' => 'Tên lớp',
            'class' => 'col-md-6',
            'value' => $old["grade"] ?? null,
            'type' => 'text'
        ]);
        $entry->addField([
            'name' => 'customers',
            'label' => 'Khách hàng',
            'class' => 'col-md-6',
            'type' => 'select2_relation',
            'value' => $old?->Customer()->allRelatedIds()->toArray(),
            'options' => $this->customerRepository->getForSelect(),
        ]);
        $entry->addField([
            'name' => 'student_phone',
            'label' => 'Số điện thoại',
            'class' => 'col-md-6',
            'value' => $old["student_phone"] ?? null,
            'type' => 'text'
        ]);
        $entry->addField([
            'name' => 'facebook',
            'label' => 'Facbook',
            'class' => 'col-md-6',
            'value' => $old["facebook"] ?? null,
            'type' => 'text'
        ]);
        $entry->addField([
            'name' => 'students',
            'label' => 'Học sinh',
            'class' => 'col-md-6',
            'value' => $old["students"] ?? null,
            'type' => 'text'
        ]);
        $entry->addField([
            'name' => 'teacher_id',
            'label' => 'Giáo viên',
            'class' => 'col-md-6',
            'type' => 'select2',
            'value' => $old["teacher_id"] ?? null,
            'options' => $this->teacherRepository->getForSelect(),
        ]);
        $entry->addField([
            'name' => 'client_id',
            'label' => 'Đối tác',
            'class' => 'col-md-6',
            'type' => 'select2',
            'value' => $old["client_id"] ?? null,
            'options' => $this->clientRepository->getForSelect(),
        ]);
        if (principal()->getType() == "-1") {
            $entry->addField([
                'name' => 'staff_id',
                'label' => 'Nhân viên',
                'class' => 'col-md-6',
                'type' => 'select2',
                'value' => $old["staff_id"] ?? null,
                'options' => $this->staffRepository->getForSelect(),
            ]);
        } else {
            $entry->addField([
                'name' => "staff_id",
                'label' => 'Nhân viên',
                'class' => 'col-md-6',
                'type' => 'select2',
                'value' => [principal()->getId()] ?? null,
                'options' => $this->staffRepository->getForSelect(),
                'disable' => true,
            ]);
        }
        $entry->addField([
            'name' => 'supporter_id',
            'label' => 'Nhân viên hỗ trợ',
            'class' => 'col-md-6',
            'type' => 'select2',
            'value' => $old["supporter_id"] ?? null,
            'options' => $this->supporterRepository->getForSelect(),
        ]);
        $entry->addField([
            'name' => 'date',
            'label' => 'Ngày',
            'class' => 'col-md-6',
            'type' => 'date',
            'value' => $old["date"] ?? null,
        ]);
        $entry->addField([
            'name' => 'start',
            'label' => 'Bắt đầu',
            'class' => 'col-md-6',
            'type' => 'time',
            'value' => $old["start"] ?? null,
        ]);
        $entry->addField([
            'name' => 'end',
            'label' => 'Kết thúc',
            'class' => 'col-md-6',
            'type' => 'time',
            'value' => $old["end"] ?? null,
        ]);
        $entry->addField([
            'name' => 'duration',
            'label' => 'Thời lượng (Phút)',
            'class' => 'col-md-6',
            'type' => 'numbers',
            'value' => $old["duration"] ?? null,
        ]);
        $entry->addField([
            'name' => 'hour_salary',
            'label' => 'Lương buổi học',
            'class' => 'col-md-6',
            'type' => 'numbers',
            'value' => $old["hour_salary"] ?? null,
        ]);
        $entry->addField([
            'name' => 'lesson',
            'label' => 'Bài học',
            'class' => 'col-md-12',
            'type' => 'text',
            'value' => $old["lesson"] ?? null,
        ]);
        $entry->addField([
            'name' => 'information',
            'label' => 'Nội dung chi tiết',
            'class' => 'col-md-12',
            'type' => 'tinymce',
            'value' => $old["information"] ?? null,
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

    public function setupEditOperation($id): CrudEntry
    {
        $demo = $this->demoRepository->show($id);
        return $this->setupCreateOperation($demo);
    }

    public function createDemo($attributes): void
    {
        /**
         * @var UploadedFile[] $attachments
         */
        $result = [];
        $attachments = $attributes["attachments"];
        foreach ($attachments as $attachment) {
            $result[] = EzUpload::uploadToStorage($attachment, $attachment->getClientOriginalName(), "/demos");
        }
        $attributes["attachments"] = $result;
        $demoStoreObject = new DemoStoreObject($attributes);
        /**
         * @var Demo $newDemo
         */
        $newDemo = $this->demoRepository->create($demoStoreObject->toArray());
        $newDemo->Customer()->sync($attributes["customers"] ?? []);
    }

    public function updateDemo($attributes, $id): void
    {
        /**
         * @var Demo $demo
         */
        $demo = $this->demoRepository->show($id);
        if (isset($attributes["attachments"])) {
            $result = [];
            $attachments = $attributes["attachments"];
            foreach ($attachments as $attachment) {
                $result[] = EzUpload::uploadToStorage($attachment, $attachment->getClientOriginalName(), "/demos");
            }
            $attributes["attachments"] = $result;
        } else {
            $attributes["attachments"] = json_decode($attributes["attachments-old"]);
        }
        $demoStoreObject = new DemoStoreObject($attributes);
        $demo->update($demoStoreObject->toArray());
        $demo->Customer()->sync($attributes["customers"] ?? []);

    }

    public function deleteDemo($id): void
    {
        /**
         * @var Demo $demo
         */
        $demo = $this->demoRepository->show($id);
        $demo->delete();
    }
}
