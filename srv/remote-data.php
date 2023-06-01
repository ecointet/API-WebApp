<?php
// Web App To demonstrate tons of APIS
// Built for demo purposes (by Postman)
// Author: @ecointet (twitter)
require "database/Store.php"; //database
$databaseDirectory = "../data";
$configuration = [
	"timeout" => false
  ];
$data = new \SleekDB\Store("data_info", $databaseDirectory, $configuration);

if (isset($_GET['url']))
{
    $url = location_photo($_GET['url']);
   // print_r("[data:".$url."]");
    
   // CURL
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($curl);
    curl_close($curl);
    $result = $response;
    /// END

    if (!$result)
        die("0");
    
    die($result);
}

if (isset($_GET['id']))
{
    $id = $_GET['id'];

    //Search in Database
    $result = $data->findBy(["name", "like", strtolower($id)], ["_id" => "desc"]);
   // $data->deleteBy(["name", "=", strtolower($id)]);
    if ($result) $result =  $result[0];

    die(json_encode($result));
    die("0");
}

function location_photo($url)
{
   // $ip = $_SERVER['REMOTE_ADDR'];
   // $ip = "46.8.175.173";

   // $url = $url.urlencode($ip);
    return $url;
}
?>