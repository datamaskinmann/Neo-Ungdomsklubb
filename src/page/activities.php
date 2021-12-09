<?php

// The page that displays an overview over all the available activities
include "../service/html/htmlService.php";
session_start();
if (!doFilter()) { // if you are not logged in
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
    <link rel="stylesheet" href="../stylesheets/overlay.css">
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

getHeader(); // Prints the header (navigation bar)
?>
<div class="center" style="width: auto">
    <h1>Aktiviteter</h1>
    <?php
    $activities = getAllActivities();

    // Make a table of all available activities
    echo "<table>
    <tr>
        <th>Beskrivelse</th>
        <th>Dato</th>";
    // Display an option for selecting an activity if you are an admin
    if ($_SESSION["isAdmin"]) echo "<th style='display: flex; justify-content: center'><input type='checkbox' id='selectAll'></th>";
    include '../service/time/dateFormatter.php';
    echo "</tr>";
    while ($row = mysqli_fetch_array($activities)) {
        $date = stringToDate($row["date"]);

        echo "<tr id='" . $row["id"] . "'>";
        echo "<td>" . $row["tag"] . "</td>";
        echo "<td>" . $date->format("M d - Y H:i") . "</td>";
        // Display an option to select the activity if you are an admin
        // For deleting the activity
        if ($_SESSION["isAdmin"]) echo "<td class='inputContainer' style='display: flex; justify-content: center'><input type='checkbox'></td>";
        echo "</tr>";
    }
    echo "</table>";

    echo "<button><a href='createActivity.php'>Opprett aktivitet</a></button>";
    // Display a delete button for the activity if the user is an admin
    if ($_SESSION["isAdmin"]) {
        echo "<button id='delete' style='float: right'>Slett aktivitet</button>";
    }
    ?>
</div>
<script type="text/javascript">
    // When clikcing on a row
    $("tr").on('click', (e) => {
        // Ignore if the user clicked a checkbox or an an input
        if (e.target.type == "checkbox" || e.target.classList.contains("inputContainer")) return;
        // Redirect the user to a page displaying the activity
        window.location = `activity.php?id=${e.currentTarget.id}`;
    });
    // When clicking the checkbox that allows the option for deleting all activities
    $("#selectAll").on('click', () => {
        // Find all checkboxes and set them to be selected
        $("td").children().toArray().forEach(x => {
            if (x.type == "checkbox") x.checked = $("#selectAll").is(":checked");
        })
    });
    // When clicking the delete button
    $("#delete").on('click', () => {
        // Make a map containing all activity ids of the clicked activities
        const data = {"idList":  $("td input:checked").toArray().map(x => x.parentElement.parentElement.id)};

        if(confirm("Er du sikker på at du vil slette aktiviteten(e)?")) {
            doPost("../service/activity/deleteActivityService.php", data, null, () => {
                window.location.reload();
            })
        }
    })
</script>
</body>
</html>
