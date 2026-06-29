<?php require 'config.php'; if(!isset($_SESSION['user_id'])) header("Location: index.php"); ?>
<!DOCTYPE html><html><head><title>Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head><body>
<nav class="navbar navbar-dark bg-dark"><div class="container-fluid">
<a class="navbar-brand">UAS Pemweb 2</a>
<a href="logout.php" class="btn btn-outline-light">Logout</a>
</div></nav>
<div class="container mt-4">
  <div class="alert alert-success">Halo, kamu sudah login ✅</div>
  <a href="barang.php" class="btn btn-primary btn-lg">Masuk ke Data Barang [CRUD]</a>
</div></body></html>