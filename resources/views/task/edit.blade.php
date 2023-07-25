<form method="POST" action="{{ route('task.update', ['task' => $task->id]) }}" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <input type="hidden" name="task_list_id" value="{{ $task->task_list_id }}">
    <div class="modal fade" id="editTask{{ $task->id }}" tabindex="-1" aria-labelledby="editTaskModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Изменение задачи</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Название задачи</label>
                        <input name="title" class="form-control" type="text" placeholder="" aria-label="default input example" value="{{ $task->title }}">
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Теги</label>
                        <select class="form-select" name="tag_ids[]" multiple aria-label="multiple select example">
                            @foreach($tags as $tag)
                                <option value="{{$tag->id}}"
                                        {{ in_array($tag->id, $task->tags->pluck('id')->toArray()) ? 'selected' : '' }}>
                                    {{$tag->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Текущее изображение</label>
                        @if($task->image)
                            <a href="{{ asset('storage/'.$task->image) }}" target="_blank">
                                <img src="{{ asset('storage/'.$task->image) }}" width="100">
                            </a>
                            <button type="submit" name="delete_image" class="btn btn-danger" value="1">Удалить изображение</button>
                        @else
                            Нет загруженного изображения.
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Сменить изображение</label>
                        <input name="image" class="form-control" type="file" id="formFile">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Изменить</button>
                </div>
            </div>
        </div>
    </div>
</form>