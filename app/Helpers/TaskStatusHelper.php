<?php

namespace App\Helpers;

use App\Enums\TaskStatusEnum;

class TaskStatusHelper
{
    public static function getBadgeType(TaskStatusEnum $status): string
    {
        return match ($status) {
            TaskStatusEnum::Done => 'success',
            TaskStatusEnum::ToDo => 'info',
            TaskStatusEnum::InProgress => 'warning',
        };
    }
}
