<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class TaskController extends Controller
{
    public function list(){
        return response()->json([
            'status' => 'success',
            'data' => [
                'tasks'=>auth()->user()->tasks,
            ],
        ], 200);
    }
    public function add(Request $request){
        if($request){
            $date = strtotime($request->date);
            $task = new Task;
            $task->user_id = Auth::id();
            $task->title = $request->title;
            $task->description = $request->description??'';
            $task->y = date('Y',$date);
            $task->m = date('m',$date);
            $task->d = date('d',$date);
            $task->date = $date;
            $task->status = 3;
            if($task->save()){
                return response()->json([
                    'status' => 'success',
                    'data' => [
                        'tasks'=>Auth::user()->tasks,
                    ],
                ], 200);
            }else{
                return response()->json([
                    'status' => 'fail',
                    'data' => null,
                    'msg' => "error in save task",
                ], 400);
            }

        }
    }
}
