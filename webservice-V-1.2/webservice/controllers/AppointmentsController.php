<?php

require(dirname(__DIR__)."/models/appointmentModel.php");

class AppointmentsController {

    private $appointmentModel; //model
    
    function __construct()
    {
        $this->appointmentModel = new Appointment();
    }

    function createAppointment($data){
        $apikey = $data['apikey'];
        $date_Time = $data['date_Time'];
        $donor_Name = $data['donor_Name'];
        $user_ID = $data['user_ID'];

        // Insert to database
        $data =[
            'client_ID' => $this->appointmentModel->getClientID($apikey),
            'date_Time' => $date_Time,
            'donor_Name'=> $donor_Name,
            'user_ID' => $user_ID,
        ];
        
        return $data; // returns to index.php method processPostResponse
    }

}

?>