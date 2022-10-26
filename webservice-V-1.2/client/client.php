<?php

    $ch = curl_init();

    $url = "http://localhost/webservice/api/index.php?resource=videoconversion&apikey=apikey123";

    curl_setopt($ch, CURLOPT_URL,$url);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Accept: application/json'
    ));   

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $data = curl_exec($ch);

    echo $data;

    curl_close($ch);	
?>