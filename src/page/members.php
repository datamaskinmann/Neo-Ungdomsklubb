<?php
include "../service/html/htmlService.php";
session_start();
if (!doFilter()) {
    http_response_code(403);
    return;
}

if (!$_SESSION["isAdmin"]) {
    http_response_code(403);
    return;
}

?>

<html>
<style>
    h3 {
        color: #f6c453;
    }

    li {
        transition: opacity 0.25s;
        opacity: 1;
        margin: 1em;
    }

    li:hover {
        transition: opacity 0.25s;
        opacity: 0.75;
    }

    input:hover {
        cursor: pointer;
    }

    textarea {
        width: 100%;
        height: 100%;
        background-color: #e1eedd;
        border: none;
    }

    hr {
        background-color: #e1eedd;
        height: 2px;
        border-width: 0;
        color: #e1eedd;
        border-color: #e1eedd;
    }

    ul {
        width: 100%;
        list-style: none;
        padding: 0;
        margin-right: 1em;
    }

    input[type=submit] {
        background-color: #183a1d;
        color: white;
        width: 40%;
        float: right;
        margin: 1em auto;
        padding: 0.5em;
        transition: opacity 0.25s;
        opacity: 1;
        border-radius: 1em;
    }

    input[type=submit]:hover {
        transition: 0.25s;
        opacity: 0.75;
        cursor: pointer;
    }

    input[type=text] {
        background-color: #e1eedd;
        margin-bottom: 0.5em;
        width: 100%;
    }
</style>
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
<body>
<?php
include "../service/activity/activityService.php";

getHeader();
?>
<div style="width: 100%; display: flex; justify-content: center">
    <h2>Medlemsoversikt</h2>
</div>
<div style="max-height: 85%; overflow-y: auto; display: flex; flex-direction: row; justify-content: center">
    <div style="width: 25%; overflow-y: auto">
        <?php
        include '../service/database/advancedQueries.php';
        include '../service/database/filtering.php';

        $activityParticipants = getAllActivityParticipants()->fetch_all(MYSQLI_ASSOC);
        $interests = getAllInterests()->fetch_all(MYSQLI_ASSOC);
        $contingencyState = getAllContingencyState()->fetch_all(MYSQLI_ASSOC);
        $pastMembers = getAllPastMembers()->fetch_all(MYSQLI_ASSOC);

        echo "<div id='emailListContainer'>";
        echo "<h2>Aktiviteter</h2>";
        foreach (filterResultByAttributeUnique($activityParticipants, "tag") as $tag) {
            echo "<h3>" . $tag . "</h3>";
            echo "<ul>";
            foreach (filterResultByAttributeValue($activityParticipants, "tag", $tag) as $member) {
                echo "<li>";
                echo "<div>";
                echo $member["firstname"] . " " . $member["lastname"] . " (" . $member["email"] . ")";
                echo "<input email='" . $member["email"] . "' type='checkbox' style='float: right;'/>";
                echo "</div>";
                echo "</li>";
            }
            echo "</ul>";
        }
        echo "<h2>Interesser</h2>";
        foreach (filterResultByAttributeUnique($interests, "tag") as $interest) {
            echo "<h3>" . mb_strtoupper($interest[0]) . substr($interest, 1) . "</h3>";
            echo "<ul>";
            foreach (filterResultByAttributeValue($interests, "tag", $interest) as $member) {
                echo "<li>";
                echo "<div>";
                echo $member["firstname"] . " " . $member["lastname"] . " (" . $member["email"] . ")";
                echo "<input email='" . $member["email"] . "' type='checkbox' style='float: right;'/>";
                echo "</div>";
                echo "</li>";
            }
            echo "</ul>";
        }
        echo "<h2>Kontingentstatus</h2>";
        foreach (filterResultByAttributeUnique($contingencyState, "status") as $status) {
            echo "<h3>" . $status . "</h3>";
            echo "<ul>";
            foreach (filterResultByAttributeValue($contingencyState, "status", $status) as $member) {
                echo "<li>";
                echo "<div>";
                echo $member["firstname"] . " " . $member["lastname"] . " (" . $member["email"] . ")";
                echo "<input email='" . $member["email"] . "' type='checkbox' style='float: right;'/>";
                echo "</div>";
                echo "</li>";
            }
            echo "</ul>";
        }
        echo "<h2>Tidligere medlemmer</h2>";
        foreach($pastMembers as $member) {
            echo "<li>";
            echo "<div>";
            echo $member["firstname"] . " " . $member["lastname"] . " (" . $member["email"] . ")";
            echo "<input email='" . $member["email"] . "' type='checkbox' style='float: right;/>";
            echo "</div>";
            echo "</li>";
        }
        echo "</div>";
        ?>
    </div>
    <div style="width: 25%; border: 2px solid #e1eedd;">
    <textarea readonly id="selected">

    </textarea>
    </div>
</div>
</body>
<script type="text/javascript">
    $("input[type='checkbox']").on('change', (e) => {
        let email = e.target.attributes["email"].value;
        $("input[email='" + email + "']").prop("checked", e.target.checked);

        let emailList = [];
        $("input:checked").toArray().forEach((x) => {
            if(!emailList.includes(x.attributes["email"].value)) emailList.push(x.attributes["email"].value);
        })

        $("#selected").val(emailList.join(',\n'));
    });
</script>
</html>
