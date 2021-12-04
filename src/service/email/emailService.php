<?php

    include '../html/htmlService.php';

    session_start();

    if(!doFilter()) {
        http_response_code(403);
        return;
    }

    if(!$_SESSION["isAdmin"]) {
        http_response_code(403);
        return;
    }

$headers = array("From: styret@neoungdomsklubb.no",
    "Reply-To: styret@neoungdomsklubb.no",
    "X-Mailer: PHP/" . PHP_VERSION
);

    if(empty($_POST["emailList"])
            || empty($_POST["subject"]
            || empty($_POST["content"])
            || !is_array($_POST["emailList"]))) {
        http_response_code(400);
        return;
    }

    mail(join(",", $_POST["emailList"]), $_POST["subject"], $_POST["content"], $headers);
