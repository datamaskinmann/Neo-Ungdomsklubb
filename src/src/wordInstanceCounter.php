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
<div class="menu" style="height: 90%; width: 65%">
    <h3>Modul 2 - Oppgave 3</h3>
    <h4>Ditt resultat</h4>
    <?php
    // Telle antall forekomster av ordet ved å bruke substr count og skrive det til brukeren
    echo "Antall forekomster av '" . $_GET["word"] . "': " . substr_count($_GET["richText"], $_GET["word"]);
    echo "<br><br>";
    // For å illustrere hvor ordet forekommer kan vi bruke regex til å finne forekomster av ordet
    // og øke tekststørrelsen og gjøre teksten fet
        $buffer = preg_replace("/" . $_GET["word"] . "/",
            "<strong style='font-size: 16pt'>" . $_GET["word"] . "</strong>", $_GET["richText"]);
        echo preg_replace("/\n/", "<br/>", $buffer);
    ?>
</div>
</html>