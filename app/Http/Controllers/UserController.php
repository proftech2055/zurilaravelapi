<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{

    public function create(Request $request){
        $valid = $request->validate([
            "name" => ["required"],
            "email" => ["required", "email:rfc"],
            "phone" => ["required", "regex: /^[0-9]{11}$/"]
        ]);

        if(User::where("email", $valid["email"])->first())
            return back()->with("error", "Account already exist");
        User::create([
            "name" => $valid["name"],
            "email" => $valid["email"],
            "phone" => $valid["phone"]
        ]);
        return back()->with("success", "Account registered");
    }

     public function read(){
        $data = User::all();
        return view('all-account', ["title" => "Accounts", "data" => $data]);
    }

    public function edit($id){
        $acct = User::find($id);
        if(!$acct)
            return abort(404);
        return view('edit-account', ["title" => "Edit - Accounts", "data" => $acct]);
    }

    public function update(Request $request, $id){
        $acct = User::find($id);
        if(!$acct)
            return abort(404);
        $valid = $request->validate([
            "name" => ["required"],
            "email" => ["required", "email:rfc"],
            "phone" => ["required", "regex: /^[0-9]{11}$/"]
        ]);
        $acct->name = $valid["name"];
        $acct->email = $valid["email"];
        $acct->phone = $valid["phone"];
        $acct->save();
        return back()->with("success", "Account updated");
    }

    public function delete($id){
        $acct = User::find($id);
        if(!$acct)
            return abort(404);
        $acct->delete();
        return back()->with('success', "Account deleted"); 
    }
}
