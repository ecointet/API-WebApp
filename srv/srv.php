<?php
// Web App To demonstrate tons of APIS
// Built for demo purposes (by Postman)
// Author: @ecointet (twitter)

//SAVE NEW DATA
if (isset($_POST['company_name']))
{
    $result = CreateACompany($_POST, $data);
}

function CreateACompany($details, $data)
{
    $company_name = $details['company_name'];
    
    $company_logo = SetDefaultValues($details, "company_logo");
    $company_background = SetDefaultValues($details, "company_background");
    $company_api = SetDefaultValues($details,"company_api");
    $company_option = SetDefaultValues($details, "company_option");

    //Default Account : Postman
    $company_logo = "/images/postman/logo.png";
	$company_background = "/images/postman/intro.jpg";

    //Get Images from Google if not set
    if ($company_logo == "")
        $company_logo = GetImagefromGoogle(urlencode($company_name)."+logo", "trans", "small");
    if ($company_background == "")
        $company_background = GetImagefromGoogle(urlencode($company_name), "color", "xlarge");

    $company_name =  preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '', strtolower($company_name)));
    
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
    
    return $result;
   // header('Location: /'.$company_name);
   // if ($result) $result = $result[0];
   // else unset($result);
   // print_r($user);
  //  die();

}
//GET EXISTING DATA
if (isset($_GET['id']))
{
    $result = $data->findBy(["name", "=", strtolower($_GET['id'])], ["_id" => "desc"], 1);
    if ($result) $result = $result[0];
    else 
    {
        //CREATE A NEW COMPANY ASAP
        $details['company_name'] = $_GET['id'];
        $result = CreateACompany($details, $data);
    }
   // print_r($result[0]['logo']);
   // die();
}

function SetDefaultValues($data, $array)
{
    if (isset($data[$array])) return $data[$array];
    else if ($array == "company_logo") return "";
    else if ($array == "company_background") return "";
    else if ($array == "company_api") return "API-URL";
    else if ($array == "company_option") return "no_option";
    return "";
}
//Get Images from Google
function GetImagefromGoogle($keywords, $type, $size)
{
    $gkey = getenv("GKEY");
    $cx = "5289f90fb0fc740a7";
    $url = "https://www.googleapis.com/customsearch/v1?key=".$gkey."&cx=".$cx."&q=".$keywords."&searchType=image&safe=active&imgColorType=".$type."&imgSize=".$size."&alt=json";
    //$rights = "cc_sharealike";
   // $url = $url."&rights=".$rights;
    $retour = getdatafromapi($url);
  //  die($url);
  //if ($type == "color")
  //  die($retour);
    $json = json_decode($retour);
    if (!isset($json->items[0]->link) && $type == "trans")
        return "/images/postman/logo.png";
    if (!isset($json->items[0]->link) && $type == "color")
        return "/images/postman/intro.jpg";
    //Get First restult and return it.
    $ia_choice = mt_rand(0, 9);
    return $json->items[$ia_choice]->link;
}

function getdatafromapi($url)
{
 // CURL
 $curl = curl_init($url);
 curl_setopt($curl, CURLOPT_URL, $url);
 curl_setopt($curl, CURLOPT_HEADER, false);
 curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

 $response = curl_exec($curl);
 curl_close($curl);

 return $response;
}
?>