<?php

    error_reporting(0);

    session_start();

    include '../database/database.php';

    $row = select("id, email", "member", "WHERE email=? AND password=?",
        [$_POST["email"], $_POST["password"]], "ss")->fetch_assoc();

    if(!is_null($row)) {
        $_SESSION["username"] = $row["email"];

        $row = select("COUNT(*)", "admin", "WHERE memberId=?", [$row["id"]], "i")->fetch_row()[0];

        if($row > 0) {
            $_SESSION["isAdmin"] = true;
        } else {
            $_SESSION["isAdmin"] = false;
        }

        header("location: ../../page/activities.php");
    } else {
        echo "feil";
    }
