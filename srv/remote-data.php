<?php
// Web App To demonstrate tons of APIS
// Built for demo purposes (by Postman)
// Author: @ecointet (twitter)

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

function location_photo($url)
{
   // $ip = $_SERVER['REMOTE_ADDR'];
   // $ip = "46.8.175.173";

   // $url = $url.urlencode($ip);
    return $url;
}
?>