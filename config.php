<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "uas_pw2");
if (!$conn) die("Koneksi gagal");
?>