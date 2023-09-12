<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

setlocale(LC_ALL, 'ru_RU');
date_default_timezone_set('Europe/Moscow');
header('Content-type: text/html; charset=utf-8');

function parser($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $html = curl_exec($ch);
    curl_close($ch);
    return $html;
}


$html = parser("https://www.betonvoskresensk.ru/price.html");

require_once __DIR__ . "/phpQuery.php";
$pq = phpQuery::newDocument($html);

$producCategory = [];
$dataCategory = $pq->find(".accordion-item:lt(1)");

foreach ($dataCategory as $itemCategory)
{
    $category = pq($itemCategory)->find('h2')->text();
    $producCategory = array(
        "category" => $category
    );
    print_r($producCategory);

    $product = [];
    $data = $pq->find(".table tbody tr");

    foreach ($data as $item)
    {
        $name = pq($item)->find("td:eq(0)")->text();
        $class  = pq($item)->find("td:eq(1)")->text();
        $price= pq($item)->find("td:eq(2)")->text();
        $product = array(
            "name" => $name,
            "class" => $class ,
            "price" => $price,
            "category" => $category
        );
        print_r($product);
        echo '
      <h1>'.$name.'</h1>  
      <h2>'.$class.'</h2>  
      <h3>'.$price.'</h3>  
      <h4>'.$category.'</h4>  
    ';
    }

}








