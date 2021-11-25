<?php

    include '../service/html/htmlService.php';
    session_start();
    if (!doFilter()) {
        http_response_code(403);
        return;
    }

    if(empty($_GET["id"])) {
        http_response_code(400);
        return;
    }
    ?>
<html>
    <head>
        <link rel="stylesheet" href="../stylesheets/body.css">
        <link rel="stylesheet" href="../stylesheets/box.css">
        <link rel="stylesheet" href="../stylesheets/input.css">
        <link rel="stylesheet" href="../stylesheets/header.css">
        <link rel="stylesheet" href="../stylesheets/center.css">
        <link rel="stylesheet" href="../stylesheets/h.css">
        <link rel="stylesheet" href="../stylesheets/icons.css"/>
        <link rel="stylesheet" href="../stylesheets/button.css">
        <link rel="stylesheet" href="../stylesheets/a.css">
        <link rel="stylesheet" href="../stylesheets/icons.css">
    </head>
    <body>
    <?php
        getHeader();

        include '../service/database/database.php';

        $res = select("tag, description, date", "activity", "WHERE id=?", [$_GET["id"]], "i")->fetch_assoc();
    ?>
    <div class="center">
        <h1><?php global $res; echo $res["tag"]; ?></h1>
        <h4 style="color: gray;"><span class="clock" style="height: 0.75em; width: 0.75em; margin-right: 0.5em;
         display: inline-block"></span> <?php
            include '../service/time/dateFormatter.php';

            global $res;

            $date = stringToDate($res["date"]);

            echo $date->format("M d - Y H:i");
            ?></h4>
        <p>
            <?php global $res; echo $res["description"] ?>
        </p>
        <button style="float: right; margin-top: 5%">Meld på</button>
    </div>
    </body>
</html>

