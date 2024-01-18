<?PHP
//API MODE

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    //DASHBOARD
    if (isset($_GET['dashboard']))
        $retour = ContestDashboard($data_contest, $sql, $company_id);
}

if ($method == 'POST') {
     
}

if ($method == 'PUT')
 {
  
    parse_str(file_get_contents('php://input'), $_PUT);
    header('Content-Type: application/json; charset=utf-8');

    $name = getName($_PUT);
    $player = GetPlayer($sql, $data_contest, $company_id, $name);
    $score = 2;

    //CHALLENGE 0
    if (!$player)
    {
        $name = getName($_PUT);
        InsertPlayer($sql, $data_contest, $company_id, ["company_id" => $company_id, "label" => $name, "score" => 2]);
    }

    //CHALLENGE 1
    if (!isset($player["country"]) || isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
    {
        $country = getCountry($name);
        InsertPlayer($sql, $data_contest, $company_id, ["company_id" => $company_id, "label" => $name, "score" => 5, "country" => $country]);
    }

     //CHALLENGE 2
     if (!isset($player["avatar"]) || isset($_PUT['avatar']))
     {
         $avatar = getYourAvatar($name, $_PUT);
         InsertPlayer($sql, $data_contest, $company_id, ["company_id" => $company_id, "label" => $name, "score" => 7, "avatar" => $avatar]);
     }

     //FINAL CHALLENGE
     if (!isset($player["key"]) || isset($_PUT['key']))
     {
         $key = winTheContest($name, $_PUT, $player);
         if ($key != true)
            InsertPlayer($sql, $data_contest, $company_id, ["company_id" => $company_id, "label" => $name, "score" => 9, "key_value" => $key, "key_time" => time()]);
        else
            InsertPlayer($sql, $data_contest, $company_id, ["company_id" => $company_id, "label" => $name, "score" => 99, "key_time" => time()]);
    }

    die(0);
}

if ($method == 'DELETE') {
   // echo "THIS IS A DELETE REQUEST";
}

?>

<?php

function getName($_PUT)
{
    if (!isset($_PUT['name']))
    {
        $n_json['intro'] = "Hello! Very first question. Who are you❓ ^^";
        $n_json['intro2'] = "📖 Follow the instructions to set your name";
        $n_json['tab'] = "Body";
        $n_json['type'] = "x-www-form-urlencoded";
        $n_json['key'] = "name";
        $n_json['value'] = "<YOUR-NAME>";   
        die(json_encode($n_json)); 
    }
    else
    {
        $n_json['intro2'] = "Welcome ".$_PUT['name']; 
        echo json_encode($n_json);
        return $_PUT['name'];
    }

    return false;
}

function getCountry($name)
{   
   // print_r($_SERVER);

    if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
    {
        $n_json['intro'] = "Congrats!)";
        $n_json['intro2'] = "🌍 Your Country is ".$_SERVER['HTTP_ACCEPT_LANGUAGE'];
        echo json_encode($n_json);
        return $_SERVER['HTTP_ACCEPT_LANGUAGE'];
    }
    else
    {
        $n_json['intro'] = "Ready for the 2nd Challenge ".$name." ?";
        $n_json['intro2'] = "Where are your from? Be proud and specify your Country Code (ex: GB)";
        $n_json['intro3'] = "Here are few instructions:";
        $n_json['tab'] = "Headers";
        $n_json['key'] = "Accept-Language";
        $n_json['value'] = "<SHORT-COUNTRY-CODE>";
        die(json_encode($n_json)); 
    }

    return false;
}

function getYourAvatar($name, $_PUT)
{   
    if (isset($_PUT['avatar']))
    {
        $n_json['intro'] = "Nice job! You set your avatar !";
        $n_json['avatar'] = $_PUT['avatar'];
        echo json_encode($n_json);
        return $_PUT['avatar'];
    }
    else
    {
        $n_json['intro'] = "Be creative and show your avatar, ".$name."!";
        $n_json['intro2'] = "Get your favorite image on Google, and paste the url.";
        $n_json['intro3'] = "Here are few instructions:";
        $n_json['tab'] = "Body";
        $n_json['type'] = "x-www-form-urlencoded";
        $n_json['key'] = "avatar";
        $n_json['value'] = "<FULL-URL>"; 
        die(json_encode($n_json)); 
    }

    return false;
}


function winTheContest($name, $_PUT, $player)
{   
    if (isset($_PUT['key']) && $_PUT['key'] == "get")
    {
        $n_json['intro'] = "Congrats!)";
        $n_json['details'] = "Your temporary key is available.";
        $n_json['your_key'] = getRandomStringRand();
        $n_json['hit1'] = "Now, transmit the key to complete the contest!!!!";
        $n_json['intro3'] = "Here are few instructions:";
        $n_json['tab'] = "Body";
        $n_json['type'] = "x-www-form-urlencoded";
        $n_json['key'] = "key";
        $n_json['value'] = "<YOUR-KEY> (ex: ".$n_json['your_key'].")";
        echo json_encode($n_json);
        return $n_json['your_key'];
    }
    else if (isset($_PUT['key']) && $_PUT['key'] != "get")
    {
        if (isset($player['key_value']))
            $saved_key = $player['key_value'];
        else
            $saved_key = "XX";

        $current_key = $_PUT['key'];

        $saved_time = $player['key_time'] + 2;
        $current_time = time();

        if ($saved_key != $current_key)
        {
            $n_json['intro'] = "OUPS! The key sent is different than the key expected";
            $n_json['intro2'] = "Please, get your key first (key=get), then use it (key=<YOUR-KEY>).";
            die(json_encode($n_json));
        }

        if ($saved_key == $current_key && $saved_time < $current_time)
        {
            $n_json['intro'] = "Yes.... and no! You got the right key but it expired.";
            $n_json['intro2'] = "Please, do the same operation in less than 200ms. Use Postman Run Collection & scripts to avoid manual steps.";
            die(json_encode($n_json));
        }

        $n_json['intro'] = "CONGRATS !!!!!! YOU SUCCESSFULLY COMPLETED THE CONTEST.";
        $n_json['details'] = "Check the liveboard to see your rank.";
        echo json_encode($n_json);
        return true;
    }
    else
    {
        $n_json['intro'] = "LAST ROUND! Are you ready ".$name."?!";
        $n_json['intro2'] = "You have to PUT a secure key request, then transmit it.";
        $n_json['intro3'] = "Here are few instructions:";
        $n_json['tab'] = "Body";
        $n_json['type'] = "x-www-form-urlencoded";
        $n_json['key'] = "key";
        $n_json['value'] = "get";

        die(json_encode($n_json)); 
    }

    return false;
}


function getRandomStringRand($length = 16)
{
    $stringSpace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $stringLength = strlen($stringSpace);
    $randomString = '';
    for ($i = 0; $i < $length; $i ++) {
        $randomString = $randomString . $stringSpace[rand(0, $stringLength - 1)];
    }
    return $randomString;
}

//ADMIN FUNCTIONS
function CreateList($data, $i)
{
    $country = isset($data["country"]) ? $data["country"] : null;
    $label = isset($data["label"]) ? $data["label"] : null;
    $score = isset($data["score"]) ? $data["score"] : null;
    $avatar = isset($data["avatar"]) ? $data["avatar"] : null;

    echo $label."|".$score."|".$country."|".$avatar;
    if ($score == 99) {echo "|".$i; $i++;} else echo "|0";
    echo ";";

    return $i;
}

function ContestDashboard($data, $sql, $company_id)
{
    $result = selectAllData($sql, "contest", $data, ["company_id", "=", $company_id], ["key_time" => "ASC"]);
    //return $result[0];
  //  print_r($result);
   // echo "count:";
   // print_r(count($result));
    if ($result)
    {
        /*
        if (count($result) > 1)
            {
                {*/$i = 1;
                    foreach ($result as $data) {
                        //foreach ($data as $content) {
                            //echo "$content:";
                        //}
                    //    echo "<br>line result:<br>";
                     //  print_r($data);
                     $i = CreateList($data, $i);
                    }
               /* }
            }
    else
    {
        print_r($result);
        CreateList($result);
    }*/
    }
    // print_r($result);
    die(0);
}
?>