<?php

$conn = mysqli_connect("localhost", "root", "", "jumpin");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
session_start();
?>