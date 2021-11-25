<?php
function getHeader()
{
    switch (empty($_SESSION["username"])) {
        case true:
            echo "Hello, not logged in";
            break;
        default:
            echo "<div class='header'>
    <div style='display: flex; justify-content: left; align-items: center'>
        <span class='menu' style='height: 4ch; width: 4ch; margin-left: 2em'></span>
    </div>
    <div style='display: flex; justify-content: center; align-items: center'>
        <h3><a href='/pages/activities.php'>Neo ungdomsklubb</a></h3>
    </div>
    <div class='box' style='display: flex;'>
        <input style='margin-right: 2em; width: 10em; height: 5em' type='submit' value='Logg ut'/>
    </div>
</div>";
            break;
    }
}

function generateTable($headerNames, ...$values) {
    echo "<table>";
    echo "<tr>";
    foreach($headerNames as $h) {
        echo "<th>" . $h . "</th>";
    }
    echo "</tr>";

    for($i = 0; $i < count($values); $i++) {
        echo "<tr>";
        for($j = 0; $j < count($values[$i]); $j++) {
            echo "<td>" . $values[$i][$j] . "</td>";
        }
        echo "</tr>";
    }

    echo "</table>";
}

function doFilter() {
    return !empty($_SESSION["username"]);
}
