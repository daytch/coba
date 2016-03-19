<?php
include "koneksi.php";
$data=mysql_query("SELECT * from barang");
$op=isset($_GET['op'])?$_GET['op']:null;

if($op=='kode'){
    echo"<option>Kode Barang</option>";
    while($r=mysql_fetch_array($data)){
        echo "<option value='$r[kode]'>$r[kode]</option>";
    }
}elseif($op=='barang'){
    echo'<table id="barang" class="table table-hover">
    <thead>
            <tr>
                <Td colspan="5"><a href="?page=barang&act=tambah" class="btn btn-primary">Tambah Barang</a></td>
            </tr>
            <tr>
                <td>Kode Barang</td>
                <td>Nama Barang</td>
                <td>Harga</td>
                <td>Stok</td>
                <td>Jumlah</td>
            </tr>
        </thead>';
	while ($b=mysql_fetch_array($data)){
        echo"<tr>
                <td>$b[id_barang]</td>
                <td>$b[nama]</td>
                <td>$b[harga]</td>
                <td>$b[stok]</td>
                <td>$b[jumlah]</td>
            </tr>";
        }
    echo "</table>";
}elseif($op=='ambildata'){
    $kode=$_GET['kode'];
    $dt=mysql_query("SELECT * from barang where barang_id='$kode'");
    $d=mysql_fetch_array($dt);
    echo $d['ukuran']."|".$d['stok'];
}elseif($op=='cek'){
    $kode=$_GET['kode'];
    $sql=mysql_query("SELECT * from barang where id_barang='$kode'");
    $cek=mysql_num_rows($sql);
    echo $cek;
}elseif($op=='update'){
    $kode=$_GET['kode'];
    $nama=htmlspecialchars($_GET['nama']);
    $harga=htmlspecialchars($_GET['harga']);
    $stok=htmlspecialchars($_GET['stok']);
    
    $update=mysql_query("UPDATE barang SET nama='$nama',
                        harga='$harga',
                        stok='$stok'
                        WHERE id_barang='$kode'");
    if($update){
        echo "Sukses";
    }else{
        echo "ERROR. . .";
    }
}elseif($op=='delete'){
    $kode=$_GET['kode'];
    $del=mysql_query("DELETE FROM barang where id_barang='$kode'");
    if($del){
        echo "sukses";
    }else{
        echo "ERROR";
    }
}elseif($op=='simpan'){
    $kode=$_GET['kode'];
    $nama=htmlspecialchars($_GET['nama']);
    $harga=htmlspecialchars($_GET['harga']);
    $stok=htmlspecialchars($_GET['stok']);
    
    $tambah=mysql_query("INSERT INTO barang (id_barang,nama,harga,stok)
                        values ('$kode','$nama','$harga','$stok')");
    if($tambah){
        echo "sukses";
    }else{
        echo "error";
    }
}
?>