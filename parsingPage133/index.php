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

$html = parser("https://mercury-gbi.ru/plity-perekrytiya/");
$pq = phpQuery::newDocument($html);

$homePage = array();

$categoryPage = $pq->find(".page-builder #productiya #mega-menu-max_mega_menu_1 #mega-menu-item-236 a");
    foreach ($categoryPage as $catPage)
    {
       $homePage[]= pq($catPage)->attr("href");

    }

    foreach ($homePage as $page)
    {
        $card = parser($page);
        $cardPq = phpQuery::newDocument($card);

        $homeTable = array();
        $homeCard = $pq->find(".blog-lg-area-left #tablepress-2 tbody tr");

        $categoryName = $pq->find(".blog-lg-area-left h2")->text();
        echo ' <h1>' . $categoryName . '</h1>';
        foreach ($homeCard as $table)
        {
            $name = pq($table)->find(".column-1")->text();
            $leight = pq($table)->find(".column-2")->text();
            $width = pq($table)->find(".column-3")->text();
            $height = pq($table)->find(".column-4")->text();
            $weight = pq($table)->find(".column-5")->text();
            $price = pq($table)->find(".column-6")->text();

            $homeTable = [
                "name" => $name,
                "leight" => $leight,
                "width" => $width,
                "height" => $height,
                "price" => $price
            ];

            print_r($homeTable);
            echo '
            <h1>' . $name . '</h1>
            <h2>' . $price . '</h2>
            <h3>' . $leight . '</h3>
            <h4>' . $width . '</h4>
            <h5>' . $height . '</h5>
            <h6>' . $weight . '</h6>
            ';
        }

    }
