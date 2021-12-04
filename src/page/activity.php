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

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        include '../service/database/database.php';
        switch ($_POST["mode"]) {
            case "join":
                insert("activityParticipant", "ii", ["memberId" => $_SESSION["userId"],
                    "activityId" => $_POST["activityId"]]);
                break;
            case "leave":
                delete("activityParticipant", "WHERE memberId=? AND activityId=?",
                ["memberId" => $_SESSION["userId"], "activityId" => $_POST["activityId"]], "ii");
                break;
        }
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
        <link rel="stylesheet" href="../stylesheets/overlay.css">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="/service/html/HTTP.js"></script>
        <script type="text/javascript">
            $(() => {
                $("#control").on('click', () => {
                    const params = new URLSearchParams(window.location.search);
                    doPost("", {activityId: params.get("id"), mode: $("#control").attr("mode")}, null, () => {
                        switch ($("#control").attr("mode")) {
                            case "leave":
                                alert("Du er nå meldt av!");
                                break;
                                case "join":
                                    alert("Du er nå meldt på!");
                                    break;
                        }
                        window.location.reload();
                    })
                })
            })
        </script>
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
        <?php
        if(select("COUNT(*)", "activityParticipant", "WHERE memberId=? AND activityId=?", ["memberId" => $_SESSION["userId"], "activityId" => $_GET["id"]], "ii")->fetch_row()[0] != 0) {
            echo "<button mode='leave' id='control' style='float: right; margin-top: 5%'>Meld av</button>";
            return;
        }
        echo "<button id='control' mode='join' style='float: right; margin-top: 5%'>Meld på</button>";
        ?>
    </div>
    </body>
</html>

