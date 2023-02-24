<?php

namespace App\Http\Controllers;

use App\Models\Contacts;
use App\Models\Oraganization;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class OrganizationController extends Controller
{
    public function index(){
        return Inertia::render('Organization/Index',[
            'organizations' => Oraganization::all()->map(function($organizations){
                return [
                    'id' => $organizations->id,
                    'fullname' => $organizations->name,
                    'city' => $organizations->city,
                    'user_count'=>Contacts::where('organizatio_id', $organizations->id)->count()
                ];
            })
        ]);
    }

    public function create(){
        return Inertia::render('Organization/Create');
    }

    public function save(Request $request){   
      
        Oraganization::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'city' => $request->input('city'),
            'postal' => $request->input('postal'),
            'state' => $request->input('state'),
            'address' => $request->input('address'),
            'country' => $request->input('country'),

        ]);

        return Redirect::route('organization.index');
    }

    public function edit( Oraganization $organization){
        //return $contact;
        return Inertia::render('Organization/Edit',[
            'organization' => $organization
        ]);
    }

    public function table( Oraganization $organization){
      
        return Inertia::render('Contacts/Index',[
            'contacts' => Contacts::where('organizatio_id', $organization->id)->get()->map(function($contacts){
                return [
                    'id' => $contacts->id,
                    'name' => $contacts->first_name.' '.$contacts->last_name,
                    'email' => $contacts->email,
                    'organization'=> Oraganization::where('id', $contacts->organizatio_id)->first()->name
                ];
            })
        ]);
    }

    public function update(Oraganization $organization, Request $request){
       

       $organization->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'city' => $request->input('city'),
            'postal' => $request->input('postal'),
            'state' => $request->input('state'),
            'address' => $request->input('address'),
            'country' => $request->input('country'),
       ]);

       return Redirect::route('organization.index');
    }

    public function destroy(Oraganization $organization){
        
        $organization->delete();
        return Redirect::route('organization.index');
    }

}
