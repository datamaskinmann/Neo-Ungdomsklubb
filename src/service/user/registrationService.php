<?php
include "../../service/database/database.php";

if (!empty($_POST["submit"])) {
    $insert = insert("adress", "sss",
        ["street" => $_POST["street"],
            "postalCode" => $_POST["postalCode"],
            "city" => $_POST["city"]]);

    if ($insert["insertId"] > 0) {
        $insert = insert("member", "ssssssi",
            ["firstname" => $_POST["firstname"],
                "lastname" => $_POST["lastname"],
                "phonenumber" => $_POST["phonenumber"],
                "email" => $_POST["email"],
                "password" => $_POST["password"],
                "gender" => $_POST["gender"],
                "adressId" => $insert["insertId"]]);

        insert("contingencyStatus", "is", ["memberId" => $insert["insertId"], "status" => "UNPAID"]);

        foreach (explode(",", mb_strtolower($_POST["interests"])) as $interest) {
            $interest = trim($interest);

            $elem = select("id", "interest", "WHERE tag=?", ["tag" => $interest], "s")->fetch_assoc();

            $interestId = 0;

            if ($elem != null) {
                $interestId = $elem["id"];
            } else {
                $interestId = insert("interest", "s", ["tag" => $interest])["insertId"];
            }
            insert("memberInterest", "ii", ["memberId" => $insert["insertId"], "interestId" => $interestId]);
        }
    }
}