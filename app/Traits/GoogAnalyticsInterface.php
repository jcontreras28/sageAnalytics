<?php

namespace App\Traits;

use Google\ApiClient\Client;
use App\Url;
use App\UrlType;
use App\Identifier;
use App\Article;
use Auth;

trait GoogAnalyticsInterface {


    /**
     * @param $pubKeyFile
     * @param $pubName
     * @return string
     */
    public function connect($pubKeyFile, $pubName) {

        $pubName = $pubName.' Sage Analytics Reporting';
        // Create and configure a new client object.
        $client = new \Google_Client();
        $client->setApplicationName("Hello Analytics Reporting");
        $client->setAuthConfig($pubKeyFile);
        $client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
        $analytics = new \Google_Service_AnalyticsReporting($client);

        return $analytics;
    }

    public function connectRealTime($pubKeyFile) {

  		// Create and configure a new client object.
  		$client = new \Google_Client();
  		$client->setApplicationName("Hello Analytics Reporting");
  		$client->setAuthConfig($pubKeyFile);
  		$client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
  		$analytics = new \Google_Service_Analytics($client);

  		return $analytics;
    }

    function getResultsAllPageviews($GAConn, $profileId, $start, $end) {

        // Create the DateRange object.
        $dateRange = new \Google_Service_AnalyticsReporting_DateRange();
        $dateRange->setStartDate($start);
        $dateRange->setEndDate($end);

        // Create the Metrics object.
        $sessions1 = new \Google_Service_AnalyticsReporting_Metric();
        $sessions1->setExpression("ga:pageviews");
        $sessions1->setAlias("pageviews");
        $sessions2 = new \Google_Service_AnalyticsReporting_Metric();
        $sessions2->setExpression("ga:avgTimeOnPage");
        $sessions2->setAlias("dwell");
        $sessions3 = new \Google_Service_AnalyticsReporting_Metric();
        $sessions3->setExpression("ga:uniquePageviews");
        $sessions3->setAlias("uniques");


        // Create the ReportRequest object.
        $request = new \Google_Service_AnalyticsReporting_ReportRequest();
        $request->setViewId($profileId);
        $request->setDateRanges($dateRange);
        $request->setMetrics(array($sessions1, $sessions2, $sessions3));

        $body = new \Google_Service_AnalyticsReporting_GetReportsRequest();
        $body->setReportRequests( array( $request) );
        return $GAConn->reports->batchGet( $body );

    }

    public function getAllPageViews($GAConn, $profileId, $start, $end) {
        // Create the DateRange object.
        $dateRange = new \Google_Service_AnalyticsReporting_DateRange();
        $dateRange->setStartDate($start);
        $dateRange->setEndDate($end);

        // Create the Metrics object.
        $sessions1 = new \Google_Service_AnalyticsReporting_Metric();
        $sessions1->setExpression("ga:pageviews");
        $sessions1->setAlias("pageviews");
        $sessions2 = new \Google_Service_AnalyticsReporting_Metric();
        $sessions2->setExpression("ga:avgTimeOnPage");
        $sessions2->setAlias("dwell");
        $sessions3 = new \Google_Service_AnalyticsReporting_Metric();
        $sessions3->setExpression("ga:uniquePageviews");
        $sessions3->setAlias("uniques");


        // Create the ReportRequest object.
        $request = new \Google_Service_AnalyticsReporting_ReportRequest();
        $request->setViewId("3577111");
        $request->setDateRanges($dateRange);
        $request->setMetrics(array($sessions1, $sessions2, $sessions3));

        $body = new \Google_Service_AnalyticsReporting_GetReportsRequest();
        $body->setReportRequests( array( $request) );
        $results = $GAConn->reports->batchGet( $body );
        return $results['reports'][0]->getData()->getRows();
    }

