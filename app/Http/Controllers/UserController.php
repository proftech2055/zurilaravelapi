<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function register(Request $request)
    {
        $valid = Validator::make($request->all(), [
            "name" => ["required"],
            "email" => ["required", "unique:users,email", "email:rfc"],
            "password" => ["required", "min:8", "max:20"],
            "cpassword" => ["required", "same:password"]
        ], ["unique" => "The :attribute is already taken"]);

        if ($valid->fails())
            return Response::json(["responseCode" => "99", "responseDescription" => "Fill in appropriate data", "data" => $valid->validated(), "errors" => $valid->errors()]);
        $validData = $valid->validated();
        $create = User::create([
            "name" => $validData["name"],
            "email" => $validData["email"],
            "password" => Hash::make($validData["password"])
        ]);
        return Response::json(["responseCode" => "00", "responseDescription" => "Registration successfull", "data" => $create, "errors" => []]);
    }

    public function login(Request $request)
    {
        $valid = Validator::make($request->all(), [
            "email" => ["required"],
            "password" => ["required"]
        ]);

        if ($valid->fails())
            return Response::json(["responseCode" => "99", "responseDescription" => "Fill in appropriate data", "data" => $valid->validated(), "errors" => $valid->errors()]);
        $validData = $valid->validated();
        if (Auth::validate(["email" => $validData["email"], "password" => $validData["password"]])) {
            Auth::login(User::where("email", $validData["email"])->first());
            return Response::json(["responseCode" => "00", "responseDescription" => "Login successfull", "data" => Auth::user(), "errors" => []]);
        }
        return Response::json(["responseCode" => "99", "responseDescription" => "Invalid login details", "data" => $validData, "errors" => []]);
    }

    public function getUser($id = null)
    {
        if (!$id) {
            $data = User::all();
            return Response::json(["responseCode" => "00", "responseDescription" => "All users data", "data" => $data, "errors" => []]);
        }
        $data = User::find($id);
        return Response::json(["responseCode" => "00", "responseDescription" => "single user data", "data" => $data, "errors" => []]);
    }

    public function update($id, Request $request)
    {
        //$user = User::find($id);
        $valid = Validator::make($request->all(), [
            "name" => ["required"],
            "email" => ["required", "email:rfc"]
        ], ["unique" => "The :attribute is already taken"]);

        if ($valid->fails())
            return Response::json(["responseCode" => "99", "responseDescription" => "Fill in appropriate data", "data" => $valid->validated(), "errors" => $valid->errors()]);
        $validData = $valid->validated();
        User::where("id", $id)->update([
            "name" => $validData["name"],
            "email" => $validData["email"]
        ]);
        $user = User::find($id);
        return Response::json(["responseCode" => "00", "responseDescription" => "User data updated", "data" => $user, "errors" => []]);
    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();
        return Response::json(["responseCode" => "00", "responseDescription" => "User deleted", "data" => $user, "errors" => []]);
    }
}
