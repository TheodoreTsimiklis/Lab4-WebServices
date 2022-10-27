<?php
    $ch = curl_init();
    $url = "http://localhost/webservice/api/index.php?resource=appointment&api_Key=apikey123"; // set url
#
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

    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: application/json", 'Accept: application/json', 'Expect:', 'Content-Length: ' . strlen($data)));

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    // Execute
    $response = curl_exec($ch);
    echo $response;
    // Closing
    curl_close($ch);    
?>