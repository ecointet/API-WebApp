<?php
// Web App To demonstrate tons of APIS
// Built for demo purposes (by Postman)
// Author: @ecointet (twitter)
require "data.php"; //data management

$sql = false;
  
if (getenv("DB_TYPE") && getenv("DB_TYPE") == "SQL")
  $sql = true;

$data = connect($sql);

if (isset($_GET['url']))
{
    $url = $_GET['url'];
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
    $result = selectData($sql, $data, ["name", "like", strtolower($id)], ["_id" => "desc"], 1);
   // $data->deleteBy(["name", "=", strtolower($id)]);
   // if ($result) $result =  $result[0];
    die(json_encode($result));
}

?>
<?php
if ($sql) $mysqli -> close();
?>