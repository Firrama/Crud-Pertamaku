<!DOCTYPE html>
<html>
<head>
	<title>CRUD Petani Kode</title>
	<link rel="icon" href="http://www.petanikode.com/favicon.ico" />
</head>
<body>

<?php

// --- koneksi ke database
$koneksi = mysqli_connect("localhost","root","","pertanian") or die(mysqli_error());

// --- Fngsi tambah data (Create)
function tambah($koneksi){
	
	if (isset($_POST['btn_simpan'])){
		$id = time();
		$nm_tanaman = $_POST['nm_tanaman'];
		$barang = $_POST['barang'];
		$hasil = $_POST['hasil'];
		$lama = $_POST['lama'];
		$tgl_panen = $_POST['tgl_panen'];
		
		if(!empty($nm_tanaman) && !empty($hasil) && !empty($lama) && !empty($tgl_panen)){
			$sql = "INSERT INTO tabel_panen (id,nama_tanaman, barang, hasil_panen, lama_tanam, tanggal_panen) VALUES(".$id.",'".$nm_tanaman."','".$barang."','".$hasil."','".$lama."','".$tgl_panen."')";
			$simpan = mysqli_query($koneksi, $sql);
			if($simpan && isset($_GET['aksi'])){
				if($_GET['aksi'] == 'create'){
					header('location: index.php');
				}
			}
		} else {
			$pesan = "Tidak dapat menyimpan, data belum lengkap!";
		}
	}

	?> 
		<form action="" method="POST">
			<fieldset>
				<legend><h2>Order Barang</h2></legend>
				<label>Customer <input type="text" name="nm_tanaman" /></label> <br>
				<label>Barang Jual <input type="text" name="barang" /></label> <br>
				<label>Jumlah Barang <input type="number" name="hasil" /></label><br>
				<label>Harga Barang <input type="number" name="lama" /> </label> <br>
				<label>Tanggal Pesan <input type="date" name="tgl_panen" /></label> <br>
				<br>
				<label>
					<input type="submit" name="btn_simpan" value="Simpan"/>
					<input type="reset" name="reset" value="Besihkan"/>
				</label>
				<br>
				<p><?php echo isset($pesan) ? $pesan : "" ?></p>
			</fieldset>
		</form>
	<?php

}
// --- Tutup Fngsi tambah data


// --- Fungsi Baca Data (Read)
function tampil_data($koneksi){
	$sql = "SELECT * FROM tabel_panen";
	$query = mysqli_query($koneksi, $sql);
	
	echo "<fieldset>";
	echo "<legend><h2>Data Panen</h2></legend>";
	
	echo "<table border='1' cellpadding='10'>";
	echo "<tr>
			<th>ID Order</th>
			<th>Customer</th>
			<th>Barang Jual</th>
			<th>Jumlah Barang</th>
			<th>Harga Barang</th>
			<th>Tanggal Pesan</th>
			<th>Tindakan</th>
		  </tr>";
	
	while($data = mysqli_fetch_array($query)){
		?>
			<tr>
				<td><?php echo $data['id']; ?></td>
				<td><?php echo $data['nama_tanaman']; ?></td>
				<td><?php echo $data['barang']; ?></td>
				<td><?php echo $data['hasil_panen']; ?> </td>
				<td>Rp <?php echo $data['lama_tanam']; ?> </td>
				<td><?php echo $data['tanggal_panen']; ?></td>
				<td>
					<a href="index.php?aksi=update&id=<?php echo $data['id']; ?>&nama=<?php echo $data['nama_tanaman']; ?>&barang=<?php echo $data['barang']; ?>&hasil=<?php echo $data['hasil_panen']; ?>&lama=<?php echo $data['lama_tanam']; ?>&tanggal=<?php echo $data['tanggal_panen']; ?>">Ubah</a> |
					<a href="index.php?aksi=delete&id=<?php echo $data['id']; ?>">Hapus</a>
				</td>
			</tr>
		<?php
	}
	echo "</table>";
	echo "</fieldset>";
}
// --- Tutup Fungsi Baca Data (Read)


