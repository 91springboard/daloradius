<?php
function actionSuccessful (){
    echo "Success";
    http_response_code(200);
}

function actionFailed ($error_text){
    echo "Error : ".$error_text;
    http_response_code(400);
}
