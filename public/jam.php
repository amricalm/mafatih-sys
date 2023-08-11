<?php

if (isset($_POST['time'])) {
    $current_date = array();
    $info = getdate();
    $hour = $info['hours'];
    $min = $info['minutes'];
    $sec = $info['seconds'];

    array_push($current_date, "$hour:$min:$sec");
    echo json_encode("$hour:$min:$sec");
}
