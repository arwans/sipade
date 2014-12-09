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
$fields = array('no', 'nama', 'tempat_lahir', 'tanggal_lahir', 'kelamin', 'agama', 'status', 'status_hdk', 'pekerjaan', 'pendidikan', 'ayah', 'ibu', 'goldar', 'kewarganegaraan', 'paspor', 'kitas_kitap');

$error = false; //No errors yet
foreach($fields AS $fieldname) { //Loop trough each field
  if(!isset($_POST[$fieldname]) || empty($_POST[$fieldname])) {
    $error = true; //Yup there are errors
  }
}
 
if($error==true){ echo "0"; } //ada field error respon kode = 0
elseif(!$error) { //tidak ada error dan mulai membuat query
  
$queryfields = array('no', 'nama', 'tempat_lahir', 'tanggal_lahir', 'kelamin', 'agama', 'status', 'status_hdk', 'pekerjaan', 'pendidikan', 'ayah', 'ibu', 'goldar', 'kewarganegaraan', 'paspor', 'kitas_kitap');
 
foreach($queryfields AS $fieldname) { //Loop trough each field
  		$$fieldname = $_POST[$fieldname];
}

$nama = ubah_huruf_ke_besar($nama);
$tempat_lahir = ubah_huruf_ke_besar($tempat_lahir);
$ayah = ubah_huruf_ke_besar($ayah);
$ibu = ubah_huruf_ke_besar($ibu);
$no_kk = $_GET['no_kk'];
$tgllahir = tgldb($_POST['tanggal_lahir']);
	
$cekkkquery = mysql_query("select * from kk where no_kk='$no_kk'");
$cekkk = mysql_num_rows($cekkkquery);
if ($cekkk=='0'){ //nomor kk tidak ada di database
echo "1"; // tidak ada kk kode = 1
}
else {
		$kk=mysql_fetch_array($cekkkquery);
		$sql = mysql_query("select * from penduduk where no_pen='$no'");
		$catch = mysql_num_rows($sql);
		if ($catch=='0'){ //nomor pen masih tersedia
				if(mysql_query("INSERT INTO penduduk(no_kk_pen, no_pen, nama_pen, kelamin_pen, goldar_pen, tempat_lahir_pen, tanggal_lahir_pen, agama_pen, pendidikan_pen, pekerjaan_pen, status_pen, status_hdk_pen, kewarganegaraan_pen, paspor_pen, kitas_kitap_pen, ayah_pen, ibu_pen, alamat_pen, rt_pen, rw_pen)	
				 VALUES('$no_kk', '$no', '$nama', '$kelamin', '$goldar', '$tempat_lahir', '$tgllahir', '$agama', '$pendidikan', '$pekerjaan', '$status', '$status_hdk', '$kewarganegaraan', '$paspor', '$kitas_kitap', '$ayah', '$ibu', '$kk[alamat]', '$kk[rt]', '$kk[rw]')")){
				  echo "2"; // berhasil menyimpan respon = 2
				 }
				else {
				  echo "3"; //gagal menyimpan respon = 3
				}
		}
		else {
		echo "4";
		} //nomor pen tidak tersedia respon = 4
	}
}	
	

  }
?> 