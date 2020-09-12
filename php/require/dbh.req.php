<?php

    $dBServername = "remotemysql.com";
    $dBUsername = "P44nXX5yhC";
    $dBPassword = "9koDfwra9t";
    $dBName = "P44nXX5yhC";

    $conn = mysqli_connect($dBServername, $dBUsername, $dBPassword, $dBName);
    $conn->set_charset("utf8");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }