<?php

namespace App\Enums;

enum TaskStatusEnum: string
{
    case ToDo = 'todo';
    case InProgress = 'in-progress';
    case Done = 'done';
}
