<?php
header("Access-Control-Allow-Origin: *");
isset($_POST['username']) ? $username = $_POST['username'] : $username = "";
isset($_POST['currentPassword']) ? $currentPassword = $_POST['currentPassword'] : $currentPassword = "";
isset($_POST['newPassword']) ? $newPassword = $_POST['newPassword'] : $newPassword = "";
isset($_POST['confirmPassword']) ? $confirmPassword = $_POST['confirmPassword'] : $confirmPassword = "";

function actionSuccessful (){
    echo "Success";
    http_response_code(200);
}

function actionFailed ($error_text){
    echo "Error : ".$error_text;
    http_response_code(400);
}

$logAction = "";
$logDebugSQL = "";

if (isset($_POST['submit'])) {

    if ($newPassword == $confirmPassword) {

        if (trim($currentPassword) != "") {

            include 'library/opendb.php';

            global $configValues;

            if ( !empty($configValues['CONFIG_DB_PASSWORD_ENCRYPTION']) && $configValues['CONFIG_DB_PASSWORD_ENCRYPTION'] === 'crypt') {

                $sqlTestPassword = "SELECT ENCRYPT('".$dbSocket->escapeSimple($currentPassword)."', 'SALT_DALORADIUS') as Password";
                $res = $dbSocket->query($sqlTestPassword);
                $row = $res->fetchRow();

                $passwordCryptEval = $row[0];

                $logDebugSQL .= $sqlTestPassword . "\n";

            }

            if ( !empty($configValues['CONFIG_DB_PASSWORD_ENCRYPTION']) && $configValues['CONFIG_DB_PASSWORD_ENCRYPTION'] === 'md5') {
                $currentPassword = md5($currentPassword);
                $newPassword = md5($newPassword);
            }

            $sql = "SELECT value, id FROM ".$configValues['CONFIG_DB_TBL_RADCHECK'].
                " WHERE username='".$username."' AND".
                " attribute LIKE '%-Password'";
            $res = $dbSocket->query($sql);
            $row = $res->fetchRow();

            $passwordRowId = $row[1];

            $logDebugSQL .= $sql . "\n";

            if ( ($res->numRows() == 1) && ($row[0] == $currentPassword) ) {

                $sql = "UPDATE ".$configValues['CONFIG_DB_TBL_RADCHECK'].
                    " SET value='".$dbSocket->escapeSimple($newPassword)."'".
                    " WHERE id='$passwordRowId'";

                $res = $dbSocket->query($sql);
                $logDebugSQL .= $sql . "\n";

                $logAction .= "Successfully updated authentication password for user [$username] by external login page";
                actionSuccessful();

            } elseif ( ($res->numRows() == 1) && ($passwordCryptEval == $row[0]) ) {

                $sql = "UPDATE ".$configValues['CONFIG_DB_TBL_RADCHECK'].
                    " SET value=ENCRYPT('".$dbSocket->escapeSimple($newPassword)."', 'SALT_DALORADIUS')".
                    " WHERE id='$passwordRowId'";
                $res = $dbSocket->query($sql);
                $logDebugSQL .= $sql . "\n";

                $logAction .= "Successfully updated authentication password for user [$username] by external login page";
                actionSuccessful();

            } else {
                actionFailed("possibly wrong password");
                $logAction .= "Failed updating authentication password, possibly wrong password entered for user [$username] by external login page";

            }

            include 'library/closedb.php';

        } else {
            actionFailed("current password is empty");
            $logAction .= "Failed changing user authentication password, empty current password for user [$username] by external login page";
        } // if (trim($currentPassword) != "")

    } else {
        actionFailed("new and confirm password does not match");
        $logAction .= "Failed changing user password, passwords do not match for user [$username] by external login page";
    } // if ($newPassword == $verifyPassword)

} else {
    actionFailed("submit key is not found");
}


include_once('library/config_read.php');
$log = "visited page: ";
include('include/config/logging.php');

?>