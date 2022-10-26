<?php

require(dirname(__DIR__)."/models/videoconversion.php");

class VideoconversionsController{

    private $videoconversion; //model
    
    function __construct()
    {
        $this->videoconversion = new VideoConversion();
    }

    function list($apikey, $resourceID){

        return $this->videoconversion->list($apikey, $resourceID);

    }

}

?>