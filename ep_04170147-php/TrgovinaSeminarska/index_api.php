<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once("controller/TrgovinaRESTController.php");

$server_script_name = htmlspecialchars($_SERVER["SCRIPT_NAME"]);
    
define("BASE_URL", $server_script_name . "/");

$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";

$urls_api = [
        "/^api\/ogled-izdelka\/(\d+)$/" => function ($method, $id) {
            switch ($method) {
                default: # GET
                    TrgovinaRESTController::get($id);
                    break;
            }
            
        },
                
        "/^api\/ogled-izdelka$/" => function ($method) {
            switch ($method) {
                default: # GET
                    TrgovinaRESTController::index();
                    break;
            }
        }

    ];
       
foreach ($urls_api as $pattern => $controller) {
     if (preg_match($pattern, $path, $params)) {
         try {
             $params[0] = $_SERVER["REQUEST_METHOD"];
             $controller(...$params);
         } catch (InvalidArgumentException $e) {
             ViewHelper::error404();
         } catch (Exception $e) {
             ViewHelper::displayError($e, true);
         }

         exit();
     }

 }

 ViewHelper::displayError(new InvalidArgumentException("No controller matched."), true);