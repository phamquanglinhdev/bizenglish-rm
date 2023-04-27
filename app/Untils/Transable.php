<?php

namespace App\Untils;

class Transable
{
    public static function WeekTranslate($value)
    {
        switch ($value) {
            case "mon":
                return "Thứ hai";
            case "tue":
                return "Thứ ba";
            case "wed":
                return "Thứ tư";
            case "thu":
                return "Thứ năm";
            case "fri":
                return "Thứ sáu";
            case "sat":
                return "Thứ bảy";
            case "sun":
                return "Chủ nhật";
        }
    }
}
