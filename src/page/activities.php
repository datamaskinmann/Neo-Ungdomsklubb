<?php
include "../service/html/htmlService.php";
session_start();
if (!doFilter()) {
    http_response_code(403);
    return;
}

?>

<html>
<head>
    <link rel="stylesheet" href="../stylesheets/body.css">
    <link rel="stylesheet" href="../stylesheets/box.css">
    <link rel="stylesheet" href="../stylesheets/input.css">
    <link rel="stylesheet" href="../stylesheets/header.css">
    <link rel="stylesheet" href="../stylesheets/activitiesTable.css">
    <link rel="stylesheet" href="../stylesheets/center.css">
    <link rel="stylesheet" href="../stylesheets/button.css">
    <link rel="stylesheet" href="../stylesheets/icons.css"/>
    <link rel="stylesheet" href="../stylesheets/h.css">
    <link rel="stylesheet" href="../stylesheets/a.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="../service/html/HTTP.js"></script>
</head>
<style>
    button {
        margin-top: 5%;
    }

    a {
        text-decoration: none;
        color: black;
    }
</style>
<body>
<?php
include "../service/activity/activityService.php";

getHeader();
?>
<div class="center" style="width: auto">
    <h1>Aktiviteter</h1>
    <?php
    $activities = getAllActivities();

    echo "<table>
    <tr>
        <th>Beskrivelse</th>
        <th>Dato</th>";
    if ($_SESSION["isAdmin"]) echo "<th style='display: flex; justify-content: center'><input type='checkbox' id='selectAll'></th>";
    include '../service/time/dateFormatter.php';
    echo "</tr>";
    while ($row = mysqli_fetch_array($activities)) {
        $date = stringToDate($row["date"]);

        echo "<tr id='" . $row["id"] . "'>";
        echo "<td>" . $row["tag"] . "</td>";
        echo "<td>" . $date->format("M d - Y H:i") . "</td>";
        if ($_SESSION["isAdmin"]) echo "<td class='inputContainer' style='display: flex; justify-content: center'><input type='checkbox'></td>";
        echo "</tr>";
    }
    echo "</table>";

    echo "<button><a href='createActivity.php'>Opprett aktivitet</a></button>";
    if ($_SESSION["isAdmin"]) {
        echo "<button id='delete' style='float: right'>Slett aktivitet</button>";
    }
    ?>
</div>
<script type="text/javascript">
    $("tr").on('click', (e) => {
        if (e.target.type == "checkbox" || e.target.classList.contains("inputContainer")) return;
        window.location = `activity.php?id=${e.currentTarget.id}`;
    });
    $("#selectAll").on('click', () => {
        $("td").children().toArray().forEach(x => {
            if (x.type == "checkbox") x.checked = $("#selectAll").is(":checked");
        })
    });
    $("#delete").on('click', () => {
        const data = {"idList":  $("td input:checked").toArray().map(x => x.parentElement.parentElement.id)};

        doPost("../service/activity/deleteActivityService.php", data, null, (e) => {
            console.log(e);
        })

        console.log(data)
    })

    $("td input:checked").toArray().forEach(x => {
        console.log(x.parentElement.parentElement.id);
    })
</script>
</body>
</html>
