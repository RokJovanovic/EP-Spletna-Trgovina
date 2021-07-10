<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "/store-style.css" ?>">
        <meta charset="UTF-8">
        <title>Spletna Prodajalna</title>
    </head>  
        
    <body>
        <h1>Spletna Prodajalna</h1>
        
        <p align="center">
            Prijavljeni ste kot stranka. <br>
            <a href="sprememba-podatkov">Sprememba podatkov</a> <br>
            <a href="odjava">Odjava</a> 
        </p>
        
        <div id="main">

             <?php foreach ($items as $item): ?>

                <div class="item">
                    <form action="<?= BASE_URL . "store/add-to-cart" ?>" method="post" />
                        <input type="hidden" name="id" value="<?= $item["item_id"] ?>" />
                        <p><?= $item["name"] ?></p>
                        <p><?= number_format($item["price"], 2) ?> EUR<br/>
                        <p><img src="data:image/jpeg;base64,<?php echo base64_encode( $item["thumbnail"] ); ?>" /></p>
                        <button>V voziček</button><br>
                        <a href="<?= BASE_URL . "ogled-izdelka?id=" . $item["item_id"] ?>">Podrobnosti</a>
                    </form> 
                </div>

            <?php endforeach; ?>
        </div>
        
        <?php if (!empty($cart)): ?>

            <div id="cart">
                <h3>Voziček</h3>
                <?php foreach ($cart as $item): ?>

                    <form action="<?= BASE_URL . "store/update-cart" ?>" method="post">
                        <input type="hidden" name="id" value="<?= $item["item_id"] ?>" />
                        <input type="number" name="quantity" value="<?= $item["quantity"] ?>" class="update-cart" />
                        &times; <?= $item["name"] ?> 
                        <button>Posodobi</button> 
                    </form>

                <?php endforeach; ?>

                <p>Skupni znesek: <b><?= number_format($total, 2) ?> EUR</b></p>

                <form action="<?= BASE_URL . "store/purge-cart" ?>" method="post">
                    <p><button>Izprazni</button></p>
                </form><br>
                
                <form action="<?= BASE_URL . "purchase" ?>" method="post">                                
                    <p><button>Zaključi Nakup</button></p>
                </form>
            </div>    

        <?php endif; ?>
  
    </body>

        
</html>
