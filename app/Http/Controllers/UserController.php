<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index(){
        return Inertia::render('User/Index',[
            'users' => User::all()->map(function($user){
                return [
                    'id' => $user->id,
                    'name' => $user->name.' '.$user->last_name,
                    'email' => $user->email,
                    'role'=> $user->role
                ];
            })
        ]);
    }

    public function create(){
        return Inertia::render('User/Create');
    }

    public function save(Request $request){

        $image = $request->file('avatar')->store('avatar','public');

      
        User::create([
            'name' => $request->input('name'),
            'last_name' => $request->input('lastname'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'role' => $request->input('role'),
            'postal' => $request->input('postal'),
            'photo' => $image

        ]);

        return Redirect::route('users.index');
    }

    public function update(User $user, Request $request){
        $image = $user->photo;
       if($request->file('avatar')){
            Storage::delete('public/'.$user->photo);
            $image =  $request->file('avatar')->store('avatar','public');
       }
       if($request->input('password')){
         $password = $request->input('password');
       }else{
        $password = $user->password;
        
       }
       
       
       $user->update([
        'name' => $request->input('name'),
        'last_name' => $request->input('lastname'),
        'email' => $request->input('email'),
        'password' => $password,
        'role' => $request->input('role'),
        'photo' => $image
       ]);

       return Redirect::route('users.index');
    }

    public function edit( User $user){
        
        return Inertia::render('User/Edit',[
            'user' => $user,
            'image' => asset('storage/'.$user->photo)
        ]);
    }

    public function destroy(User $user){
        Storage::delete('public/'.$user->photo);
        $user->delete();
        return Redirect::route('users.index');
    }
}
