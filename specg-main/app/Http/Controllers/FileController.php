<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Project;

use Illuminate\Http\Request;

use DB;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $files = DB::table('files')
            ->leftjoin('projects','files.projID','projects.id')
            ->select('files.*', 'projects.name')
            ->get();
        $projects = Project::orderBy('name','asc')->get();
        return view('file-list',(['files'=>$files, 'projects'=>$projects]));
    }

    public function showProjectFiles($id)
    {
        $project = Project::where('id','=',$id)->first();
        $files = DB::table('files')
            ->leftjoin('projects','files.projID','projects.id')
            ->select('files.*')
            ->where('files.projID',"=",$id)
            ->get();
        $projs = Project::orderBy('name','asc')->get();
        return view('project-files',(['files'=>$files,'project'=>$project,'projs'=>$projs]));
    }

    public function store(Request $request)
    {
        $request->validate([
            'project'=>'required',
            'filename'=>'required|unique:files|max:250',
            'file'=>'required|file|max:10240',
        ]);
        
        $newfilename = pathinfo($request->filename, PATHINFO_FILENAME).".".$request->file->extension();
        
        $file = new File();
        $file->filename =  $newfilename;
        $file->projID = $request->project;
        $new = $file->save();
        if ($new) {
            $request->file->move(public_path('files'),$newfilename);
            $files = DB::table('files')
                ->leftjoin('projects','files.projID','projects.id')
                ->get();
            $projects = Project::orderBy('name','asc')->get();
            return back()->with('files',$files)->with('projects',$projects)->with('success', 'File added successfully.');
        }
        else {
            return back()->with('fail','Error encountered. Try again later.');
        }     
    }

    public function editFile(Request $request)
    {
        $request->validate([
            'project'=>'required',
            'filename'=>'required|max:250',
            'file'=>'nullable|file|max:10240',
        ]);
        
        $oldfile = File::where('id',"=",$request->fileid)->first();
        $oldfilename = pathinfo($oldfile->filename, PATHINFO_FILENAME);

        $newfilename = pathinfo($request->filename, PATHINFO_FILENAME);
          
        if (($request->hasFile('file')) && (strcmp($newfilename,$oldfilename) != 0)){
            $exist = File::where('filename','=',$request->filename)->count();
            if ($exist > 0) {
                return back()->with('msg','New file name specified already taken. Reselect file and use different name.');
            }
            $newfilename = pathinfo($request->filename, PATHINFO_FILENAME).".".$request->file->extension();
            $fileToDelete = public_path('files/'.$oldfile->filename);
            if (file_exists($fileToDelete)) {
                if (unlink($fileToDelete)) {
                    $update = File::where('id','=',$request->fileid)->update([
                        'projID'=>$request->project,
                        'filename'=>$newfilename,
                    ]);
                    if ($update) {
                        $request->file->move(public_path('files'),$newfilename);
                        return back()->with('success', 'File edited successfully.');
                    }
                    else {
                        return back()->with('fail','Error encountered. Try again later.');
                    }
                }
                else {
                    return back()->with('fail','File failed to delete.');
                }
            }
            else {
                return back()->with('fail','File to be overwritten does not exist.');
            }
        }
        else if ($request->hasFile('file')) {
            $newfilename = pathinfo($request->filename, PATHINFO_FILENAME).".".$request->file->extension();
            $fileToDelete = public_path('files/'.$oldfile->filename);
            if (file_exists($fileToDelete)) {
                if (unlink($fileToDelete)) {
                    $update = File::where('id','=',$request->fileid)->update([
                        'projID'=>$request->project,
                        'filename'=>$newfilename,
                    ]);
                    if ($update) {
                        $request->file->move(public_path('files'),$newfilename);
                        return back()->with('success', 'File edited successfully.');
                    }
                    else {
                        return back()->with('fail','Error encountered. Try again later.');
                    }
                }
                else {
                    return back()->with('fail','File failed to delete.');
                }
            }
            else {
                return back()->with('fail','File to be overwritten does not exist.');
            }
        }
        else if ((strcmp($newfilename,$oldfilename) != 0)) {
            $exist = File::where('filename','=',$request->filename)->count();
            if ($exist > 0) {
                return back()->with('msg','New file name specified already taken. Use different name.');
            }

            $oldFilePath = public_path('files/'.$oldfile->filename);
            
            $ext = pathinfo($oldfile->filename, PATHINFO_EXTENSION);
            $newfilename = pathinfo($request->filename, PATHINFO_FILENAME).".".$ext;
            $newFilePath = public_path('files/'.$newfilename);

            if (file_exists($oldFilePath)) {
                if (rename($oldFilePath, $newFilePath)) {
                    $update = File::where('id','=',$request->fileid)->update([
                        'projID'=>$request->project,
                        'filename'=>$newfilename,
                    ]);
                    if ($update) {
                        return back()->with('success', 'File edited successfully.');
                    }
                    else {
                        return back()->with('fail','Error encountered. Try again later.');
                    }
                }
                else {
                    return back()->with('fail', 'Failed to edit the file.');
                }
            } else {
                return back()->with('fail','File to be edited does not exist.');
            }
        }
        else {
            $update = File::where('id','=',$request->fileid)->update([
                'projID'=>$request->project,
            ]);
            if ($update) {
                return back()->with('success', 'File edited successfully.');
            }
            else {
                return back()->with('fail','Error encountered. Try again later.');
            }
        }   
    }

    public function deleteFile($id)
    {
        $file = File::where('id',"=",$id)->first();
        $fileToDelete = public_path('files/'.$file->filename);
        if (file_exists($fileToDelete)) {
            if (unlink($fileToDelete)) {
                $file->delete();
                return back()->with('success','File deleted successfully.');
            } else {
                return back()->with('fail','Error encountered. Try again later.');
            }
        } else {
            return back()->with('fail','File does not exist.');
        }
    }
    
}
