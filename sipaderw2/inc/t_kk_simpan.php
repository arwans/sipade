<?php
include "../fungsi/fungsi_anti_injection.php";

session_start();
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser']) AND $_SESSION['login']==0){
  echo "6";
}
else{

  $fields = array('no_kk', 'alamat', 'rw', 'rt', 'no', 'nama', 'tempat_lahir', 'tanggal_lahir', 'kelamin', 'agama', 'status', 'pekerjaan', 'pendidikan', 'ayah', 'ibu', 'goldar', 'kewarganegaraan', 'paspor', 'kitas_kitap');

$error = false; //No errors yet
foreach($fields AS $fieldname) { //Loop trough each field
  if(!isset($_POST[$fieldname]) || empty($_POST[$fieldname])) { 
    $error = true; //Yup there are errors
  }
  
}

if($error==true){ echo "0"; } //ada field error respon kode = 0
elseif(!$error) { //Only create queries when no error occurs
  //Create queries.... 
  
include_once('../fungsi/koneksi.php');
include "../fungsi/fungsi_indotgl.php";
include "../fungsi/ubahkarakter.php";
		
$queryfields = array('no_kk', 'alamat', 'rw', 'rt', 'no', 'nama', 'tempat_lahir', 'tanggal_lahir', 'kelamin', 'agama', 'status', 'pekerjaan', 'pendidikan', 'ayah', 'ibu', 'goldar', 'kewarganegaraan', 'paspor', 'kitas_kitap');
foreach($queryfields AS $fieldname) { //Loop trough each field
  		$$fieldname = $_POST[$fieldname];
}
		
$catatan = ubah_huruf_ke_besar($nama);
$tempat_lahir = ubah_huruf_ke_besar($tempat_lahir);
$ayah = ubah_huruf_ke_besar($ayah);
$ibu = ubah_huruf_ke_besar($ibu);
$tgllahir = tgldb($_POST['tanggal_lahir']);

		$no_lamasql = mysql_query("select * from kk where no_kk='$no_kk'");
		$no_lamacatch = mysql_num_rows($no_lamasql);
		if ($no_lamacatch=='0'){ //id kk masih tersedia
		
		$nopen_lamasql = mysql_query("select * from penduduk where no_pen='$no'");
		$nopen_lamacatch = mysql_num_rows($nopen_lamasql);
		if ($nopen_lamacatch=='0'){ //no pen masih tersedia
		
	 if(mysql_query("INSERT INTO kk(no_kk, alamat, rw, rt, catatan)	
				 VALUES('$no_kk', '$alamat', '$rw', '$rt', '$catatan')")){
					 
		 mysql_query("INSERT INTO penduduk(no_kk_pen, no_pen, nama_pen, kelamin_pen, goldar_pen, tempat_lahir_pen, tanggal_lahir_pen, agama_pen, pendidikan_pen, pekerjaan_pen, status_pen, status_hdk_pen, kewarganegaraan_pen, paspor_pen, kitas_kitap_pen, ayah_pen, ibu_pen, alamat_pen, rt_pen, rw_pen)	
				 VALUES('$no_kk', '$no', '$catatan', '$kelamin', '$goldar', '$tempat_lahir', '$tgllahir', '$agama', '$pendidikan', '$pekerjaan', '$status', '1', '$kewarganegaraan', '$paspor', '$kitas_kitap', '$ayah', '$ibu', '$alamat', '$rt', '$rw')");
		  echo "$no_kk"; // sukses respon kode = 2
		}
		
		else {
		  echo "3"; // gagal respon kode 4
		  }
	 
}
else { echo "4"; }
		} 
		else { // id kk tidak tersedia
echo "1";
	  }
	  }
          
          
        
}
?>