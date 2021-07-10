<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "/item-style.css" ?>">
        <meta charset="UTF-8">
        <title>Podrobnosti Artikla</title>
    </head>
    <body>
        
        <?php 
            $items = array();
            $items = TrgovinaDB::getItem(); 
            
            foreach($items as $item) :
                if($item["item_id"] == $_GET["id"]) : ?>
                    <ul>
                        <li>Ime: <?= $item["name"] ?> </li>
                        <li>Opis: <?= $item["description"] ?> </li>
                        <li>Cena: <?= $item["price"] ?> EUR</li>
                        <img src="data:image/jpeg;base64,<?php echo base64_encode( $item["image"] ); ?>">          
                    </ul>
                <?php  endif; 
             endforeach;?>
        
        <p align="center"><a href="<?= BASE_URL . "store" ?>">Nazaj v prodajalno.</a></p>
        
    </body>
</html>
