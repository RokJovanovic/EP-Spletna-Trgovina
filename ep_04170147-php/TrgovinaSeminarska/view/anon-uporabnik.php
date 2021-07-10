<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "/anon-store-style.css" ?>">
        <meta charset="UTF-8">
        <title>Spletna Prodajalna</title>
    </head>
    
        <h1>Dobrodošli v spletni prodajalni</h1>
        <p align="center">
            <a href="prijava" class="preusmeritev">Prijava</a>
            <a href="registracija" class="preusmeritev">Registracija</a>
        </p>
        
        <div id="main">

             <?php foreach ($items as $item): ?>

                <div class="item">
                    <form action="<?= BASE_URL . "store/add-to-cart" ?>" method="post" />
                        <input type="hidden" name="id" value="<?= $item["item_id"] ?>" />
                        <p><?= $item["name"] ?></p>
                        <p><?= number_format($item["price"], 2) ?> EUR<br/>
                        <p><img src="data:image/jpeg;base64,<?php echo base64_encode( $item["thumbnail"] ); ?>" /></p>
                    </form> 
                </div>

            <?php endforeach; ?>
        </div>
    
</html>