    public function getResults($GAConn, $profileId, $start, $end) {
        // Create the DateRange object.
        $dateRange = new \Google_Service_AnalyticsReporting_DateRange();
        $dateRange->setStartDate($start);
        $dateRange->setEndDate($end);

        // Create the Metrics object.
        $sessions1 = new \Google_Service_AnalyticsReporting_Metric();
        $sessions1->setExpression("ga:pageviews");
        $sessions1->setAlias("pageviews");
        $sessions2 = new \Google_Service_AnalyticsReporting_Metric();
        $sessions2->setExpression("ga:avgTimeOnPage");
        $sessions2->setAlias("dwell");
        $sessions3 = new \Google_Service_AnalyticsReporting_Metric();
        $sessions3->setExpression("ga:uniquePageviews");
        $sessions3->setAlias("uniques");

        //Create the Dimensions object.
        $dims1 = new \Google_Service_AnalyticsReporting_Dimension();
        $dims1->setName("ga:pagePath");
        $dims2 = new \Google_Service_AnalyticsReporting_Dimension();
        $dims2->setName("ga:fullReferrer");

        // Create the Ordering.
        $ordering = new \Google_Service_AnalyticsReporting_OrderBy();
        $ordering->setOrderType("VALUE");
        $ordering->setFieldName("ga:pageviews");
        $ordering->setSortOrder("DESCENDING");

        // Create the ReportRequest object.
        $request = new \Google_Service_AnalyticsReporting_ReportRequest();
        $request->setViewId($profileId);
        $request->setDateRanges($dateRange);
        $request->setPageToken("0");
        $request->setPageSize("10000");
        $request->setDimensions(array($dims1, $dims2));
        $request->setOrderBys(array($ordering));
        $request->setMetrics(array($sessions1, $sessions2, $sessions3));

        $body = new \Google_Service_AnalyticsReporting_GetReportsRequest();
        $body->setReportRequests( array( $request) );
        return $GAConn->reports->batchGet( $body );
    }

    function getResultsRealTime($analytics, $profileId) {
		// Calls the Core Reporting API and queries for the number of sessions
  		// for the last seven days.
		$optParams = array();

		// Required Parameters
		$metrics = 'rt:activeUsers'; // Users: get active users

        $optParams['dimensions']  = 'rt:pagePath';
        $optParams['sort']        = '-rt:activeUsers';

		$return = $analytics->data_realtime->get(
              	'ga:'. $profileId,
               	$metrics,
               	$optParams
        );

        return $return->getRows();
    }
    
    function getAllStoryStats($analytics, $profileId, $urlPart, $start, $end, $type)
    {
        $query = [
            "viewId" => $profileId,
            "dateRanges" => [
                "startDate" => $start,
                "endDate" => $end
            ],
            "metrics" => [
                "expression" => $type
                //"expression" => "ga:avgTimeOnPage",
                //"expression" => "ga:uniquePageviews"
            ],

            "dimensionFilterClauses" => [
                'filters' => [
                    "dimension_name" => "ga:pagepath",
                    "operator" => "PARTIAL", // valid operators can be found here: https://developers.google.com/analytics/devguides/reporting/core/v4/rest/v4/reports/batchGet#FilterLogicalOperator
                    "expressions" => $urlPart
                ]
            ]
        ];

        // build the request and response
        $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
        $body->setReportRequests(array($query));
        // now batchGet the results https://developers.google.com/analytics/devguides/reporting/core/v4/rest/v4/reports/batchGet
        $report = $analytics->reports->batchGet($body);
        return $report;
    }

    public function cmp($a, $b)
	{
   		return (($b['Views']) - ($a['Views']));
    }
    
    function cmp2($a, $b) 
    {   
        return (($b) - ($a));
    } 

    function cmp3($a, $b)
    {
        return (($b['count']) - ($a['count']));
    }

    public function getIgnoreParams($pubData) {

        if ($pubData->ignore_all_params) {

            $ignoreParams = ['type' => 'All'];

        } else if (count($pubData->ignoreParams) > 0) {

            $tmpArray = [];

            foreach ($pubData->ignoreParams as $param) {

                array_push($tmpArray, $param->trigger_word);

            }

            $ignoreParams = ['type' => 'List', 'params' => $tmpArray];

        } else {
            
            $ignoreParams = ['type' => 'None'];
        }

        return $ignoreParams;
    }

