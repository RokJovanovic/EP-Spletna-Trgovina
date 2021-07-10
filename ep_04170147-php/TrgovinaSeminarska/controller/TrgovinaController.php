<?php

    require_once("model/TrgovinaDB.php");
    require_once("ViewHelper.php");
    
    class TrgovinaController {
        
        //Preumseri na stran za anonimno uporabo in gledanje artiklov (anon-uporabnik.php)
        public static function anonIndex() {
            //echo ViewHelper::render("view/anon-uporabnik.php");
            echo ViewHelper::render("view/anon-uporabnik.php", ["items" => TrgovinaDB::getAll()]);
        }
        
        public static function index() {
            if (isset($_GET["id"])) {
                ViewHelper::render("view/stranka.php", ["item" => TrgovinaDB::get($_GET["id"])]);
            } else {
                ViewHelper::render("view/stranka.php", ["items" => TrgovinaDB::getAll()]);
            }
        }
        
        public static function sellerIndex() {
            echo ViewHelper::render("view/prodajalec.php", ["orders" => TrgovinaDB::getOrders()]);
        }
        
        public static function adminIndex() {
            echo ViewHelper::render("view/administrator.php", ["items" => TrgovinaDB::getAll()]);
        }
        
        public static function registerUser() {
            $data = filter_input_array(INPUT_POST, self::getRulesUser());

            $user_data = array_slice($data, 0, 4);
            $user_data["password"] = self::securePassword();
            $address_data = array_slice($data, 4, 2);
            $post_data = array_slice($data, 6);          
            
            if(self::checkValues($data)) {               
                TrgovinaDB::insertPost($post_data);
                TrgovinaDB::insertAddress($address_data);
                TrgovinaDB::insertUser($user_data);
                echo ViewHelper::render("view/login.php");
            } else {
                //echo ViewHelper::render("view/anon-uporabnik.php");
                ViewHelper::redirect(BASE_URL . "anonimna-uporaba");
                echo "Registracija ni uspela. Poskusite ponovno.";
            }
        }
        
        public static function loginUser() {
            $data = filter_input_array(INPUT_POST);           
            $users = TrgovinaDB::getUsers();
            
            if(self::checkValues($data)) {
                foreach($users as $key => $value) {                    
                    $verified_password = password_verify($data["password"], $value["password"]);
                    if(!in_array($data["username"], TrgovinaDB::deactivatedUsers())) {
                        if(($data["username"] == $value["email"]) && ($verified_password)) {
                            $_SESSION["username"] = $value["email"];
                            if(self::authorization($data["username"]) == "Admin") {
                                //echo ViewHelper::render("view/administrator.php");
                                ViewHelper::redirect(BASE_URL . "admin");
                            } else if(self::authorization($data["username"]) == "Seller") {
                                //echo ViewHelper::render("view/prodajalec.php");
                                ViewHelper::redirect(BASE_URL . "pregled-narocil");
                            } else {
                                ViewHelper::redirect(BASE_URL . "store");
                            }           
                            //echo ViewHelper::render("view/store.php");
                            return;
                        }
                    } else {
                        echo ViewHelper::render("view/login.php");
                        echo "Uporabnik deaktiviran.";
                        return;
                    }
                }
                ViewHelper::redirect("prijava");
                echo "Prijava ni uspela. Poskusite znova.";                
            }
        }
        
        public static function logoutUser() {
            session_destroy();
            echo ViewHelper::redirect("anonimna-uporaba");
        }
        
        //Preusmeri na login.php
        public static function redirectLogin() {
            echo ViewHelper::render("view/login.php");
        }
        
        //Preusmeri na registracija.php
        public static function redirectRegister() {
            echo ViewHelper::render("view/registracija.php");
        }
        
        //Zavaruje geslo, tako, da ga pošlje čez zgoščevalno funkcijo
        public static function securePassword() {
            $password = filter_input_array(INPUT_POST)["password"];
            $new_password = password_hash($password, PASSWORD_BCRYPT);
            return $new_password;   
        }
        
        public static function authorization($username) {
            //TODO
            $authorized_admin = TrgovinaDB::getAuthorizedUsers()[0];
            $authorized_sellers = TrgovinaDB::getAuthorizedUsers()[1];
            
            /*$client_cert = filter_input(INPUT_POST, "SSL_CLIENT_CERT");
            $cert_data = openssl_x509_parse($client_cert);
            $commonname = $cert_data['subject']['CN'];*/
            
            if(in_array($username, $authorized_admin)) {
                return "Admin";
            } else if (in_array($username, $authorized_sellers)) {
                return "Seller";
            } else {
                return "Buyer";
            }           
        }
        
        public static function showItem() {
            echo ViewHelper::render("view/item-detail.php");
        }
        
        public static function deactivateItem($id) {
            TrgovinaDB::deactivateItem($id);
            echo ViewHelper::render("view/administrator.php");
        }
        
        //Sprememba atributov uporabnika
        public static function changeDetails() {
            //TODO                       
            $data = filter_input_array(INPUT_POST);
                        
            $data["password"] = self::securePassword();
            
            if(self::checkValues($data)) {
                if(self::authorization($data["email"]) == "Admin") {
                    TrgovinaDB::updateUser($data);
                    //echo ViewHelper::render("view/administrator.php");  
                    ViewHelper::redirect(BASE_URL . "admin");
                } else if(self::authorization($data["email"]) == "Seller") {
                    TrgovinaDB::updateUser($data);
                    //echo ViewHelper::render("view/prodajalec.php");
                    ViewHelper::redirect(BASE_URL . "pregled-narocil");
                } else {
                    TrgovinaDB::updateUser($data);
                    //echo ViewHelper::render("view/stranka.php");
                    ViewHelper::redirect(BASE_URL . "store");
                }
            } else {
                echo "Napaka. Poskusite ponovno.";
            }
        }
        
        public static function changeItemDetails() {
            $data["item_id"] = $_GET["id"];
            var_dump($data);
            $data = filter_input_array(INPUT_POST);
            
            if(self::checkValues($data)) {
                TrgovinaDB::updateItem($data);
                ViewHelper::redirect(BASE_URL . "prijavljen-uporabnik");
            } else {
                echo "Napaka. Poskusite ponovno.";
            }
        }
        
        public static function getItemData() {
            $items = TrgovinaDB::getItem();
            $item_data = array();
            
            foreach($items as $key => $value) {
                $item_data[$value["item_id"]] = array($value["item_id"], $value["name"], $value["price"]);
            }
            
            return $item_data;
            
        }
        
        public static function addOrder() {
            $data = array();
            TrgovinaDB::insertOrder($data);
        }
        
        public static function processOrder() {
            $order = filter_input_array(INPUT_POST);
            
            $data = array();
            $data["order_id"] = $order["order_id"];
            $data["status"] = $order["status"];
            
            if(self::checkValues($data)) {
                TrgovinaDB::updateOrders($data);
            }
        }
        
        //Preveri pravilnost vnosov (če so true)
        private static function checkValues($input) {
            if(empty($input)) {
                return FALSE;
            }
            
            $result = TRUE;
            foreach($input as $value) {
                $result = $result && $value != false;
            }
            
            return $result;
        }
        
        //TODO Prečistiti mora pravilne vrednosti
        //Prečisti uporabniške vnose
        private static function getRulesUser() {
            return [
                "firstname" => FILTER_SANITIZE_SPECIAL_CHARS,
                "lastname" => FILTER_SANITIZE_SPECIAL_CHARS,
                "email" => FILTER_SANITIZE_EMAIL,
                "password" => FILTER_SANITIZE_SPECIAL_CHARS,
                "street_name" => FILTER_SANITIZE_SPECIAL_CHARS,
                "house_number" => FILTER_SANITIZE_NUMBER_INT,
                "post" => FILTER_SANITIZE_SPECIAL_CHARS,
                "postal_code" => FILTER_SANITIZE_NUMBER_INT
            ];
        }
        
        
    }
    
?>
