<nav class="navbar bg-white rounded-3 shadow mx-2 mt-1">
    <div class="container-fluid">
        <a href="{{route('task_list.index')}}" class="navbar-brand text-black">REKA-TODO</a>
        <div class="ms-auto">
            @if(auth()->check())
                <div class="d-flex align-items-center">
                    <div>{{$username}}</div>
                    <form method="POST" action="{{ route('logout') }}" class="ml-3 ms-3">
                        @csrf
                        <button type="submit" class="btn btn-outline-info">Выйти</button>
                    </form>
                </div>
            @else
                <button type="button" class="btn btn-outline-info" onclick="location.href='{{ url('/login') }}'">Войти</button>
                <button type="button" class="btn btn-outline-info" onclick="location.href='{{ url('/register') }}'">Регистрация</button>
            @endif
    </div>
</nav>