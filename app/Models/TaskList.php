<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskList extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'user_id'];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

//    public function users(){
//        return $this->belongsToMany(User::class, 'task_list_user');
//    }
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('permission');
    }
}
