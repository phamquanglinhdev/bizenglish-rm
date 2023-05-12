<?php

namespace App\Services;

use App\Contract\CrudServicesInterface;
use App\Models\Log;
use App\Models\Teacher;
use App\Repositories\GradeRepository;
use App\Repositories\LogRepository;
use App\Repositories\PartnerRepository;
use App\Repositories\TeacherRepository;
use App\Untils\DataBroTable;
use App\Untils\EzUpload;
use App\ViewModels\Entry\CrudEntry;
use App\ViewModels\Teacher\Object\TeacherListObject;
use App\ViewModels\Teacher\Object\TeacherStoreObject;
use App\ViewModels\Teacher\TeacherListViewModel;
use App\ViewModels\Teacher\TeacherShowViewModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TeacherService implements CrudServicesInterface
{
    public function __construct(
        private readonly TeacherRepository $teacherRepository,
        private readonly LogRepository     $logRepository,
        private readonly PartnerRepository $partnerRepository,
        private readonly SkillRepository   $skillRepository,
    )
    {
    }

    /**
     * @return mixed
     */
    public function list($attributes): JsonResponse
    {
        $count = $this->teacherRepository->count($attributes);
        $teacherCollection = $this->teacherRepository->index($attributes);
        $teacherListViewModel = new TeacherListViewModel(
            teachers: $teacherCollection->map(
                fn(Teacher $teacher) => (new TeacherListObject(
                    id: $teacher['id'],
                    code: $teacher['code'],
                    name: $teacher['name'],
                    partner: json_encode($teacher->Partner()->first()),
                    email: $teacher['email'],
                    phone: $teacher['phone'] ?? "-",
                    skills: $teacher->Skills()->get()->pluck("name", "id")->toArray(),
                    video: $teacher['video'] ?? "-",
                    cv: $teacher['cv'] ?? "-",
                    grades: $teacher->Grades()->get()->pluck("name", "id")->toArray(),
                ))->toArray()
            )->toArray()
        );
        return DataBroTable::collect($teacherListViewModel->getTeachers(), $count, $attributes);
    }

    public function setupListOperation(): array
    {
        return [
            'code' => 'Mã giáo viên',
            'name' => 'Tên giáo viên',
            'partner' => 'Đối tác cung cấp',
            'email' => 'Email giáo viên',
            'phone' => 'Số điện thoại',
            'skills' => 'Kỹ năng',
            'video' => 'Video',
            'cv' => 'Hồ sơ giáo viên',
            'grades' => 'Lớp'
        ];
    }

    /**
     * @return mixed
     */
    public function setupFilterOperation($attributes = null)
    {
        return [
            [
                'name' => 'name',
                'label' => 'Tên giáo viên',
                'value' => $attributes->name ?? null,
                'type' => 'text'
            ]
        ];
    }

    public function validate($attributes, $id = null): \Illuminate\Validation\Validator
    {
        return Validator::make($attributes,
            [
                'name' => 'required',
                'code' => 'required',
                'email' => 'required|email|unique:users,email,' . $id,
                'phone' => 'numeric|required',
                'password' => 'required',
            ]
            ,
            [
                '*.required' => 'Không được để trống',
                '*.numeric' => 'Không đúng định dạng số',
                'email.email' => 'Không đúng định dạng email',
                'email.unique' => 'Email đã tồn tại trong hệ thống',
            ]);
    }

    /**
     * @return mixed
     */
    public function setupCreateOperation(Teacher $old = null): CrudEntry
    {
        $entry = new CrudEntry("teachers", $old->id ?? null, "Giáo viên");
        $entry->addField([
            'label' => 'Mã giáo viên',
            'name' => 'code',
            'type' => 'text',
            'value' => $old->name ?? null,
            'class' => 'col-md-6'
        ]);
        $entry->addField([
            'label' => 'Tên giáo viên',
            'name' => 'name',
            'type' => 'text',
            'value' => $old->name ?? null,
            'class' => 'col-md-6'
        ]);
        $entry->addField([
            'label' => 'Đối tác cung cấp',
            'name' => 'partner_id',
            'type' => 'select2',
            'color' => 'danger',
            'nullable' => true,
            'options' => $this->partnerRepository->getForSelect(),
            'value' => $old['partner_id'] ?? null,
            'class' => 'col-md-6'
        ]);
        $entry->addField([
            'label' => 'Email giáo viên',
            'name' => 'email',
            'type' => 'text',
            'value' => $old->email ?? null,
            'class' => 'col-md-6'
        ]);
        $entry->addField([
            'label' => 'Link facebook',
            'name' => 'facebook',
            'type' => 'text',
            'value' => $old->facebook ?? null,
            'class' => 'col-md-6'
        ]);
        $entry->addField([
            'label' => 'Địa chỉ',
            'name' => 'address',
            'type' => 'text',
            'value' => $old->address ?? null,
            'class' => 'col-md-6'
        ]);
        $entry->addField([
            'label' => 'Link video',
            'name' => 'video',
            'type' => 'text',
            'value' => $old->video ?? null,
            'class' => 'col-md-6'
        ]);
        $entry->addField([
            'label' => 'Hồ sơ giáo viên',
            'name' => 'cv',
            'type' => 'text',
            'value' => $old->cv ?? null,
            'class' => 'col-md-6'
        ]);
        $entry->addField([
            'label' => 'Số điện thoại',
            'name' => 'phone',
            'type' => 'text',
            'value' => $old->phone ?? null,
            'class' => 'col-md-6'
        ]);
        $entry->addField([
            'label' => 'Kỹ năng',
            'name' => 'skills',
            'type' => 'select2_relation',
            'color' => 'danger',
            'options' => $this->skillRepository->getForSelect(),
            'value' => $old?->Skills()->allRelatedIds()->toArray(),
            'class' => 'col-md-6'
        ]);
        $entry->addField([
            'name' => 'extra',
            'label' => 'Thông tin thêm',
            'type' => 'repeatable',
            'new_label' => 'Thêm thông tin',
            'value' => $old['extra'] ?? null,
            'sub_fields' => [
                [
                    'name' => 'name',
                    'label' => 'Tên thông tin',
                    'type' => 'text',
                    'class' => 'col-md-5'
                ],
                [
                    'name' => 'info',
                    'label' => 'Giá trị',
                    'type' => 'text',
                    'class' => 'col-md-5'
                ],

            ]
        ]);
        $entry->addField([
            'name' => 'files',
            'label' => 'File đính kèm',
            'type' => 'repeatable',
            'new_label' => 'Thêm file đính kèm',
            'value' => $old['files'] ?? null,
            'sub_fields' => [
                [
                    'name' => 'name',
                    'label' => 'Tiêu đề',
                    'type' => 'text',
                    'class' => 'col-md-5'
                ],
                [
                    'name' => 'link',
                    'label' => 'File đính kèm',
                    'type' => 'upload',
                    'class' => 'col-md-5'
                ],

            ]
        ]);
        $entry->addField([
            'name' => 'password',
            'label' => 'Mật khẩu',
            'type' => 'password',
        ]);
        return $entry;
    }

    public function create($attributes): RedirectResponse
    {
        if ($attributes["password"] != null) {
            $attributes["password"] = Hash::make($attributes['password']);
        }
        $validate = $this->validate($attributes);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->errors());
        }
        foreach ($attributes['files'] as $key => $file) {
            /**
             * @var UploadedFile $link
             */
            $link = $file['link'];
            $attributes['files'][$key]['link'] = EzUpload::uploadToStorage($link, $link->getClientOriginalName(), "/teachers") ?? null;
        }
        /**
         * @var Teacher $teacher
         */
        $teacher = $this->teacherRepository->create((new TeacherStoreObject(
            code: $attributes['code'],
            name: $attributes['name'],
            partner_id: $attributes['partner_id'],
            email: $attributes['email'],
            facebook: $attributes['facebook'],
            address: $attributes['address'],
            video: $attributes['video'],
            cv: $attributes['cv'],
            phone: $attributes['phone'],
            extra: $attributes['extra'],
            files: $attributes['files'],
            password: $attributes['password']
        ))->toArray());
        $this->teacherRepository->syncRelation($teacher, "Skills", $attributes['skills']);
        return to_route("teachers.index")->with("success", "Thêm mới thành công");
    }

    /**
     * @param $id
     * @return mixed
     */
    public function setupEditOperation($id): mixed
    {
        /**
         * @var  Teacher $teacher
         */
        $teacher = $this->teacherRepository->show($id);
        if (!isset($teacher->id)) {
            return to_route("teachers.index");
        }
        return $this->setupCreateOperation($teacher);
    }

    public function update($attributes, $id)
    {
        /**
         * @var  Teacher $teacher
         */
        $teacher = $this->teacherRepository->show($id);
        if (!isset($teacher->id)) {
            return to_route("teachers.index");
        }
        if ($attributes["password"] != null) {
            $attributes["password"] = Hash::make($attributes['password']);
        } else {
            $attributes["password"] = $teacher->password;
        }
        $validate = $this->validate($attributes, $teacher->id);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->errors());
        }
        foreach ($attributes['files'] as $key => $file) {
            /**
             * @var UploadedFile $link
             */
            if (!isset($attributes['files'][$key]['link'])) {
                $attributes['files'][$key]['link'] = $file['link-old'] ?? null;

            } else {
                $link = $file['link'];
                $attributes['files'][$key]['link'] = EzUpload::uploadToStorage($link, $link->getClientOriginalName(), "/teachers") ?? null;
            }
            unset($attributes['files'][$key]['link-old']);
        }
        $this->teacherRepository->update((new TeacherStoreObject(
            code: $attributes['code'],
            name: $attributes['name'],
            partner_id: $attributes['partner_id'],
            email: $attributes['email'],
            facebook: $attributes['facebook'],
            address: $attributes['address'],
            video: $attributes['video'],
            cv: $attributes['cv'],
            phone: $attributes['phone'],
            extra: $attributes['extra'],
            files: $attributes['files'],
            password: $attributes['password']
        ))->toArray(), $id);
        $this->teacherRepository->syncRelation($teacher, "Skills", $attributes['skills']);
        return to_route("teachers.index")->with("success", "Cập nhật thành công");
    }

    public function delete($id): RedirectResponse
    {
        if ($this->teacherRepository->update(["disable" => 1], $id)) {
            return to_route("teachers.index")->with("success", "Xóa thành công");
        } else {
            return to_route("teachers.index")->with("success", "Xóa thất bại");
        }
    }

    public function showTeacherProfile($id): TeacherShowViewModel|RedirectResponse
    {
        /**
         * @var Teacher $teacherModel
         * @var Log[] $logs
         */
        $teacherModel = $this->teacherRepository->show($id);
        $grades = $teacherModel->Grades()->get();
        $logs = $teacherModel->Logs()->orderBy("updated_at", "DESC")->get();
        return new TeacherShowViewModel(
            teacher: $teacherModel,
            logs: $logs,
            grades: $grades,
            calendars: $teacherModel->getOwnTime()
        );
    }
}
