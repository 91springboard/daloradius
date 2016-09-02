<?php
header("Access-Control-Allow-Origin: *");

$logAction = "";

isset($_POST['username']) ? $username = $_POST['username'] : $username = "";
isset($_POST['nasaddr']) ? $nasaddr = $_POST['nasaddr'] : $nasaddr = "";
isset($_POST['nasport']) ? $nasport = $_POST['nasport'] : $nasport = "";
isset($_POST['nassecret']) ? $nassecret = $_POST['nassecret'] : $nassecret = "";
isset($_POST['customattributes']) ? $customAttributes = $_POST['customattributes'] : $customAttributes = "";
isset($_POST['commanddebug']) ? $commanddebug = $_POST['commanddebug'] : $commanddebug = "no";

include 'utils.php';

if (isset($_POST['submit'])) {

    if ( ($nasaddr == "") || ($nasport == "") || ($nassecret == "") ) {

        actionFailed("One of NAS Address, NAS Port or NAS Secret fields were left empty");
        $logAction .= "Failed performing disconnect on user [$username] because of missing NAS fields on page: ";

    } else if ($username == "") {

        actionFailed("The User-Name to disconnect was not provided");
        $logAction .= "Failed performing disconnect on user [$username] because of missing User-Name on page: ";

    } else {

        include_once('../library/exten-maint-radclient.php');

        $username = $_POST['username'];

        // process advanced options to pass to radclient
        isset($_POST['debug']) ? $debug = $_POST['debug'] : $debug = "no";
        isset($_POST['timeout']) ? $timeout = $_POST['timeout'] : $timeout = 3;
        isset($_POST['retries']) ? $retries = $_POST['retries'] : $retries = 1;
        isset($_POST['count']) ? $count = $_POST['count'] : $count = 1;
        isset($_POST['requests']) ? $requests = $_POST['requests'] : $requests = 1;

        // create the optional arguments variable

        // convert the debug = yes to the actual debug option which is "-x" to pass to radclient
        if ($debug == "yes")
            $debug = "-x";
        else
            $debug = "";

        $options = array("count" => $count, "requests" => $requests,
            "retries" => $retries, "timeout" => $timeout,
            "debug" => $debug,
        );

        // radclient command name
        $packettype = "disconnect";

        $commandMsg = user_disconnect($options,$username,$nasaddr,$nasport,$nassecret,$packettype,$customAttributes);

        // this message denoted disconnect command is successful.
        $successMsg = "Disconnect-ACK";

        if (strpos($commandMsg, $successMsg) !== false){
            $logAction .= "User disconnect action performed on user [$username] on page: ";
            actionSuccessful();
        }else{
            $logAction .= "User disconnect action performed on user [$username] on page: ";
            if ($commanddebug === "no"){
                $commandMsg = "Failed";
            }
            actionFailed($commandMsg);
        }

    }

}else {
    actionFailed("submit key is not found");
}


include_once('../library/config_read.php');
$log = "visited page: ";
include('../include/config/logging.php');

