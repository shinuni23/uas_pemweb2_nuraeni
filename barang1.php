<?php
class barang {
  private $db; // Enkapsulasi
  public function __construct($db){ $this->db = $db; } // Constructor

  public function getAll($cari=''){ // Read + Search No 2
    $sql = "SELECT * FROM barang WHERE nama_barang LIKE '%$cari%'";
    return mysqli_query($this->db, $sql);
  }
  public function tambah($data, $file){ // Create + Upload No 5
    $nama = $data['nama']; $stok = $data['stok']; $harga = $data['harga'];
    $foto = '';
    if($file['foto']['name']!= ''){
      $ekstensi = pathinfo($file['foto']['name'], PATHINFO_EXTENSION);
      if(in_array($ekstensi, ['jpg','png','jpeg'])){ // Validasi
        $nama_baru = time().'.'.$ekstensi;
        move_uploaded_file($file['foto']['tmp_name'], 'uploads/'.$nama_baru);
        $foto = $nama_baru;
      }
    }
    mysqli_query($this->db, "INSERT INTO barang (nama_barang,stok,harga,foto) VALUES('$nama','$stok','$harga','$foto')");
  }
  public function hapus($id){ mysqli_query($this->db, "DELETE FROM barang WHERE id=$id"); } // Delete
}
?>