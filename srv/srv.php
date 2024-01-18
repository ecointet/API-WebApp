<?php
// Web App To demonstrate tons of APIS
// Built for demo purposes (by Postman)
// Author: @ecointet (twitter)

//SAVE NEW DATA
if (isset($_POST['company_name']))
{
    $_POST['company_name'] = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '', strtolower($_POST['company_name'])));
    $result = CreateACompany($_POST, $data, $sql);
    header('Location: /'.$_POST['company_name']);
}

function CreateACompany($details, $data, $sql)
{
    $company_name = $details['company_name'];
    
    $company_logo = SetDefaultValues($details, "company_logo");
    $company_background = SetDefaultValues($details, "company_background");
    $company_api = SetDefaultValues($details,"company_api");
    $company_option = SetDefaultValues($details, "company_option");

    //Default Account : Postman
    if (strtolower($company_name) == "postman")
    {
        $company_logo = "/images/postman/logo.png";
	    $company_background = "/images/postman/intro.jpg";
    }

    //Get Images from Google if not set
    if ($company_logo == "")
        $company_logo = GetImagefromGoogle(urlencode($company_name)."+logo", "trans", "small");
    if ($company_background == "")
        $company_background = GetImagefromGoogle(urlencode($company_name), "color", "xlarge");
    
    $company = [
        'name' =>  $company_name ,
        'logo' => $company_logo,
        'background' => $company_background,
        'api' => urlencode($company_api),
        'opt' => $company_option
    ];

    //SEARCH IF COMPANY EXISTS
    $exist_result = selectData($sql, "companies", $data, ["name", "=", "$company_name"], ["_id" => "desc"], 1);
   
    if ($exist_result)
        $result = updateDataById($sql, $data, "companies", $exist_result[0]["_id"], $company);
    else
        $result = insertData($sql, "companies", $data, $company);
    
    return $result;
   // if ($result) $result = $result[0];
   // else unset($result);
   // print_r($user);
  //  die();

}
//GET EXISTING DATA
if (isset($_GET['id']))
{
    $result = selectData($sql, "companies", $data, ["name", "=", strtolower($_GET['id'])], ["_id" => "desc"], 1);
    if (!$result)
    {
        //CREATE A NEW COMPANY ASAP
        $details['company_name'] = $_GET['id'];
        $result = CreateACompany($details, $data, $sql);
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

//CONTEST
function GetCurrentPlayers($sql, $data, $company_id)
{
    $result = selectAllData($sql, "contest", $data, ["company_id", "=", $company_id], ["_id" => "desc"]);
    return $result;
}

//CONTEST
function GetPlayer($sql, $data, $company_id, $name)
{
    $result = selectData($sql, "contest", $data, [["label", "=", $name], ["company_id", "=", $company_id]], ["_id" => "desc"], 1);
    if ($result)
        return $result[0];
    return 
        false;
}

//CONTEST
function InsertPlayer($sql, $data, $company_id, $info)
{
   // print_r($info);
    $result = selectData($sql, "contest", $data, [["label", "=", $info['label']], ["company_id", "=", $company_id]], ["_id" => "desc"], 1);
    
    if ($result)
        $result = updateDataById($sql, $data, "contest", $result[0]["_id"], $info);
    else
        insertData($sql, "contest", $data, $info);

    //return true;
    return $result;
}

//CONTEST
function ResetContest($sql, $data, $company_id)
{
    $result = deleteData($sql, $data, "contest", ["company_id", "=", $company_id]);
    return $result;
}

//CONTEST
function GetKey($sql, $data, $company_id, $name)
{
    $result = selectData($sql, "contest", $data, [["label", "=", $name], ["company_id", "=", $company_id]], ["_id" => "desc"], 1);
    if ($result)
        return $result[0];
    return 
        false;
}

?>