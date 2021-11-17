<?php
    include "../../service/database/database.php";

    if(!empty($_POST["submit"])) {
        print_r($_POST);
        $insert = insert("adress", "sss",
            ["street" => $_POST["street"],
                "postalCode" => $_POST["postalCode"],
                "city" => $_POST["city"]]);

        if($insert["result"] > 0) {
            $insert = insert("member", "ssssssi",
            ["firstname" => $_POST["firstname"],
                "lastname" => $_POST["lastname"],
                "phonenumber" => $_POST["phonenumber"],
                "email" => $_POST["email"],
                "password" => $_POST["password"],
                "gender" => $_POST["gender"],
                "adressId" => $insert["insertId"]]);
        }
    }