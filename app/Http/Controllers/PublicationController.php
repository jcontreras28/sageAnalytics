<?php

namespace App\Http\Controllers;

use App\Publication;
use Illuminate\Http\Request;
use App\Traits\GoogAnalyticsInterface;

class PublicationController extends Controller
{
    use GoogAnalyticsInterface;

    public function index($id) {
        $pub = Publication::findOrFail($id);

        $path = __DIR__ . '/CredentialJson/'.str_replace(' ', '', $pub->name).'Sage.json';
        //$GAConn = $this->connect(__DIR__.'/CredentialJson/BendBulletinSage.json', 'BendBulletin');
        $GAConn = $this->connect($path, $pub->name);

        $profId = $pub->GAProfileId;
        $resultsTotalPages = $this->getAllPageViews($GAConn, $profId, '0daysAgo', 'today'); 

        $returnArray = ['pubData' => $pub, 'viewData' => $resultsTotalPages];


        return view('publications.stats', compact('returnArray'));

    }

    public function adminIndex($id) {
        
        $pub = Publication::findOrFail($id);

        return view('admin.pubAdmin', compact('pub'));
    }
}
