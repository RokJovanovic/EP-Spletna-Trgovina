<?php

require_once("model/TrgovinaDB.php");

class CartDB {

    public static function getAll() {
        if (!isset($_SESSION["cart"]) || empty($_SESSION["cart"])) {
            return [];
        }

        $ids = array_keys($_SESSION["cart"]);
        $cart = TrgovinaDB::getForIds($ids);

        // Adds a quantity field to each book in the list
        foreach ($cart as &$item) {
            $item["quantity"] = $_SESSION["cart"][$item["item_id"]];
        }

        return $cart;
    }

    public static function add($id) {
        $item = TrgovinaDB::get($id);

        if ($item != null) {
            if (isset($_SESSION["cart"][$id])) {
                $_SESSION["cart"][$id] += 1;
            } else {
                $_SESSION["cart"][$id] = 1;
            }            
        }
    }

    public static function update($id, $quantity) {
        $item = TrgovinaDB::get($id);
        $quantity = intval($quantity);

        if ($item != null) {
            if ($quantity <= 0) {
                unset($_SESSION["cart"][$id]);
            } else {
                $_SESSION["cart"][$id] = $quantity;
            }
        }
    }

    public static function purge() {
        unset($_SESSION["cart"]);
    }

    public static function total() {
        return array_reduce(self::getAll(), function ($total, $item) {
            return $total + $item["price"] * $item["quantity"];
        }, 0);
    }
}