<?php

require_once("model/TrgovinaDB.php");
require_once("model/CartDB.php");
require_once("ViewHelper.php");

class StoreController {

    public static function index() {
        $vars = [
            "items" => TrgovinaDB::getAll(),
            "cart" => CartDB::getAll(),
            "total" => CartDB::total()
        ];
        
        echo ViewHelper::render("view/stranka.php", $vars);
    }

    public static function addToCart() {
        $id = isset($_POST["id"]) ? intval($_POST["id"]) : null;

        if ($id !== null) {
            CartDB::add($id);
        }

        ViewHelper::redirect(BASE_URL . "store");
    }

    public static function updateCart() {
        $id = (isset($_POST["id"])) ? intval($_POST["id"]) : null;
        $quantity = (isset($_POST["quantity"])) ? intval($_POST["quantity"]) : null;

        if ($id !== null && $quantity !== null) {
            CartDB::update($id, $quantity);
        }

        ViewHelper::redirect(BASE_URL . "store");
    }

    public static function purgeCart() {
        CartDB::purge();

        ViewHelper::redirect(BASE_URL . "store");
    }

}
