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
        <title>Registracija</title>
    </head>
    <body>
        <h2>Dobrodošli na strani za registracijo</h2>
        
        <form action="<?= BASE_URL . "registriran-uporabnik" ?>" method="post">
            <p><input type="text" name="firstname" required placeholder="Ime"></p><br>  
            <p><input type="text" name="lastname" placeholder="Priimek" required></p><br>
            <p><input type="text" name="email" placeholder="Email naslov" required></p><br>
            <p><input type="password" name="password" placeholder="Geslo" required></p><br>
            <p><input type="text" name="street_name" placeholder="Ulica" required></p><br>
            <p><input type="text" name="house_number" placeholder="Hišna številka" required></p><br>
            <p><input type="text" name="post" placeholder="Kraj" required></p><br>
            <p><input type="text" name="postal_code" placeholder="Poštna številka" required></p><br>
            <p><label>Izberite kako se želite registrirati</label></p>
            <p><button type="submit" value="2" name="prodajalec">Kot prodajalec</button></p> 
            <p><button type="submit" value="3" name="stranka">Kot stranka</button></p>
        </form>
    </body>
    <footer>
        <a href="prijava">Če ste že registrirani se lahko prijavite tukaj</a>
    </footer>
</html>
