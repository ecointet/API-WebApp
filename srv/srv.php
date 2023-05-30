<?php
// Web App To demonstrate tons of APIS
// Built for demo purposes (by Postman)
// Author: @ecointet (twitter)

//SAVE NEW DATA
if (isset($_POST['company_name']))
{
    $company_name = strtolower($_POST['company_name']);
    $company_logo = $_POST['company_logo'];
    $company_background = $_POST['company_background'];
    $company_api = $_POST['company_api'];
   // echo "write data:".$company_name;
    
    $company = [
        'name' =>  $company_name ,
        'logo' => $company_logo,
        'background' => $company_background,
        'api' => urlencode($company_api)
    ];

    $result = $data->insert($company);
    
   // if ($result) $result = $result[0];
   // else unset($result);
   // print_r($user);
  //  die();
}

//GET EXISTING DATA
if (isset($_GET['id']))
{
    $result = $data->findBy(["name", "=", strtolower($_GET['id'])], ["_id" => "desc"], 1);
    if ($result) $result =  $result[0];
    else unset($result);
   // print_r($result[0]['logo']);
   // die();
}
?>