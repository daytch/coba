<?php
include "koneksi.php";
$op=ISSET($_GET['op'])?$_GET['op']:null;
if($op=='ambilbarang'){
    $data=mysql_query("SELECT * FROM barang");
    echo"<option>Kode Barang</option>";
    while($r=mysql_fetch_array($data)){
        echo "<option value='$r[barang_id]'>$r[nama_barang]</option>";
    }
}elseif ($op=='ambilsupplier') {
    $supplier=mysql_query("SELECT * FROM supplier");
    echo"<option>Nama Supplier</option>";
    while($r=mysql_fetch_array($supplier)){
        echo "<option value='$r[supplier_id]'>$r[nama_supplier]</option>";
    }
}elseif($op=='ambilbrg'){
    $supplier=$_GET['supplier'];
    $dt=mysql_query("SELECT * FROM barang WHERE supplier_id='$supplier'");
    while($r=mysql_fetch_array($dt)){
        echo "<option value='$r[barang_id]'>$r[nama_barang]</option>";
    }
}elseif($op=='ambildt'){
    $kode=$_GET['brg'];
    $dt=mysql_query("SELECT * FROM barang WHERE barang_id='$kode'");
    $d=mysql_fetch_array($dt);
    echo "<input type='text' value='$d[ukuran]' id='uk' style='width:75px;' readonly>";
}elseif($op=='ambildata'){
    $kode=$_GET['kode'];
    $dt=mysql_query("SELECT * FROM barang WHERE barang_id='$kode'");
    $d=mysql_fetch_array($dt);
    echo $d['nama_barang']."|".$d['ukuran']."|".$d['stok'];
}elseif($op=='trx'){
    $brg=mysql_query("SELECT *,barang.nama_barang,barang.ukuran FROM beli_sementara,barang WHERE barang.barang_id=beli_sementara.barang_id");
    echo "<thead>
            <tr>
                <td>Nama Barang</td>
                <td>Ukuran</td>
                <td>Harga</td>
                <td>Jumlah Beli</td>
                <td>Subtotal</td>
                <td>Tools</td>
            </tr>
        </thead>";
    $total=mysql_fetch_array(mysql_query("SELECT sum(subtotal) as total FROM beli_sementara"));
    while($r=mysql_fetch_array($brg)){
        $harga = rupiah($r['harga']);
        $sub = rupiah($r['subtotal']);
        $ttl = rupiah($total['total']);
        echo "<tr>
                <td>$r[nama_barang]</td>
                <td>$r[ukuran]</td>
                <td>$harga</td>
                <td><input type='text' name='jum' id='jum' value='$r[jumlah]' onchange='gantiJml();' style='width:35px;'>
                <input type='text' id='id' value='$r[id_smntr]' style='width:35px;' class='hidden'>
                <input type='text' id='hrg' value='$r[harga]' style='width:50px;' class='hidden'></td>
                <td>$sub</td>
                <td><a href='pk.php?op=hapusTrx&id=$r[id_smntr]' id='hapus'>Hapus</a></td>
            </tr>";
    }
    echo "<tr>
        <td colspan='4'>Total</td>
        <td colspan='4'><h5><b>$ttl</b></h5></td>
    </tr>";
}elseif($op=='barang'){
    $brg=mysql_query("SELECT *, nama_barang, ukuran FROM pakai_sementara,barang WHERE barang.barang_id=pakai_sementara.barang_id");
    echo "<thead>
            <tr><td>No. </td>
                <td>Nama Barang</td>
                <td>Ukuran</td>
                <td>Jumlah</td>
                <td>Tools</td>
            </tr>
        </thead>";
        $no=1;
    while($r=mysql_fetch_array($brg)){
        echo "<tr>
                <td>$no</td>
                <td>$r[nama_barang]</td>
                <td>$r[ukuran]</td>
                <td>
                    <input type='text' name='jum' id='jum' value='$r[jumlah]' onchange='gantiJumlah();' style='width:35px;'>
                    <input type='text' id='id' value='$r[id]' style='width:35px;' class='hidden'>
                </td>
                <td><a href='pk.php?op=hapus&id=$r[id]' id='hapus'>Hapus</a></td>
            </tr>";
            $no++;
    }

}elseif($op=='bayar'){
    $byr  = $_GET['byr'];
    $nota = $_GET['nota'];
    $ket = $_GET['ket'];
    $tgl = $_GET['tgl'];
    
    $tambah=mysql_query("INSERT INTO pembayaran (bayar_id, keterangan, debit, kredit, tanggal) VALUES ('', '$ket', '', '$byr', '$tgl')");
            mysql_query("UPDATE pembelian SET total=total-'$byr' WHERE no_nota='$nota' ");
    
    if($tambah){
        echo "sukses";
    }else{
        echo "ERROR";
    }
}elseif($op=='tambahBrg'){
    $brg=$_GET['brg'];
    $jumlah=$_GET['jumlah'];
    $harga= $_GET['harga'];
    $supplier= $_GET['supplier'];
    $subtotal=$harga*$jumlah;
    
    $tambah=mysql_query("INSERT INTO beli_sementara (id_smntr, supplier_id, barang_id, harga, jumlah, subtotal)
                        values ('$id','$supplier','$brg','$harga','$jumlah','$subtotal')");
    
    if($tambah){
        echo "sukses";
    }else{
        echo "ERROR";
    }
}elseif($op=='tambah'){
    $kode=$_GET['kode'];
    $jumlah=$_GET['jumlah'];
    $subtotal=$harga*$jumlah;
    
    $tambah=mysql_query("INSERT INTO pakai_sementara (id, barang_id,jumlah)
                        values ('','$kode','$jumlah')");
    
    if($tambah){
        echo "sukses";
    }else{
        echo "ERROR";
    }
}elseif($op=='hapus'){
    $id = $_GET['id'];
    $del=mysql_query("DELETE FROM pakai_sementara WHERE id='$id'");
    if($del){
        echo "<script>window.location='dashboard.php?perangkat=Pemakaian&act=tambah';</script>";
    }else{
        echo "<script>alert('Hapus Data Berhasil');
            window.location='dashboard.php?perangkat=Pemakaian&act=tambah';</script>";
    }
}elseif($op=='hapusTrx'){
    $id = $_GET['id'];
    $del=mysql_query("DELETE FROM beli_sementara WHERE id_smntr='$id'");
    if($del){
        echo "<script>window.location='dashboard.php?perangkat=Pembelian&act=tambah';</script>";
    }else{
        echo "<script>alert('Hapus Data Berhasil');
            window.location='dashboard.php?perangkat=Pembelian&act=tambah';</script>";
    }
}elseif($op=='prosesTrx'){
    $id=$_GET['nota'];
    $tanggal=$_GET['tanggal'];
    $to=mysql_fetch_array(mysql_query("SELECT sum(subtotal) as total FROM beli_sementara"));
    $tot=$to['total'];
    $nom=$to['total'];
    $bl = mysql_fetch_array(mysql_query("SELECT * FROM beli_sementara"));
    $simpan=mysql_query("INSERT INTO pembelian(no_nota, beli_id, tanggal, supplier_id, total, nominal)
                        values ('$id','','$tanggal','$bl[supplier_id]','$tot','$nom')");
    
    if($simpan){
        $q = mysql_fetch_array(mysql_query("SELECT * FROM pembelian WHERE no_nota='$id'"));
        $beli = $q['beli_id'];
        $query=mysql_query("SELECT * FROM beli_sementara");
        while($r=mysql_fetch_array($query)){
            mysql_query("INSERT INTO pembelian_detail(belidetail_id, barang_id, harga, qty, beli_id, subtotal)
                        values('','$r[barang_id]','$r[harga]','$r[jumlah]','$beli', '$r[subtotal]')");
            mysql_query("UPDATE barang SET stok=stok+'$r[jumlah]'
                        WHERE barang_id='$r[barang_id]'");
        }
        //hapus seluruh isi tabel sementara
        mysql_query("TRUNCATE TABLE beli_sementara");
        echo "sukses";
    }else{
        echo "ERROR";
    }
}elseif($op=='proses'){
    $id=$_GET['nota'];
    $tanggal=$_GET['tanggal'];
    $simpan=mysql_query("INSERT INTO pemakaian(id_pakai,tanggal)
                        values ('$id','$tanggal')");
    if($simpan){
        $query=mysql_query("SELECT * FROM pakai_sementara");
        while($r=mysql_fetch_array($query)){
            mysql_query("INSERT INTO pemakaian_detail(id_pakai,id_detail,barang_id,jumlah)
                        values('$id','','$r[barang_id]','$r[jumlah]')");
            mysql_query("UPDATE barang SET stok=stok-'$r[jumlah]'
                        WHERE barang_id='$r[barang_id]'");
        }
        //hapus seluruh isi tabel sementara
        mysql_query("TRUNCATE TABLE pakai_sementara");
        echo "sukses";
    }else{
        echo "ERROR";
    }
}elseif ($op='ganti') {
    $jum = $_GET['jum'];
    $id = $_GET['id'];

    $ganti = mysql_query("UPDATE pakai_sementara SET jumlah='$jum' WHERE id='$id'");

}elseif ($op='gantiJml') {
    $jml = $_GET['jum'];
    $id = $_GET['id'];
    $harga = $_GET['hrg'];
    $j = $jml*$harga;

    $gantiDong = mysql_query("UPDATE beli_sementara SET jumlah='$jml', subtotal='$j' WHERE id_smntr='$id'");

    if($gantiDong){
        echo "sukses";
    }else{
        echo "ERROR";
    }

}
?>