    private function cleanUrl($url, $ignoreParams) {

        $cleanUrl = '';

        $url = trim($url);
        /*$url = ltrim($url, '/');
        $url = rtrim($url, '/');*/
 
        if ($ignoreParams['type'] == 'All'){

            $url = explode("?", $url);
            $cleanUrl = $url[0];

        } else if (array_key_exists( 'params', $ignoreParams)){

            $parsed = parse_url($url);
            
            if (array_key_exists('query', $parsed)){
                
                //dd($parsed);
                $query = $parsed['query'];
                parse_str($query, $theparams);
                
                foreach($ignoreParams['params'] as $ignoreparam) {
   
                    if (array_key_exists($ignoreparam, $theparams)) {
                    
                        unset($theparams[$ignoreparam]);

                    }
                }
                $cleanUrl = $parsed['path'];
                if (count($theparams) > 0){
                    $cleanUrl .= "?".http_build_query($theparams);
                }

            } else {

                $cleanUrl = $url;

            }

        } else {

            $cleanUrl = $url;

        }

        if ($cleanUrl == "" || $cleanUrl == "/") {

            $cleanUrl = "/Home/";

        }
        return $cleanUrl;
    }

    public function getUrlArray($results, $ignoreParams) {

        $rows = $results['reports'][0]->getData()->getRows();
        $urlArray = [];

        foreach($rows as $row) {

            $url = $row['dimensions'][0];
            $url = self::cleanUrl($url, $ignoreParams);

            if (!in_array($url, $urlArray)) {

                array_push($urlArray, $url);

            }
        }
        return $urlArray;
    }

    public function getUrlData ($url) {

        $html = @file_get_contents( $url );

        if ($html === FALSE) {
            return 'bad json';
        }

        $dom  = new \DOMDocument();
        libxml_use_internal_errors( 1 );
        $dom->loadHTML( $html );
        $xpath = new \DOMXpath( $dom );

        $jsonScripts = $xpath->query( '//script[@type="application/ld+json"]' );
        if (isset($jsonScripts->item(0)->nodeValue)) {
            $json = trim( $jsonScripts->item(0)->nodeValue );
        } else {
            return 'bad json';
        }

        $data = json_decode( $json );

        if(!$data || $data == "") {

            $data = 'bad json';

        }

        return $data;
    }

    public function getArticleData($urlData) {

        $article = new Article();
        $article->headline = substr($urlData->headline, 0, 127);
        $article->published_date = $urlData->datePublished;

        if (array_key_exists('thumbnailUrl', $urlData)) {

            $article->image = $urlData->thumbnailUrl;

        } else {
            $article->image = "none";
        }

        if (array_key_exists('author', $urlData)) {

            $article->author = $urlData->author;

        }

        if (array_key_exists('name', $urlData)) {

            $article->name = $urlData->name;

        }

        return $article;
    }

    public function inLookupTable($url, $pubId) {

        echo "\r\n\r\n   ".$url."  ";

        $theUrl = Url::where('url', '=', $url)->where('publication_id', '=', $pubId)->first();
        
        //var_dump($theUrl);
        
        if ($theUrl) {
            
            if ($theUrl->publication->id == $pubId) {
                echo " ***** found! ";
                return true;
            }
            echo " exists but wrong pub - ".$theUrl->publication->id." - ".$pubId;
        }
        echo " not found!";
        return false;
    }

