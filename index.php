<?php
session_start();
define('API', 'https://api.exchangeratesapi.io/latest');
$answer = getAnswer();
$base =($answer->base);
$currencyKeys = (array) $answer->rates;
$currencyKeys = array_keys($currencyKeys);

if(empty($_POST)){
  
    // $from = $_POST['fromSum'];
    // $to = $_POST['toSum'];

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
            return json_decode(file_get_contents('currencies.json'));
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
    <input type='number' placeholder='from' name='fromSum'></input>
    <select name="" id="">
        <?php
        for ( $i = 0; $i < count($currencyKeys); $i++){
            echo '<option value='. $currencyKeys[$i] .'>'. $currencyKeys[$i] .'</option>';
        }
        ?>
    </select>
    <input type='number' placeholder='to' name='toSum'></input>
    <select name="" id="">
    <?php
        for ( $i = 0; $i < count($currencyKeys); $i++){
            echo '<option value='. $currencyKeys[$i] .'>'. $currencyKeys[$i] .'</option>';
        }
        ?>
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