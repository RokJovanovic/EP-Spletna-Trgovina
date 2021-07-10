<?php
    
    session_start();
    
    require_once("controller/TrgovinaController.php");
    require_once("controller/StoreController.php");
    //require_once("controller/TrgovinaRESTController.php");
    
    
    $server_script_name = htmlspecialchars($_SERVER["SCRIPT_NAME"]);
    
    define("BASE_URL", $server_script_name . "/");
    define("CSS_URL", rtrim($server_script_name, "index.php") . "static/CSS");
    
    $path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";
    
    $urls = [
        //Klicejo se funkcije iz TrgovinaController      
        "prijava" => function() {
            //Dostopen iz anonimne uporabe ali registracije
            TrgovinaController::redirectLogin();
        },
                
        "odjava" => function() {
            TrgovinaController::logoutUser();
            ViewHelper::redirect(BASE_URL . "anonimna-uporaba");
        },
                
        "registracija" => function() {
            //Dostopen iz anonimne uporabe ali prijave
            TrgovinaController::redirectRegister();  
        },
                
        "anonimna-uporaba" => function() {
            //Tukaj bo link do prijave in registracije ter pregled izdelkov trgovine
            TrgovinaController::anonIndex();              
            //TrgovinaDB::getItem();
        },
             
        "ogled-izdelka" => function() {
            TrgovinaController::showItem();            
        },
                
        /*"posodobi-izdelek" => function() {
            TrgovinaController::showItem();
            echo ViewHelper::render("view/update-item.php");
            if(!empty($_POST)) {
                TrgovinaController::changeItemDetails();
            }
            echo "Vnesite podatke.";
        },*/
                
        "store" => function () {
            StoreController::index();
        },
                
        "store/add-to-cart" => function () {
            StoreController::addToCart();
        },
                
        "store/update-cart" => function () {
            StoreController::updateCart();
        },
                
        "store/purge-cart" => function () {
            StoreController::purgeCart();
        },
                
        "purchase" => function() {
            TrgovinaController::addOrder();
            StoreController::index();
        },
                
        "registriran-uporabnik" => function() {
            TrgovinaController::registerUser();  
        },
                
        "prijavljen-uporabnik" => function() {
            //Ko je uporabnik že prijavljen ga preusmerimo sem
            TrgovinaController::loginUser(); 
            //echo ViewHelper::render("view/stranka.php");
        },
                
        "sprememba-podatkov" => function() {
            echo ViewHelper::render("view/update-user.php");
            if(!empty($_POST)) {
                TrgovinaController::changeDetails();
            }
            echo "Vnesite podatke.";
        },
                
        "pregled-narocil" => function() {
            TrgovinaController::sellerIndex();
        },
                
        "obdelava-narocila" => function() {
            TrgovinaController::processOrder();
            TrgovinaController::sellerIndex();
        },
                
        "admin" => function() {
            TrgovinaController::adminIndex();
        },
                
        /*"deaktivacija-izdelka" => function() {           
            if (isset($_GET)) {
                TrgovinaController::deactivateItem($_GET["id"]);
            } else {
                var_dump($_GET);
            }
        },*/
        
        "" => function() {
            //ViewHelper::redirect(BASE_URL . "anonimna-uporaba");
            ViewHelper::redirect(BASE_URL . "anonimna-uporaba"); 
        }
    ];     
    
    try {
        if(isset($urls[$path])) {
            $urls[$path]();
        } else {
            echo "No controller for '$path'";
        }
    } catch (InvalidArgumentException $e) {
        ViewHelper::error404();
    } catch (Exception $e) {
        echo "An error occurred: <pre>$e</pre>";
    }