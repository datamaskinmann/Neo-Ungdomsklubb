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

    ul {
        width: 100%;
        list-style: none;
        padding: 0;
        margin-right: 1em;
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
    <h2>Send en epost</h2>
</div>
<div style="width: auto; max-height: 80%; position: absolute; left: 50%; transform: translateX(-50%); overflow-y: auto">
    <?php
    include '../service/database/advancedQueries.php';

    $activityParticipants = getAllActivityParticipants()->fetch_all(MYSQLI_ASSOC);
    $interests = getAllInterests()->fetch_all(MYSQLI_ASSOC);
    $contingencyState = getAllContingencyState()->fetch_all(MYSQLI_ASSOC);



    echo "<div id='emailListContainer'>";
    foreach(filterResultByAttributeUnique($activityParticipants, "tag") as $tag) {
        echo "<h3>" . $tag . "</h3>";
        echo "<ul>";
        foreach(filterResultByAttributeValue($activityParticipants, "tag", $tag) as $member) {
            echo "<li>";
            echo "<div>";
            echo $member["firstname"] . " " . $member["lastname"] . " (" . $member["email"] . ")";
            echo "<input email='" . $member["email"] . "' type='checkbox' style='float: right;'/>";
            echo "</div>";
            echo "</li>";
        }
        echo "</ul>";
    }
    echo "</div>";

    function filterResultByAttributeValue($result, $attribute, $value) {
        $ret = [];

        $index = 0;
        for($i = 0; $i < count($result); $i++) {
            if($result[$i][$attribute] != $value) continue;
            $ret[$index] = $result[$i];
            $index++;
        }
        return $ret;
    }

    function filterResultByAttributeUnique($result, $attribute) {
        $ret = [];

        for($i = 0; $i < count($result); $i++) {
            if(!in_array($result[$i][$attribute], $ret)) array_push($ret, $result[$i][$attribute]);
        }

        return $ret;
    }
    ?>
</div>
<script type="text/javascript">

</script>
</body>
</html>
