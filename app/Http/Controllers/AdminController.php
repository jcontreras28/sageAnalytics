<?php

namespace App\Http\Controllers;

use App\Publication;
use Illuminate\Http\Request;


class AdminController extends Controller
{
    public function superAdmin() {
        $pubs = Publication::all();
        return view('admin.superAdmin', compact('pubs'));
    }

    public function pubAdmin() {
        return "<H1>Hello</h1>";
    }

    public function newPub() {
        return view('admin.newPub');
    }

    public function editPub($id) {
        $pubData = Publication::findOrFail($id);
        return view('admin.editPub', compact('pubData'));
    }

    public function deletePub($id) {
        $pub = Publication::findOrFail($id);
        $pub->delete();
        return redirect('/admin');
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
        $pub = Blog::onlyTrashed()->findOrFail($id);
        $pub->forceDelete();
        return back();
    }

    public function store(Request $request) {
        $input = $request->all();
        $pub = Publication::create($input);

        return redirect('/admin');
    }
}
