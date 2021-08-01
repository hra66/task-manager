<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Task;
use App\Models\User;
class TaskController extends Controller
{
    public function status(Task $task,$action="accept"){
        if($task){
            $task->status = ($action=="accept") ? Task::STATUS_ACCEPT : Task::STATUS_REJECT ;
            $task->save();
            return redirect()->back()->with('success','action done.');
        }
    }
}
