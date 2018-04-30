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

    private $g_Results = [];

    public function wrapper($id) {

        $pubData = Publication::findOrFail($id);
        return view('publications.statsWrapper', compact('pubData'));

    }

    public function sectionRefresh() {

        $results = $g_Results;
        return view('publications.sectionStats', compact('results'));

    }

    public function refreshData($id) {

        $pubData = Publication::findOrFail($id);

        $path = __DIR__ . '/CredentialJson/'.$pubData->GAJsonFile;
        
        if(file_exists($path)){
            $GAConn = $this->connect($path, $pubData->name);

            $profId = strval($pubData->GAProfileId);

            $resultsTotalPages = $this->getResultsAllPageViews($GAConn, $profId, '0daysAgo', 'today'); 
            $rowsAllPages = $resultsTotalPages['reports'][0]->getData()->getRows();

            $results = $this->getResults($GAConn, $profId, '0daysAgo', 'today');
            //$results2 = $results;
            if (count($results['reports'][0]->getData()->getRows()) > 0) {

                $ignoreParams = $this->getIgnoreParams($pubData);
           
                $urlArray = $this->getUrlArray($results, $ignoreParams);
                $results = $urlArray;
                //$this->getPageDataFromUrls($urlArray, $pubData->domain, Auth::user()->publication->id);
                
                //$results = $this->parseResults($results, $ignoreParams, Auth::user()->publication->id);
                $g_Results = $results; // saving global for filling sections
               /* echo "<div id='storiesPanel'>";

                displayOverallResults($rowsAllPages, $results);

                displayResults($results);

                echo "</div>"*/

            }
            
            //$results = [$urlArray, $results];
            //$returnArray = $results; //$results['reports'][0]->getData()->getRows();

        } else {
            $returnArray = ['errors' => ['JSON credentials file has not been uploaded.', 'Another error just to test']];
        }
        $returnHtml = view('publications.storyStats', compact('results', 'rowsAllPages', 'pubData', 'returnArray'))->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
        //return view('publications.storyStats', compact('results', 'rowsAllPages', 'pubData', 'returnArray'));

    }

    public function adminIndex($id) {
        
        $pub = Publication::findOrFail($id);

        return view('admin.pubAdmin', compact('pub'));
    }

}
