<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Publication;
use App\Traits\GoogAnalyticsInterface;
use File;

class getRealtimeGAData extends Command
{

    use GoogAnalyticsInterface;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'article:getGARealtimeData';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get the realtime data from google analytics and write array to file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function getData() 
    {
        //
        $pubs = Publication::all();

        foreach($pubs as $pubData) {

            $results = [];
            $resultsTotalPages = [];
            $pubId = $pubData->id;
            echo "doing pub: ".$pubData->name;
            //
            //$pubData = Publication::findOrFail($pubId);

            if ($pubData->GAJsonFile == NULL) {

                echo "No GA JSON for this pub.";

            } else {

                $path = __DIR__ . '/CredentialJson/'.$pubData->GAJsonFile;
            
                if(file_exists($path)){

                    $GAConn = $this->connectRealTime($path);

                    if ($GAConn) {
                        $profId = strval($pubData->GAProfileId);

                        echo "connect to ga...";
                        $rows = $this->getResultsRealtime($GAConn, $profId); 

                        $ignoreParams = $this->getIgnoreParams($pubData);

                        $resultsTotalPages = $this->parseResultsRealtime($rows, $ignoreParams, $pubId);

                    } else {

                        $results['errors'] = ['Failed connecting to Google Analytics API'];

                    }

                } else {

                    $results['errors'] = ['JSON credentials file has not been uploaded. Path: '.$path];

                }

                $fileName = './public/'.$pubData->id.'rt.txt';

                var_dump($resultsTotalPages);
                var_dump($fileName);

                File::put($fileName, json_encode($resultsTotalPages));

                unset($resultsTotalPages);

            }
        }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        this::getData();
        sleep(25);
        this::getData();
    }
}
