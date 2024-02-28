<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;

use Session;

class ClientController extends Controller
{
    public function showClientList() {
        $clients = Client::orderBy('lastname','asc')->get();
        return view('client',['clients'=>$clients]);
    }
    public function addClient(Request $request) {
        $request->validate([
            'firstName'=>'required|max:255',
            'lastName'=>'required|max:255', 
            'phone'=>'required|regex:/^[0-9()\-]+$/|max:255',
        ]);   
        $client = new Client();
        $client->firstname = ucwords(strtolower(trim($request->firstName)));
        $client->lastname = ucwords(strtolower(trim($request->lastName)));
        $client->phone = $request->phone;
        $new = $client->save();
        if ($new) {
            $clientid = $client->id;
            session()->flash('success', 'Client ' . $clientid . ' added successfully.');
            session()->flash('clientid', $clientid);
            return back();
        }
        else {
            return back()->with('fail','Error encountered. Try again later.');
        }
    }
   
    public function editClient(Request $request) {
        $request->validate([
            'firstName'=>'required|max:255',
            'lastName'=>'required|max:255', 
            'phone'=>'required|regex:/^[0-9()\-]+$/|max:255',
        ]);
        $save = Client::where('id','=',$request->id)->update([
            'firstname'=>ucwords(strtolower(trim($request->firstName))),
            'lastname'=>ucwords(strtolower(trim($request->lastName))),
            'phone'=>$request->phone,
        ]);
        if ($save) {
            return back()->with('success', 'Client ID '.$request->id.' details updated successfully.');
            
        }
        else {
            return back()->with('fail','Error encountered. Try again later.');
        }
    }
}
