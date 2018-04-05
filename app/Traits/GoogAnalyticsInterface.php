<?php

namespace App\Traits;

use Google\ApiClient\Client;

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
        return $GAConn->reports->batchGet( $body );
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

}