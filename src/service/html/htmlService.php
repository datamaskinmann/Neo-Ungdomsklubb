<?php
function getHeader($logoutPath)
{
    switch (empty($_SESSION["username"])) {
        case true:
            echo "Hello, not logged in";
            break;
        default:
            echo "<div class='header box'>
    <form action='" . $logoutPath . "'>
        <input style='margin-right: 5em; width: 10%' type='submit' value='Logg ut'/>
    </form>
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
