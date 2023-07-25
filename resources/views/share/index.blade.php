<div class="modal fade" id="share" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Выберите пользователя</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('task_list.share', $taskList->id) }}">
                @csrf
                <div class="modal-body">
                    <select class="form-select" aria-label="Default select example" id="users" name="user_id">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    <select class="form-select" id="permissions" name="permissions">
                        <option value="read">Читать</option>
                        <option value="write">Читать и Редактировать</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <button class="btn btn-primary" type="submit">Поделиться</button>
                </div>
            </form>
        </div>
    </div>
</div>