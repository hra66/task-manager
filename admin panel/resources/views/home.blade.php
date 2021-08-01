@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Tasks</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                        
                    @if($tasks)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Id</th>    
                                    <th>Title</th>    
                                    <th>User email</th>    
                                    <th>Date</th>    
                                    <th>Status</th>    
                                <tr>
                            </thead>
                            <tbody>
                            @foreach ($tasks as $task)
                                <tr>
                                    <td>{{$task->id}}</td>    
                                    <td>{{$task->title}}</td>    
                                    <td>{{($task->user)?$task->user->email:''}}</td>    
                                    <td>{{date('Y-m-d',$task->date)}}</td>    
                                    <td>
                                        @if($task->status==\App\Models\Task::STATUS_ACCEPT)
                                            <a href="{{route('task.status',['task'=>$task->id,'action'=>'reject'])}}" class="btn btn-danger btn-sm">Reject it</a>
                                        @else
                                            <a href="{{route('task.status',['task'=>$task->id,'action'=>'accept'])}}" class="btn btn-success btn-sm">Accept it</a>
                                        @endif
                                    </td>    
                                <tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
