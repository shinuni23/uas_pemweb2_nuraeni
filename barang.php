<?php require 'config.php'; require 'barang1.php';
if(!isset($_SESSION['user_id'])) header("Location: index.php");
$barang = new barang($conn); $msg = '';

if(isset($_POST['simpan'])){ // No 5 Validasi
  if(empty($_POST['nama']) || empty($_POST['stok']) || empty($_POST['harga'])){ 
    $msg = "<div class='alert alert-danger'>Semua field wajib diisi!</div>"; 
  } else { $barang->tambah($_POST, $_FILES); $msg = "<div class='alert alert-success'>Data disimpan</div>"; }
}
if(isset($_GET['hapus'])){ $barang->hapus($_GET['hapus']); header("Location: barang.php"); }

if(isset($_GET['export'])){ // No 3 PDF
  require('fpdf/fpdf.php'); $pdf = new FPDF(); $pdf->AddPage(); $pdf->SetFont('Arial','B',16);
  $pdf->Cell(0,10,'Laporan Data Barang',0,1,'C'); $pdf->Ln(5);
  $pdf->SetFont('Arial','B',12); $pdf->Cell(70,10,'Nama',1); $pdf->Cell(30,10,'Stok',1); $pdf->Cell(40,10,'Harga',1); $pdf->Ln();
  $pdf->SetFont('Arial','',12);
  foreach($barang->getAll() as $d){ $pdf->Cell(70,10,$d['nama_barang'],1); $pdf->Cell(30,10,$d['stok'],1); $pdf->Cell(40,10,'Rp '.$d['harga'],1); $pdf->Ln(); }
  $pdf->Output('D','laporan_barang.pdf'); exit;
}
?>
<!DOCTYPE html><html><head><title>Data Barang</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head><body>
<nav class="navbar navbar-dark bg-dark mb-4"><div class="container-fluid">
<a class="navbar-brand">Data Barang</a><a href="dashboard.php" class="btn btn-sm btn-secondary">Kembali</a>
</div></nav>
<div class="container">
<?= $msg ?>
<div class="card mb-3"><div class="card-body">
  <h5 class="card-title">Tambah Data [Create + Upload]</h5>
  <form method="POST" enctype="multipart/form-data" class="row g-3">
    <div class="col-md-3"><input name="nama" placeholder="Nama Barang" class="form-control" required></div>
    <div class="col-md-2"><input type="number" name="stok" placeholder="Stok" class="form-control" required></div>
    <div class="col-md-2"><input type="number" name="harga" placeholder="Harga" class="form-control" required></div>
    <div class="col-md-3"><input type="file" name="foto" class="form-control"></div>
    <div class="col-md-2"><button name="simpan" class="btn btn-success w-100">Simpan</button></div>
  </form>
</div></div>

<div class="card"><div class="card-body">
  <div class="d-flex justify-content-between mb-3">
    <form method="GET" class="d-flex">
      <input name="keyword" placeholder="Cari barang..." class="form-control me-2" value="<?= $_GET['keyword']?? ''?>">
      <button class="btn btn-primary">Search</button>
    </form>
    <a href="?export=1" class="btn btn-danger">Export PDF</a>
  </div>
  <div class="table-responsive">
  <table class="table table-striped table-hover">
  <thead class="table-dark"><tr><th>Nama</th><th>Stok</th><th>Harga</th><th>Foto</th><th>Aksi</th></tr></thead>
  <tbody>
  <?php foreach($barang->getAll($_GET['keyword']?? '') as $d):?>
  <tr>
    <td><?= $d['nama_barang']?></td><td><?= $d['stok']?></td><td>Rp <?= number_format($d['harga'])?></td>
    <td><?php if($d['foto']): ?><img src="uploads/<?= $d['foto']?>" width="60" class="img-thumbnail"><?php endif;?></td>
    <td><a href="?hapus=<?= $d['id']?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus?')">Hapus</a></td>
  </tr>
  <?php endforeach;?>
  </tbody></table>
  </div>
</div></div>
</div></body></html>