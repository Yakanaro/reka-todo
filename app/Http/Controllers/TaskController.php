<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\TaskList;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;

class TaskController extends Controller
{

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'task_list_id' => 'required|exists:task_lists,id',
            'tag_ids' => 'array',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $task = new Task;

        $task->task_list_id = $request->task_list_id;
        $task->title = $request->title;

        if ($request->hasFile('image')) {
            $name = time().'.'.$request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('public', $name);
            $task->image = $name;
        }
        $task->save();

        $tag_ids = $request->get('tag_ids');
        $task->tags()->sync($tag_ids);

        return back()->with('success', 'Task created successfully.');
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'task_list_id' => 'required|exists:task_lists,id',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $task->task_list_id = $request->task_list_id;
        $task->title = $request->title;

        if ($request->has('delete_image')) {
            if ($task->image != null) {
                Storage::disk('public')->delete($task->image);
                $task->image = null; // here we're making the img field null after deleting it
            }
        } elseif ($request->hasFile('image')) {
            if ($task->image != null) {
                Storage::disk('public')->delete($task->image);
            }

            $name = time().'.'.$request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('public', $name);
            $task->image = $name;
        }

        $task->save();

        return back()->with('success', 'Task updated successfully.');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $taskList = Task::where('title', 'LIKE', "%{$query}%")->get();

        $view = view('task.tasks_partial', compact('taskList'))->render();
        return response()->json(['html' => $view]);
    }

    public function filterByTag(Request $request)
    {
        $tagId = $request->get('tag_id');

        $taskList = Task::whereHas('tags', function ($query) use ($tagId) {
            $query->where('tags.id', $tagId); // specify the table name here
        })->get();

        $view = view('task.tasks_partial', compact('taskList'))->render();
        return response()->json(['html' => $view]);
    }
    public function destroy(Task $task)
    {

        if ($task->image != null) {
            File::delete(public_path('images/' . $task->image));
        }

        $task->delete();
        return response()->json('Task Deleted Successfully.', 200);
    }
}
