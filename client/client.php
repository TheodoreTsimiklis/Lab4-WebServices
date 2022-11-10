<?php
    echo '
    <h1> Blood Donation Appointment Booking</h1>
    <div>
    <form action="" method="post">
        <label for="name">Donor Name:</label> 
        <input type="text" name="name">
        </br>
        <label for="appointmenttime">Appointment (date and time):</label>
        <input type="datetime-local" id="appointmenttime" name="appointmenttime">
        </br>
        <input type="submit" value="SUBMIT" name="submitButton" style="background-color:green;margin-left:20%;margin-right:auto;display:block;margin-bottom:0%; margin-top:5%">
    </form>
    </div>';
    $ch = curl_init();
    $url = "http://localhost/webservice/api/appointments/"; // set url
    if (isset($_POST['submitButton'])) {
        $data = json_encode(array(
            "api_Key" => "apikey123",
            "user_ID" => 1,
            "donor_Name" => $_POST['name'],
            "date_Time" => $_POST['appointmenttime'], //using this date and time for now since there is no form created yet
        )); 

        curl_setopt($ch, CURLOPT_URL,$url); 

        curl_setopt($ch, CURLOPT_POST, 1);
        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: application/json", 'Accept: application/json', 'Expect:', 'Content-Length: ' . strlen($data)));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        // Execute
        $response = curl_exec($ch);
        if( $response != null || $response != FALSE || $response != '' ) {
            echo $response;
        // Closing the connection
        curl_close($ch);
        }
    }
    else {
        echo "Please enter your name and appointment date and time.";
    }
   
?>