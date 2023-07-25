@foreach($taskList as $task)
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
@endforeach
