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
        <title>Prijava</title>
    </head>
    <body>
        <h2>Za opravljanje nakupa se morate prijaviti.</h2>
        <form action="<?= BASE_URL . "prijavljen-uporabnik" ?>" method="post">
            <p><input type="text" name="username" placeholder="Email naslov" required></p><br>  
            <p><input type="password" name="password" placeholder="Geslo" required></p><br>
            <p><button type="submit">Prijava</button></p>
        </form>

    </body>
    <footer>
        <a href="registracija">Če se še niste registrirali, lahko to storite tukaj</a>
    </footer>
</html>
