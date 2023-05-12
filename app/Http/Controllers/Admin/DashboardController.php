<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private readonly StaffCrudController   $staffCrudController,
        private readonly StudentCrudController $studentCrudController,
        private readonly TeacherCrudController     $teacherCrudController,
    )
    {
    }

    public function index(): View
    {
        if (principal()->getType() == 0) {
            return $this->staffCrudController->show(principal()->getId());
        }
        if (principal()->getType() == 1) {
            return $this->teacherCrudController->show(principal()->getId());
        }
        if (principal()->getType() == 3) {
            return $this->studentCrudController->show(principal()->getId());
        }
        return \view("layouts.app");
    }
}
