<?php 
	require_once('layout/header.php'); 
	require_once('layout/sidebar.php');
?>
  
<div class="container-fluid" id="pcont">
	<!-- <div class="page-head">
		<h2>Welcome</h2>
		<ol class="breadcrumb">
			<li><a href="dashboard.php"><i class="glyphicon glyphicon-home"></i> Home</a></li>
		</ol>
	</div>    -->
	<div class="cl-mcont">
<!-- ===================================== Content Here ===================================== -->
		<!-- Start Management -->
		<?php 
			if (isset($_GET['users'])) { //Users
				if ($_GET['users'] == 'Admin') {
					include('tabel/tabel_admin.php');
				}elseif ($_GET['users'] == 'Operator') {
					include('tabel/tabel_operator.php');
				}elseif ($_GET['users'] == 'create-admin') {
					include('form/create_admin.php');
					include('core/create.php');
				}elseif ($_GET['users'] == 'create-operator') {
					include('form/create_operator.php');
					include('core/create.php');
				}
			}elseif (isset($_GET['edit-admin'])) {				
				include('form/edit_admin.php');
			}elseif (isset($_GET['edit-supplier'])) {
				include('form/edit_supplier.php');
			}elseif (isset($_GET['edit-operator'])) {				
				include('form/edit_operator.php');
			}elseif (isset($_GET['del-admin'])) {				
				include('core/delete.php');
			}elseif (isset($_GET['del-operator'])) {				
				include('core/delete.php');
			}elseif (isset($_GET['perangkat'])) { //Perangkat
				if ($_GET['perangkat'] == 'Pembelian') {
					include('tabel/tabel_pembelian.php');
				}elseif ($_GET['perangkat'] == 'lap_stokproduk') {				
					include('tabel/lap_stokproduk.php');
				}elseif ($_GET['perangkat'] == 'lap_stokbarang') {				
					include('tabel/lap_stokbarang.php');
				}elseif ($_GET['perangkat'] == 'create-beli') {
					include('form/create_beli.php');
					include('core/create.php');
				}elseif ($_GET['perangkat'] == 'create-prive') {
					include('form/create_prive.php');
					include('core/create.php');
				}elseif ($_GET['perangkat'] == 'create-special') {
					include('form/create_special.php');
					include('core/create.php');
				}elseif ($_GET['perangkat'] == 'create-brg') {
					include('form/create_brg.php');
					include('core/create.php');
				}elseif ($_GET['perangkat'] == 'create-modal') {
					include('form/create_modal.php');
					include('core/create.php');
				}elseif ($_GET['perangkat'] == 'Cash') {
					include('tabel/tabel_cash.php');
				}elseif ($_GET['perangkat'] == 'Jaminan') {
					include('tabel/tabel_jaminan.php');
				}elseif ($_GET['perangkat'] == 'Transaksi') {
					include('tabel/tabel_transaksi.php');
				}elseif ($_GET['perangkat'] == 'Produk') {
					include('tabel/tabel_produk.php');
				}elseif ($_GET['perangkat'] == 'Home') {
					include('home.php');
				}elseif ($_GET['perangkat'] == 'Jaminan') {
					include('tabel/tabel_jaminan.php');
				}elseif ($_GET['perangkat'] == 'Supplier') {
					include('tabel/tabel_supplier.php');
				}elseif ($_GET['perangkat'] == 'Pemakaian') {
					include('tabel/tabel_pemakaian.php');
				}elseif ($_GET['perangkat'] == 'Backup') {
					include('tabel/backup.php');
				}elseif ($_GET['perangkat'] == 'Laporan') {
					include('tabel/laporan.php');
				}elseif ($_GET['perangkat'] == 'Barang') {
					include('tabel/tabel_barang.php');
				}elseif ($_GET['perangkat'] == 'AjaxPakai') {
					include('ajax/ajax_pemakaian.php');
				}elseif ($_GET['perangkat'] == 'Lap-Penjualan') {
					include('tabel/lap_penjualan.php');
				}elseif ($_GET['perangkat'] == 'Pakai') {
					include('tabel/coba.php');
				}elseif ($_GET['perangkat'] == 'ModalKasir') {
					include('tabel/tabel_modalkasir.php');
				}elseif ($_GET['perangkat'] == 'Modal') {
					include('tabel/tabel_modal.php');
				}elseif ($_GET['perangkat'] == 'create-supplier') {
					include('form/create_supplier.php');
					include('core/create.php');
				}elseif ($_GET['perangkat'] == 'create-produk') {
					include('form/create_produk.php');
					include('core/create.php');
				}elseif ($_GET['perangkat'] == 'create-barang') {
					include('form/create_barang.php');
					include('core/create.php');
				}elseif ($_GET['perangkat'] == 'create-rekap') {
					include('form/create_rekap.php');
					include('core/create.php');
				}
			}elseif (isset($_GET['edit-penjualan'])) {
				include('form/edit_penjualan.php');
			}elseif (isset($_GET['edit-produk'])) {
				include('form/edit_produk.php');
			}elseif (isset($_GET['edit-sp'])) {
				include('form/edit_sp.php');
			}elseif (isset($_GET['edit-beli'])) {
				include('form/edit_beli.php');
			}elseif (isset($_GET['edit-bayar'])) {
				include('form/edit_bayar.php');
			}elseif (isset($_GET['edit-barang'])) {
				include('form/edit_barang.php');
			}elseif (isset($_GET['edit-trx'])) {
				include('form/edit_trx.php');
			}elseif (isset($_GET['edit-rekap'])) {
				include('form/edit_rekap.php');
			}elseif (isset($_GET['del-produk'])) {
				include('core/delete.php');
			}elseif (isset($_GET['del-supplier'])) {
				include('core/delete.php');
			}elseif (isset($_GET['del-trx'])) {
				include('core/delete.php');
			}elseif (isset($_GET['del-penjualan'])) {
				include('core/delete.php');
			}elseif (isset($_GET['del-brg'])) {
				include('core/delete.php');
			}elseif (isset($_GET['del-barang'])) {
				include('core/delete.php');
			}elseif (isset($_GET['del-beli'])) {
				include('core/delete.php');
			}elseif (isset($_GET['del-cash'])) {
				include('core/delete.php');
			}elseif (isset($_GET['del-rekap'])) {
				include('core/delete.php');
			}
			elseif (isset($_GET['edit-barang'])) {
				include('form/edit_barang.php');
			}elseif (isset($_GET['del-barang'])) {
				include('core/delete.php');
			}elseif (isset($_GET['laporan'])) { //Laporan
				if ($_GET['laporan'] == 'Keuangan') {
					include('tabel/tabel_laporan.php');
				}
			}
		?>
		<!-- End Management -->
<!-- ===================================== Content Here ===================================== -->
	</div>
</div> 
  
<?php require_once('layout/footer.php'); ?>