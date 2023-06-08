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

function selectData($sql, $data, $condition, $sort, $limit)
{
    if ($sql)
        $result = SQLselect($data, $condition, $sort, $limit);
    else
    {
        $result = $data->findBy($condition, $sort, $limit);
        if (isset($result[0])) $result = $result[0];
    }

   // print_r($result);
    return $result;
}

function updateDataById($sql, $data, $cond, $details)
{
    if ($sql)
        $result = SQLupdatebyId($data, $cond, $details);
    else
        $result = $data->updateById($cond, $details);

    return $result;
}

function insertData($sql, $data, $details)
{
    if ($sql)
        $result = SQLinsert($data, $details);
    else
        $result = $data->insert($details);

    return $result;
}
?>