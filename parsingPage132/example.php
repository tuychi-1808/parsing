<?php

$html = file_get_contents('https://www.favoright.ru/catalog/zhbi/');

// Создаем новый объект документа
$doc = phpQuery::newDocument($html);

// Извлекаем ссылки на категории
$categories = array();
foreach ($doc->find('.catalog-section-list a') as $category) {
    $categories[] = pq($category)->attr('href');
}

// Парсим каждую категорию
foreach ($categories as $category) {
    $category_url = 'https://www.favoright.ru' . $category;
    $category_html = file_get_contents($category_url);
    $category_doc = phpQuery::newDocument($category_html);

    // Извлекаем ссылки на товары
    $products = array();
    foreach ($category_doc->find('.catalog-item-title a') as $product) {
        $products[] = pq($product)->attr('href');
    }

    // Парсим каждый товар
    foreach ($products as $product) {
        $product_url = 'https://www.favoright.ru' . $product;
        $product_html = file_get_contents($product_url);
        $product_doc = phpQuery::newDocument($product_html);

        // Извлекаем данные о товаре
        $name = $product_doc->find('.product-title')->text();
        $price = $product_doc->find('.product-price')->text();
        $description = $product_doc->find('.product-description')->text();

        // Выводим данные о товаре
        echo "Название: " . $name . "<br>";
        echo "Цена: " . $price . "<br>";
        echo "Описание: " . $description . "<br><br>";
    }
}