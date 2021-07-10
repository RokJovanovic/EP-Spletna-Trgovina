<?php

    require_once("AbstractDB.php");
    
    class TrgovinaDB extends AbstractDB {
        
        public static function insertPost(array $params) {
            return parent::modify("INSERT IGNORE INTO post (post, postal_code)"
                    . "VALUES (:post, :postal_code)", $params);
        }
        
        public static function insertAddress(array $params) {
            $postal_code = $_POST["postal_code"];
            return parent::modify("INSERT IGNORE INTO address (postal_code, street_name, house_number)"
                    . "VALUES ('$postal_code', :street_name, :house_number)", $params);
        }
        
        public static function getAddressID(array $params) {
            return parent::query("SELECT address_id FROM address");
        }
        
        public static function insertUser(array $params) {
            $role_id = 0;
            $address_id = self::getAddressID($params);
  
            $max = 0;
            foreach($address_id as $i) {
                $max = max($max, $i["address_id"]);
            }
            
            $max_int = intval($max);
            
            if(isset($_POST["prodajalec"])) {
                $role_id = 2;
            } else {
                $role_id = 3;
            }
            
            return parent::modify("INSERT INTO users (role_id, address_id, name, surname, email, password)"
                    . "VALUES ('$role_id', '$max_int', :firstname, :lastname, :email, :password)", $params);
        }
        
        public static function insertOrder(array $params) {
            $user = self::getCurrentUserId();
            $user_id = $user[0]["user_id"];
            $datetime = date('Y-m-d H:i:s');
            $status = "Neobdelano";
            
            return parent::modify("INSERT IGNORE INTO orders (user_id, datetime, status)"
                    . "VALUES ('$user_id', '$datetime', '$status')", $params);
        }
        
        public static function getCurrentUserId() {
            $current_user = $_SESSION["username"];
            return parent::query("SELECT user_id FROM users WHERE email = '$current_user'");
        }
        
        public static function getUsers() {
            $users_data = parent::query("SELECT email, password FROM users");
            return $users_data;
        }
        
        public static function getAuthorizedUsers() {
            $query = parent::query("SELECT role_id, email FROM users WHERE role_id = 1 OR role_id = 2");
            
            $authorized_admin = array();
            $authorized_sellers = [[]];         
            
            foreach($query as $key => $value) {
                if($value["role_id"] == 1) {
                    $authorized_admin[$value["role_id"]] = $value["email"];
                } else {
                    $authorized_sellers[] = $value["email"];
                }
            }
            
            return array($authorized_admin, $authorized_sellers);
        }
        
        public static function getItem() {
            //TODO
            $items = parent::query("SELECT item_id, name, description, price, image, thumbnail FROM item");
            return $items;
        }
        
        public static function getItemIds() {
            return parent::query("SELECT item_id FROM item");
        }
        
        public static function getOrders() {
            $orders = parent::query("SELECT order_id, user_id, datetime, status FROM orders "
                    . "WHERE status = 'Neobdelano'");
            return $orders;
        }
        
        public static function updateOrders(array $params) {
            return parent::modify("UPDATE orders SET status = :status "
                    . "WHERE order_id = :order_id", $params);   
        }
        
        public static function updateUser(array $params) {
            //TODO
            $email = $_SESSION["username"];
            return parent::modify("UPDATE users SET name = :firstname, surname = :lastname, "
                    . "email = :email, password = :password WHERE email = '$email'", $params);           
        }
        
        public static function updateItem(array $params) {           
            $item_id = $params["item_id"];
            return parent::modify("UPDATE item SET name = :name, description = :description,"
                    . "price = :price WHERE item_id = '$item_id'", $params);
        }
        
        
        public static function getForIds($ids) {
            $db = DBInit::getInstance();

            $id_placeholders = implode(",", array_fill(0, count($ids), "?"));

            $statement = $db->prepare("SELECT item_id, name, description, price, thumbnail, image FROM item 
                WHERE item_id IN (" . $id_placeholders . ")");
            $statement->execute($ids);

            return $statement->fetchAll();
        }

        public static function getAll() {
            $db = DBInit::getInstance();

            $statement = $db->prepare("SELECT item_id, name, description, price, thumbnail, image FROM item");
            $statement->execute();

            return $statement->fetchAll();
        }

        public static function get($id) {
            $db = DBInit::getInstance();

            $statement = $db->prepare("SELECT item_id, name, description, price, thumbnail, image FROM item 
                WHERE item_id = :id");
            $statement->bindParam(":id", $id, PDO::PARAM_INT);
            $statement->execute();

            $item = $statement->fetch();

            if ($item != null) {
                return $item;
            } else {
                throw new InvalidArgumentException("No record with id $id");
            }
        }
        
        public static function getAllwithURI(array $prefix) {
            return parent::query("SELECT item_id, name, description, price, "
                            . "          CONCAT(:prefix, item_id) as uri "
                            . "FROM item "
                            . "ORDER BY item_id ASC", $prefix);
        }
        
        public static function deactivateItem($id) {
            //TODO
            return parent::modify("DELETE item_id, name, description, price, image, thumbnail FROM item"
                    . "WHERE item_id = '$id'");
        }
        
        public static function deactivatedUsers() {
            $deactivated = array("jakasraka@gmail.com");
            return $deactivated;
        }


    }
    
?>