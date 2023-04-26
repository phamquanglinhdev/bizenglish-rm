<?php

namespace App\ViewModels\Teacher\Object;

use App\Untils\DataBroTable;

class TeacherListObject
{
    public function __construct(
        readonly private string  $id,
        readonly private string  $code,
        readonly private string  $name,
        readonly private ?string $partner,
        readonly private string  $email,
        readonly private ?string $phone,
        readonly private ?array  $skills,
        readonly private ?string $video,
        readonly private ?string $cv,
        readonly private ?array  $grades,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'code' => $this->getCode(),
            'name' => DataBroTable::cView("name", ['entry' => 'teachers', 'collection' => ['id' => $this->getId(), 'name' => $this->getName()]]),
            'partner' => DataBroTable::cView("belongTo", ['entry' => 'partners', 'object' => $this->getPartner()]),
            'email' => $this->getEmail(),
            'phone' => $this->getPhone(),
            'skills' => DataBroTable::cView("belongToMany", ['entry' => 'skills', 'objects' => $this->getSkills()]),
            'video' => DataBroTable::cView("link", ['link' => $this->getVideo()]),
            'cv' => DataBroTable::cView("link", ['link' => $this->getCv()]),
            'grades' => DataBroTable::cView("belongToMany", ['entry' => 'grades', 'objects' => $this->getGrades()]),
            'action' => DataBroTable::cView("actions", ['entry' => 'teachers', 'id' => $this->getId()])
        ];
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getPartner(): ?string
    {
        return $this->partner;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @return array|null
     */
    public function getSkills(): ?array
    {
        return $this->skills;
    }

    /**
     * @return string|null
     */
    public function getVideo(): ?string
    {
        return $this->video;
    }

    /**
     * @return string|null
     */
    public function getCv(): ?string
    {
        return $this->cv;
    }

    /**
     * @return array|null
     */
    public function getGrades(): ?array
    {
        return $this->grades;
    }

    /**
     * @return string
     */

}
