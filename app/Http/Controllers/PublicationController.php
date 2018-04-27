<?php

namespace App\Http\Controllers;

use App\Publication;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Traits\GoogAnalyticsInterface;
use App\User;
use App\Role;
use App\Action;
use File;
use Auth;

class PublicationController extends Controller
{
    use GoogAnalyticsInterface;

    public function index($id) {

        $pubData = Publication::findOrFail($id);

        $path = __DIR__ . '/CredentialJson/'.$pubData->GAJsonFile;
        
        if(file_exists($path)){
            $GAConn = $this->connect($path, $pubData->name);

            $profId = strval($pubData->GAProfileId);
            //$resultsTotalPages = $this->getAllPageViews($GAConn, $profId, '0daysAgo', 'today'); 

            $results = $this->getResults($GAConn, $profId, '0daysAgo', 'today');
            //$results2 = $results;
            if (count($results['reports'][0]->getData()->getRows()) > 0) {

                $ignoreParams = $this->getIgnoreParams($pubData);
           
                $urlArray = $this->getUrlArray($results, $ignoreParams);

                //$this->getPageDataFromUrls($urlArray, $pubData->domain, Auth::user()->publication->id);
                
                $results = $this->parseResults($results, $ignoreParams, Auth::user()->publication->id);
            }
            
            //$results = [$urlArray, $results];
            $returnArray = $results; //$results['reports'][0]->getData()->getRows();

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
