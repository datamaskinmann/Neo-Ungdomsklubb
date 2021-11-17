<?php
session_start();

include '../../service/html/htmlService.php';

if (!doFilter()) {
    http_response_code(403);
    return;
}

if (!$_SESSION["isAdmin"]) {
    http_response_code(403);
    return;
}

if (empty($_POST["id"])) {
    http_response_code(400);
    return;
}

include '../database/database.php';

if(!is_array($_POST["id"])) $_POST["id"] = [$_POST["id"]];

delete("activity", "WHERE id in (" . str_repeat("?,",
        count($_POST["id"]) - 1) . "?)", $_POST["idList"],
    str_repeat("i", count($_POST["id"])));