    public function getPageDataFromUrls($urlArray, $domain, $pubId) {

        $allUrlData = [];
        $count = 0;

        foreach($urlArray as $url) {

            $fullUrl = 'http://'.$domain.$url;

            if (!self::inLookupTable($url, $pubId)) {

                // get the json ld data from the url
                $urlData = self::getUrlData($fullUrl);

                //var_dump($urlData);

                $theArticleSection = 'noneGiven';

                //print_r($urlData);
                if ($urlData != 'bad json') {

                    // parse out the type of page it is - NewsArticle, WebPage, or no json present
                    $type = "";
                    if ($urlData->{'@type'} == 'NewsArticle') {
                        
                        $theIdentifier = $urlData->identifier;  

                        
                        if (isset($urlData->articleSection)) {

                            $theArticleSection = $urlData->articleSection;

                        }

                        $type = 'newsarticle';
                           
                    }  else if ($urlData->{'@type'} == 'WebPage') {

                        $theIdentifier = $urlData->identifier;  
                        $type = 'webpage';
                        
                    } else {

                        $type = 'webpage';
                        $theIdentifier = $url;

                    }

                    // Look to see if the identifier is already in identifier table (diff urls can have same identifier)
                    $ident = Identifier::where('identifier', "=", $theIdentifier)->first();

                    if ($ident) {

                        $id = $ident->id;

                    } else {

                        // add new identifier to table
                        $ident = new Identifier();
                        $ident->identifier = $theIdentifier;
                        $ident->publication_id = $pubId; //Auth::user()->publication->id;

                        // get url type from table so we have access to its id or add it if not there
                        $typeObj = UrlType::where('name', '=', $type)->first();
                       
                        if ($typeObj) {

                            $ident->url_type_id = $typeObj->id;

                        } else {

                            $data = ['name' => $typeObj];
                            $newType = UrlType::Create($data);
                            $ident->url_type_id = $newType->id;

                        }

                        $ident->save();
                        
                    }

                    // if its a news article, then we need to check if we have story data already
                    if ($type == 'newsarticle') {

                        // check if article is already in table
                        $article = Article::where('identifier_id', "=", $ident->id)->first();

                        if (!$article) {

                            $newarticle = self::getArticleData($urlData);
                            $newarticle->identifier_id = $ident->id;
                            $newarticle->save();

                        }

                    }
                    
                    // finally, add the new url to the url lookup table.
                    $newurl = new Url();
                    $newurl->identifier_id = $ident->id;
                    $newurl->url = $url;
                    $newurl->articleSection = $theArticleSection;
                    $newurl->publication_id = $pubId;
                    $saved = $newurl->save();

                    if (!$saved) { dd($url); }

                } else {
                    //dd($url);
                    print_r ($url);
                }
            }
        }
    }

    public function calculateNewTotal($dataArray, $row, $type, $url, $index) {

        $oldVal = $dataArray[$url->identifier->identifier][$type];
        $newVal = $oldVal + (int)$row['metrics'][0]['values'][$index];
        $dataArray[$url->identifier->identifier][$type] = $newVal;
        return $dataArray;

    }

    function getReferrers($row, $theArray, $key) {

    	$theRefUrl = $row['dimensions'][1];
		$refUrlArr = explode('/', $theRefUrl);
		$theRefUrl = $refUrlArr[0];

        
		if (array_key_exists($theRefUrl, $theArray[$key]['referrers'])) {

			$curTot = $theArray[$key]['referrers'][$theRefUrl];
			$newTot = $curTot + $row['metrics'][0]['values'][0];
            $theArray[$key]['referrers'][$theRefUrl] = $newTot;
            
		} else {

            $theArray[$key]['referrers'][$theRefUrl] = $row['metrics'][0]['values'][0];
            
        }
       
		return $theArray;
    }

    public function parseResultsRealtime($rows, $ignoreParams, $pubId, $count = 20) {

        // Get the entry for the first entry in the first row.

        $sessions = $rows[0][0];

        $storyArray = [];
        $allPageTotal = 0;
        $storyTotal = 0;

        if ($rows) {

            foreach($rows as $row) {

                $thisUrl = self::cleanUrl($row[0], $ignoreParams);
                $url = Url::where('url', '=', $thisUrl)->where('publication_id', '=', $pubId)->first();

                $allPageTotal = $allPageTotal + $row[1]; // ongoing total of everybody on site

                if ($url && ($url->publication->id == $pubId)) {
    
                    if($url->identifier->urlType->name == 'newsarticle') {
    
                        $storyTotal = $storyTotal + $row[1];

                        if (array_key_exists($url->identifier->identifier, $storyArray)) {

                            $oldTotal = $storyArray[$url->identifier->identifier]['count'];
                            $newTotal = $row[1] + $oldTotal;
                            $storyArray[$url->identifier->identifier]['count'] = $newTotal;

                        } else {

                            $tmpArray = [
                                'count' => (int)$row[1],
                                'link' => $thisUrl,
                                'headline' => $url->identifier->article->headline,
                                'image' => $url->identifier->article->image,
                                'published_date' => $url->identifier->article->published_date,
                                'author' => $url->identifier->article->author,
                                'name' => $url->identifier->article->name
                            ];

                            $storyArray[$url->identifier->identifier] = $tmpArray;
                        }
                    }
                }
            }

            uasort($storyArray, "self::cmp3");
            $storyArray = array_slice($storyArray, 0, 20, true);
            $returnArray = array("stories" => $storyArray,
                                "storyTotal" => $storyTotal,
                                "allPageTotal" => $allPageTotal,
                                "sessions" => $sessions);
        } else {
            $returnArray['errors'] = 'No rows returned from GA';
        }

        return $returnArray;
    }

