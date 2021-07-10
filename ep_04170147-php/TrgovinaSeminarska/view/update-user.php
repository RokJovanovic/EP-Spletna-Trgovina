<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "/form-style.css" ?>">
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <h2>Tukaj lahko spremenite svoje podatke.</h2>
        
        <form action="<?= BASE_URL . "sprememba-podatkov" ?>" method="post">
            <p><input type="text" name="firstname" required placeholder="Ime"></p><br>  
            <p><input type="text" name="lastname" placeholder="Priimek" required></p><br>
            <p><input type="text" name="email" placeholder="Email naslov" required></p><br>
            <p><input type="password" name="password" placeholder="Geslo" required></p><br>
            <p><button type="submit" value="posodobi">Posodobi</button></p>            
        </form>
    </body>
</html>
