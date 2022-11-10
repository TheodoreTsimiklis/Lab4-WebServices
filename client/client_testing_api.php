<?php
    $ch = curl_init();
    $url = "http://localhost/webservice/api/movie/"; // set url
    $data = json_encode(array(
        "apikey" => "api123",
        "clientid" => 1,
        "appear_date"=> "2022-07-01",
        "name" => "Minions: The Rise of Gru",
        "genre" => "Animation",
        "description" => "In the heart of the 1970s, amid a flurry of feathered hair and flared jeans, Gru (Oscar® nominee Steve Carell) is growing up in the suburbs. A fanboy of a supervillain supergroup known as the Vicious 6, Gru hatches a plan to become evil enough to join them. Luckily, he gets some mayhem-making backup from his loyal followers, the Minions. Together, Kevin, Stuart, Bob, and Otto--a new Minion sporting braces and a desperate need to please--deploy their skills as they and Gru build their first lair, experiment with their first weapons and pull off their first missions. When the Vicious 6 oust their leader, legendary fighter Wild Knuckles (Oscar® winner Alan Arkin), Gru interviews to become their newest member. It doesn't go well (to say the least), and only gets worse after Gru outsmarts them and suddenly finds himself the mortal enemy of the apex of evil. On the run, Gru will turn to an unlikely source for guidance, Wild Knuckles himself, and discover that even bad guys need a little help from their friends.", //using this date and time for now since there is no form created yet
    )); 

    curl_setopt($ch, CURLOPT_URL,$url); 

    curl_setopt($ch, CURLOPT_POST, 1);
    
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: application/json", 'Accept: application/json'));

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    // Execute
    $response = curl_exec($ch);
    if( $response != null || $response != FALSE || $response != '' ) {
        echo $response;
    // Closing the connection
    }
    curl_close($ch);
    
?>