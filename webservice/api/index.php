<?php

    require(dirname(__DIR__)."/core/http/requestbuilder.php");
    require(dirname(__DIR__)."/core/http/responsebuilder.php");

    //request.php is already required by requestbuilder.php thus here we put "require_once" instead of "require"
    require_once(dirname(__DIR__)."/core/http/request.php");

    require_once(dirname(__DIR__)."/core/http/response.php");

    // Not a final code, we will have to revise this to generalize it.
    //require(dirname(__DIR__)."/controllers/videoconversioncontroller.php");

    // spl_autoload_register is called when class_exists is called
    spl_autoload_register('auto_loader');

    function auto_loader($class){

        if(file_exists(dirname(__DIR__)."/controllers/".$class.".php"))
            require(dirname(__DIR__)."/controllers/".$class.".php");

    }

    // The job of this class:
    // To process the HTTP Request URL 
    // and select the appropriate controller
    // instantiate the controller and then call its specific function
    //Then once the controller gets the data from the model
    // this class would build and return an HTTP Response
    class API{

        // Instead of building the request here, we encapsulate the request code in separate classes
        private $request;

        public $response;

        private $controller;

        function __construct()
        {}

        function processRequest(){

            $requestBuilder = new RequestBuilder();

            $this->request = $requestBuilder->getRequest();

            // To be revised
            // $this->controller = new VideoConversion();

            // Generalize the way we get the name of the controller from the URL
            // so it is not only the VideoConversionController controller.

            // For the URL /api/videoconversion/123
            // $this->request->urlparams["resource"] will give us: videoconversion

            // But we need to capetalize the first letter
            $controllername = ucfirst($this->request->urlparams["resource"])."Controller";

            // Check if the controller's class exists
            if(class_exists($controllername)){ // class_exists will call the spl_autoload_register

                $this->controller = new $controllername();

            }else{

                // either throw an error

                // or 

                // implement a default controller


            }

            // Determine which controller function to call based on the request method
            switch ($this->request->method){

                case 'GET': 
                    // what paramters whould we pass? Where do we get it from?
                    //--- We need the apikey to identify the specific client we are getting the video conversions of
                    // What data should we expect and where to store it?
                   // $controller->list($apikey);

                    $this->processGetResponse();

                    break;
                case 'POST':
                    $this->processPostResponse();
                    break;
                case 'PUT':
                    break;
                case 'DELETE':
                    break;
                case 'HEAD':
                    break;
                case 'OPTIONS':
                    break;

            }
        }

        // method that process the GET response
        function processGetResponse(){
            // Read the API key sent by the client
            $apikey = $this->request->urlparams['apikey'];

            $resourceID = $this->request->urlparams['id'];

            // Determine the reponse properties
                $header = array();
                $payload = array();
                $statuscode = 0;
                $statustext = "";
                $contenttype = "";

                // Get the data/resource
                $rawpayload = $this->controller->list($apikey, $resourceID);

                // Check if data  was returned: the data here is the requested resource
                // If the data is found and can be returned
                // The HTTP status code of the response should be: 200
                if(count($rawpayload) > 0){

                    $statuscode = 200;
                    $statustext = "OK";

                }else{

                    $statuscode = 404;
                    $statustext = "Not Found";

                    $rawpayload = array('message' => "No data found, possibly invalid enpoint.");

                }

                // How do we decide what is the response content-type?
                switch($this->request->header['Accept']){

                    case 'application/json':
                        // Serialize the array of objects into a JSON array
                        $payload = json_encode($rawpayload);
                        $contenttype = 'application/json';
                        break;
                    case 'application/xml':
                        break;
                    default:
                        $payload = json_encode($rawpayload);
                        $contenttype = 'application/json';                               
                }

                $headerfields = ['Status-Code'=> $statuscode, 'Status-Text' => $statustext, 'Content-Type' => $contenttype ];

                $responseBuilder  = new Responsebuilder($headerfields, $payload);

                $this->response = $responseBuilder->getResponse();
            }

        // method that proces the POST response
        function processPostResponse() {
            // Takes raw data from the request
            $json = file_get_contents('php://input');

            // Converts it into a PHP object
            $data = json_decode($json, true);
            //var_dump($data);

            // Determine the reponse properties
            $header = array();
            $payload = array();
            $statuscode = 0;
            $statustext = "";
            $contenttype = "";

            # WORK HERE TOMORROW
            $appointmentStatus = $this->controller->createAppointment($data);
          
            $rawpayload = array("appointmentStatus" => $appointmentStatus);
            // var_dump($rawpayload);
            // Check if data  was returned: the data here is the requested resource
            // If the data is found and can be returned
            // The HTTP status code of the response should be: 200
            if (!is_null($rawpayload)){
                $statuscode = 200;
                $statustext = "OK";
            }
            else {   // 0 rows in the databasse because the resource was not found
                $statuscode = 404;
                $statustext = "Not Found";

                $rawpayload = array('message' => "Possibly invalid enpoint.");
            }

            // How do we decide what is the response content-type?
            switch($this->request->header['Accept']) {  // Making sure we know what the client wants -> we are generalizing/assuming that we know that we know what the client wants back(Accept)
                case 'application/json':
                    // Serialize the array of objects into a JSON array
                    $payload = json_encode($rawpayload);
                    $contenttype = 'application/json';
                    break;
                case 'application/xml':
                    break;
                default:
                    $payload = json_encode($rawpayload);
                    $contenttype = 'application/json';                               
            }
            //set up the headerfields that will be sent to the response builder
            $headerfields = ['Status-Code'=> $statuscode, 'Status-Text' => $statustext, 'Content-Type' => $contenttype ];
            // echo $payload; testing purpose
            // build the headerfields array that will be pass to the ResponseBuilder -> put all the data in the header array 
            $responseBuilder  = new Responsebuilder($headerfields, $payload);

            $this->response = $responseBuilder->getResponse(); // which returns a response objec
           
            $responseBody = json_decode($this->response->payload);

            // for printing the payload response
            if ($responseBody->appointmentStatus) {
                echo "APPOINTMENT BOOKING SUCCESSFUL FOR " . $data['donor_Name'] . " ON " . date("F-d-Y", strtotime($data['date_Time'])) . ", " . date("h:i", strtotime($data['date_Time']));
            }
            else {
                echo "APPOINTMENT BOOKING FAILED";
            }
                
        }
    }// API class

    $api = new API();

    $api->processRequest();

    // echo( $api->response->payload);

?>