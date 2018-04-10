<?php

namespace App\Http\Controllers;

use App\Publication;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\User;
use App\Role;
use App\ActionType;
use File;
use Auth;


class AdminController extends Controller
{
    public function superAdmin() {
        $pubs = Publication::all();
        return view('admin.superAdmin', compact('pubs'));
    }

    public function pubAdmin($id) {
        $pubData = Publication::findOrFail($id);
        return view('admin.pubAdmin', compact('pubData'));
    }

    public function newPub() {
        return view('admin.newPub');
    }

    public function editPub($id) {
        $publication = Publication::findOrFail($id);
        $actions = $publication->Actions()->get();
        $types = ActionType::all();
        return view('admin.editPub', compact('publication', 'actions', 'types'));
    }

    public function deletePub($id) {
        $pub = Publication::findOrFail($id);
        $pub->delete();
        $results['success'] = ['Publication Moved to trash.'];
        $pubs = Publication::all();
        return view('admin.superAdmin', compact('results', 'pubs'));
    }

    public function viewTrash() {
        $pubs = Publication::onlyTrashed()->get();
        return view('admin.trash', compact('pubs'));
    }

    public function restorePub($id) {
        $pub = Publication::onlyTrashed()->findOrFail($id);
        $pub->restore($pub);
        return redirect('/admin');
    }


    public function permanentDeletePub($id) {

        $pub = Publication::onlyTrashed()->findOrFail($id);
        $jsonFile = app_path() . "/Http/Controllers/CredentialJson/".str_replace(".", "_", $pub->domain).".json";
   
        if(File::exists($jsonFile)) {
            File::delete($jsonFile);
        }

        if (File::exists(public_path() . '/images/pubLogos/'.$pub->logo)) {
            File::delete(public_path() . '/images/pubLogos/'.$pub->logo);
        }

        $pub->forceDelete();
        return back();
    }

    public function store(Request $request) {

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'domain' => 'required'
        ]);

        $input = $request->all();
        //strip http and https out if pressent
        $domain = str_replace("http://", "", $request->domain);
        $domain = str_replace("https://", "", $domain);
        $input['domain'] = $domain;

        $name = str_replace(".", "_", $domain);

        $results = [];
        
        try {

            $pub = Publication::create($input);

            if ($filelogo = $request->file('filelogo')) {

                $nameImg = $name.".".$filelogo->getClientOriginalExtension();
                $filelogo->move('images/pubLogos', $nameImg);
    
                // add logo file name to database
                $pub->logo = $nameImg;
                $pub->save();
            } 
            if ($file = $request->file('file')) {

                $destination = app_path() . "/Http/Controllers/CredentialJson/";
                $file->move($destination, $name.".json");
            } 

            $results['success'] = ["Publication created successfully."];

        } catch(\Illuminate\Database\QueryException $e) {
            $results['errors'] = [$e->errorInfo[2]];
        }

        $pubs = Publication::all();
        return view('admin.superAdmin', compact('pubs', 'results'));
        //return redirect('/admin', $resString);
    }

    public function updatePub($id) {

    }

    public function updateAction($id) {

    }

    public function storeAction($id) {
        
    }
}
