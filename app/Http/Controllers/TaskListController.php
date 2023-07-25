<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\TaskList;
use App\Models\User;
use Illuminate\Http\Request;

class TaskListController extends Controller
{
    public function index()
    {
        $tags = Tag::all();
        $taskLists = auth()->check() ? auth()->user()->taskLists : null;
        $username = auth()->check() ? auth()->user()->name : null;
        $sharedTaskLists = auth()->check() ? auth()->user()->sharedTaskLists : null;

        return view('index', compact('taskLists', 'tags', 'username', 'sharedTaskLists'));
    }

    public function show($id)
    {
        $taskList = TaskList::findOrFail($id);
        $tags = Tag::all();
        $users = User::all();
        $username = auth()->check() ? auth()->user()->name : null;

        return view('task.show', ['taskList' => $taskList, 'tags' => $tags, 'users' => $users, 'username' => $username]);
    }

    public function store(Request $request)
    {
        $taskList = new TaskList;

        $taskList->fill($request->all());

        $taskList->user_id = auth()->id();

        $taskList->save();

        $taskList->tasks = [];

        return response()->json([
            'taskList' => $taskList,
        ]);
    }

    public function share(Request $request, TaskList $taskList)
    {
        $user = User::find($request->get('user_id'));
        $permissions = $request->get('permissions');

        // Используйте attach, чтобы добавить новую запись, и передайте уровень разрешений в массиве дополнительных данных
        $taskList->users()->attach($user, ['permission' => $permissions]);

        return back()->with('success', 'Список успешно поделен');
    }

    public function destroy($id)
    {
        $taskList = TaskList::findOrFail($id);

        if (!auth()->user()->canEditTaskList($taskList->id)) {
            return redirect()->route('task_list.index')
                ->with('message', 'Вы не имеете права на удаление этого списка задач!');
        }

        $taskList->delete();

        return redirect()->route('task_list.index')
            ->with('message', 'Список задач успешно удалён!');
    }
}
