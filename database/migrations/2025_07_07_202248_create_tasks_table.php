<?php

use App\Enums\TaskPriorityEnum;
use App\Enums\TaskStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->enum('priority', [
                TaskPriorityEnum::Low->value,
                TaskPriorityEnum::Medium->value,
                TaskPriorityEnum::High->value,
            ])->default('medium');
            $table->enum('status', [
                TaskStatusEnum::ToDo->value,
                TaskStatusEnum::InProgress->value,
                TaskStatusEnum::Done->value,
            ])->default('todo');
            $table->dateTime('due_date');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
