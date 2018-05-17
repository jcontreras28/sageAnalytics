<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Publication;
use App\StatType;
use App\DailyStatsTotal;
use App\DailyStoryStatsTotal;
use App\Traits\GoogAnalyticsInterface;

class getAndSavePreviousDaysGATotals extends Command
{

    use GoogAnalyticsInterface;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DailyStats:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to grab the previous days stats - totals/stories and put in table';

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
        $yesterday = date('Y-m-d', time() - 60 * 60 * 24);  //yesterdays date
       // $yesterday = date('Y-m-d')
        $start = '1daysAgo';
        $end = '1daysAgo';
        
        $pubs = Publication::all();

        foreach($pubs as $pub) {

            $pubId = $pub->id;
            echo "doing pub: ".$pub->name;
            //
            //$pubData = Publication::findOrFail($pubId);

            if ($pub->GAJsonFile == NULL) {

                echo "No GA JSON for this pub.";

            } else {

                $path = __DIR__ . '/CredentialJson/'.$pub->GAJsonFile;
            
                if(file_exists($path)){

                    $GAConn = $this->connect($path, $pub->name);

                    if ($GAConn) {
                        $profId = strval($pub->GAProfileId);

                        echo "connect to ga...";

                        $resultsAllPages = $this->getResultsAllPageviews($GAConn, $profId, $start, $end);
                        $rowsAllPages = $resultsAllPages['reports'][0]->getData()->getRows();
                        $vals = $rowsAllPages[0]['metrics'][0]['values'];
                        $statTypeId = StatType::where('TypeName', '=', 'all')->first()->id;
                        
                        $vals = $rowsAllPages[0]['metrics'][0]['values'];

                        $dailyStat = new DailyStatsTotal();
                        $dailyStat->Date = $yesterday;
                        $dailyStat->Hits = $vals[0];
                        $dailyStat->Uniques = $vals[2];
                        $dailyStat->Dwell = $vals[1];
                        $dailyStat->TypeId = $statTypeId;
                        $dailyStat->publication_id = $pub->id;
                        $dailyStat->save();
                        unset($dailyStat); 

                        $statTypeId = StatType::where('TypeName', '=', 'story')->first()->id;
                        echo "statTypeId: ".$statTypeId;
                       // $results = $this->getResults($GAConn, $profId, '1daysAgo', '1daysAgo');
                        $results = $this->getResults($GAConn, $profId, '0daysAgo', 'today');
                        //var_dump($results);

                        if (count($results['reports'][0]->getData()->getRows()) > 0) {

                            $ignoreParams = $this->getIgnoreParams($pub);

                            $results = $this->parseResultsDailyStory($results, $ignoreParams, $pubId);

                            dd($results);
                            $dailyStat = new DailyStatsTotal();
                            $dailyStat->Date = $yesterday;
                            $dailyStat->Hits = $results['storyTotal'];
                            $dailyStat->Uniques = $results['storyUniqueTotal'];
                            $dailyStat->Dwell = 0; // TODO impliment in parseResults and here
                            $dailyStat->TypeId = $statTypeId;
                            $dailyStat->publication_id = $pub->id;
                            $dailyStat->save(); 

                            unset($dailyStat);

                           /* dd($results);

                            foreach($results['articles'] as $identifier => $story) {

                                echo 'working on ';
                                var_dump($story);
                                $identifierId = Identifier::where('identifier', '=', $identifier)->first()->id;
                                $dailyStoryStat = new DailyStoryStatsTotal();
                                $dailyStoryStat->date = $yesterday;
                                $dailyStoryStat->identifier_id = $identifierId;
                                $dailyStoryStat->hits = $story['Views'];
                                $dailyStoryStat->uniques = $story['Uniques'];
                                $dailyStoryStat->dwell = 0; //$story['Dwell'];  // TODO impliment in parseResults and here
                                $dailyStoryStat->publication_id = $pub->id;
                                $dailyStoryStat->save();

                                unset($dailyStoryStat);

                            }*/

                        }
                    }
                }
            }
        }
        return 1;
    }
}
