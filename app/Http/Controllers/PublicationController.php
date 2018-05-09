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

    public function sectionRefresh($id) {

        $pubData = Publication::findOrFail($id);
        $fileName = $pubData->id.".txt";

        $contents = file_get_contents($fileName);
        $results = json_decode($contents, true);
        //$results = Config::get('gResults');
        return view('publications.sectionStats', compact('results'));

    }

    public function refreshData($id) {

        $pubData = Publication::findOrFail($id);
        $fileName = $pubData->id.".txt";
        if ($contents = file_get_contents($fileName)) {

            $results = json_decode($contents, true);

            $totalStoriesUniques = $results['storyUniqueTotal'];
            $totalStoriesViews = $results['storyTotal'];
            $dayTotalViews = $results['dayTotalViews'];
            $dayTotalUniques = $results['dayTotalUniques'];

        } else {
            $results['errors']  = "Could not open data file.";
        }

        return view('publications.storyStats', compact('results', 'pubData', 'totalStoriesUniques', 'totalStoriesViews', 'dayTotalViews', 'dayTotalUniques'));

    }

    public function realtimeRefresh($id) {
        $pubData = Publication::findOrFail($id);

        $returnData = " Return from realTimeRefresh";

        return view('publications.realTime', compact('returnData', 'pubData'));

    }

    public function adminIndex($id) {
        
        $pub = Publication::findOrFail($id);

        return view('admin.pubAdmin', compact('pub'));
    }

    

}
