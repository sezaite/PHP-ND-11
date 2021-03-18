<?php
session_start();
if (!defined('API')) define('API', 'https://api.exchangeratesapi.io/latest');
if (!defined('URL')) define('URL', 'http://localhost/bit/nd11/');
if (!defined('TIME')) define('TIME', 15);

if (!file_exists(__DIR__.'/data.json')) {
    file_put_contents(__DIR__.'/data.json', 
         json_encode([
            'time' => time()-TIME-1, 
            'data' => (object)[]
            ])
    );
}
$cache = json_decode(file_get_contents(__DIR__.'/data.json'));
$answer = $cache->time > time()-TIME ? (array) $cache->data : getData();  
$rates = $answer['rates'];
$currencyKeys = array_keys($rates);

if(!empty($_POST)){
    $_SESSION['fromSum'] =(int)$_POST['fromSum'];
    foreach($rates as $key => $rate){
        if($key == $_POST['from']){
            $_SESSION['from'] = $rates[$key];
            $_SESSION['fromCur'] = $key;
            _d($_SESSION['from']);
        } 
        if($key == $_POST['to']){
            $_SESSION['to'] = $rates[$key];
            $_SESSION['toCur'] = $key;
            _d($_SESSION['to']);
        }
    }
    $_SESSION['toSum'] = $_SESSION['fromSum'] * $_SESSION['from'] * $_SESSION['to'];
    header('Location: '.URL);
    die;
}
    

function getData(){
        $curl= curl_init();
        curl_setopt($curl, CURLOPT_URL, API);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $answer = curl_exec($curl);
        curl_close($curl);
        $answer = json_decode($answer, true);
        file_put_contents(__DIR__.'/data.json', 
        json_encode([
            'time' => time(), 
            'data' => $answer
            ])
        );
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
        echo "<h2 class='result'>" . $_SESSION['fromSum'] ." ". $_SESSION['fromCur'] . " equals " . $_SESSION['toSum'] . " " . $_SESSION['toCur'] . "</h2>";
        session_destroy();
    }
    
    ?>
</main>
</body>
</html>