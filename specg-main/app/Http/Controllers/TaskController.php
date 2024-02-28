<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Task;
use App\Models\Client;
use App\Models\Project;
use App\Models\User;

use DB;

class TaskController extends Controller
{
    public function addTask(Request $request) {
        //dd($request->all());
        $request->validate([
            'project'=>'required',
            'task_name'=>'required',
            'assignee'=>'required', 
        ]);   
        $task = new Task();
        $task->taskname = ucwords(strtolower(trim($request->task_name)));
        $task->projectid = $request->project;
        $task->creatorid = $request->creatorid;
        $task->notes = $request->notes;
        $task->assigneeid = $request->assignee;
        $task->status = "Open";
        $new = $task->save();
        if ($new) {
            session()->flash('success', 'Task added successfully.');
            return back();
        }
        else {
            return back()->with('fail','Error encountered. Try again later.');
        }
    }

    public function closeTask(Request $request) { 
        $save = Task::where('id','=',$request->taskid)->update([
            'reply'=>$request->reply,
            'status'=>"Done"
        ]);
        
        if ($save > 0) { //update returns number of affected rows
            $clients = Client::orderBy('lastname','asc')->get();
            $project = Project::where('id','=',$request->projectid)->first();
            return back()->with(['clients'=>$clients,'project'=>$project])->with('success', 'Task marked as "Done" successfully.');
        }
        else {
            return back()->with('fail', 'Error encountered during closing task. Try again later.');     
        }
    }

    public function deleteTask(Request $request) { 
        $delete = Task::where('id','=',$request->deletetaskid)->delete();
        
        if ($delete) {
            return back()->with('success', 'Task deleted successfully.');
        }
        else {
            return back()->with('fail', 'Error encountered during closing task. Try again later.');     
        }
    }


    public function showTaskList() {
        $loginId = session('loginId');
        $user = User::where('id','=',$loginId)->first();
        $projects = Project::orderBy('name','asc')->get();
        $tasks = DB::table('tasks')
            ->leftJoin('users AS creator', 'tasks.creatorid', '=', 'creator.id')
            ->leftJoin('users AS assignee', 'tasks.assigneeid', '=', 'assignee.id')
            ->leftJoin('projects', 'tasks.projectid', '=', 'projects.id')
            ->select(
                'tasks.*',
                'creator.lastname AS clastname',
                'creator.firstname AS cfirstname',
                'assignee.lastname AS alastname',
                'assignee.firstname AS afirstname',
                'projects.name',
            )
            ->get();
        $emps = User::orderBy('lastname','asc')->get();
        return view('task-list', (['emps'=>$emps, 'user'=>$user, 'tasks'=>$tasks, 'projects'=>$projects]));
    }
}
