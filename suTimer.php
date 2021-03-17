<?php
session_start();
define('API', 'https://api.exchangeratesapi.io/latest');
define('DIR', __DIR__);
$timeLimit = 300;
if(!empty($_POST)){
    $answer = getAnswer();
}

function getData(){
        $curl= curl_init();
        curl_setopt($curl, CURLOPT_URL, $API);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $answer = curl_exec($curl);
        curl_close($curl);
        return $answer;
}

function getAnswer(){
    if (!file_exists(DIR.'currencies.json')){
        $answer = getData();
        file_put_contents(DIR.'currencies.json', $answer);
        $timer = set_time_limit($timeLimit);
        return $answer;
    } else {
        if ($timer) {
            return json_decode(file_get_contents(DIR.'currencies.json'));
        } else {
            return getData();  
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css?<?=filemtime("style.css")?>" rel="stylesheet" type="text/css" />
    <title>Currency converter</title>
</head>
<body>
<main class='converter'>
    <h1>Convert NOW only for 9.99!!!</h1>
    <form action='' method='post'>
    <input type='number'></input>
    <select name="" id="">
    <option value="Curr"></option>
    </select>
    <input type='number'></input>
    <select name="" id="">
    <option value="Curr"></option>
    </select>
    <button type='submit'>Convert</button>
</form>
    <?php 
    if (isset($_SESSION['fromSum']) && isset($_SESSION['toSum'])){
        echo "<h2><?=$fromSum . $fromCur . 'converted into' . $toCur . 'equals' . $toSum ?></h2>";
        session_destroy();
    }
    
    ?>
</main>
</body>
</html>