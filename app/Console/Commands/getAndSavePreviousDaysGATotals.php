<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Publication;
use App\StatsType;
use App\Traits\GoogAnalyticsInterface;

class getAndSavePreviousDaysGATotals extends Command
{

    use GoogAnalyticsInterface;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $pubs = Publication::all();
        $yesterday = date('Y-m-d', time() - 60 * 60 * 24);  //yesterdays date

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

                    if ($GAConn) {
                        $profId = strval($pub->GAProfileId);

                        echo "connect to ga...";

                        $resultsAllPages = $this->getResultsAllPageviews($GAConn, $profId, $start, $end);
                        $rowsAllPages = $resultsAllPages['reports'][0]->getData()->getRows();
                        $vals = $rowsAllPages[0]['metrics'][0]['values'];
                        $statTypeId = StatType::where('TypeName', '=', 'all')->first()->id;
                        
                        $vals = $rowsAllPages[0]['metrics'][0]['values'];
                        
                        $dailyStat = new DailyStat();
                        $dailyStat->Date = $yesterday;
                        $dailyStat->Hits = $vals[0];
                        $dailyStat->Uniques = $vals[2];
                        $dailyStat->Dwell = $vals[1];
                        $dailyStat->TypeId = $statTypeId;
                        $dailyStat->save();
                       
                        
                    }
                }
            }
        }
        return 1;
    }
}
