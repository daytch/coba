<?php
if (version_compare(phpversion(), '5.3.0', '>=') == 1) {
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
} else {
    error_reporting(E_ALL & ~E_NOTICE);
}
//konfigurasi
ini_set('display_errors',FALSE);
$host="localhost";
$user="root";
$pass="1991462";
$db="roti";

//koneksi 
$koneksi=mysql_connect($host,$user,$pass);
mysql_SELECT_db($db,$koneksi);
//$tanggal=date("d/M/y");

//cek
if ($koneksi)
{
	//echo "Berhasil terkoneksi ke database..!!";
}else{
?>
    <script language="javascript">alert("Gagal Koneksi Database MySql !!")</script>
<?php
}

if ( ! function_exists('bulan'))
{
    function bulan($bln)
    {
        switch ($bln)
        {
            case 1:
                return "Januari";
                break;
            case 2:
                return "Februari";
                break;
            case 3:
                return "Maret";
                break;
            case 4:
                return "April";
                break;
            case 5:
                return "Mei";
                break;
            case 6:
                return "Juni";
                break;
            case 7:
                return "Juli";
                break;
            case 8:
                return "Agustus";
                break;
            case 9:
                return "September";
                break;
            case 10:
                return "Oktober";
                break;
            case 11:
                return "November";
                break;
            case 12:
                return "Desember";
                break;
        }
    }
}

if( ! function_exists('rupiah'))
{
    function rupiah($rp)
    {
        $jadi = "Rp " . number_format($rp,0,',','.');
        return $jadi;
    }
}

//format tanggal yyyy-mm-dd
if ( ! function_exists('tgl_indo'))
{
    function tgl_indo($tgl)
    {
        $ubah = gmdate($tgl, time()+60*60*8); 
        $pecah = explode("-",$ubah);  //memecah variabel berdasarkan -
        $tanggal = $pecah[2]; 
        $bulan = bulan($pecah[1]);
        $tahun = $pecah[0];
        return $tanggal.' '.$bulan.' '.$tahun; //hasil akhir
    }
}

//format tanggal timestamp
if( ! function_exists('tgl_indo_timestamp')){
 
function tgl_indo_timestamp($tgl)
{
    $inttime = date("Y-m-d H:i:s", strtotime($tgl));//mengubah format menjadi tanggal biasa
    $tglBaru=explode(" ",$inttime); //memecah berdasarkan spaasi
     
    $tglBaru1=$tglBaru[0]; //mendapatkan variabel format yyyy-mm-dd 
    $tglBaru2=$tglBaru[1]; //mendapatkan fotmat hh:ii:ss
    $tglBarua=explode("-",$tglBaru1); //lalu memecah variabel berdasarkan -
 
    $tgl=$tglBarua[2];
    $bln=$tglBarua[1];
    $thn=$tglBarua[0];
 
    $bln=bulan($bln); //mengganti bulan angka menjadi text dari fungsi bulan
    $ubahTanggal="$tgl $bln $thn | $tglBaru2 "; //hasil akhir tanggal
 
    return $ubahTanggal;
}
}

function kodeSupplier(){
    $host="localhost";
    $user="root";
    $pass="1991462";
    $db="roti";

    //koneksi 
    $koneksi=mysql_connect($host,$user,$pass);
    mysql_SELECT_db($db,$koneksi);

    $chek= mysql_query("SELECT kode_supplier FROM supplier ORDER BY supplier_id DESC");
    if(mysql_num_rows($chek)>0){
        $chek=mysql_fetch_array($chek);
        $lastKode=$chek['kode_supplier'];
        $ambil=  substr($lastKode, 2,3)+1;
        $newCode=  "SP".sprintf("%03s",$ambil);
        return $newCode;
    }
    else{
        return 'SP001';
    }
}


function num($rp){
if($rp!=0){
    $hasil = number_format($rp, 0, ',', '.');
    }
    else{
    $hasil=0;
    }
return $hasil;
}
?>
