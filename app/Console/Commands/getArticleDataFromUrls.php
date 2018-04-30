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

        $id = 2;
        $pub = Publication::findOrFail($id);
        var_dump($pub);
        //foreach($pubs as $pub) {

            $path = __DIR__ . '/../../Http/Controllers/CredentialJson/'.$pub->GAJsonFile;
            
            //echo $path;
            if(file_exists($path)){
                
                $GAConn = $this->connect($path, $pub->name);

                $profId = strval($pub->GAProfileId);
                
                $results = $this->getResults($GAConn, $profId, '0daysAgo', 'today');
             
                if (count($results['reports'][0]->getData()->getRows()) > 0) {

                    $ignoreParams = $this->getIgnoreParams($pub);
                    
                    $urlArray = $this->getUrlArray($results, $ignoreParams);

                    $pubId = 2; // todo switch to per pub
                    $this->getPageDataFromUrls($urlArray, $pub->domain, $pubId);
                
                }
            }
            //var_dump( $urlArray );
       // }
       return $pub;
    }
}