    public function parseResultsDailyStory($results, $ignoreParams, $pubId) {
        
        $rows = $results['reports'][0]->getData()->getRows();
        $dataArray = [
            'articles' => [],
        ];

        $storyTotal = 0;
        $storyUniqueTotal = 0;

        foreach($rows as $row) {
            // get identifier from url table

            $thisUrl = self::cleanUrl($row['dimensions'][0], $ignoreParams);
            $url = Url::where('url', '=', $thisUrl)->where('publication_id', '=', $pubId)->first();

            if ($url && ($url->publication->id == $pubId)) {
 
                if($url->identifier->urlType->name == 'newsarticle') {

                    // its an article - calcuate day total results
                    $storyTotal = $storyTotal + $row['metrics'][0]['values'][0];
                    $storyUniqueTotal = $storyUniqueTotal + $row['metrics'][0]['values'][2];

                    //      check if identifier is key in array['articles']
                    if (array_key_exists($url->identifier->identifier, $dataArray['articles'])) {

                        $dataArray['articles'] = self::calculateNewTotal($dataArray['articles'], $row, 'Views', $url, 0);
                        $dataArray['articles'] = self::calculateNewTotal($dataArray['articles'], $row, 'Uniques', $url, 2);
                        $dataArray['articles'] = self::calculateNewTotal($dataArray['articles'], $row, 'Dwell', $url, 1);

                    } else {

                        //$secArray[$url->articleSection] = (int)$row['metrics'][0]['values'][0];
                        $refArray = array();
                        $tmpArray = ['Views' => (int)$row['metrics'][0]['values'][0], 
                                    'Uniques' => (int)$row['metrics'][0]['values'][2], 
                                    'Dwell' => (float)$row['metrics'][0]['values'][1]
                                ];
                        $dataArray['articles'][$url->identifier->identifier] = $tmpArray;

                    }
                    
                }
            }
        }
        $dataArray['storyTotal'] = $storyTotal;
        $dataArray['storyUniqueTotal'] = $storyUniqueTotal;

        return $dataArray;
    }

