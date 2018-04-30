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
use Config;

class PublicationController extends Controller
{
    use GoogAnalyticsInterface;

    private $g_Results = [];

    public function wrapper($id) {

        $pubData = Publication::findOrFail($id);
        return view('publications.statsWrapper', compact('pubData'));

    }

    public function sectionRefresh() {

        $contents = file_get_contents('resultsArray.txt');
        $results = json_decode($contents, true);
        //$results = Config::get('gResults');
        return view('publications.sectionStats', compact('results'));

    }

    public function refreshData($id) {

        $pubData = Publication::findOrFail($id);

        $path = __DIR__ . '/CredentialJson/'.$pubData->GAJsonFile;
        
        if(file_exists($path)){
            $GAConn = $this->connect($path, $pubData->name);

            if ($GAConn) {
                $profId = strval($pubData->GAProfileId);

                $resultsTotalPages = $this->getResultsAllPageViews($GAConn, $profId, '0daysAgo', 'today'); 
                $rowsAllPages = $resultsTotalPages['reports'][0]->getData()->getRows();

                $results = $this->getResults($GAConn, $profId, '0daysAgo', 'today');
                //$results2 = $results;
                if (count($results['reports'][0]->getData()->getRows()) > 0) {

                    $ignoreParams = $this->getIgnoreParams($pubData);
            
                    $urlArray = $this->getUrlArray($results, $ignoreParams);

                    //$this->getPageDataFromUrls($urlArray, $pubData->domain, Auth::user()->publication->id);
                    
                    $results = $this->parseResults($results, $ignoreParams, Auth::user()->publication->id);
                    //$this->g_Results = $results; // saving global for filling sections
                    
                    File::put('resultsArray.txt', json_encode($results));
                    
                /* echo "<div id='storiesPanel'>";

                    displayOverallResults($rowsAllPages, $results);

                    displayResults($results);

                    echo "</div>"*/

                }

                $totalStoriesUniques = $results['storyUniqueTotal'];
                $totalStoriesViews = $results['storyTotal'];
                $dayTotalViews = $rowsAllPages[0]['metrics'][0][0];
                $dayTotalUniques = $rowsAllPages[0]['metrics'][0][2];

            } else {
                $results['errors'] = ['GAReturn' => $GAConn];
            }
            
            //$results = [$urlArray, $results];
            //$returnArray = $results; //$results['reports'][0]->getData()->getRows();

        } else {
            $results['errors'] = ['JSON credentials file has not been uploaded.'];
        }
        

        return view('publications.storyStats', compact('results', 'pubData', 'totalStoriesUniques', 'totalStoriesViews', 'dayTotalViews', 'dayTotalUniques'));

    }

    public function adminIndex($id) {
        
        $pub = Publication::findOrFail($id);

        return view('admin.pubAdmin', compact('pub'));
    }

}
