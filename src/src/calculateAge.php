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
    <h3>Modul 2 - Oppgave 4</h3>
    <h4>Ditt resultat</h4>
    <?php
    try {
        // Datoen som ble gitt av brukeren
        $date = new DateTime($_GET["date"]);
        // Datoen nå
        $now = new DateTime(date("d-m-Y"));

        // Differansen mellom disse datoene
        $i = $now->diff($date);

        // Printe ut antall år siden brukerens dato
        echo "Du er " . $i->y . " år";
        // Hvis måned er større enn null og dag er større enn null må
        // Resultatet formatteres slik:
        // Du er X år, Y måneder og Z dager gammel
        if($i->m > 0 && $i->d > 0) {
            echo ", " . formatMonth($i->m) . " og " .
                formatDay($i->d);
        }
        // Hvis måneder er større enn null, men dager er null må
        // Resultatet formatteres slik:
        // Du er X år og Y måneder gammel.
        else if($i->m > 0 && $i->d == 0) {
            echo " og " . formatMonth($i->m);
        }
        // Hvis dager er større enn null, men måneder er null må
        // Resultatet formatteres slik:
        // Du er X år og Z dager gammel
        else if($i->m == 0 && $i->d > 0) {
            echo " og " . formatDay($i->d);
        }
        // Hvis ingen av de overnevnte tilfellene inntreffer,
        // Betyr det at dager er null og måneder er null
        // Resultatet formatteres slik
        // Du er X år gammel
        echo " gammel";
    } catch (Exception $e) {
        echo "Noe gikk galt " . $e->getMessage();
    }

    // Funksjon for å få en streng til å være grammatisk korrekt
    // Eks hvis $month = 1 blir det 1 måned,
    // hvis $month er ikke er null blir det X måneder
    function formatMonth($month) {
        return $month == 1 ? $month . " måned" : $month . " måneder";
    }

    // Funksjon for å få en streng til å være grammatisk korrekt.
    // Eks hvis $day = 1 blir det 1 dag.
    // hvis $day ikke er null blir det X dager
    function formatDay($day) {
        return $day == 1 ? $day . " dag" : $day . " dager";
    }
    ?>
</div>
</html>