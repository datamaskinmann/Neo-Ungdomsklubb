<?php
include '../service/html/htmlService.php';
session_start();
if (!doFilter()) {
    http_response_code(403);
    return;
}
?>

<style>
    input {
        width: 100%;
    }
</style>
<html>
<head>
    <link rel="stylesheet" href="../stylesheets/body.css">
    <link rel="stylesheet" href="../stylesheets/box.css">
    <link rel="stylesheet" href="../stylesheets/input.css">
    <link rel="stylesheet" href="../stylesheets/header.css">
    <link rel="stylesheet" href="../stylesheets/activitiesTable.css">
    <link rel="stylesheet" href="../stylesheets/center.css">
    <link rel="stylesheet" href="../stylesheets/h.css">
    <link rel="stylesheet" href="../stylesheets/a.css">
    <link rel="stylesheet" href="../stylesheets/icons.css">
    <link rel="stylesheet" href="../stylesheets/button.css">
    <link rel="stylesheet" href="../stylesheets/overlay.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
</head>
<body>
<?php
    getHeader();
?>
<div class="center" style="top: 35%; width: 40%; display: flex; justify-content: center">
    <div class="box">
        <form action="../service/activity/createActivityService.php" method="POST">
            <h1>Opprett en aktivitet</h1>
            <h3>Tittel</h3>
            <input required name="tag" style="width: 100%; margin: 0" type="text"/>
            <h3>Dato</h3>
            <input name="date" type="datetime-local"/>
            <h3>Beskrivelse</h3>
            <textarea required name="description" style="height: 10em;
            background-color: #e1eedd; border: none; width: 100%;"></textarea>
            <input required type="submit" value="Send inn" style="position: fixed; "/>
        </form>
    </div>
</div>
</body>
</html>