@php
    use App\Helpers\TaskHelper;
@endphp

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <a class="btn btn-primary" href="{{ route('tasks.create') }}">Add New Task</a>
            </div>
        </div>
        <hr/>
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        @include('task._search')
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 ms-auto">
                        <label>Order By</label>
                        <select class="form-control" name="order" id="js-tasks-order">
                            @foreach(TaskHelper::ORDER_FIELDS as $key => $value)
                                <option value="{{ $key }}" @selected(request('order') === $key)>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="task-list mt-2">
                    @forelse($tasks as $task)
                        @include('task._task', ['task' => $task])
                    @empty
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i>
                            {{ __('No tasks match your filters.') }}
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
