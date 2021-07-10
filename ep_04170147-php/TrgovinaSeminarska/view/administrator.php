<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "/admin-style.css" ?>">
        <meta charset="UTF-8">
        <title>Spletna Prodajalna</title>
    </head>
    
        <p align="center">
            Prijavljeni ste kot administrator. <br>
            <a href="sprememba-podatkov">Sprememba podatkov</a> <br>
            <a href="odjava">Odjava</a>
        </p>
        
    <body>
        <div id="main">

             <?php foreach ($items as $item): ?>

                <div class="item">
                    <input type="hidden" name="id" value="<?= $item["item_id"] ?>" />
                    <p><?= $item["name"] ?></p>
                    <p><?= number_format($item["price"], 2) ?> EUR<br/>
                    <p><img src="data:image/jpeg;base64,<?php echo base64_encode( $item["thumbnail"] ); ?>" /></p>
                </div>

            <?php endforeach; ?>
        </div>
       
    </body>
    
</html>
