@extends('layouts.app')

@section('content')
<div class="taskListContainer">
        <div class="container mt-3 bg-white rounded-3 shadow d-flex flex-column mb-2" style="min-height: 200px;" id="test">
            <div class="d-flex justify-content-between row mt-2">
                <div class="col">
                    <form class="d-flex me-2" role="search" id="searchForm" method="post" action="{{ route('tasks.search') }}">
                        @csrf
                        <input class="form-control me-2" type="search" placeholder="Поиск по названию задачи" aria-label="Search" id="searchInput" name="query">
                        <button class="btn btn-outline-success" type="submit">Найти</button>
                    </form>
                </div>
                <div class="col">
                    <form id="tagFilterForm" method="post" class="d-flex align-items-center">
                        @csrf
                        <select class="form-control me-2" id="tagFilter" name="tag_id">
                            @foreach($tags as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-outline-success" type="submit">Фильтровать</button>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="container d-flex flex-row">
                    <div class="p-2 text-wrap coll d-flex justify-content-center align-items-center" style="width: 20%; min-width: 100px;">
                        <h5 class="ml-3">{{$taskList->title}}</h5>
                    </div>
                    <div class="p-2 coll flex-grow-2" style="min-width: 60%;">
                        <div class="d-flex flex-column justify-content-between" style="height: 100%;">
                            <div id="taskContainer">
                                @foreach($taskList->tasks as $task)
                                    <div class="form-check d-flex flex-column justify-content-center align-items-center border rounded-3 mt-2 task" data-id="{{ $task->id }}">
                                        <div class="d-flex flex-row justify-content-center align-items-center" style="height: 150px">
                                            @foreach($task->tags as $tag)
                                                <span class="badge rounded-pill text-bg-info mx-1 me-5">{{$tag->name}}</span>
                                            @endforeach
                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault{{ $task->id }}">
                                            @if($task->image)
                                                <a href="{{ asset('images/'.$task->image) }}" target="_blank">
                                                    <img class="mt-2 mb-2 ms-2" src="{{ asset('images/'.$task->image) }}" style="width:150px;height:150px;">
                                                </a>
                                            @endif
                                            <label class="form-check-label ms-2" for="flexCheckDefault{{ $task->id }}">
                                                {{ $task->title }}
                                            </label>
                                            <button class="btn cursor-pointer " data-bs-toggle="modal" data-bs-target="#editTask{{ $task->id }}" style="border: none; background: transparent;">
                                                <i class="bi bi-gear-wide-connected ms-2"></i>
                                            </button>
                                            <button class="btn delete-button cursor-pointer" style="color: red; border: none; background: transparent;">
                                                <i class="bi bi-trash3 ms-2"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @include('task.edit')
                                @endforeach
                            </div>
                            <div class="d-flex justify-content-center align-items-center">
                                <button type="button" class="btn btn-outline-success mt-2 mb-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    Добавить задачу
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="p-2 coll text-center d-flex justify-content-center align-items-center flex-column" style="width: 20%; min-width: 100px;">
                        <button type="button" class="mb-2 btn btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#addTag">Добавить теги</button>

                        @if(auth()->user()->canEditTaskList($taskList->id))
                            <form method="POST" action="{{ route('task_list.delete', $taskList->id) }}">
                                @csrf
                                <button type="submit" class="mr-3 btn btn-outline-danger">Удалить список</button>
                            </form>
                        @endif
                        <button type="button" class="btn btn-outline-warning mt-2" data-bs-toggle="modal" data-bs-target="#share">Поделиться</button>
                    </div>
                </div>
            </div>
        </div>
    @include('tags.new')

{{--    @include('task.edit')--}}
    @include('task.new')
    @include('share.index', ['users' => $users])
</div>
<script>
    $(document).ready(function() {
        $('#tagFilterForm').on('submit', function (e) {
            e.preventDefault();

            const tagId = $('#tagFilter').val();

            $.ajax({
                url: "{{ route('tasks.filterByTag') }}",
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    tag_id: tagId
                },
                success: function (data) {
                    $('#taskContainer').empty();
                    $('#taskContainer').html(data.html);
                },
                error: function(err) {
                    console.log(err);
                }
            });
        });
        $('.delete-button').on('click', function(){
            var taskDiv = $(this).closest('div[data-id]');
            var taskId = taskDiv.data('id');
            $.ajax({
                url: '/tasks/' + taskId,
                type: 'DELETE',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function(response){
                    taskDiv.remove();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.responseJSON.message);
                }
            });
        });
        $('#searchForm').on('submit', function (e) {
            e.preventDefault();

            const query = $('#searchInput').val();

            $.ajax({
                url: "{{ route('tasks.search') }}",
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    query: query
                },
                success: function (data) {
                    $('#taskContainer').empty();
                    $('#taskContainer').html(data.html);
                },
                error: function(err) {
                    console.log(err);
                }
            });
        });
    });
</script>
@endsection