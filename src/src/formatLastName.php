<html>
<head>
    <link rel="stylesheet" href="/stylesheets/body.css"/>
    <link rel="stylesheet" href="/stylesheets/navBar.css"/>
    <link rel="stylesheet" href="/stylesheets/menu.css"/>
    <link rel="stylesheet" href="/stylesheets/input.css"/>
</head>
<div class="navBar">
    <a href="../">Hovedmeny</a>
</div>
<div class="menu">
    <h3>Modul 2 - Oppgave 1</h3>
    <h4>Ditt resultat</h4>
    <?php
        // Konvertere første bokstav i teksten til stor
        // Konvertere resten av strengen fra og med 2. bokstav til små bokstaver og
        // printe det ut
        echo mb_strtoupper($_GET["lastName"][0]) . mb_strtolower(substr($_GET["lastName"], 1));
    ?>
</div>
</html>