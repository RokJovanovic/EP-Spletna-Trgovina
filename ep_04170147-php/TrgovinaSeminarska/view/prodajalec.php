<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "/seller-style.css" ?>">
        <meta charset="UTF-8">
        <title>Spletna Prodajalna</title>
    </head>
    
    <body>
    
        <p align="center">
            Prijavljeni ste kot prodajalec. <br>
            <a href="sprememba-podatkov">Sprememba podatkov</a> <br>
            <a href="odjava">Odjava</a>
        </p>
        
        <h1>Neobdelana Naročila</h1><br>
        <div id="main">
            <p>Štev. Naročila | ID Uporabnika | Datum Naročila | Status </p>

            <?php foreach($orders as $order) : ?>
            
            <div class="orders">
                <form action="<?= BASE_URL . "obdelava-narocila" ?>" method="post">
                    <input type="text" name="order_id" value="<?= $order["order_id"] ?>" />
                    <input type="text" name="user_id" value="<?= $order["user_id"] ?>" />
                    <input type="text" name="time" value="<?= $order["datetime"] ?>" />
                    <select name="status" id="status">
                        <option>Neobdelano</option>
                        <option>Odobreno</option>
                        <option>Preklicano</option>
                        <option>Stornirano</option>
                    </select>
                                                                 
            <?php endforeach; ?>
            
                    <p><button>Posodobi</button></p>
                </form>
            </div> 
            
        </div>
        
    </body>
    
</html>
