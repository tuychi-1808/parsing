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

$html = parser("https://www.favoright.ru/catalog/zhbi/");
$pq = phpQuery::newDocument($html);

$data = array();

$listLinks = $pq->find('#tab-1 .catalog-section .catalog-section-childs .catalog-section-child a');
foreach ($listLinks as $link) {
    $data[] = pq($link)->attr('href');
}

foreach ($data as $datum) {
    if ($datum == "/catalog/balki-zhelezobetonnye/")
    {
        continue;
    }else {
        $card =  parser("https://www.favoright.ru" . $datum);
        $cardPq = phpQuery::newDocument($card);

        $dataCard = array();
        $listCard = $pq->find('#catalog .catalog-item-table-view .catalog-item-card .catalog-item-info .item-all-title a');
        foreach ($listCard as $links) {
            $dataCard[] = pq($links)->attr('href');
        }
        foreach ($dataCard as $cardList)
        {
            $cardListData =  parser("https://www.favoright.ru" . $cardList);
            $cardPqList = phpQuery::newDocument($cardListData);

            $name = $cardPqList->find(".workarea .body_text #pagetitle")->text();
            $price = $cardPqList->find(".column .price_buy_detail .catalog-detail-item-price-current")->text();
            $description = $cardPqList->find(".tabs-catalog-detail .tabs__box .tabs__box-content")->text();

            $allProduct = [
                "name" =>$name,
                "price" => $price,
                "description" => $description
            ];

            print_r($allProduct);
            echo '
            <h1>'.$name .'</h1>
            <h2>'.$price.'</h2>
            <h3>'.$description.'</h3>
            ';
        }
    }
}
