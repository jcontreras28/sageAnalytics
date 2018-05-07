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

        $pubs = Publication::all();

        foreach($pubs as $pubData) {

            $pubId = $pubData->id;
            echo "doing pub: ".$pubData->name;
            //
            //$pubData = Publication::findOrFail($pubId);

            if ($pubData->GAJsonFile == NULL) {

                echo "No GA JSON for this pub.";

            } else {

                $path = __DIR__ . '/CredentialJson/'.$pubData->GAJsonFile;
            
                if(file_exists($path)){
                    $GAConn = $this->connect($path, $pubData->name);

                    if ($GAConn) {
                        $profId = strval($pubData->GAProfileId);

                        echo "connect to ga...";
                        $resultsTotalPages = $this->getResultsAllPageViews($GAConn, $profId, '0daysAgo', 'today'); 
                        $rowsAllPages = $resultsTotalPages['reports'][0]->getData()->getRows();

                        $results = $this->getResults($GAConn, $profId, '0daysAgo', 'today');

                        if (count($results['reports'][0]->getData()->getRows()) > 0) {

                            $ignoreParams = $this->getIgnoreParams($pubData);
                    
                            $urlArray = $this->getUrlArray($results, $ignoreParams);

                            $results = $this->parseResults($results, $ignoreParams, $pubId);

                        }

                        $results['dayTotalViews'] = $rowsAllPages[0]['metrics'][0][0];
                        $results['dayTotalUniques'] = $rowsAllPages[0]['metrics'][0][2];

                    } else {

                        $results['errors'] = ['Failed connecting to Google Analytics API'];

                    }

                } else {

                    $results['errors'] = ['JSON credentials file has not been uploaded. Path: '.$path];

                }

                var_dump($results);

                $fileName = './public/'.$pubData->id.'.txt';

                var_dump($fileName);

                File::put($fileName, json_encode($results));

            }

        }

        return 1; //view('publications.storyStats', compact('results', 'pubData', 'totalStoriesUniques', 'totalStoriesViews', 'dayTotalViews', 'dayTotalUniques'));
    }
}
