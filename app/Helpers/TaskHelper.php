<?php

namespace App\Helpers;

use App\Enums\TaskPriorityEnum;
use App\Enums\TaskStatusEnum;

class TaskHelper
{
    const ORDER_FIELDS = [
        'due_date-asc' => 'Due Date (earliest first)',
        'due_date-desc' => 'Due Date (latest first)',
        'priority-asc' => 'Priority (lowest first)',
        'priority-desc' => 'Priority (highest first)',
    ];

    public static function getStatusBadgeType(TaskStatusEnum $status): string
    {
        return match ($status) {
            TaskStatusEnum::Done => 'success',
            TaskStatusEnum::ToDo => 'info',
            TaskStatusEnum::InProgress => 'warning',
        };
    }

    public static function getPriorityBadgeType(TaskPriorityEnum $priority): string
    {
        return match ($priority) {
            TaskPriorityEnum::Low => 'secondary',
            TaskPriorityEnum::Medium => 'primary',
            TaskPriorityEnum::High => 'danger',
        };
    }
}
