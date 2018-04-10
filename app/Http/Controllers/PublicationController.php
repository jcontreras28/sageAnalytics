<?php

namespace App\Http\Controllers;

use App\Publication;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Traits\GoogAnalyticsInterface;
use App\User;
use App\Role;
use File;
use Auth;

class PublicationController extends Controller
{
    use GoogAnalyticsInterface;

    public function index($id) {
        $pubData = Publication::findOrFail($id);

        $path = __DIR__ . '/CredentialJson/'.str_replace(' ', '', $pubData->name).'Sage.json';
        
        if(file_exists($path)){
            $GAConn = $this->connect($path, $pubData->name);

            $profId = $pubData->GAProfileId;
            $resultsTotalPages = $this->getAllPageViews($GAConn, $profId, '0daysAgo', 'today'); 

            $returnArray = $resultsTotalPages;
        } else {
            $returnArray = ['errors' => ['JSON credentials file has not been uploaded.', 'Another error just to test']];
        }

        return view('publications.stats', compact('returnArray', 'pubData'));

    }

    public function adminIndex($id) {
        
        $pub = Publication::findOrFail($id);

        return view('admin.pubAdmin', compact('pub'));
    }

}
