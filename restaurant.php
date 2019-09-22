<?php
namespace test;

if(!defined('SITE'))
{
    exit;
}

class Restaurant {
    public function __construct()
    {

    }

    private static function getPricerange($value)
    {
        switch($value)
        {
            case 1:
                return 'USD';
                break;
            case 2:
                return 'RUB';
                break;
            case 3:
                return 'YUAN';
                break;
        }

        return 'EUR';
    }

    private function getJsonLd()
    {
        $rows = $this->getList();
        $count = count($rows);

        $itemListElement = [];
        foreach($rows as $index => $row)
        {
            $itemListElement[] = $this->generateOneRest($row);
        }

        $data = [
            "@context" => "http://schema.org",
            "@type" => ["ItemList", "Food"],
            "name" => "My TOP ".$count." Best Restaurants",
            "author" => "Val",
            "about" => [
                "@type" => "World Restaurants",
                "byCreated" => [
                    "@type" => "Restaurant",
                    "name" => "Black Panter",
                ]
            ],
            "itemListOrder" => "http://schema.org/ItemListOrderAscending",
            "numberOfItems" => $count,
            "itemListElement" => $itemListElement,
        ];

        return $data;
    }

    private function generateOneRest($row)
    {
        $data = [
            "@context" => "http://schema.org",
            "@type" => "Restaurant",
            "name" => $row['name'],
            "address" => [
                "@type" => "PostalAddress",
                "postalCode" => $row['country'],
                "streetAddress" => $row['address'],
            ],
            "telephone" => $row['phone'],
            "ownerName" => $row['owner'],
            "hasMenu" =>  urldecode($row['site_url']),
            "priceRange" => self::getPricerange($row['pricerange']),
        ];

        return $data;
    }

    private function getList()
    {
        $db = new DB();

        $query = '
        SELECT *
        FROM restaurant
        ORDER BY createddate DESC
        ';

        return $db->find($query);
    }


    public function generateSchema()
    {
        return $this->getJsonLd();
    }
}