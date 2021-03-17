<?php
$dist = 0;
define('API', 'adresas? stops=');
//reikia ziureti API dokumentacijoje, kaip apiforminti sita url, kad gautum butent tokius duomenis, kokiu nori (pvz atstuma nuo vilniaus iki kauno)

if(!empty($_POST)){

$kintamasisPirmas = 'zalias';
$kintamasisAntras = 'raudonas';

//kreipimasis vyksta is serverio i kita serveri (ne is narsykles):
//serverio asmenine narsykle vadinasi curl

$curl= curl_init(); //vidinis php objektas(resursas); gave ji turim nusikonfiguruoti. t.y. parasyti, kur ji pasiust. siunciam pas api:
curl_setopt($curl, CURLOPT_URL, API.$kintamasisPirmas.'|'.$kintamasisAntras);
//toliau: prasom, kad parnestu, ka gavo. jei sito neparasom, tai jis kreipsis i serveri, nepalauks atsakymo, ir nieko neparnes:
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
//iveikiu eiga tokia: siunciame uzklausa, laukiame ir atsakyma irasome i answer variable
$answer = curl_exec($curl); 
//kai gauname atsakyma, curla reikia uzdaryti:
curl_close($curl);

echo $answer //gausim stringo tipo duomenis

$dist = $answer->distance;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Atstumas <?= $dist ?></h2>
    <form action='' method=''>
    Miestas 1 <input type='text' name='c1'></input>
    Miestas 2 <input type='text' name='c2'></input>
    <button type='submit'>Atstumas</button>
    </form>
</body>
</html>