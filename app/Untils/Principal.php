<?php

namespace App\Untils;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

/**
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string $email
 */
class Principal
{
    public function __construct(
        private readonly int    $id,
        private readonly string $name,
        private readonly int $type,
        private readonly string $email,
        private readonly bool   $auth,
    )
    {
    }

    /**
     * @return bool
     */
    public function isAuth(): bool
    {
        return $this->auth;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRoleName(): string
    {
        return match ($this->type) {
            -1 => "Quản trị viên",
            0 => "Nhân viên",
            1 => "Giáo viên",
            2 => "Đối tác",
            3 => "Học sinh",
            4 => "Khách hàng",
            5 => "Đối tác cung cấp",
            default => "Không xác định",
        };
    }
}
