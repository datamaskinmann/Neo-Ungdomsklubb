<?php
    $host = "172.20.0.2";
    $username = "root";
    $password = "root";
    $db = "neo";

    $conn = new mysqli($host, $username, $password, $db);

    if($conn->connect_error) die("An error occurred while connecting to the database");

    function insert($table, $types, $data) {
        global $conn;

        $buffer = "INSERT INTO " . $table . " (";

        $i = 0;
        foreach(array_keys($data) as $key) {
            $buffer .= $i != count($data) -1 ? ($key . ",") : ($key . ")");
            $i++;
        }

        $buffer .= " VALUES (";

        for($i = 0; $i < count($data); $i++) {
            $buffer .= $i != count($data) -1 ? "?," : "?)";
        }
        try {
            $stmt = $conn->prepare($buffer);
            if(!$stmt) {
                echo $conn->error;
                return null;
            }
            $stmt->bind_param($types, ...array_values($data));
        } catch (Exception $e) {
            echo $e->getMessage();
            return null;
        }

        try {
            $res = $stmt->execute();
        } catch (Exception $e) {
            echo $e->getMessage();
            return null;
        }

        return ["insertId" => $conn->insert_id, "result" => $stmt->get_result()];
    }

    function select($what, $table, $suffix, $data, $types) {
        global $conn;

        $buffer = "SELECT " . $what . " FROM " . $table . " " . $suffix;

        $stmt = $conn->prepare($buffer);

        if(!$stmt) {
            echo $conn->error;
            return null;
        }

        if($data != null && $types != null)
        $stmt->bind_param($types, ...array_values($data));

        $stmt->execute();

        return $stmt->get_result();
    }

    function update($table, $condition, $data, $types) {
        global $conn;

        $buffer = "UPDATE " . $table . " SET ";

        $i = 0;
        foreach(array_keys($data) as $key) {
            $buffer .= $i != count($data) -1 ? ($key . "=?,") : ($key . "=?");
            $i++;
        }

        $buffer .= " " . $condition;

        $stmt = $conn->prepare($buffer);

        $stmt->bind_param($types, ...array_values($data));
        $stmt->execute();

        return $stmt->get_result();
    }

    function delete($table, $condition, $data, $types) {
        global $conn;

        $buffer = "DELETE FROM " . $table . " " . $condition;

        $stmt = $conn->prepare($buffer);
        $stmt->bind_param($types, ...array_values($data));

        $stmt->execute();

        return $stmt->get_result();
    }

    function customQuery($query) {
        global $conn;

        $stmt = $conn->prepare($query);

        $stmt->execute();

        return $stmt->get_result();
    }