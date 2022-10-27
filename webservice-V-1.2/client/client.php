<?php

    $ch = curl_init();
    
    $url = "http://localhost/webservice/api/appointments/"; // set url

    $data = json_encode(array(
        "api_Key" => "apikey123",
        "user_ID" => 1,
        "donor_Name" => "Bob Robert",
        "date_Time" => date("Y-m-d H:i:s"),
    )); 
    
    // Set the url
    curl_setopt($ch, CURLOPT_URL,$url); 

    curl_setopt($ch, CURLOPT_POST, 1);
    
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json'
    ));    

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    // Execute
    $response = curl_exec($ch);
    
    // Closing
    curl_close($ch);    


?>