<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$logAction = "";

//setting values for the order by and order type variables
isset($_REQUEST['orderBy']) ? $orderBy = $_REQUEST['orderBy'] : $orderBy = "acctstarttime";
isset($_REQUEST['orderType']) ? $orderType = $_REQUEST['orderType'] : $orderType = "desc";
isset($_REQUEST['orderType']) ? $orderType = $_REQUEST['orderType'] : $orderType = "desc";
isset($_REQUEST['usernameOnline']) ? $usernameOnline = $_GET['usernameOnline'] : $usernameOnline = "";


include_once('../library/config_read.php');
$log = "visited page: ";
$logQuery = "performed query for listing of records on page: ";


include '../library/opendb.php';
include '../include/management/pages_common.php';

/* we are searching for both kind of attributes for the password, being User-Password, the more
   common one and the other which is Password, this is also done for considerations of backwards
   compatibility with version 0.7        */


$sql = "SELECT ".$configValues['CONFIG_DB_TBL_RADACCT'].".Username, ".$configValues['CONFIG_DB_TBL_RADACCT'].".FramedIPAddress,
".$configValues['CONFIG_DB_TBL_RADACCT'].".CallingStationId, ".$configValues['CONFIG_DB_TBL_RADACCT'].".AcctStartTime,
".$configValues['CONFIG_DB_TBL_RADACCT'].".AcctSessionTime, ".$configValues['CONFIG_DB_TBL_RADACCT'].".NASIPAddress, 
".$configValues['CONFIG_DB_TBL_RADACCT'].".CalledStationId, ".$configValues['CONFIG_DB_TBL_RADACCT'].".AcctSessionId, 
".$configValues['CONFIG_DB_TBL_RADACCT'].".AcctInputOctets AS Upload,
".$configValues['CONFIG_DB_TBL_RADACCT'].".AcctOutputOctets AS Download".
    " FROM ".$configValues['CONFIG_DB_TBL_RADACCT'].
    " WHERE (".$configValues['CONFIG_DB_TBL_RADACCT'].".AcctStopTime IS NULL OR ".
    $configValues['CONFIG_DB_TBL_RADACCT'].".AcctStopTime = '0000-00-00 00:00:00') AND (".$configValues['CONFIG_DB_TBL_RADACCT'].".Username = '".$dbSocket->escapeSimple($usernameOnline)."')".
    " ORDER BY $orderBy $orderType ";

$res = $dbSocket->query($sql);

$response = array();

if ($res->numRows() > 0){

    while($row = $res->fetchRow(DB_FETCHMODE_ASSOC)) {

        $username = $row['Username'];
        $ip = $row['FramedIPAddress'];
        $usermac = $row['CallingStationId'];
        $start = $row['AcctStartTime'];
        $nasip = $row['NASIPAddress'];
        $nasmac = $row['CalledStationId'];
        $acctsessionid = $row['AcctSessionId'];

        $upload = toxbyte($row['Upload']);
        $download = toxbyte($row['Download']);
        $traffic = toxbyte($row['Upload']+$row['Download']);

        $totalTime = time2str($row['AcctSessionTime']);

        array_push($response, array(
            "NASIPAddress" => $nasip,
            "FramedIPAddress" => $ip,
            "CallingStationId" => $usermac,
            "AcctStartTime"=>$start,
            "AcctSessionTime"=>$totalTime
            )
        );
    }
}

echo json_encode($response);

include '../library/closedb.php';
include('../include/config/logging.php');

