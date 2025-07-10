<?php

namespace App\Http\Requests;

use App\Enums\TaskPriorityEnum;
use App\Enums\TaskStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Using a single TaskRequest instead of separate StoreTaskRequest and UpdateTaskRequest since both share identical validation rules.
 *
 */
class TaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'description' => 'max:500',
            'priority' => ['required', Rule::enum(TaskPriorityEnum::class)],
            'status' => ['required', Rule::enum(TaskStatusEnum::class)],
            'due_date' => 'required|date|date_format:Y-m-d\TH:i|after:now',
        ];
    }
    public function messages(): array
    {
        return [
            'due_date.date_format' => 'The due date must be a date format. Y-m-d H:i',
            'due_date.after' => 'The due date must be set in the future.',
        ];
    }
}
