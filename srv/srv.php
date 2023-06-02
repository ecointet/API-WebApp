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
    $company_option = $_POST['company_option'];
   // echo "write data:".$company_name;
    
    $company = [
        'name' =>  $company_name ,
        'logo' => $company_logo,
        'background' => $company_background,
        'api' => urlencode($company_api),
        'option' => $company_option
    ];

    $exist_result = $data->findBy(["name", "=", $company_name], ["_id" => "desc"], 1);
   
    if ($exist_result)
        $result = $data->updateById($exist_result[0]["_id"], $company);
    else
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