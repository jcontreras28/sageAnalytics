<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Publication;
use App\Traits\GoogAnalyticsInterface;

class getArticleDataFromUrls extends Command
{
    use GoogAnalyticsInterface;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'articleData:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get article data from analytics urls';

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

            foreach($pubs as $pub) {
            
                echo " Working on ".$pub->name;

                if ($pub->GAJsonFile == NULL) {

                    echo "No GA JSON for this pub.";
    
                } else {

                    $path = __DIR__ . '/CredentialJson/'.$pub->GAJsonFile;

                    if(file_exists($path)){
                        
                        $GAConn = $this->connect($path, $pub->name);

                        if ($GAConn) {
                            $profId = strval($pub->GAProfileId);
    
                            echo "connect to ga...";

                        
                            $results = $this->getResults($GAConn, $profId, '0daysAgo', 'today');
                        
                            if (count($results['reports'][0]->getData()->getRows()) > 0) {

                                $ignoreParams = $this->getIgnoreParams($pub);
                                
                                $urlArray = $this->getUrlArray($results, $ignoreParams);

                                $this->getPageDataFromUrls($urlArray, $pub->domain, $pub->id);
                            
                            }
                        } else {
                            echo "couldn't connect to GA.";
                        }
                    } else {
                        echo "NO GA JSON file found.";
                    }
                }
                
            }

        return 1;
    }
}
