<?php
    require_once("model/TrgovinaDB.php");
    require_once("controller/TrgovinaController.php");
    require_once("ViewHelper.php");
    
    class TrgovinaRESTController {
        
        public static function get($id) {
            try {
                echo ViewHelper::renderJSON(TrgovinaDB::get(["id" => $id]));
            } catch (InvalidArgumentException $e) {
                echo ViewHelper::renderJSON($e->getMessage(), 404);
        }
    }

        public static function index() {
            $prefix = $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"]
                    . $_SERVER["REQUEST_URI"];
            echo ViewHelper::renderJSON(TrgovinaDB::getAllwithURI(["prefix" => $prefix]));
        }
    }
?>
