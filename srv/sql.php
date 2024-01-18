<?php

function SQLconnect()
{
    $dbhost = getenv("SQL_HOST");
    $dbname = getenv("SQL_DB");
    $dbuser = getenv("SQL_DB");
    $dbpass = getenv("SQL_PWD");
    if (str_contains($dbhost, "cloudsql"))
        $mysqli = new mysqli(null, $dbname, $dbpass, $dbname, null, $dbhost);
    else
        $mysqli = new mysqli($dbhost,$dbname, $dbpass, $dbname);

    // Connect the DB
    if ($mysqli -> connect_errno)
    die("Failed to connect to MySQL (".$dbhost." /  ".$dbname." /  /: " . $mysqli -> connect_error);

    // Create the Schema (WebApp General Config)
    $create_table = "CREATE TABLE if not exists `companies` (_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, name VARCHAR(30) NOT NULL, logo VARCHAR(255) NULL, background VARCHAR(255) NULL, api VARCHAR(255) NULL, opt VARCHAR(30) NULL)";
    $mysqli->query($create_table);

    // Create the Schema (Contest)
    $create_table = "CREATE TABLE if not exists `contest` (_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, company_id INT(6) NOT NULL, label VARCHAR(30) NULL, score INT(2) NULL, img VARCHAR(255) NULL, avatar VARCHAR(255) NULL, notes VARCHAR(255) NULL, country VARCHAR(3) NULL, key_value VARCHAR(20) NULL, key_time BIGINT NULL DEFAULT NULL);";
    $mysqli->query($create_table);

    if ($mysqli->error) die($mysqli->error);
    
    return $mysqli;
}

function SQLselect($table, $data, $condition, $sort, $limit = null)
{
    $values = "";
    foreach($sort as $x => $val) {
        $values = $x." ".$val;
      }

      if (is_array($condition[0]) && is_array($condition[1]))
        {
            $condition[0][2] = "'".$condition[0][2]."'";
            $condition[1][2] = "'".$condition[1][2]."'";

            $cond = implode($condition[0]);
            $cond = $cond." AND ".implode($condition[1]);
        }
        else
        {
            $condition[2] = "'".$condition[2]."'";
            if ($condition[1] == "LIKE") $condition[1] = " LIKE ";

            $cond = implode($condition);
        }


    $query = "SELECT * FROM ".$table." WHERE ".$cond." ORDER BY ".$values;
    if ($limit) $query = $query." LIMIT ".$limit;

   // print_r($query);
    $result = $data->query($query);
    if ($data->error) die($data->error);
   // print_r($result);
    if ($result->num_rows == 0)
        return false;
    
        /*
    if ($result->num_rows == 1)
        $row = $result -> fetch_array(MYSQLI_ASSOC);
*/
    //if ($result->num_rows > 1)
        $row = $result -> fetch_all(MYSQLI_ASSOC);  
      //  print_r($row);
    return $row;
}

function SQLdelete($table, $data, $condition)
{
      if (is_array($condition[0]) && is_array($condition[1]))
        {
            $condition[0][2] = "'".$condition[0][2]."'";
            $condition[1][2] = "'".$condition[1][2]."'";

            $cond = implode($condition[0]);
            $cond = $cond." AND ".implode($condition[1]);
        }
        else
        {
            $condition[2] = "'".$condition[2]."'";
            if ($condition[1] == "LIKE") $condition[1] = " LIKE ";

            $cond = implode($condition);
        }


    $query = "DELETE FROM ".$table." WHERE ".$cond;

    $result = $data->query($query);
    if ($data->error) die($data->error);

    return true;
}

function SQLupdatebyId($data, $table, $cond, $details)
{
    $values = "";
    foreach($details as $x => $val) {
        $values =  $values."$x='$val',";
      }
    $values = rtrim($values,",");

    $query = "UPDATE `".$table."` SET ".$values." WHERE _id='".$cond."'";
    $data->query($query);
   // print_r($data);
    if ($data->error) die($data->error);

    $result = SQLselect($table, $data, array("_id","=",$cond), ["_id" => "desc"], 1);
    return $result;
}

function SQLinsert($data, $table, $details)
{
    $fields = "";
    $values = "";
    foreach($details as $x => $val) {
        $fields =  $fields.$x.",";
        $values =  $values."'$val',";
      }

    $values = rtrim($values, ",");
    $fields = rtrim($fields, ",");

    $sql = "INSERT INTO `".$table."` (".$fields.") VALUES (".$values.")";
    $data->query($sql);
    //print_r($sql);
    //print_r($data);
    if ($data->error) die($data->error);
    $new_id = $data->insert_id;

    $cond = array("_id","=",$new_id);
    $result = SQLselect($table, $data, $cond, ["_id" => "desc"], 1);
   
    return $result;
}




function SQLdebug_sql()
{
//SQL TESTS
$dbhost = getenv("SQL_HOST");
$dbname = getenv("SQL_DB");
$dbuser = getenv("SQL_DB");
$dbpass = getenv("SQL_PWD");

$mysqli = new mysqli($dbhost,$dbname, $dbpass, $dbname);

// Connect the DB
if ($mysqli -> connect_errno)
 die("Failed to connect to MySQL (".$dbhost." /  ".$dbname." / ".$dbpass." /: " . $mysqli -> connect_error);

 // Create the Schema
$create_table = "CREATE TABLE if not exists `companies` (_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, name VARCHAR(30) NOT NULL, logo VARCHAR(255) NULL, background VARCHAR(255) NULL, api VARCHAR(255) NULL, opt VARCHAR(30) NULL)";
$mysqli->query($create_table);
if ($mysqli->error) die($mysqli->error);

$name = "LVMH";
$logo = "logo.jpg";
$background = "background.jpg";
$opt = "no_opt";
$api = "n/a";

// INSERT DATA
$sql = "INSERT INTO `companies` (name, logo, background, api, opt) VALUES ('".$name."', '".$logo."', '".$background."', '".$api."', '".$opt."')";
$mysqli->query($sql);
if ($mysqli->error) die($mysqli->error);
$new_id = $mysqli->insert_id;
echo "New ID: ".$new_id;

// READ DATA
$sql = "SELECT * FROM companies WHERE name='".$name."' ORDER BY id DESC LIMIT 1";
$result = $mysqli->query($sql);
while($row = $result->fetch_assoc()) {
    $data[] = $row;
}
print_r($data);
echo "Company Found: ".$data[0]['name'];

$logo = "new_logo.jpg";
// UPDATE DATA
$sql = "UPDATE `companies` SET logo='".$logo."', background='".$background."', api='".$api."', opt='".$opt."' WHERE id=".$new_id."";
$mysqli->query($sql);
if ($mysqli->error) die($mysqli->error);

$mysqli -> close();
}
?>