<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

setlocale(LC_ALL, 'ru_RU');
date_default_timezone_set('Europe/Moscow');
header('Content-type: text/html; charset=utf-8');

require_once __DIR__ . "/phpQuery.php";

function parser($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $html = curl_exec($ch);
    curl_close($ch);
    return $html;
}

$html = parser("http://svapbeton.ru/#content");
$pq = phpQuery::newDocument($html);



$catName = array();
$categoryName = $pq->find("#content-tab2 div:nth-child(2)");

foreach ($categoryName as $name) {
    $cardName = pq($name)->find("h3:lt(0)")->text();

    $catName = array(
        'category' => $cardName
    );
    print_r($catName);

    $dataProduct = array();
    $cardProduct = $pq->find('.char tbody tr');
    foreach ($cardProduct as $cardList)
    {
        $name = pq($cardList)->find("td:eq(0)")->text();
        $length = pq($cardList)->find("td^eq(1)")->text();
        $width = pq($cardList)->find("td:eq(2)")->text();
        $height = pq($cardList)->find("td:eq(3)")->text();
        $weight = pq($cardList)->find("td:eq(4)")->text();
        $price = pq($cardList)->find("td:eq(5)")->text();

        $dataProduct = array(
            "name" => $name,
            "leight" => $length,
            "widht" => $width,
            "hieght" => $height,
            "weight" => $weight,
            "price" => $price,
            "category" => $cardName
        );

        print_r($dataProduct);
        echo '
        <h1>'. $cardName . '</h1>
        <h2>'. $length .'</h2>
        <h3>'. $weight . '</h3>
        <h4>'. $height . '</h4>
        <h5>'. $weight .  '</h5>
        <h6>'. $price . '</h6>
        <h6>'. $name . '</h6>
        ';

    }
}

$dataList = array();
$cardData = $pq->find("#content-tab2 div:nth-child(2) table.gust-table-item tbody tr td");
foreach ($cardData as $data) {
    $category = pq($data)->find("h3")->text();

    $dataList = array(
        "category" => $category
    );

    print_r($dataList);

    $dataCards = array();
    $cardTale = $pq->find("#content-tab2 div:nth-child(2) table.gust-table-item tbody tr:nth-child(4)");
    $cardTale = $pq->find("#content-tab2 div:nth-child(2) table.gust-table-item tbody tr:nth-child(4) td table tbody tr:lt(2)");
    foreach ($cardTale as $tableList)
    {
        $nameRow = pq($cardList)->find("td:eq(0)")->text();
        $lengthRow = pq($cardList)->find("td^eq(1)")->text();
        $widthRow = pq($cardList)->find("td:eq(2)")->text();
        $heightRow = pq($cardList)->find("td:eq(3)")->text();
        $weightRow = pq($cardList)->find("td:eq(4)")->text();
        $priceRow = pq($cardList)->find("td:eq(5)")->text();

        $dataCards = array(
            "name" => $nameRow,
            "leight" => $lengthRow,
            "widht" => $widthRow,
            "hieght" => $heightRow,
            "weight" => $weightRow,
            "price" => $priceRow,
            "category" => $category
        );
        print_r($dataCards);
        echo '
        <h1>'. $category . '</h1>
        <h2>'. $lengthRow .'</h2>
        <h3>'. $widthRow . '</h3>
        <h4>'. $heightRow . '</h4>
        <h5>'. $weightRow .  '</h5>
        <h6>'. $priceRow . '</h6>
        <h6>'. $nameRow . '</h6>
        ';
    }
}






