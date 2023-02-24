<?php

namespace App\Http\Controllers;

use App\Models\Contacts;
use App\Models\Oraganization;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ContactsController extends Controller
{
    public function index(){
        return Inertia::render('Contacts/Index',[
            'contacts' => Contacts::all()->map(function($contacts){
                return [
                    'id' => $contacts->id,
                    'name' => $contacts->first_name.' '.$contacts->last_name,
                    'email' => $contacts->email,
                    'organization'=> Oraganization::where('id', $contacts->organizatio_id)->first()->name
                ];
            })
        ]);
    }

    public function create(){
       return Inertia::render('Contacts/Create',[
            'organizations' => Oraganization::all()->map(function($organizations){
                return [
                    'id' => $organizations->id,
                    'name' =>  $organizations->name
                ];
            })
       ]);
    }

    public function save(Request $request){

        $image = $request->file('avatar')->store('avatar','public');

      
        Contacts::create([
            'first_name' => $request->input('name'),
            'last_name' => $request->input('lastname'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'city' => $request->input('city'),
            'postal' => $request->input('postal'),
            'state_province' => $request->input('state'),
            'address' => $request->input('address'),
            'country' => $request->input('country'),
            'organizatio_id' => $request->input('org'),
            'photo' => $image

        ]);

        return Redirect::route('topics.index');
    }

    public function edit( Contacts $contact){
        //return $contact;
        return Inertia::render('Contacts/Edit',[
            'contact' => $contact,
            'image' => asset('storage/'.$contact->photo),
            'organizations' => Oraganization::all()->map(function($organizations){
                return [
                    'id' => $organizations->id,
                    'name' =>  $organizations->name
                ];
            })
        ]);
    }

    public function update(Contacts $contact, Request $request){
        $image = $contact->photo;
       if($request->file('avatar')){
            Storage::delete('public/'.$contact->photo);
            $image =  $request->file('avatar')->store('avatar','public');
       }

       $contact->update([
        'first_name' => $request->input('name'),
        'last_name' => $request->input('lastname'),
        'email' => $request->input('email'),
        'phone' => $request->input('phone'),
        'city' => $request->input('city'),
        'postal' => $request->input('postal'),
        'state_province' => $request->input('state'),
        'address' => $request->input('address'),
        'country' => $request->input('country'),
        'organizatio_id' => $request->input('org'),
        'photo' => $image
       ]);

       return Redirect::route('topics.index');
    }

    public function destroy(Contacts $contact){
        Storage::delete('public/'.$contact->photo);
        $contact->delete();
        return Redirect::route('topics.index');
    }
}
?>
