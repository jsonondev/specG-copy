<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\Project;
use App\Models\User;
use App\Models\Client;
use App\Models\Task;
use Hash;
use Session;
use DB;

class ProjectController extends Controller
{
    public function home() {
        $projects = DB::table('projects')
            ->leftJoin('clients','clients.id','projects.clientid')
            ->select('projects.*','clients.lastname','clients.firstname')
            ->orderBy('name','asc')
            ->get();
        return view('homepage',(['projects'=>$projects]));
    }
    public function addProject() {
        $clients = Client::orderBy('lastname','asc')->get();
        return view('project-details', (['clients'=>$clients]));
    }
    public function saveProject(Request $request) {
        //dd($request->all());
        $request->validate([
            'name'=>'required',
            'client'=>'required',
            'location'=>'required', 
            'contract_price'=>'required|decimal:0,2',
            'completion_date'=>'required|date|after_or_equal:today',
        ]);   
        $project = new Project();
        $project->name = ucwords(strtolower(trim($request->name)));
        $project->clientid = $request->client;
        $project->location = $request->location;
        $project->status = "Not Started";
        $project->phase = "X - NOT STARTED";
        $project->contractprice = $request->contract_price;
        $project->completiondate = $request->completion_date;
        $new = $project->save();
        if ($new) {
            $project = Project::where('id','=',$project->id)->first();
            return redirect()->route('view-project',['id'=>$project->id])->with('project',$project)->with('success', 'Project added successfully.');            
        }
        else {
            return back()->with('fail','Error encountered. Try again later.');
        }
    }
    public function viewProject($id) {
        $loginId = session('loginId');
        $user = User::where('id','=',$loginId)->first();
        $project = Project::where('id','=',$id)->first();
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
                'projects.name'
            )
            ->where('projectid', '=', $id)
            ->get();
        $clients = Client::orderBy('lastname','asc')->get();
        $emps = User::orderBy('lastname','asc')->get();
        $countfiles = DB::table('files')
            ->where('projID', '=', $id)
            ->count();
        return view('view-project', (['clients'=>$clients, 'emps'=>$emps, 'user'=>$user, 'tasks'=>$tasks]))
            ->with('project',$project)
            ->with('count',$countfiles);
    }
    public function editProject(Request $request) {
        $request->validate([
            'name'=>'required',
            'client'=>'required',
            'location'=>'required', 
            'contract_price'=>'required|decimal:0,2',
            'completion_date'=>'required|date|after_or_equal:today',
        ]);
        $save = Project::where('id','=',$request->id)->update([
            'name'=>ucwords(strtolower(trim($request->name))),
            'clientid'=>$request->client,
            'location'=>$request->location,
            'status'=>$request->status,
            'phase'=>$request->phase,
            'contractprice'=>$request->contract_price,
            'completiondate'=>$request->completion_date
        ]);
        
        if ($save > 0) { //update returns number of affected rows
            $clients = Client::orderBy('lastname','asc')->get();
            $project = Project::where('id','=',$request->id)->first();
            //return view('view-project', ['clients'=>$clients,'project'=>$project])->with('success', 'Project updated successfully.');
            return back()->with(['clients'=>$clients,'project'=>$project])->with('success', 'Project updated successfully.');
        }
        else {
            return back()->with('fail', 'Error encountered during project update. Try again later.');     
        }
    }
   
}