    public function parseResults($results, $ignoreParams, $pubId) {

        $rows = $results['reports'][0]->getData()->getRows();
        $dataArray = [
            "articles" => [],
            "sections" => [],
        ];

        $dayTotal = 0;
        $storyTotal = 0;
        $sectionTotal = 0;
        $storyUniqueTotal = 0;
        $sectionUniqueTotal = 0;

        foreach($rows as $row) {
            // get identifier from url table

            $thisUrl = self::cleanUrl($row['dimensions'][0], $ignoreParams);
            $url = Url::where('url', '=', $thisUrl)->where('publication_id', '=', $pubId)->first();

            if ($url && ($url->publication->id == $pubId)) {
 
                if($url->identifier->urlType->name == 'newsarticle') {

                    // its an article - calcuate day total results
                    $dayTotal = $dayTotal + $row['metrics'][0]['values'][0];
                    $storyTotal = $storyTotal + $row['metrics'][0]['values'][0];
                    $storyUniqueTotal = $storyUniqueTotal + $row['metrics'][0]['values'][2];

                    //      check if identifier is key in array['articles']
                    if (array_key_exists($url->identifier->identifier, $dataArray['articles'])) {

                        $dataArray['articles'] = self::calculateNewTotal($dataArray['articles'], $row, 'Views', $url, 0);
                        $dataArray['articles'] = self::calculateNewTotal($dataArray['articles'], $row, 'Uniques', $url, 2);
                        $dataArray['articles'] = self::calculateNewTotal($dataArray['articles'], $row, 'Dwell', $url, 1);
                        $dataArray['articles'] = self::getReferrers($row, $dataArray['articles'], $url->identifier->identifier);

                        /*if (array_key_exists($url->articleSection, $dataArray['articles']['sections'])) {
                            $oldSectionValue = $dataArray['articles'][$url->articleSection];
                            $newValue = $oldSectionValue + $row['metrics'][0]['values'][0];
                            $dataArray['articles']['sections'][$url->articleSection] = $newValue;
                        } else {
                            $dataArray['articles']['sections'][$url->articleSection] = $row['metrics'][0]['values'][0];
                        }*/

                    } else {

                        //$secArray[$url->articleSection] = (int)$row['metrics'][0]['values'][0];
                        $refArray = array();
                        $tmpArray = ['Views' => (int)$row['metrics'][0]['values'][0], 
                                    'Uniques' => (int)$row['metrics'][0]['values'][2], 
                                    'Dwell' => (float)$row['metrics'][0]['values'][1], 
                                    'link' => $thisUrl,
                                    'referrers' => $refArray,
                                    'headline' => $url->identifier->article->headline,
                                    'image' => $url->identifier->article->image,
                                    'published_date' => $url->identifier->article->published_date,
                                    'author' => $url->identifier->article->author,
                                    'name' => $url->identifier->article->name
                                    //'sections' => $secArray
                                ];
                        $dataArray['articles'][$url->identifier->identifier] = $tmpArray;

                    }
                    
                } else {
                
                    $dayTotal = $dayTotal + $row['metrics'][0]['values'][0];
                    $sectionTotal = $sectionTotal + $row['metrics'][0]['values'][0];
                    $sectionUniqueTotal = $sectionUniqueTotal + $row['metrics'][0]['values'][2];

                    if (array_key_exists($url->identifier->identifier, $dataArray['sections'])) {

                        $dataArray['sections'] = self::calculateNewTotal($dataArray['sections'], $row, 'Views', $url, 0);
                        $dataArray['sections'] = self::calculateNewTotal($dataArray['sections'], $row, 'Uniques', $url, 2);
                        $dataArray['sections'] = self::calculateNewTotal($dataArray['sections'], $row, 'Dwell', $url, 1);
                        $dataArray['sections'] = self::getReferrers($row, $dataArray['sections'], $url->identifier->identifier);
                        
                    } else {

                        $refArray = array();
                        $tmpArray = ['Views' => (int)$row['metrics'][0]['values'][0], 
                                    'Uniques' => (int)$row['metrics'][0]['values'][2], 
                                    'Dwell' => (float)$row['metrics'][0]['values'][1], 
                                    'referrers' => $refArray];
                        $dataArray['sections'][$url->identifier->identifier] = $tmpArray;

                    }  
                }
            }
        }
        uasort($dataArray['articles'], "self::cmp");
        uasort($dataArray['sections'], "self::cmp");
        $dataArray['articles'] = array_slice($dataArray['articles'], 0, 200, true);

        // sort the referrers array into descending order
        foreach($dataArray['articles'] as $key => $article) {
            uasort($article['referrers'], "self::cmp2");
            $dataArray['articles'][$key]['referrers'] = $article['referrers'];
        }

        // sort the referrers array for sections into descending order
        foreach($dataArray['sections'] as $key => $section) {
            uasort($section['referrers'], "self::cmp2");
            $dataArray['sections'][$key]['referrers'] = $section['referrers'];
        }


        /*$identifier = array_keys($storyArray);
        $cmsIdsArray = array_slice($identifier, 0, 199);
        $storyArray = getNameAndHeadline($cmsIdsArray, $storyArray);*/
        $dataArray['storyTotal'] = $storyTotal;
        $dataArray['storyUniqueTotal'] = $storyUniqueTotal;
        $dataArray['dayTotal'] = $dayTotal;
        $dataArray['sectionTotal'] = $sectionTotal;
        $dataArray['sectionUniqueTotal'] = $sectionUniqueTotal;

        return $dataArray;
    }

    

}