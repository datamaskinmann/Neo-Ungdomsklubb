<?php

    // Service for creating an activity

    session_start();

    include '../../service/html/htmlService.php';

    if(!doFilter()) {
        http_response_code(403);
        return;
    }

    include  $_SERVER["DOCUMENT_ROOT"] . '/service/database/database.php';

    insert("activity", "sss", [
        "tag" => $_POST["tag"],
        "date" => $_POST["date"],
        "description" => $_POST["description"]
    ]);
