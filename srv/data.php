<?php
require "database/Store.php"; //database file
require "sql.php"; //database sql

function connect($sql)
{
$databaseDirectory = __DIR__ . "/../data";
$configuration = [
	"timeout" => false
  ];

    if ($sql)
        $data = SQLconnect();
    else
        $data = new \SleekDB\Store("data_info", $databaseDirectory, $configuration);

    return $data;
}

function connect_contest($sql)
{
$databaseDirectory = __DIR__ . "/../data";
$configuration = [
	"timeout" => false
  ];

    if ($sql)
        $data = SQLconnect();
    else
        $data = new \SleekDB\Store("data_contest", $databaseDirectory, $configuration);

    return $data;
}

function selectData($sql, $table, $data, $condition, $sort, $limit = null)
{
    if ($sql)
        $result = SQLselect($table, $data, $condition, $sort, $limit);
    else
    {
        $result = $data->findBy($condition, $sort, $limit);
       // if (isset($result[0])) $result = $result[0];
    }

   // print_r($result);
    return $result;
}

function selectAllData($sql, $table, $data, $condition, $sort)
{
    if ($sql)
        $result = SQLselect($table, $data, $condition, $sort);
    else
        $result = $data->findBy($condition, $sort);

    //print_r($result);
    return $result;
}

function updateDataById($sql, $data, $table, $cond, $details)
{
    if ($sql)
        $result = SQLupdatebyId($data, $table, $cond, $details);
    else
        $result = $data->updateById($cond, $details);

    return $result;
}

function deleteData($sql, $data, $table, $cond)
{
    if ($sql)
        $result = SQLdelete($table, $data, $cond);
    else
        $result = $data->deleteBy($cond);
       
    return $result;
}

function insertData($sql, $table, $data, $details)
{
    if ($sql)
        $result = SQLinsert($data, $table, $details);
    else
        $result = $data->insert($details);

    return $result;
}
?>