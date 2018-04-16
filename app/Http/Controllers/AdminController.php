<?php

namespace App\Http\Controllers;

use App\Publication;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\User;
use App\Role;
use App\ActionType;
use App\Action;
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
        //$types = ActionType::all();
        $types = ActionType::pluck('name', 'id');
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

        //$name = str_replace(".", "_", $domain);

        $results = [];

        $unique = date('ymdhms');
        
        try {

            $pub = Publication::create($input);

            if ($filelogo = $request->file('filelogo')) {

                // move the file to images/pubLogos folder
                $nameImg = $unique."_".$filelogo->getClientOriginalName();
                $filelogo->move('images/pubLogos', $nameImg);
    
                // add logo file name to database
                $pub->logo = $nameImg;
                $pub->save();
            } 
            if ($file = $request->file('file')) {

                // move file to folder
                $destination = app_path() . "/Http/Controllers/CredentialJson/";
                $name = $unique."_".$file->getClientOriginalName();
                $file->move($destination, $name);

                // add json file name to database
                $pub->GAJsonFile = $name;
                $pub->save();
            } 

            $results['success'] = ["Publication created successfully."];

        } catch(\Illuminate\Database\QueryException $e) {
            $results['errors'] = [$e->errorInfo[2]];
        }

        $pubs = Publication::all();
        return view('admin.superAdmin', compact('pubs', 'results'));
        //return redirect('/admin', $resString);
    }

    public function updatePub(Request $request, $id) {
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

        $results = [];
        
        try {
            $unique = date('ymdhms');
            $pub = Publication::findOrFail($id);
            $oldLogo = $pub->logo;
            $oldJson = $pub->GAJsonFile;

            $pub->update($input);

            if ($filelogo = $request->file('filelogo')) {
                
                if (File::exists(public_path() . '/images/pubLogos/'.$oldLogo)) {
                    File::delete(public_path() . '/images/pubLogos/'.$oldLogo);
                }

                // move the file to images/pubLogos folder
                $nameImg = $unique."_".$filelogo->getClientOriginalName();
                $filelogo->move('images/pubLogos', $nameImg);
    
                // add logo file name to database
                $pub->logo = $nameImg;
                $pub->save();
            } 
            if ($file = $request->file('file')) {

                $jsonFile = app_path() . "/Http/Controllers/CredentialJson/".$oldJson;
                if(File::exists($jsonFile)) {
                    File::delete($jsonFile);
                }

                // move file to folder
                $destination = app_path() . "/Http/Controllers/CredentialJson/";
                $name = $unique."_".$file->getClientOriginalName();
                $file->move($destination, $name);

                // add json file name to database
                $pub->GAJsonFile = $name;
                $pub->save();
            } 

            $results['success'] = ["Publication updated successfully."];

        } catch(\Illuminate\Database\QueryException $e) {
            $results['errors'] = [$e->errorInfo[2]];
        }

        $pubs = Publication::all();
        return redirect()->route('admin.superAdmin', compact('pubs', 'results'));

    }

    public function updateAction(Request $request, $id) {
        
        $action = Action::findOrFail($id);
        $pubId = $action->publication->id;
        $input = $request->all();
        $action->update($input);

        $publication = Publication::findOrFail($pubId);
        $actions = $publication->Actions()->get();
        //dd($publication, $actions);
        $types = ActionType::pluck('name', 'id');

        return redirect()->route('admin.editPub', compact('publication', 'actions', 'types'));
    }

    public function storeAction(Request $request) {

        $input = $request->all();
        $action = Action::create($input);
        
        $publication = Publication::findOrFail($input['publication_id']);
        $actions = $publication->Actions()->get();
        $types = ActionType::pluck('name', 'id');

        return redirect()->route('admin.editPub', compact('publication', 'actions', 'types'));

    }

    public function deleteAction($id) {
        $action = Action::findOrFail($id);
        $pubId = $action->publication->id;
        $publication = Publication::findOrFail($pubId);

        $action->delete();

        $actions = $publication->Actions()->get();
        $types = ActionType::pluck('name', 'id');
        return redirect()->route('admin.editPub', compact('publication', 'actions', 'types'));
    }
}
