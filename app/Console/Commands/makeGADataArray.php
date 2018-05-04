<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Publication;
use App\Traits\GoogAnalyticsInterface;
use File;

class makeGADataArray extends Command
{
    use GoogAnalyticsInterface;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'article:getGAData';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets GA data, parses into array and writes to file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $pubData = Publication::findOrFail(1);

        $path = '/CredentialJson/'.$pubData->GAJsonFile;
        
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

                }

                $results['dayTotalViews'] = $rowsAllPages[0]['metrics'][0][0];
                $results['dayTotalUniques'] = $rowsAllPages[0]['metrics'][0][2];

            } else {

                $results['errors'] = ['Failed connecting to Google Analytics API'];

            }

        } else {

            $results['errors'] = ['JSON credentials file has not been uploaded. Path: '.$path];

        }
        
        File::put('./public/resultsArray.txt', json_encode($results));

        return view('publications.storyStats', compact('results', 'pubData', 'totalStoriesUniques', 'totalStoriesViews', 'dayTotalViews', 'dayTotalUniques'));
    }
}
