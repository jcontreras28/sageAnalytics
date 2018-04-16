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

        //dd($url);
        $html = file_get_contents( $url );
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

        return $data;
    }

    public function getArticleData($urlData) {

        $article = new Article();
        $article->headline = substr($urlData->headline, 0, 127);
        $article->published_date = $urlData->datePublished;

        if (array_key_exists('thumbnailUrl', $urlData)) {

            $article->image = $urlData->thumbnailUrl;

        }

        if (array_key_exists('author', $urlData)) {

            $article->author = $urlData->author;

        }

        if (array_key_exists('name', $urlData)) {

            $article->name = $urlData->name;

        }

        return $article;
    }

    public function inLookupTable($url) {

        $allUrlData = [];

        if (Url::where('url', '=', $url)->exists()) {
            return true;
        }

        return false;
    }

    public function getStoryDataFromUrls($urlArray, $domain) {

        $allUrlData = [];
        $count = 0;

        foreach($urlArray as $url) {

            $count++;
            if ($count > 20)
                break;

            $fullUrl = 'http://'.$domain.$url;

            if (!self::inLookupTable($url)) {

                $urlData = self::getUrlData($fullUrl);

                if (($urlData != 'bad json') && ($urlData))  {

                    if ($urlData->{'@type'} == 'NewsArticle') {
                        $theIdentifier = $urlData->identifier;       
                    } else {
                        $theIdentifier = $url;
                    }

                    $ident = Identifier::where('identifier', "=", $theIdentifier)->first();

                    if ($ident) {

                        $id = $ident->id;

                    } else {

                        $ident = new Identifier();
                        $ident->identifier = $theIdentifier;
                        $ident->publication_id = Auth::user()->publication->id;

                        $type = strtolower($urlData->{'@type'});
                        $type = UrlType::where('name', '=', $type)->first();

                        if ($type) {

                            $ident->url_type_id = $type->id;

                        } else {

                            $data = ['name' => $type];
                            $newType = UrlType::Create($data);
                            $ident->url_type_id = $newType->id;

                        }

                        $ident->save();
                    }

                    if ($urlData->{'@type'} == 'NewsArticle') {

                        $article = self::getArticleData($urlData);
                        $article->identifier_id = $ident->id;
                        $article->save();

                    }
                    
                    $newurl = new Url();
                    $newurl->identifier_id = $ident->id;
                    $newurl->url = $url;
                    $newurl->save();

                }
            }
        }

        //return $allUrlData;
    }

    public function calculateNewTotal($dataArray, $row, $type, $url, $index) {

        $oldVal = $dataArray[$url->identifier->identifier][$type];
        $newVal = $oldVal + (int)$row['metrics'][0]['values'][$index];
        $dataArray[$url->identifier->identifier][$type] = $newVal;
        return $dataArray;

    }

    public function parseResults($results, $ignoreParams) {

        $rows = $results['reports'][0]->getData()->getRows();
        $dataArray = [
            "articles" => [],
            "sections" => [],
        ];

        foreach($rows as $row) {
            // get identifier from url table

            $thisUrl = self::cleanUrl($row['dimensions'][0], $ignoreParams);
            $url = Url::where('url', '=', $thisUrl)->first();

            if ($url) {
 
                if($url->identifier->urlType->name == 'newsarticle') {
                    //      check if identifier is key in array['articles']
                    if (array_key_exists($url->identifier->identifier, $dataArray['articles'])) {

                        $dataArray['articles'] = self::calculateNewTotal($dataArray['articles'], $row, 'Views', $url, 0);
                        $dataArray['articles'] = self::calculateNewTotal($dataArray['articles'], $row, 'Uniques', $url, 2);
                        $dataArray['articles'] = self::calculateNewTotal($dataArray['articles'], $row, 'Dwell', $url, 1);

                    } else {

                        $tmpArray = ['Views' => (int)$row['metrics'][0]['values'][0], 'Uniques' => (int)$row['metrics'][0]['values'][2], 'Dwell' => (float)$row['metrics'][0]['values'][1]];
                        $dataArray['articles'][$url->identifier->identifier] = $tmpArray;

                    }
                    
                } else {
                
                    if (array_key_exists($url->identifier->identifier, $dataArray['sections'])) {

                        $dataArray['sections'] = self::calculateNewTotal($dataArray['sections'], $row, 'Views', $url, 0);
                        $dataArray['sections'] = self::calculateNewTotal($dataArray['sections'], $row, 'Uniques', $url, 2);
                        $dataArray['sections'] = self::calculateNewTotal($dataArray['sections'], $row, 'Dwell', $url, 1);
                        
                    } else {

                        $tmpArray = ['Views' => (int)$row['metrics'][0]['values'][0], 'Uniques' => (int)$row['metrics'][0]['values'][2], 'Dwell' => (float)$row['metrics'][0]['values'][1]];
                        $dataArray['sections'][$url->identifier->identifier] = $tmpArray;

                    }  
                }
            }
        }
        return $dataArray;
    }

}