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
    <h3>Modul 2 - Oppgave 2</h3>
    <h4>Ditt resultat</h4>
    <?php
        /*
         * Utfør 3 regex operasjoner
         * 1. Finn alle instanser av <?php
         * 2. Finn alle instanser av ?>
         * 3. Finn alle instanser av et mønster
         * Mønsteret kan forklares som følger
         * Mønsteret starter med en < karakter.
         * Deretter stopper mønstergjenkjenningen dersom vi treffer på en >
         * karakter
         *
         * Til sist
         * Erstatt alle funn med tom tekst
         */
        echo preg_replace("/<\?php|\?>|<.+?>/", "", $_GET["lastName"]);
    ?>
</div>
</html>