// --- Fungsi Ubah Data (Update)
function ubah($koneksi){

	// ubah data
	if(isset($_POST['btn_ubah'])){
		$id = $_POST['id'];
		$nm_tanaman = $_POST['nm_tanaman'];
		$barang = $_POST['barang'];
		$hasil = $_POST['hasil'];
		$lama = $_POST['lama'];
		$tgl_panen = $_POST['tgl_panen'];
		
		if(!empty($nm_tanaman) && empty($barang) && !empty($hasil) && !empty($lama) && !empty($tgl_panen)){
			$perubahan = "nama_tanaman='".$nm_tanaman."',barang=".$barang.",hasil_panen=".$hasil.",lama_tanam=".$lama.",tanggal_panen='".$tgl_panen."'";
			$sql_update = "UPDATE tabel_panen SET ".$perubahan." WHERE id=$id";
			$update = mysqli_query($koneksi, $sql_update);
			if($update && isset($_GET['aksi'])){
				if($_GET['aksi'] == 'update'){
					header('location: index.php');
				}
			}
		} else {
			$pesan = "Data tidak lengkap!";
		}
	}
	
	// tampilkan form ubah
	if(isset($_GET['id'])){
		?>
			<a href="index.php"> &laquo; Home</a> | 
			<a href="index.php?aksi=create"> (+) Tambah Data</a>
			<hr>
			
			<form action="" method="POST">
			<fieldset>
				<legend><h2>Ubah data</h2></legend>
				<input type="hidden" name="id" value="<?php echo $_GET['id'] ?>"/>
				<label>Customer <input type="text" name="nm_tanaman" value="<?php echo $_GET['nama'] ?>"/></label> <br>
				<label>Barang Jual <input type="text" name="barang" value="<?php echo $_GET['barang'] ?>"/></label> <br>
				<label>Jumlah Barang <input type="number" name="hasil" value="<?php echo $_GET['hasil'] ?>"/> <RP></RP></label><br>
				<label>Harga Barang <input type="number" name="lama" value="<?php echo $_GET['lama'] ?>"/> bulan</label> <br>
				<label>Tanggal Pesan <input type="date" name="tgl_panen" value="<?php echo $_GET['tanggal'] ?>"/></label> <br>
				<br>
				<label>
					<input type="submit" name="btn_ubah" value="Simpan Perubahan"/> atau <a href="index.php?aksi=delete&id=<?php echo $_GET['id'] ?>"> (x) Hapus data ini</a>!
				</label>
				<br>
				<p><?php echo isset($pesan) ? $pesan : "" ?></p>
				
			</fieldset>
			</form>
		<?php
	}
	
}
// --- Tutup Fungsi Update


// --- Fungsi Delete
function hapus($koneksi){

	if(isset($_GET['id']) && isset($_GET['aksi'])){
		$id = $_GET['id'];
		$sql_hapus = "DELETE FROM tabel_panen WHERE id=" . $id;
		$hapus = mysqli_query($koneksi, $sql_hapus);
		
		if($hapus){
			if($_GET['aksi'] == 'delete'){
				header('location: index.php');
			}
		}
	}
	
}
// --- Tutup Fungsi Hapus


// ===================================================================

// --- Program Utama
if (isset($_GET['aksi'])){
	switch($_GET['aksi']){
		case "create":
			echo '<a href="index.php"> &laquo; Home</a>';
			tambah($koneksi);
			break;
		case "read":
			tampil_data($koneksi);
			break;
		case "update":
			ubah($koneksi);
			tampil_data($koneksi);
			break;
		case "delete":
			hapus($koneksi);
			break;
		default:
			echo "<h3>Aksi <i>".$_GET['aksi']."</i> tidaka ada!</h3>";
			tambah($koneksi);
			tampil_data($koneksi);
	}
} else {
	tambah($koneksi);
	tampil_data($koneksi);
}

?>
</body>
</html>
