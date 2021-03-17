<?php

class Helper {

    public function getData($API) {
    $curl= curl_init();
    curl_setopt($curl, CURLOPT_URL, $API);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $answer = curl_exec($curl);
    curl_close($curl);
    return $answer;
    }
}