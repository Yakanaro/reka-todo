<form method="POST" action="{{ route('task.store')}}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="task_list_id" value="{{ $taskList->id }}">
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Добавление задачи</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Название задачи</label>
                        <input name="title" class="form-control" type="text" placeholder="" aria-label="default input example">
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Теги</label>
{{--                        <input class="form-control" type="text" placeholder="" aria-label="default input example">--}}
                        <select class="form-select" name="tag_ids[]" multiple aria-label="multiple select example">
                            @foreach($tags as $tag)
                                <option value="{{$tag->id}}">{{$tag->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Добавить изображение</label>
                        <input class="form-control" type="file" id="formFile" name="image">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Добавить</button>
                </div>
            </div>
        </div>
    </div>
</form>