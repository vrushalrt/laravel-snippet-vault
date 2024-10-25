<?php

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

Route::get('/', function(){
    return redirect()->route('tasks.index');
});

Route::get('/tasks', function () {
    $taskData = Task::latest()->paginate();
    return view('index', [
        'tasks' => $taskData,
    ]);
})->name('tasks.index');

//Route::get('/tasks/{id}', function($id) use($tasks) {
//    $task = collect($tasks)->firstWhere('id',$id);
//
//    if (!$task) {
//        abort(Response::HTTP_NOT_FOUND);
//    }
//
//    return view('show',['task' => $task]);
//
//})->name('tasks.show');

Route::View('/tasks/create','create')->name('tasks.create');

Route::get('/tasks/{task}/edit', function(Task $task) {
//Route::get('/tasks/{id}/edit', function($id) {
//    $taskData = \App\Models\Task::find($id);
    $taskData = $task;
//    $taskData = Task::findOrFail($id);
    return view('edit',[
        'task' => $taskData
    ]);
})->name('tasks.edit');

Route::get('/tasks/{task}', function(Task $task) {
//Route::get('/tasks/{id}', function($id) {
//    $taskData = \App\Models\Task::find($id);
//    $taskData = Task::findOrFail($id);
    $taskData = $task;
    return view('show',['task' => $taskData]);

})->name('tasks.show');

// Task Create POST
Route::post('/tasks', action: function(TaskRequest $request) {
    $data = $request->validated();
//    $data = $request->validate([
//        'title' => 'required|max:255',
//        'description' => 'required',
//        'long_description' => 'required'
//    ]);

//    $task = new Task;
//    $task->title = $data['title'];
//    $task->description = $data['description'];
//    $task->long_description = $data['long_description'];
//    $task->save();

    $task = Task::create($request->validated());

    return redirect()->route('tasks.show', ['task' => $task->id])
        ->with('success', 'Task created successfully!');

})->name('task.store');

Route::put('/tasks/{task}', action: function(Task $task, TaskRequest $request) {
//Route::put('/tasks/{id}', action: function($id, Request $request) {
    $data = $request->validated();
//    $data = $request->validate([
//        'title' => 'required|max:255',
//        'description' => 'required',
//        'long_description' => 'required'
//    ]);

//    $task = Task::findOrFail($id);

//    $task->title = $data['title'];
//    $task->description = $data['description'];
//    $task->long_description = $data['long_description'];
//    $task->save();
    $task->update($data);

    return redirect()->route('tasks.show', ['task' => $task->id])
        ->with('success', 'Task updated successfully!');

})->name('task.update');

//Route::get('/tasks/{id}', function($id) {
//    return 'One Single Task';
//})->name('tasks.show');

//Route::get('/', function () {
//    return view('index', [
//        'name' => 'Vrushal'
//    ]);
//});

//Route::get('/hello', function() {
//    return "Hello";
//})->name('hello');
//
//Route::get('/hallo', function() {
//    return redirect()->route('hello');
//});

Route::delete('/tasks/{task}', function(Task $task) {
    $task->delete();

    return redirect()->route('tasks.index')
        ->with('success', 'Task Deleted success');
})->name('task.destroy');

//Route::get('/greet/{name}', function($name) {
//    return "Hello ".$name;
//});

Route::put('tasks/{task}/toggle-complete', function(Task $task) {
    $task->toggleComplte();
    return redirect()->back()->with('success', 'Task Updated Successfully!');
})->name('task.toggle-complete');

Route::fallback(function() {
    return 'Still Got Somewhere!';
});

//GET POST PUT DELETE
