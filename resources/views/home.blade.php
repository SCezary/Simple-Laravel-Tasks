@php
    use App\Enums\TaskStatusEnum;
@endphp

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @auth
                    <div class="row">
                        <div class="col-md-4">
                            <a class="aggregation-card" href="{{ route('tasks.index', ['status' => TaskStatusEnum::ToDo->value]) }}">
                                <span class="aggregation-card__title">Todo</span>
                                <span
                                    class="aggregation-card__value">{{ $aggregations[TaskStatusEnum::ToDo->value] ?? '0' }}</span>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a class="aggregation-card" href="{{ route('tasks.index', ['status' => TaskStatusEnum::InProgress->value]) }}">
                                <span class="aggregation-card__title">IN-PROGRESS</span>
                                <span class="aggregation-card__value">{{ $aggregations[TaskStatusEnum::InProgress->value] ?? '0' }}</span>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a class="aggregation-card" href="{{ route('tasks.index', ['status' => TaskStatusEnum::Done->value]) }}">
                                <span class="aggregation-card__title">DONE</span>
                                <span class="aggregation-card__value">{{ $aggregations[TaskStatusEnum::Done->value] ?? '0' }}</span>
                            </a>
                        </div>
                    </div>
                    <div class="card mt-3">
                        <div class="card-body">
                            Use header as navigation.
                        </div>
                    </div>
                @endauth
                @guest
                    <div class="card">
                        <div class="card-body">
                            Log in to take full advantage of the site's features, such as adding, managing, and
                            displaying tasks.
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </div>
@endsection
