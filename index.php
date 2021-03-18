<?php
session_start();
define('API', 'https://api.exchangeratesapi.io/latest');
$answer = json_decode(getAnswer());
$currencyKeys = (array) $answer->rates;
$currencyKeys = array_keys($currencyKeys);

if(!empty($_POST)){
    $fromSum = $_POST['fromSum'];
    $from = $_POST['from'];
    $to = $_POST['to'];
    $rates = $answer->rates;
    foreach($rates as $key => $rate){
        if($from === $key){
            $from = $rates[$key];
            break;
        } 
    }
    foreach($rates as $key => $rate){
        if($to === $key){
            $to = $rates[$key];
            break;
        } 
    }
    $_SESSION['toCur'] = $from * $to;
}

function getData(){
        $curl= curl_init();
        curl_setopt($curl, CURLOPT_URL, API);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $answer = curl_exec($curl);
        curl_close($curl);
        return $answer;
}

function getAnswer(){
    if (!file_exists('currencies.json')){
        $answer = getData();
        file_put_contents('currencies.json', $answer);
        return $answer;
    } else {
            return file_get_contents('currencies.json');
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
    <input type='number' placeholder='Enter the amount' name='fromSum'></input>
    <select name="from">
        <?php
        for ( $i = 0; $i < count($currencyKeys); $i++){
            echo "<option value=". $currencyKeys[$i] .">". $currencyKeys[$i] ."</option>";
        }
        ?>
    </select>
    <span class='label'>into</span>
    <select name='to'>
    <?php
        for ( $i = 0; $i < count($currencyKeys); $i++){
            echo "<option value=". $currencyKeys[$i] .">". $currencyKeys[$i] ."</option>";
        }
        ?>
    </select>
    <button type='submit'>Convert</button>
</form>
    <?php 
    if (isset($_SESSION['fromSum']) && isset($_SESSION['from']) && isset($_SESSION['to'])) {
        echo "<h2><?=$fromSum . $fromCur . 'converted into' . $toCur . 'equals' . $toSum ?></h2>";
        session_destroy();
    }
    
    ?>
</main>
</body>
</html>