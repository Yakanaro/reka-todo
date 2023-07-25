@extends('layouts.app')

@section('content')
    <div class="container mt-5 bg-white rounded-3 shadow d-flex flex-column justify-content-center align-items-center "
         style="min-height: 200px;">
        <form id="newTaskListForm" class="w-50 d-flex flex-column justify-content-center align-items-center">
            <label for="title">Название списка:</label>
            <input class="form-control"  type="text" placeholder="Введите название списка" aria-label="default input example">
            @if(auth()->check())
            <button type="submit" class="btn btn-outline-success mt-2" id="createTaskList">Создать список</button>
            @else
                <button type="button" class="btn btn-outline-success mt-2" onclick="location.href='{{ url('/register') }}'">Создать список</button>
            @endif
        </form>
        @if(auth()->check())
            <div class="taskListContainer">
                <p class="text-center">Мои списки:</p>
                @foreach($taskLists as $taskList)
                    <p><a href="{{ route('task_list.show', $taskList->id) }}" style="min-width: 200px;" class="list-group-item list-group-item-action list-group-item-info text-center mt-1 rounded border border-info">
                            {{ $taskList->title }}
                        </a></p>
                @endforeach
            </div>
            <p>Списки пользователей:</p>
            @foreach($sharedTaskLists as $taskList)
                <p><a href="{{ route('task_list.show', $taskList->id) }}" style="min-width: 200px;" class="list-group-item list-group-item-action list-group-item-info text-center mt-1 rounded border border-info">
                        {{ $taskList->title }}
                    </a></p>
            @endforeach
            @else
            <div>Добавьте список</div>
            @endif


    </div>
    <script>
        $(document).ready(function() {
            $('#newTaskListForm').on('submit', function(e) {
                e.preventDefault();

                var title = $(this).find('input').val();

                $.ajax({
                    url: '/task-lists',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        title: title
                    },
                    success: function(response) {

                        renderTaskList(response.taskList);
                        $('#newTaskListForm')[0].reset();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert("Произошла ошибка при добавлении списка задач: " + textStatus);
                    }
                });
                function renderTaskList(taskList) {
                    var newTaskListHtml = `
                        <p>
                            <a href="/task-lists/${taskList.id}"
                               style="min-width: 200px;"
                               class="list-group-item list-group-item-action list-group-item-info text-center mt-1 rounded border border-info">
                                  ${taskList.title}
                            </a>
                        </p>`;
                    $('.taskListContainer').append(newTaskListHtml);
                }
            });
        });
    </script>
@endsection