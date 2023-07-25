<?php

use App\Http\Controllers\TagController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskListController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', function () {
//    return view('index');
//});

Auth::routes();
Route::get('/', [TaskListController::class, 'index'])->name('task_list.index');
Route::post('/task-lists', [TaskListController::class, 'store']);
Route::delete('/task-lists/{id}', [TaskListController::class, 'destroy']);
Route::post('/task/store', [TaskController::class, 'store'])->name('task.store');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
Route::patch('/task/{task}', [TaskController::class, 'update'])->name('task.update');
Route::post('/tags', [TagController::class, 'store'])->name('tag.store');
Route::post('/tasks/search', [TaskController::class, 'search'])->name('tasks.search');
Route::post('/tasks/filter', [TaskController::class, 'filterByTag'])->name('tasks.filterByTag');
Route::get('/task-lists/{id}', [TaskListController::class, 'show'])->name('task_list.show');
Route::post('/task-list/delete/{id}', [TaskListController::class, 'destroy'])->name('task_list.delete');
Route::post('/share/{taskList}', [TaskListController::class, 'share'])->name('task_list.share');