<?php
include "../fungsi/fungsi_anti_injection.php";
session_start();
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser']) AND $_SESSION['login']==0){
  echo "6";
}
else{
include_once('../fungsi/koneksi.php');
include "../fungsi/fungsi_indotgl.php";
include "../fungsi/ubahkarakter.php";
$fields = array('id', 'no', 'nama', 'tempat_lahir', 'tanggal_lahir', 'kelamin', 'agama', 'status', 'status_hdk', 'pekerjaan', 'pendidikan', 'ayah', 'ibu', 'goldar', 'kewarganegaraan', 'paspor', 'kitas_kitap');

$error = false; //No errors yet
foreach($fields AS $fieldname) { //Loop trough each field
  if(!isset($_POST[$fieldname]) || empty($_POST[$fieldname])) {
    $error = true; //Yup there are errors
  }
}
 
if($error==true){ echo "0"; } //ada field error respon kode = 0
elseif(!$error) { //tidak ada error dan mulai membuat query
  
$queryfields = array('id', 'no', 'nama', 'tempat_lahir', 'tanggal_lahir', 'kelamin', 'agama', 'status', 'status_hdk', 'pekerjaan', 'pendidikan', 'ayah', 'ibu', 'goldar', 'kewarganegaraan', 'paspor', 'kitas_kitap');
 
foreach($queryfields AS $fieldname) { //Loop trough each field
  		$$fieldname = $_POST[$fieldname];
}
$nama = ubah_huruf_ke_besar($nama);
$tempat_lahir = ubah_huruf_ke_besar($tempat_lahir);
$ayah = ubah_huruf_ke_besar($ayah);
$ibu = ubah_huruf_ke_besar($ibu);
$tgllahir = tgldb($_POST['tanggal_lahir']);
	 
		$no_lamasql = mysql_query("select * from penduduk where id_pen='$id'");
		$no_lamacatch = mysql_num_rows($no_lamasql);
		$penlama = mysql_fetch_array($no_lamasql);
		if ($no_lamacatch=='0'){ echo "1"; } // id pen tidak terverifikasi
	 else { // id pen terverifikasi
	 if ($penlama['no_pen']==$no){ // jika nopen tidak berubah 
	 if(mysql_query("UPDATE penduduk SET 	nama_pen = '$nama', 
											kelamin_pen = '$kelamin',
											goldar_pen = '$goldar', 
											tempat_lahir_pen = '$tempat_lahir', 
											tanggal_lahir_pen = '$tgllahir', 
											agama_pen = '$agama', 
											pendidikan_pen = '$pendidikan', 
											pekerjaan_pen = '$pekerjaan', 
											status_pen = '$status', 
											status_hdk_pen = '$status_hdk', 
											kewarganegaraan_pen = '$kewarganegaraan', 
											paspor_pen = '$paspor', 
											kitas_kitap_pen = '$kitas_kitap', 
											ayah_pen = '$ayah', 
											ibu_pen = '$ibu'
									  WHERE id_pen= '$penlama[id_pen]'")){
				  echo "2"; // berhasil menyimpan respon = 2
				 }
				else {
				  echo "3"; //gagal menyimpan respon = 3
				}
				}
				else { //jika nopen berubah
				$no_penbaru = mysql_query("select * from penduduk where no_pen='$no'");
				$no_penbarucek = mysql_num_rows($no_penbaru);
		if ($no_penbarucek=='0'){   // id pen masih tersedia				
				 if(mysql_query("UPDATE penduduk SET nama_pen = '$nama', 
											no_pen = '$no',
											kelamin_pen = '$kelamin',
											goldar_pen = '$goldar', 
											tempat_lahir_pen = '$tempat_lahir', 
											tanggal_lahir_pen = '$tgllahir', 
											agama_pen = '$agama', 
											pendidikan_pen = '$pendidikan', 
											pekerjaan_pen = '$pekerjaan', 
											status_pen = '$status', 
											status_hdk_pen = '$status_hdk', 
											kewarganegaraan_pen = '$kewarganegaraan', 
											paspor_pen = '$paspor', 
											kitas_kitap_pen = '$kitas_kitap', 
											ayah_pen = '$ayah', 
											ibu_pen = '$ibu'
									  WHERE id_pen= '$penlama[id_pen]'")){
				  echo "4"; // berhasil menyimpan respon = 2
				 }
				else {
				  echo "3"; //gagal menyimpan respon = 3
				}
				}
				else { echo "5"; }
				
				}
	 
	 }
	
}	
	
}
  
?>