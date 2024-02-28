<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class SearchController extends Controller
{
    public function search(Request $request) {
        if ($request->filled('search')) {
            $projects = DB::table('projects')
                ->select('name', 'id', DB::raw("'projects' AS source"))
                ->where('name', 'LIKE', '%' . $request->search . '%');
    
            $clientsl = DB::table('clients')
                ->select('lastname AS name','id', DB::raw("'clients' AS source"))
                ->where('lastname', 'LIKE', '%' . $request->search . '%');
            
            $clientsf = DB::table('clients')
                ->select('firstname AS name','id', DB::raw("'clients' AS source"))
                ->where('firstname', 'LIKE', '%' . $request->search . '%');
            
            $tasks = DB::table('tasks')
                ->leftJoin('projects','tasks.projectid','=','projects.id')
                ->select('taskname AS name', 'projects.id AS id', DB::raw("'tasks' AS source"))
                ->where('taskname', 'LIKE', '%' . $request->search . '%');

            $files = DB::table('files')
                ->select('filename AS name', 'id', DB::raw("'files' AS source"))
                ->where('filename', 'LIKE', '%' . $request->search . '%');

            $data = $projects->union($clientsl)
                ->union($clientsf)
                ->union($tasks)
                ->union($files)
                ->orderBy('name')
                ->get();
            return view('search')->with('data',$data);
        }
        else {
            return back();
        }
    }
}
