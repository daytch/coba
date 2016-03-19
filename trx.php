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
    $kode   =  $_GET['kode'];
    $dt     = mysql_query("SELECT * FROM produk WHERE kode='$kode'");
    $r      = mysql_fetch_row($dt);
    $harga  = rupiah($r[2]);
        echo "<div class='form-group'>
                    <label class='col-sm-3 control-label'>Nama:</label>
                    <div class='col-sm-6'>
                        <input class='form-control' type='text' id='nama' value='$r[1]' disabled>
                    </div>
                </div>";
        echo "  <div class='form-group'>
                    <label class='col-sm-3 control-label'>Harga:</label>
                    <div class='col-sm-6'>
                        <input class='form-control' type='text' id='hrg' value='$harga' disabled>
                        <input class='form-control hidden' type='text' id='harga' value='$r[2]'>
                    </div>
                </div>";
        echo " <div class='form-group'>
                    <label class='col-sm-3 control-label'>Stok:</label>
                    <div class='col-sm-6'>
                        <input class='form-control' type='text' id='stok' value='$r[3]' disabled>
                        <input class='form-control hidden' type='text' id='id' value='$r[0]'>
                    </div>
                </div>";

}elseif($op=='ambildt'){
    $kode=$_GET['brg'];
    $dt=mysql_query("SELECT * FROM barang WHERE barang_id='$kode'");
    $d=mysql_fetch_array($dt);
    echo "<input type='text' value='$d[ukuran]' id='uk' style='width:75px;' readonly>";
}elseif($op=='trx'){
   $brg=mysql_query("SELECT *,produk.nama_produk FROM transaksi_sementara,produk WHERE produk.produk_id=transaksi_sementara.produk_id");
    echo "<thead>
            <tr>
                <td>Nama Barang</td>
                <td>Harga</td>
                <td>Jumlah</td>
                <td>Subtotal</td>
                <td>Tools</td>
            </tr>
        </thead>";
    $total=mysql_fetch_array(mysql_query("SELECT sum(subtotal) as total FROM transaksi_sementara"));
    while($r=mysql_fetch_array($brg)){
        $harga = rupiah($r['harga']);
        $sub = rupiah($r['subtotal']);
        $ttl = rupiah($total['total']);
        echo "<tr>
                <td>$r[nama_produk]</td>
                <td>$harga</td>
                <td class='text-center'>$r[jumlah]</td>
                <td>$sub</td>
                <td><a href='trx.php?op=hapusTrx&id=$r[id_smntr]' id='hapus' class='btn btn-minier btn-danger fa fa-trash-o'> Hapus</a></td>
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
                <td><a href='trx.php?op=hapus&id=$r[id]' id='hapus'>Hapus</a></td>
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
    $id = $_GET['id'];
    $jumlah = $_GET['jumlah'];
    $harga = $_GET['harga'];
    $subtotal=$harga*$jumlah;
    
    $tambah=mysql_query("INSERT INTO transaksi_sementara (id_smntr, produk_id, harga, jumlah, subtotal)
                        values ('','$id','$harga','$jumlah','$subtotal')");
    
    if($tambah){
        echo "sukses";
    }else{
        echo "ERROR";
    }
}elseif($op=='hapusTrx'){
    $id = $_GET['id'];
    $del=mysql_query("DELETE FROM transaksi_sementara WHERE id_smntr='$id'");
    if($del){
        echo "<script>window.location.href = document.referrer;</script>";
    }else{
        echo "<script>alert('Hapus Data Berhasil');
            window.location.href = document.referrer;</script>";
    }
}elseif($op=='prosesTrx'){
    $id=$_GET['nota'];
    $tanggal=$_GET['tanggal'];
    $metode=$_GET['metode'];
    $to=mysql_fetch_array(mysql_query("SELECT sum(subtotal) as total FROM transaksi_sementara"));
    $tot=$to['total'];
    $bl = mysql_fetch_array(mysql_query("SELECT * FROM transaksi_sementara"));
    $simpan=mysql_query("INSERT INTO transaksi(no_nota, trx_id, tanggal, total, metode)
                        values ('$id','','$tanggal','$tot', '$metode')");
    if($simpan){
        $q = mysql_fetch_array(mysql_query("SELECT * FROM transaksi WHERE no_nota='$id'"));
        $beli = $q['trx_id'];
        $query=mysql_query("SELECT * FROM transaksi_sementara");
        while($r=mysql_fetch_array($query)){
            mysql_query("INSERT INTO transaksi_detail(trxdetail_id, produk_id, harga, qty, trx_id, subtotal)
                        values('','$r[produk_id]','$r[harga]','$r[jumlah]','$beli', '$r[subtotal]')");
            mysql_query("UPDATE produk SET stok=stok-'$r[jumlah]'
                        WHERE produk_id='$r[produk_id]'");
        }
        //hapus seluruh isi tabel sementara
        mysql_query("TRUNCATE TABLE transaksi_sementara");
        echo "sukses";
    }else{
        echo "ERROR";
    }
}elseif($op=='edit'){
    $id=$_GET['id'];
    
    $r=mysql_fetch_array(mysql_query("SELECT td.*,p.nama_produk 
                                    FROM transaksi_detail AS td, produk AS p 
                                    WHERE td.produk_id=p.produk_id AND trxdetail_id='$id'"));
    
    echo "<form role='form' class='form-horizontal' method='POST'> 
            <div class='form-group'>
                <label class='col-sm-2 control-label'>Nama</label>
                <div class='col-sm-4'>
                    <input type='text' id='nama' readonly='' class='form-control ' name='nama' value='$r[nama_produk]'>
                    <input type='text' id='trx' class='form-control hidden' name='id' value='$r[trxdetail_id]'>
                </div>
            </div>
            <div class='form-group'>
                <label class='col-sm-2 control-label'>Harga</label>
                <div class='col-sm-4'>
                    <input type='text' class='form-control' id='hrg' name='harga' id='harga' value='$r[harga]'>
                </div>
            </div>
            <div class='form-group'>
                <label class='col-sm-2 control-label'>Jumlah</label>
                <div class='col-sm-4'>
                    <input type='text' id='qty' class='form-control' name='jumlah' value='$r[qty]'>
                </div>
            </div>
            <div class='modal-footer'>
                <button class='btn btn-primary  text-center' type='submit' name='edit-trx'><span class='fa fa-hdd-o'></span> Simpan</button>
            </div>
        </form>";

}elseif($op=='proses'){
    $id=$_GET['nota'];
    $tanggal=$_GET['tanggal'];
    $to=mysql_fetch_array(mysql_query("SELECT sum(subtotal) as total FROM tblsementara"));
    $tot=$to['total'];
    $simpan=mysql_query("INSERT INTO pemakaian(id_pakai,tanggal)
                        values ('$id','$tanggal')");
    if($simpan){
        $query=mysql_query("SELECT * FROM pakai_sementara");
        while($r=mysql_fetch_array($query)){
            mysql_query("INSERT INTO pemakaian_detail(id_pakai,id_detail,id_barang,jumlah)
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
}

?>