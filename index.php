<?php 
   
//ini_set('display_errors', 1); 
//error_reporting(E_ALL);
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Content-type:text/javascript');

   $zillowID = 'X1-ZWz1dy1htzjtvv_9od0r';
   $street   = $_GET['streetInput'];
   $city     = $_GET['cityInput'];
   $state    = $_GET['stateInput'];
   $citystate =  $city .","." ". $state;
   $address  = urlencode($street);
   $citystatezip = urlencode($citystate);
   $rentzestimate = true; 
   
   $url = "http://www.zillow.com/webservice/GetDeepSearchResults.htm?zws-id=$zillowID&address=$address&citystatezip=$citystatezip&rentzestimate=$rentzestimate";
//   $url="http://www.zillow.com/webservice/GetDeepSearchResults.htm?zws-id=$zillowID&address=2114+Bigelow+Ave&citystatezip=Seattle%2C+WA";  


 $XMLResponse = file_get_contents($url);
//echo $XMLData;
$resultData = simplexml_load_string($XMLResponse);
//print_r($resultData);
$jsondata = json_encode($resultData);

$zpid = $resultData->response->results->result->zpid;
$unit_type = 'percent';
$height = 300;
$width = 600;

$charturl1 = "http://www.zillow.com/webservice/GetChart.htm?zws-id=$zillowID&unit-type=$unit_type&zpid=$zpid&width=$width&height=$height&chartDuration=1year";


$charturl2 = "http://www.zillow.com/webservice/GetChart.htm?zws-id=$zillowID&unit-type=$unit_type&zpid=$zpid&width=$width&height=$height&chartDuration=5year";

$charturl3 = "http://www.zillow.com/webservice/GetChart.htm?zws-id=$zillowID&unit-type=$unit_type&zpid=$zpid&width=$width&height=$height&chartDuration=10year";


$chart1xml = file_get_contents($charturl1);
$chart2xml = file_get_contents($charturl2);
$chart3xml = file_get_contents($charturl3);




$chart_1 = simplexml_load_string($chart1xml);
$chart_2 = simplexml_load_string($chart2xml);
$chart_3 = simplexml_load_string($chart3xml);


$final_data = array();

$final_data["info"] = json_encode($resultData);
$final_data["c1"] = json_encode($chart_1);
$final_data["c2"] = json_encode($chart_2);
$final_data["c3"] = json_encode($chart_3);

echo(json_encode($final_data));
?>