<?php
include "fungsi/fungsi_anti_injection.php";
session_start();
error_reporting(0);
include "inc/timeout.php";

if($_SESSION[login]==1){
if(!cek_login()){
$_SESSION[login] = 0;
}
}
if($_SESSION[login]==0){
  header('location:inc/logout.php');
}
else{
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser']) AND $_SESSION['login']==0){
  echo "Anda harus masuk terlebih dahulu !";
}
else{
?>
<?php 
include "fungsi/koneksi.php";
include "fungsi/class_paging.php";
include "fungsi/fungsi_indotgl.php";
include "fungsi/library.php";
include "fungsi/ubahkarakter.php"; 
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>SI PA'DE | Sistem Informasi Pelayanan Desa</title>
	<link rel="shortcut icon" href="images/favicon.gif">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">  
	<link type="text/css" href="rakstrap/css/style.css" rel="stylesheet">    
<link rel="stylesheet" href="rakstrap/css/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" />
  <link href="rakstrap/css/loadingindicator.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
</head>

<body class="pace-done">
<?php include "inc/ui_top_panel.php"; ?>
<div class="container clearfix">
<div class="header clearfix">

<div class="row">
  <div class="col-md-4"><h2>#Pelayanan</h2></div>
  <div class="col-md-4" style="text-align:center;"><h1>MESIN PEMBUAT SURAT</h1></div>
  <div class="col-md-4" style="text-align:right;">
<div class="btn-group">
    <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button">
      <span class="glyphicon glyphicon-tasks"></span> Kelola
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu pull-right">
      <li><a href="arsip?submit=Saring">Arsip Pelayanan</a></li> 
      <li><a href="pengaturan?lembar=pelayanan">Kelola Pelayanan</a></li> 
	</ul></div>
</div> 

</div>
    
    <div class="clear"> </div><hr>
<div class="informasi" align="center"> [?] Tips Pelayanan : Hindari kesalahan data dengan lebih teliti dan waspada. Ikuti prosedur yang berlaku. 
     <div class="clear"></div> 
     </div>
    
     <div class="clear"></div>
     <hr> 
	 </div>
	 
<form action="submit.php" method="POST" class="input has-validation-callback" id="t_surat"> 
     <div class="content clearfix" style="width:295px; float:left; margin:0;">
     <div class="panel panel-primary">
      <div class="panel-heading">
        <h2 class="panel-title" align="center">PILIH JENIS PELAYANAN</h2>
      </div>
      <div class="panel-body">
    <div class="btn-group-vertical"  style="width:241px;">
        
    <?php  
$surat=mysql_query("SELECT * FROM arsip_surat where aktif='Y'"); 
	while($s=mysql_fetch_array($surat)){
$singkat = ubah_huruf_ke_kecil($s['singkat_surat']);
if ($s[jenis]=='K'){$jenissurat='Ket';$jenissuratinfo='Surat Keterangan';}
if ($s[jenis]=='F'){$jenissurat='For';$jenissuratinfo='Formulir';}
if ($s[jenis]=='P'){$jenissurat='Oth';$jenissuratinfo='Surat Lainnya';}
echo "<label class='btn btn-default' id='$singkat'>
	<span class='badge' title='$jenissuratinfo'>$jenissurat</span>
        <input type='radio' name='surat' value='$s[id_surat]' class='trigger'  data-rel='$singkat'/> $s[nama_surat]
    </label> 
    <div style='display: none;' class='lembar2 surat_$singkat info_surat'>$s[ket_surat]</div>"; 
	} ?>
	      </div> 
		  
  <div class="panel-footer"> 
  <span class="label label-default">Ket</span> / Keterangan<br/>
  <span class="label label-default">For</span> / Formulir</div>
    </div>
    </div>
     </div>
	 
     <div class="content clearfix" style="width:570px; float:right; margin:0; position:static;"> 
<b>
<h3>LEMBAR IDENTITAS (KTP/KK)</h3></b><hr>
      <table border="0" width="100%">
  <tbody><tr>
    <td colspan="5" id="autosugest"><b>NIK :</b> <input autocomplete="off" name="noid" data-get="no_pen" value="<?php if(isset($_GET[nik])) {echo $_GET[nik];} ?>" style="width: 300px;" id="no_pen" data-validation="number" data-validation-error-msg="&nbsp;?&nbsp;&nbsp; : Pastikan data berupa angka." type="text">
      <span class="no_cek" id="no_pen_cek">&nbsp;</span></td>
    </tr>
  <tr>
    <td colspan="5" id="autosugest"><b>NKK :</b> <input name="nokk" data-get="no_kk" value="<?php if(isset($_GET[nokk])) {echo $_GET[nokk];} ?>" style="width: 300px;" id="no_kk" type="text">
      <span class="no_cek" id="no_kk_cek">&nbsp;</span></td>
    </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
   
    <td colspan="2"></td>
  </tr>
  <tr>
    <td>Nama</td>
    <td width="0%">:</td>
    <td colspan="3"><input name="nama" id="nama" style="width:310px;" data-validation="custom" data-validation-regexp="^[a-zA-Z\.\(\)\-\s]+$" data-validation-error-msg="&nbsp;?&nbsp;&nbsp; : Jangan Menggunakan Singkatan,Angka." type="text"></td>
    </tr>
  <tr>
    <td>Tempat/Tgl Lahir</td>
    <td>:</td>
    <td colspan="3"><input name="ttl1" id="ttl1" data-validation="custom" data-validation-regexp="^[a-zA-Z\.\-\s]+$" data-validation-error-msg="&nbsp;?&nbsp;&nbsp; : Kota Kelahiran Harus di isi !" type="text" style="width:200px;">, 
	
                    <input size="16" id="ttl2" data-date="" data-date-format="dd-mm-yyyy" value="" readonly="" type="text" name="ttl2" style="width:100px;" data-validation="date" data-validation-error-msg="&nbsp;?&nbsp;&nbsp;" data-validation-format="dd-mm-yyyy" maxlength="10">
                     </td>
    </tr>
  <tr>
    <td>Jenis Kelamin</td>
    <td>:</td>
    <td width="52%"><select name="jk" id="jk" data-validation="number" data-validation-error-msg="&nbsp;?&nbsp;&nbsp; : Pilih salah satu !" style="width:105px;">
    <option value="a" selected="selected"> </option>
    <option value="1">Laki-Laki</option>
    <option value="2">Perempuan</option>
    </select></td>
    <td width="1%">&nbsp;</td>
    <td width="17%">&nbsp;</td>
    </tr>
  <tr>
    <td>Agama</td>
    <td>:</td>
    <td><select name="agm" id="agm" data-validation="number" data-validation-error-msg="&nbsp;?&nbsp;&nbsp; : Pilih salah satu !" style="width:105px;">
	<option value="a" selected="selected"> </option>
    <?php $arsip_agama = mysql_query("select * from arsip_agama"); 
	while($agama=mysql_fetch_array($arsip_agama)){
		echo "<option value='$agama[id_agama]'>$agama[agama]</option>";
	}
		?></select>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Alamat</td>
    <td>:</td>
    <td> 
    <input name="almt" id="almt" style="width:310px;" data-validation="custom" data-validation-regexp="^[a-zA-Z\0-9\-\.\s]+$" data-validation-error-msg="&nbsp;?&nbsp;&nbsp; : Sebutkan KP/JL !" type="text"></td>
    <td rowspan="2"></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>RT/RW</td>
    <td>:</td>
    <td>
      <input name="rt" id="rt" min="1" style="width:45px;" data-validation="number" data-validation-error-msg="&nbsp;?&nbsp;&nbsp; : Hanya berupa angka!" type="number"> / 
      <input name="rw" id="rw" min="1" style="width:45px;" data-validation="number" data-validation-error-msg="&nbsp;?&nbsp;&nbsp; : Hanya berupa angka!" type="number">
      
    </td>
    <td></td>
  </tr><?php $pengaturan = mysql_query("select * from pengaturan where id='2'"); 
	$set=mysql_fetch_array($pengaturan);
		?>
  <tr>    <td>Desa/Kelurahan</td>
    <td>:</td>
    <td><input name="desa" id="desa" style="width:200px;" value="<?php echo "$set[desa]"; ?>" data-validation="custom" data-validation-regexp="^[a-zA-Z\-\.\s]+$" data-validation-error-msg="&nbsp;?&nbsp;&nbsp; : Harus diisi !" type="text">&nbsp;</td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td>Kecamatan</td>
    <td>:</td>
    <td><input name="kec" id="kec" style="width:200px;" value="<?php echo "$set[kecamatan]"; ?>" data-validation="custom" data-validation-regexp="^[a-zA-Z\-\.\s]+$" data-validation-error-msg="&nbsp;?&nbsp;&nbsp; : Harus diisi !" type="text">&nbsp;</td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td>Kabupaten/kota</td>
    <td>:</td>
    <td><input name="kab" id="kab" style="width:200px;" value="<?php echo "$set[kabupaten]"; ?>" data-validation="custom" data-validation-regexp="^[a-zA-Z\-\.\s]+$" data-validation-error-msg="&nbsp;?&nbsp;&nbsp; : Harus diisi !" type="text">&nbsp;</td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td>Kewarganegaraan</td>
    <td>:</td>
    <td><select name="wn" id="wn" data-validation="number" data-validation-error-msg="&nbsp;?&nbsp;&nbsp; : Pilih salah satu !" style="width:45px;">
    <option value="a"> </option>
    <option value="1">WNI</option>
    <option value="2">WNA</option>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>Pekerjaan</td>
    <td>:</td>
    <td><select name="kerja" id="kerja" data-validation="number" data-validation-error-msg="&nbsp;?&nbsp;&nbsp; : Pilih salah satu !" style="width:200px;">
    <option value="a"> </option>    
	<?php $arsip_pekerjaan = mysql_query("select * from arsip_pekerjaan"); 
	while($kerja=mysql_fetch_array($arsip_pekerjaan)){
		echo "<option value='$kerja[id_pekerjaan]'>$kerja[pekerjaan]</option>";
	}
		?></select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>Status Nikah</td>
    <td>:</td>
    <td><select name="status" id="status" data-validation="number" data-validation-error-msg="&nbsp;?&nbsp;&nbsp; : Pilih salah satu !" style="width:105px;">
    <option value="a"> </option>
	<?php $arsip_status = mysql_query("select * from arsip_status"); 
	while($sts=mysql_fetch_array($arsip_status)){
		echo "<option value='$sts[id_status]'>$sts[status]</option>";
	}
		?>
		</select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
	<tr style="display: none;" class="sktm skkm lembar2">
      <td>Nama Orang Tua</td>
      <td>:</td>
        <td colspan="3"><input name="ortu" id="ortu" style="width:310px;" value="-" data-validation="custom" data-validation-regexp="^[a-zA-Z\.\(\)\-\s]+$" data-validation-error-msg="&nbsp;?&nbsp;&nbsp; : Harus diisi !" type="text">          * SKKM &amp; SKTM</td>
        </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
      </tbody></table> 
    <div class="clearfix"></div>
    <table style="display: none;" class="resi lembar2" width="100%">
      <tbody><tr>
        <td>
<hr><b><h3>Surat Keterangan Resi KTP Sementara</h3></b><hr></td>
      </tr>
      
      </tbody></table>
      
      
    <div class="clearfix"></div> 
      <table style="display: none;" class="skd lembar2" width="100%">
      <tbody><tr>
        <td colspan="5">
<hr><b><h3>Surat Keterangan Domisili</h3></b><hr></td>
      </tr>
      </tbody></table>
      
    <div class="clearfix"></div> 
      <table style="display: none;" class="sktm lembar2" width="100%">
      <tbody><tr>
        <td colspan="5">
<hr><b>
<h3>Surat Keterangan Tidak Mampu</h3>
</b><hr></td> 
      </tr>
      <tr>
      <td width="27%">Gunakan Nomor</td>
      <td width="1%">:</td>
        <td width="45%">&nbsp;&nbsp;&nbsp;<input id="sktmgunakannomor" name="sktmgunakannomor" value="1" type="radio">KTP <input id="sktmgunakannomor" name="sktmgunakannomor" value="2" checked="checked" type="radio">KK</td>
        <td></td>
         <td></td>
     </tr>
      </tbody></table>
      
      
    <div class="clearfix"></div> 
      <table style="display: none;" class="skkm lembar2" width="100%">
      <tbody><tr>
        <td colspan="5">
<hr><b>
<h3>Surat Keterangan Keluarga Miskin</h3>
</b><hr></td> 
      </tr>
      <tr>
      <td width="27%">Gunakan Nomor</td>
      <td width="1%">:</td>
        <td width="45%">&nbsp;&nbsp;&nbsp;<input id="skkmgunakannomor" name="skkmgunakannomor" value="1" type="radio">KTP <input id="skkmgunakannomor" name="skkmgunakannomor" value="2" checked="checked" type="radio">KK</td>
        <td></td>
         <td></td>
     </tr>
      </tbody></table>
      
    <div class="clearfix"></div> 
      <table style="display: none;" class="skkb lembar2" width="100%">
      <tbody><tr>
        <td colspan="6">
<hr><b>
<h3>Surat Keterangan Kelakuan Baik</h3>
</b><hr></td> 
      </tr>
      <tr>
      <td width="27%">Gunakan Nomor</td>
      <td width="1%">:</td>
        <td width="45%">&nbsp;&nbsp;&nbsp;<input id="skkbgunakannomor" name="skkbgunakannomor" value="1" type="radio">KTP <input id="skkbgunakannomor" name="skkbgunakannomor" value="2" checked="checked" type="radio">KK</td>
        <td></td>
         <td></td>
     </tr>
      </tbody></table>
      
      
    <div class="clearfix"></div> 
      <table style="display: none;" class="sku lembar2" width="100%">
      <tbody><tr>
        <td colspan="5">
<hr><b><h3>Surat Keterangan Usaha</h3></b><hr></td>
      </tr>
      <tr>
    <td width="34%">Bentuk Usaha</td>
    <td width="1%">:</td>
    <td width="40%"><select name="sku_bu" id="sku_bu">
<option value="Perorangan">Perorangan</option>
<option value="Kelompok">Kelompok</option>
</select></td>
    <td width="23%">&nbsp;</td>
    <td width="2%">&nbsp;</td>
  </tr>
  <tr>
    <td>Nama Perusahaan</td>
    <td>:</td>
    <td><input name="sku_np" id="sku_np" type="text"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Jenis Usaha</td>
    <td>:</td>
    <td><input name="sku_ju" id="sku_ju" placeholder="(Dagang/Jasa/Dagang dan Jasa) / (Komoditi)" type="text" style="width:300px;"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td>Tempat/Lokasi Usaha</td>
    <td>:</td>
    <td> 
 
    <input name="almtsku_lu" id="almtsku_lu" style="width:300px;" type="text">
    
     </td>
    <td><button type="button" id="tooltip" data-toggle="tooltip" data-placement="top" title="Samakan Alamat Dengan Lembar Identitas" class="btn btn-default btn-xs ambilalmt" data-id="almt" data-rt="rt" data-rw="rw" data-desa="desa" data-kec="kec" data-kab="kab" data-rel="sku_lu">
  <span class="glyphicon glyphicon-edit"></span>#1
</button></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td width="23%">RT/RW</td>
    <td>:</td>
    <td>
      <input name="rtsku_lu" id="rtsku_lu" style="width:45px;" type="number" min="1"> / 
      <input name="rwsku_lu" id="rwsku_lu" style="width:45px;" type="number" min="1">
      
    </td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr> 
    <td>Desa/Kelurahan</td>
    <td>:</td>
    <td><input name="desasku_lu" type="text" id="desasku_lu" style="width:200px;" value="<?php echo "$set[desa]"; ?>"/>&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr> 
    <td>Kecamatan</td>
    <td>:</td>
    <td><input name="kecsku_lu" type="text" id="kecsku_lu" style="width:200px;" value="<?php echo "$set[kecamatan]"; ?>"/>&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td>Kabupaten/kota</td>
    <td>:</td>
    <td><input name="kabsku_lu" type="text" id="kabsku_lu" style="width:200px;" value="<?php echo "$set[kabupaten]"; ?>"/>&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td></td>
  </tr>  
      </tbody></table>
      
      
    <div class="clearfix"></div> 
      
      <table style="display: none;" class="skdu lembar2" width="100%">
      <tbody><tr>
        <td colspan="5">
<hr><b>
<h3>Surat Keterangan Domisili Usaha</h3></b><hr></td>
      </tr>
       
  <tr>
    <td width="34%">Nama Perusahaan</td>
    <td width="1%">:</td>
    <td width="50%"><input name="skdu_np" id="skdu_np" type="text"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Jenis Usaha</td>
    <td>:</td>
    <td><input name="skdu_ju" id="skdu_ju" type="text" placeholder="(Dagang/Jasa/Dagang dan Jasa) / (Komoditi)" type="text" style="width:300px;"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Luas Tempat Usaha</td>
    <td>:</td>
    <td><input name="skdu_ltu" id="skdu_ltu" type="text"> 
    M2</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td>Tempat/Lokasi Usaha</td>
    <td>:</td>
    <td> 
 
    <input name="almtskdu_almt" id="almtskdu_almt" style="width:300px;" type="text">
    
     </td>
    <td><button type="button" id="tooltip" data-toggle="tooltip" data-placement="top" title="Samakan Alamat Dengan Lembar Identitas" class="btn btn-default btn-xs ambilalmt" data-id="almt" data-rt="rt" data-rw="rw" data-rel="skdu_almt">
  <span class="glyphicon glyphicon-edit"></span>#1
</button></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td width="23%">RT/RW</td>
    <td>:</td>
    <td>
      <input name="rtskdu_almt" id="rtskdu_almt" style="width:45px;"  type="number" min="1"> / 
      <input name="rwskdu_almt" id="rwskdu_almt" style="width:45px;"  type="number" min="1">
      
    </td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td>Jumlah Karyawan</td>
    <td>:</td>
    <td><input name="skdu_jk" id="skdu_jk" type="text" style="width:45px;"> Orang</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Status Tanah / Bangunan</td>
    <td>:</td>
    <td><input name="skdu_stb" id="skdu_stb" type="text"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Nilai Investasi Perusahaan</td>
    <td>:</td>
     <td colspan="3">Rp. <input placeholder="Hanya Angka / Tanpa Titik" style="width:270px;" name="skdu_nip" id="skdu_nip" type="text"> 
	 <br/><i><sup>Tidak Termasuk Tanah / Bangunan</sup></i></td>
  
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>   
      </tbody></table>
      
 
      
    <div class="clearfix"></div> 
      <table style="display: none;" class="skk lembar2" width="100%">
      <tbody><tr>
        <td colspan="6"><hr><b>
  <h3>Surat Keterangan Kelahiran</h3></b><hr></td>
        </tr>
      <tr>
        <td colspan="6"><table width="100%">
            <tbody><tr>
              <td>Jam Lahir</td>
              <td>:</td>
              <td><input name="jamlahir" id="jamlahir" style="width: 50px;" data-date="" data-date-format="hh:ii" placeholder="jj:mm" type="text">
                <select name="zonawaktu" id="zonawaktu">
                  <option value="WIB" selected="selected">WIB</option>
                  <option value="WITA">WITA</option>
                  <option value="WIT">WIT</option>
                </select></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td width="20%">Anak Ke</td>
              <td width="2%">:</td>
              <td width="30%"> <input name="anakke" id="anakke" type="number" min="1" Max="15" style="width: 50px;"></td>
              <td width="19%">Dari</td>
              <td width="1%">:</td>
              <td width="28%"> <input name="dari" id="dari" type="number" min="1" Max="15" style="width: 50px;"></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </tbody></table></td>
      </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3"><b>AYAH  //</b></td>
   
    <td colspan="2"></td>
  </tr>
  <tr><td>&nbsp;</td>
    <td colspan="5" id="autosugest">NIK : <input autocomplete="off" name="noidayah" data-get="no_pen" style="width: 300px;" id="no_penayah" type="text">
      <span class="no_cek" id="no_pen_cekayah">&nbsp;</span></td>
    </tr>
  <tr><td>&nbsp;</td>
    <td>Nama</td>
    <td width="0%">:</td>
    <td colspan="3"><input autocomplete="off" name="namaayah" id="namaayah" style="width:300px;" type="text"><input name="pupusayah" id="pupusayah" value="1" type="checkbox">
     #Almarhum</td>
    </tr>
  <tr><td>&nbsp;</td>
    <td>Tempat/Tgl Lahir</td>
    <td>:</td>
    <td colspan="3"><input name="ttl1ayah" id="ttl1ayah" type="text">, <input id="ttl2ayah" data-date="" data-date-format="dd-mm-yyyy" value="" readonly="" size="50" name="ttl2ayah" style="width:100px;" placeholder="dd-mm-yyyy" type="text"></td>
    </tr> 
  <tr><td>&nbsp;</td>
    <td>Agama</td>
    <td>:</td>
    <td><select name="agmayah" id="agmayah">
    <option value="a" selected="selected"> </option>
    
    <?php $arsip_agama = mysql_query("select * from arsip_agama"); 
	while($agama=mysql_fetch_array($arsip_agama)){
		echo "<option value='$agama[id_agama]'>$agama[agama]</option>";
	}
		?></select>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr><td>&nbsp;</td>
    <td>Alamat</td>
    <td>:</td>
    <td> 
 
    <input name="almtayah" id="almtayah" style="width:300px;" type="text">
    <button type="button" id="tooltip" data-toggle="tooltip" data-placement="top" title="Samakan Alamat Dengan Lembar Identitas" class="btn btn-default btn-xs ambilalmt" data-id="almt" data-rt="rt" data-rw="rw" data-desa="desa" data-kec="kec" data-kab="kab" data-rel="ayah">
  <span class="glyphicon glyphicon-edit"></span>#1
</button>

     </td>
    <td rowspan="2"></td>
    <td>&nbsp;</td>
    </tr>
  <tr><td>&nbsp;</td>
    <td>RT/RW</td>
    <td>:</td>
    <td>
      <input name="rtayah" id="rtayah" style="width:45px;" type="number" min="1"> / 
      <input name="rwayah" id="rwayah" style="width:45px;" type="number" min="1">
      
    </td>
    <td></td>
  </tr>
  <tr><td>&nbsp;</td>    
    <td>Desa/Kelurahan</td>
    <td>:</td>
    <td><input name="desaayah" type="text" id="desaayah" style="width:200px;" value="<?php echo "$set[desa]"; ?>"/>&nbsp;</td>
    <td></td>
    <td></td>
  </tr>
  <tr><td>&nbsp;</td>
    <td>Kecamatan</td>
    <td>:</td>
    <td><input name="kecayah" type="text" id="kecayah" style="width:200px;" value="<?php echo "$set[kecamatan]"; ?>"/>&nbsp;</td>
    <td></td>
    <td></td>
  </tr>
  <tr><td>&nbsp;</td>
    <td>Kabupaten/kota</td>
    <td>:</td>
    <td><input name="kabayah" type="text" id="kabayah" style="width:200px;" value="<?php echo "$set[kabupaten]"; ?>"/>&nbsp;</td>
    <td></td>
    <td></td>
  </tr>  
  <tr><td>&nbsp;</td>
    <td>Pekerjaan</td>
    <td>:</td>
    <td><select name="kerjaayah" id="kerjaayah">
    <option value="a"> </option>
    <option value="1">Belum/Tidak Bekerja</option><option value="2">Mengurus Rumah Tangga</option><option value="3">Pelajar/Mahasiswa</option><option value="4">Pensiunan</option><option value="5">Pegawai Negeri Sipil (PNS)</option><option value="6">Tentara Nasional Indonesia (TNI)</option><option value="7">Kepolisian (POLRI)</option><option value="8">Perdagangan</option><option value="9">Petani/Pekebun</option><option value="10">Peternak</option><option value="11">Nelayan/Perikanan</option><option value="12">Industri</option><option value="13">Konstruksi</option><option value="14">Transportasi</option><option value="15">Karyawan Swasta</option><option value="16">Karyawan BUMN</option><option value="17">Karyawan BUMD</option><option value="18">Karyawan Honorer</option><option value="19">Buruh Harian Lepas</option><option value="20">Buruh Tani/Perkebunan</option><option value="21">Buruh Nelayan/Perikanan</option><option value="22">Buruh Peternakan</option><option value="23">Pembantu Rumah Tangga</option><option value="24">Tukang Cukur</option><option value="25">Tukang Listrik</option><option value="26">Tukang Batu</option><option value="27">Tukang Kayu</option><option value="28">Tukang Sol Sepatu</option><option value="29">Tukang Las/Pandai Besi</option><option value="30">Tukang Jahit</option><option value="31">Tukang Gigi</option><option value="32">Penata Rias</option><option value="33">Penata Busana</option><option value="34">Penata Rambut</option><option value="35">Mekanik</option><option value="36">Seniman</option><option value="37">Tabib</option><option value="38">Paraji</option><option value="39">Perancang Busana</option><option value="40">Penterjemah</option><option value="41">Imam Masjid</option><option value="42">Pendeta</option><option value="43">Pastor</option><option value="44">Wartawan</option><option value="45">Ustadz/Mubaligh</option><option value="46">Juru Masak</option><option value="47">Promotor Acara</option><option value="48">Anggota DPR-RI</option><option value="49">Anggota DPD</option><option value="50">Anggota BPK</option><option value="51">Presiden</option><option value="52">Wakil Presiden</option><option value="53">Anggota Mahkamah Konstitusi</option><option value="54">Anggota Kabinet/Kementrian</option><option value="55">Duta Besar</option><option value="56">Gubernur</option><option value="57">Wakil Gubernur</option><option value="58">Bupati</option><option value="59">Wakil Bupati</option><option value="60">Walikota</option><option value="61">Wakil Walikota</option><option value="62">Anggota DPRD Prop</option><option value="63">Anggota DPRD Kab Kota PROPESI LAIN SELAIN PEGAWAI </option><option value="64">Dosen</option><option value="65">Guru</option><option value="66">Pilot</option><option value="67">Pengacara</option><option value="68">Notaris</option><option value="69">Arsitek</option><option value="70">Akuntan</option><option value="71">Konsultan</option><option value="72">Dokter</option><option value="73">Bidan</option><option value="74">Perawat</option><option value="75">Apoteker</option><option value="76">Psikiater/Psikolog</option><option value="77">Penyiar Televisi</option><option value="78">Penyiar Radio</option><option value="79">Pelaut</option><option value="80">Peneliti</option><option value="81">Sopir</option><option value="82">Pialang</option><option value="83">Paranormal</option><option value="84">Pedagang</option><option value="85">Perangkat Desa</option><option value="86">Kepala Desa</option><option value="87">Biarawati</option><option value="88">Wiraswasta</option>    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>  
    
    <tr>
    <td>&nbsp;</td>
    <td colspan="3"><b>IBU  //</b></td>
   
    <td colspan="2"></td>
  </tr>
  <tr><td>&nbsp;</td>
    <td colspan="5" id="autosugest">NIK : <input autocomplete="off" name="noidibu" data-get="no_pen" style="width: 300px;" id="no_penibu" type="text">
      <span class="no_cek" id="no_pen_cekibu">&nbsp;</span></td>
    </tr>
  <tr><td>&nbsp;</td>
    <td>Nama</td>
    <td width="0%">:</td>
    <td colspan="3"><input autocomplete="off" name="namaibu" id="namaibu" style="width:300px;" type="text"><input name="pupusibu" id="pupusibu" value="1" type="checkbox">
     #Almarhumah</td>
    </tr>
  <tr><td>&nbsp;</td>
    <td>Tempat/Tgl Lahir</td>
    <td>:</td>
    <td colspan="3"><input name="ttl1ibu" id="ttl1ibu" type="text">, <input id="ttl2ibu" data-date="" data-date-format="dd-mm-yyyy" value="" readonly="" size="50" name="ttl2ibu" style="width:100px;" placeholder="dd-mm-yyyy" type="text"></td>
    </tr> 
  <tr><td>&nbsp;</td>
    <td>Agama</td>
    <td>:</td>
    <td><select name="agmibu" id="agmibu">
    <option value="a" selected="selected"> </option>
    
    <?php $arsip_agama = mysql_query("select * from arsip_agama"); 
	while($agama=mysql_fetch_array($arsip_agama)){
		echo "<option value='$agama[id_agama]'>$agama[agama]</option>";
	}
		?></select>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr><td>&nbsp;</td>
    <td>Alamat</td>
    <td>:</td>
    <td> 
    <input name="almtibu" id="almtibu" style="width:300px;" type="text">
        <button type="button" id="tooltip" data-toggle="tooltip" data-placement="top" title="Samakan Alamat Dengan Lembar Identitas" class="btn btn-default btn-xs ambilalmt" data-id="almt" data-rt="rt" data-rw="rw" data-desa="desa" data-kec="kec" data-kab="kab" data-rel="ibu">
  <span class="glyphicon glyphicon-edit"></span>#1
</button>
<button type="button" id="tooltip" data-toggle="tooltip" data-placement="top" title="Samakan Alamat Dengan Data Ayah" class="btn btn-default btn-xs ambilalmt" data-id="almtayah" data-rt="rtayah" data-rw="rwayah" data-desa="desaayah" data-kec="kecayah" data-kab="kabayah" data-rel="ibu">
  <span class="glyphicon glyphicon-edit"></span>#2
</button>
</td>
    <td rowspan="2"></td>
    <td>&nbsp;</td>
    </tr>
  <tr><td>&nbsp;</td>
    <td>RT/RW</td>
    <td>:</td>
    <td>
      <input name="rtibu" id="rtibu" style="width:45px;" type="number" min="1"> / 
      <input name="rwibu" id="rwibu" style="width:45px;" type="number" min="1">
      
    </td>
    <td></td>
  </tr>
  <tr><td>&nbsp;</td>    
    <td>Desa/Kelurahan</td>
    <td>:</td>
    <td><input name="desaibu" type="text" id="desaibu" style="width:200px;" value="<?php echo "$set[desa]"; ?>"/>&nbsp;</td>
    <td></td>
    <td></td>
  </tr>
  <tr><td>&nbsp;</td>
    <td>Kecamatan</td>
    <td>:</td>
    <td><input name="kecibu" type="text" id="kecibu" style="width:200px;" value="<?php echo "$set[kecamatan]"; ?>"/>&nbsp;</td>
    <td></td>
    <td></td>
  </tr>
  <tr><td>&nbsp;</td>
    <td>Kabupaten/kota</td>
    <td>:</td>
    <td><input name="kabibu" type="text" id="kabibu" style="width:200px;" value="<?php echo "$set[kabupaten]"; ?>"/>&nbsp;</td>
    <td></td>
    <td></td>
  </tr> 
  <tr><td>&nbsp;</td>
    <td>Pekerjaan</td>
    <td>:</td>
    <td><select name="kerjaibu" id="kerjaibu">
    <option value="a"> </option>
    <?php $arsip_pekerjaan = mysql_query("select * from arsip_pekerjaan"); 
	while($kerja=mysql_fetch_array($arsip_pekerjaan)){
		echo "<option value='$kerja[id_pekerjaan]'>$kerja[pekerjaan]</option>";
	}
		?>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>  
  <tr><td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr></table>     
      
      
    <div class="clearfix"></div> 
      <table style="display: none;" class="skkk lembar2" width="100%">
      <tbody><tr>
        <td colspan="5">
<hr><b><h3>Surat Keterangan Kegiatan Keramaian</h3></b><hr></td>
      </tr>
      
            <tr>
              <td width="27%">Jenis Kegiatan</td>
              <td width="1%">:</td>
              <td><input name="jenisrame" id="jenisrame" style="width: 330px;" placeholder="Orgen/Band/Pensi" type="text"></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td width="3%">&nbsp;</td>
            </tr>
            <tr>
              <td width="27%">Waktu Pelaksanaan</td>
              <td width="1%">:</td>
              <td><input id="datepicker1"  data-date="" data-date-format="dd-mm-yyyy" value="" readonly="" name="wakturame" maxlength="10" type="text" style="width:100px;"></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td width="3%">&nbsp;</td>
            </tr>
            <tr>
              <td width="27%">Maksud Kegiatan</td>
              <td width="1%">:</td>
              <td><input name="maksudrame" id="maksudrame" style="width: 330px;" placeholder="Resepsi Pernikahan/Khitan" type="text"></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td width="3%">&nbsp;</td>
            </tr>
            <tr>
              <td width="27%"></td>
              <td width="1%">&nbsp;</td>
              <td></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td width="3%">&nbsp;</td>
            </tr>
            
      </tbody></table>
    <div class="clearfix"></div> 
      <table style="display: none;" class="skw lembar2" width="100%">
      <tbody><tr>
        <td colspan="5">
<hr><b><h3>Surat Keterangan Kematian</h3></b><hr></td>
      </tr>
      
            <tr>
              <td width="27%">Tanggal Wafat</td>
              <td width="1%">:</td>
              <td><input id="tglwafat" data-date="" data-date-format="dd-mm-yyyy" value="" readonly="" name="tglwafat" maxlength="10" type="text"></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td width="3%">&nbsp;</td>
            </tr>
            <tr>
              <td width="27%">Kota Wafat</td>
              <td width="1%">:</td>
              <td><input name="di" id="di" style="width: 330px;" placeholder="Desa/Kota" type="text"></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td width="3%">&nbsp;</td>
            </tr>
            <tr>
              <td width="27%">Sebab Wafat</td>
              <td width="1%">:</td>
              <td><input name="sebabwafat" id="sebabwafat" style="width: 330px;" type="text"></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td width="3%">&nbsp;</td>
            </tr>
            <tr>
              <td width="27%"></td>
              <td width="1%">&nbsp;</td>
              <td></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td width="3%">&nbsp;</td>
            </tr>
            
      </tbody></table>
    <div class="clearfix"></div> 
  
      <table style="display: none;" class="skpd lembar2" width="100%"> 
      
      <tbody><tr>
        <td colspan="6">
<hr><b>
<h3>Surat Keterangan Pindah Datang WNI</h3>
</b><hr></td> 
      </tr>
      
  <tr>
    <td colspan="4"><h5>DATA DASAR</h5></td>
    </tr>
    <tr>
    <td width="21%">Kepala Keluarga</td>
    <td width="1%">:</td>
    <td colspan="2"><input name="skpdkk" id="skpdkk" style="width:300px;" type="text"></td>
    </tr>
   
    
  <tr>
    <td colspan="4"><h5>DATA KEPINDAHAN</h5></td>
    </tr>
    <tr>
    <td>Alasan Pindah</td>
    <td>:</td>
    <td colspan="2">
      <select name="skpdap" id="skpdap">
        <option value="a" selected="selected"> </option>
        <option value="1">Pekerjaan</option>
        <option value="2">Pendidikan</option>
        <option value="3">Keamanan</option>
        <option value="4">Kesehatan</option>
        <option value="5">Perumahan</option>
        <option value="6">Keluarga</option>
  </select>
      / <input name="skpdtulisalasan" id="skpdtulisalasan" value="7" type="checkbox"> Lainnya :  
      <input name="skpdtulisalasan2" id="skpdtulisalasan2" style="width:200px;" placeholder="Sebutkan alasan disini" type="text">
    </td>
    </tr>
  <tr>
    <td>Alamat Tujuan </td>
    <td>:</td>
    <td width="53%"> 
      <input name="skpdalmt" id="skpdalmt" style="width:300px;" type="text"></td>
    <td width="25%"></td>
    </tr>
  <tr>
    <td>RT/RW</td>
    <td>:</td>
    <td>
      <input name="skpdrt" id="skpdrt" style="width:45px;" type="number" min="1"> / 
      <input name="skpdrw" id="skpdrw" style="width:45px;" type="number" min="1">
      
    </td>
    <td></td> 
  </tr>
  
  <tr>    
    <td>Desa/Kelurahan</td>
    <td>:</td>
    <td><input name="skpddesa" type="text" id="skpddesa" style="width:200px;" value="<?php echo "$set[desa]"; ?>"/>&nbsp;</td>
    <td></td> 
      </tr>
  <tr>
    <td>Kecamatan</td>
    <td>:</td>
    <td><input name="skpdkec" type="text" id="skpdkec" style="width:200px;" value="<?php echo "$set[kecamatan]"; ?>"/>&nbsp;</td>
    <td></td> 
  </tr>
  <tr>
    <td>Kabupaten/kota</td>
    <td>:</td>
    <td><input name="skpdkab" type="text" id="skpdkab" style="width:200px;" value="<?php echo "$set[kabupaten]"; ?>"/>&nbsp;</td>
    <td></td> 
  </tr>
  <tr>
    <td>Provinsi</td>
    <td>:</td>
    <td><input name="skpdprov" type="text" id="skpdprov" style="width:200px;" value="<?php echo "$set[provinsi]"; ?>"/>&nbsp;</td>
    <td></td> 
  </tr>
  <tr>
    <td>Klasifikasi Pindah</td>
    <td>:</td>
    <td>
    <select name="skpdkp" id="skpdkp">
    <option value="a" selected="selected"> </option>
	<option value="1">Dalam Satu Desa Kelurahan</option>
	<option value="2">Antar Desa/Kelurahan</option>
	<option value="3">Antar Kecamatan</option>
	<option value="4">Antar Kab/Kota</option>
	<option value="5">Antar Provinsi</option>
</select>
    </td>
    <td></td>
    </tr>
  <tr>
    <td>Jenis Kepindahan</td>
    <td>:</td>
    <td>
    <select name="skpdjk" id="skpdjk">
    <option value="a" selected="selected"> </option>
	<option value="1">Kep. Keluarga</option>
	<option value="2">Kep. Keluarga Sel Angg.</option>
	<option value="3">Kep. Keluarga &amp; Seb Angg.</option>
	<option value="4">Angg. Keluarga</option> 
</select>
    </td>
    <td></td>
    </tr> 
  <tr>
    <td colspan="4"><hr>
      <table width="100%">
        <tbody><tr>
          <td width="45%">Status Nomor KK Yang Tidak Pindah</td>
          <td width="2%">:</td>
          <td width="53%"><select name="skpdnokktp" id="skpdnokktp" style="width:250px">
    <option value="a" selected="selected"> </option>
	<option value="1">Numpang KK</option>
	<option value="2">Membuat KK Baru</option>
	<option value="3">Tidak Ada Angg. Kel Yg Ditunggu</option>
	<option value="4">Nomor KK Tetap</option>
</select></td>
        </tr>
      </tbody></table></td>
  </tr> 
  <tr>
    <td colspan="4"> 
      <table width="100%">
        <tbody><tr>
          <td width="45%">Status Nomor KK Bagi Yg Pindah </td>
          <td width="2%">:</td>
          <td width="53%">
      <select name="skpdnokkp" id="skpdnokkp" style="width:250px">
    <option value="a" selected="selected"> </option>
	<option value="1">Numpang KK</option>
	<option value="2">Membuat KK Baru</option>
	<option value="3">Nomor Kep. Kel &amp; KTP Tetap</option>
</select></td>
        </tr>
      </tbody></table></td>
  </tr>
 
    
  <tr>
    <td colspan="4">Rencana Tanggal Pindah  : 
      <input id="datepickerskpd" data-date="" data-date-format="dd-mm-yyyy" value="" readonly="" name="skpdrtglpindah" maxlength="10" type="text" style="width:100px;"></td>
    </tr>
  <tr>
    <td colspan="4">Keluarga Yang Pindah :</td>
  </tr>
  <tr>
    <td colspan="4"><table class="list" width="100%">
      <tbody><tr class="subtitle">
        <td width="4%">NO</td>
        <td width="4%">-</td>
        <td width="32%">NIK</td>
        <td width="49%">NAMA</td>
        <td>SHDK</td>
        </tr>
        </tbody>
	  <tr>
        <td colspan="5">&nbsp;</td>
      </tr>
    </tbody>
		<tbody id="listangota">      
      <tr>
        <td colspan="5" style="padding:5px;"><div class="alert alert-info">Data Anggota Keluarga Akan Tampil Setelah Anda Menulis No KK Yang terverifikasi di bagian atas.</div></td> 
      </tr>
      </tbody>
      <tbody>
	  <tr>
        <td colspan="5">&nbsp;</td>
      </tr>
    </tbody></table></td>
  </tr> 
      </tbody></table>
      
    <div class="clearfix"></div> 
      <table style="display: none;" class="ktp lembar2" width="100%">
      <tbody><tr>
        <td colspan="5">
<hr><b>
<h3>Formulir KTP</h3>
</b><hr></td> 
      </tr>
      <tr>
      <td width="27%">Permohonan KTP</td>
      <td width="1%">:</td>
        <td colspan="3">&nbsp;&nbsp;&nbsp;
		
		<div class="btn-group">
		<label class="btn btn-default active">
		<input id="permohonanktp" name="permohonanktp" value="1" checked="checked" type="radio"> Buat Baru
		</label>
		<label class="btn btn-default">
		<input id="permohonanktp" name="permohonanktp" value="2" type="radio"> Perpanjangan
		</label>
		<label class="btn btn-default">
		<input id="permohonanktp" name="permohonanktp" value="3" type="radio"> Pergantian
		</label>
		</div>
		
		</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
      </tr>
      </tbody></table>
      
      
    <div class="clearfix"></div> 
      
      <table width="100%" style="display: none;" class="resi skd sku skdu sktm skkm skkb skk skkk skw skpd ktp lembar2">
      <tbody><tr>
    <td width="34%">Keterangan Surat</td>
    <td width="1%">:</td>
    <td><input name="ket" id="ket" style="width: 330px;" data-validation="custom" data-validation-regexp="^[a-zA-Z\,\.\(\)\-\s]+$" data-validation-error-msg="&nbsp;?&nbsp;&nbsp; : Keterangan surat harus diisi." type="text"></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>Tanggal Buat</td>
    <td>:</td>
    <td><input id="datepicker" data-date="" data-date-format="dd-mm-yyyy" value="" readonly="" name="tglbuat" data-validation="required" data-validation-error-msg="&nbsp;?&nbsp;&nbsp; :  Tanggal Lahir Harus di isi !" data-validation-format="dd-mm-yyyy" maxlength="10" type="text" style="width:105px;"></td>
    <td>&nbsp;</td>
    </tr> 
  <tr>
    <td>Yang Bertanda Tangan</td>
    <td>:</td>
    <td><select name="ybt" id="ybt" data-validation="number" data-validation-error-msg="&nbsp;?&nbsp;&nbsp; : Pilih salah satu !" style="width:165px;"> 
	 <?php
	
$pejabat1=mysql_query("SELECT * FROM pejabat where teken='Y'");
while($b=mysql_fetch_array($pejabat1)){
		echo "<option value='$b[id]'>$b[nama]</option>";
	}
	?>
	</select></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">
	
		<div class="btn-group">
		<button type="submit" name="submit" value="PROSES" id="submitsurat" value="Simpan" data-loading-text="Memproses..." class="btn  btn-default disabled">
		<span class="glyphicon glyphicon-floppy-open"></span> PROSES</button> 
		</div>  <input type="checkbox" class="btn btn-primary" id="aktifkan"> Cek Jika Data Sudah Benar
		<button type="button" data-toggle="modal" data-target="#alertbersihkan" data-backdrop="static" value="BERSIHKAN"  style="float:right;" class="btn btn-default"><span class="glyphicon glyphicon glyphicon-trash"></span> BERSIHKAN</button>&nbsp;</td>
    </tr>
  </tbody></table>
  
      <table width="100%" style="display:block;" class="lembar2" id="info">
      <tbody>
	  <tr>
        <td colspan="5" style="padding:5px;"><div class="alert alert-info" style="width:545px;">Silahkan Pilih Terlebih Dahulu Jenis Pelayanan Di Panel Sebelah Kiri.</div></td> 
      </tr>
	  </tbody>
	  </table>
  </div>
  
  <!--// modal bersihkan // -->
	<div class="modal fade" id="alertbersihkan" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    
    <div class="modal-content" id="reloadcont">
      <div class='modal-header'>
		<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
		<h4 class='modal-title' id='reloadLabel'><span class="glyphicon glyphicon-comment"></span> SI PA'DE Bilang ...</h4>
		</div>
		<div class='modal-body'>
		Apakah anda yakin untuk membersihkan semua isian ?
    </div>
		<div class="modal-footer"> 
     <button type="reset" id="bersihkan" onclick="tutupmodal(bersihkantutup)"  style="float:left;" class="btn btn-danger"><span class="glyphicon glyphicon glyphicon-trash"></span> BERSIHKAN</button>&nbsp;
	 <button type="button" id="bersihkantutup" style="float:right;" class="btn btn-default"  data-dismiss="modal"> TIDAK</button>&nbsp;
	 <div class="clearfix"></div>		 
		</div>
  </div>
</div>
	
     </form>
     </div> </div> 

<div class="footer clearfix"><div style="float:left; width:300px; text-align:left;">SI PA'DE v.2.0 &nbsp;&nbsp;&nbsp;&nbsp; | Use updated Internet browser for best performer</div><div style="float:right; width:300px; text-align:right;">© 2014 Ade A S | RakIT Solution <br></div></div>
<br/>

	 
<!-- Modal -->
<?php include "inc/ui_modal.php"; ?>
	
	
<script src="rakstrap/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.js"></script> 
<script src="rakstrap/js/pace.min.js"></script>
 
<script type="text/javascript" src="rakstrap/js/date_time.js"></script>
<script type="text/javascript">window.onload = date_time('date_time');</script>
<script type="text/javascript">   
$('body').tooltip({
    selector: '[data-toggle=tooltip]'
}); 
$.fn.extend({
    popoverClosable: function (options) {
        var defaults = {
            template:
                '<div class="popover">\
<div class="arrow"></div>\
<div class="popover-header">\
<button type="button" class="close" data-dismiss="popover" aria-hidden="true">&times;</button>\
<h3 class="popover-title"></h3>\
</div>\
<div class="popover-content"></div>\
</div>'
        };
        options = $.extend({}, defaults, options);
        var $popover_togglers = this;
        $popover_togglers.popover(options);
        $popover_togglers.on('click', function (e) {
            e.preventDefault();
            $popover_togglers.not(this).popover('hide');
        });
        $('html').on('click', '[data-dismiss="popover"]', function (e) {
            $popover_togglers.popover('hide');
        });
    }
});

$(function () {
    $('[data-toggle="popover"]').popoverClosable();
});
//menampilkan modal  
$('#myModal').on('show.bs.modal', function (e) {
  });
	  
$('#myModal').on('hidden.bs.modal', function (e) {
   $(this).removeData('bs.modal');
   $("#myModal .modal-content").html("<div class='modal-header'>"
+ "<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>"
+ "<h4 class='modal-title' id='myModalLabel'>SEDANG MEMUAT...</h4>"
+ "</div>" 
+ "<div class='modal-body'>"
+ "<div class='progress progress-striped active'>"
+ "<div class='progress-bar'  role='progressbar' aria-valuenow='45' aria-valuemin='0' aria-valuemax='100' style='width: 100%'></div></div></div>");
   
}); 

</script>

  <script src="rakstrap/js/jquery.form-validator.js"></script>

<script>
  $.validate({ 
    validateOnBlur : true // disable validation when input looses focus 
 
  });
  
 
</script>
<script type='text/javascript'>

	function tutupmodal (dismiss){ 
		$(dismiss).click();		
    $('.lembar2').hide();   
	$('.btn').removeClass('active'); 
	$('#info').show(); 
	$('.no_cek').html(""); 
	} 
</script>
<script type='text/javascript'>
$(document).ready(function() {
  $(window).keydown(function(event){ 
    if(event.keyCode == 13) { //menonaktifkan submit via enter
      event.preventDefault();
      return false;
    }
  });
});

		$("#aktifkan").prop("checked", false);
$('#aktifkan').click(function(){ // enable submit button via checkbox
         $(this).toggleClass('active');
         $('#submitsurat').toggleClass('disabled');
         $('#submitsurat').toggleClass('btn-default');
         $('#submitsurat').toggleClass('btn-primary');
});
</script>
<script type="text/javascript">  
		$(".trigger").prop("checked", false);
var dari = document.getElementById("dari");

$("#anakke").change(function() { 
var min = this.value;
    $("#dari").attr('min', min);
});
</script>
<script type="text/javascript">
//menampilkan modal
$('#myModal').on('show.bs.modal', function (e) {
   $(".modal-content").html("<div class=\"modal-header\"><button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">&times;</button><h4 class=\"modal-title\" id=\"myModalLabel\">INFORMASI</h4></div><div class=\"modal-body\"><div class=\"progress progress-striped active\"><div class=\"progress-bar\"  role=\"progressbar\" aria-valuenow=\"45\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: 100%\"><span class=\"sr-only\">Memuat</span></div></div></div>");
})
	  
$('#myModal').on('hidden.bs.modal', function (e) {
   $(this).removeData('bs.modal');
})
</script>
<script type="text/javascript">
        $(document).ready(function(){
            $("#no_kk").blur(function(){
				
		$("#listangota").html("<tr><td colspan='5'><br/><div class='alert alert-info'><p align='center'><img src='images/loading.gif' style='width:20px; height:20px;'/> loading...</p></div></td></tr>");
                 var nokk = $("#no_kk").val();
				 var noid = $("#no_pen").val();
                 $.ajax({
                    type:"post",
                    url:"inc/inc_anggota.php",
                    data:"nokk="+nokk+"&noid="+noid,
                    success: function(data) {
                      $("#listangota").html(data);
                    }
                 });
            });
       });
    </script>
	
   <script type="text/javascript">
$(document).ready(function(){ 

$(".ambilalmt").click(function() {
	//ambil data lembar identitas #1
    	$('#almt' + $(this).data('rel')).val($('#' + $(this).data('id')).val());
    	$('#rt' + $(this).data('rel')).val($('#' + $(this).data('rt')).val());
    	$('#rw' + $(this).data('rel')).val($('#' + $(this).data('rw')).val());
    	$('#desa' + $(this).data('rel')).val($('#' + $(this).data('desa')).val());
    	$('#kec' + $(this).data('rel')).val($('#' + $(this).data('kec')).val());
    	$('#kab' + $(this).data('rel')).val($('#' + $(this).data('kab')).val());
	
});
});
</script>

      
<script type="text/javascript" src="bootstrap/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="bootstrap/js/locales/bootstrap-datetimepicker.id.js" charset="UTF-8"></script>
      
<script type='text/javascript'>   
	$('#ttl2').datetimepicker({
        language:  'id',  
		autoclose: 1,
		todayHighlight: 1, 
		minView: 2, 
		weekStart: 1, 
		forceParse: 0
    });
	$('#ttl2ayah').datetimepicker({
        language:  'id',  
		autoclose: 1,
		todayHighlight: 1, 
		minView: 2, 
		weekStart: 1, 
		forceParse: 0
    });
	$('#ttl2ibu').datetimepicker({
        language:  'id',  
		autoclose: 1,
		todayHighlight: 1, 
		minView: 2, 
		weekStart: 1, 
		forceParse: 0
    });
	$('#datepicker').datetimepicker({
        language:  'id',  
		autoclose: 1,
		todayHighlight: 1, 
		minView: 2, 
		weekStart: 1, 
		forceParse: 0,
		todayBtn: true,
		pickerPosition: "top-right"
    });
	$('#datepicker1').datetimepicker({
        language:  'id',  
		autoclose: 1,
		todayHighlight: 1, 
		minView: 2, 
		weekStart: 1, 
		forceParse: 0
    });
	$('#tglwafat').datetimepicker({
        language:  'id',  
		autoclose: 1,
		todayHighlight: 1, 
		minView: 2, 
		weekStart: 1, 
		forceParse: 0
    });
	$('#datepickerskpd').datetimepicker({
        language:  'id',  
		autoclose: 1,
		todayHighlight: 1, 
		minView: 2, 
		weekStart: 1, 
		forceParse: 0
    });    

	$('#jamlahir').datetimepicker({
        language:  'id',
        weekStart: 1, 
		autoclose: 1, 
		startView: 1,
		minView: 0,
		maxView: 1,
		forceParse: 0
    });
</script>

   <script type="text/javascript">
$(document).ready(function(){   
   $('.trigger').click(function() {
	this.checked = true;
    $('.lembar2').hide();   
	$('.btn').removeClass('active');
    $('#' + $(this).data('rel')).addClass('active');
    $('.' + $(this).data('rel')).slideDown('');
    $('.surat_' + $(this).data('rel')).slideDown('');
});
   
});
</script>  
<script type="text/javascript" src="rakstrap/js/bsn.AutoSuggest_2.1.3.js" charset="utf-8"></script>

<script type="text/javascript">
	var no_pen = { 
		script:"inc/inc_sugest.php?data=nopensurat&limit=20&",
		varname:"input",
		json:true,
		shownoresults:false,
		maxresults:20, 
		maxheight: 250,
		callback: function (obj) {  
		document.getElementById('no_pen').value = obj.id;    
		document.getElementById('no_kk').value = obj.add;
			document.getElementById('skpdkk').value = obj.add3;            
		$("#no_pen_cek").html("<img src='images/loading.gif' style='width:20px; height:20px;'/>");
var no_pen = $("#no_pen").val();
	$.ajax({
	type:"GET",
	url:"inc/inc_ceknik.php?mod=nopen",
	data: "no_pen="+no_pen,
		success: function(data){
				if(data==0){ 
	 $("#no_pen_cek").html("<img src='images/error.ico' style='width:20px; height:20px;'/> <sup>Tidak Terverifikasi</sup>"); 
				}
				else{ 
	 $("#no_pen_cek").html("<img src='images/success.png' style='width:20px; height:20px;'/> <sup>Terverifikasi</sup>");
				}
		}
	}); 
		  
		$("#no_kk_cek").html("<img src='images/loading.gif' style='width:20px; height:20px;'/>");
var no_kk = $("#no_kk").val();
	$.ajax({
	type:"GET",
	url:"inc/inc_ceknik.php?mod=nokk",
	data: "no_kk="+no_kk,
		success: function(data){
				if(data==0){ 
	 $("#no_kk_cek").html("<img src='images/error.ico' style='width:20px; height:20px;'/> <sup>Tidak Terverifikasi</sup>"); 
					
		$("#listangota").html("<tr><td colspan='5'><br/><div class='alert alert-info'><p align='center'><img src='images/loading.gif' style='width:20px; height:20px;'/> loading...</p></div></td></tr>");
                 var nokk = $("#no_kk").val();
				 var noid = $("#no_pen").val();
                 $.ajax({
                    type:"post",
                    url:"inc/inc_anggota.php",
                    data:"nokk="+nokk+"&noid="+noid,
                    success: function(data) {
                      $("#listangota").html(data);
                    }
                 });
             
				}
				else{ 
	 $("#no_kk_cek").html("<img src='images/success.png' style='width:20px; height:20px;'/> <sup>Terverifikasi</sup>");
	 $("#no_kk_tbh").html(""); 
		$("#listangota").html("<tr><td colspan='5' style='padding:5px;'><div class='alert alert-info'><p align='center'><img src='images/loading.gif' style='width:20px; height:20px;'/> loading...</p></div></td></tr>");
                 var nokk = $("#no_kk").val();
				 var noid = $("#no_pen").val();
                 $.ajax({
                    type:"post",
                    url:"inc/inc_anggota.php",
                    data:"nokk="+nokk+"&noid="+noid,
                    success: function(data) {
                      $("#listangota").html(data);
                    }
                 });
            
				}
		}
	});   ; 
		    document.getElementById('nama').value = obj.value; 
		    document.getElementById('ortu').value = obj.add2; 
		    document.getElementById('ttl1').value = obj.tmpt; 
		    document.getElementById('ttl2').value = obj.tgl;
		    document.getElementById('jk').selectedIndex = obj.jk; 
		    document.getElementById('agm').selectedIndex = obj.agm; 
		    document.getElementById('kerja').selectedIndex = obj.kerja; 
		    document.getElementById('status').selectedIndex = obj.status;  
		    document.getElementById('wn').selectedIndex = obj.wn;  
		    document.getElementById('almt').value = obj.almt;  
		    document.getElementById('rw').value = obj.rw;	
		    document.getElementById('rt').value = obj.rt;	
				  
		}
		   
	};
	var as_json = new bsn.AutoSuggest('no_pen', no_pen); 
		
	var ayah_pen = { 
		script:"inc/inc_sugest.php?data=nopensurat&jk=1&limit=20&",
		varname:"input",
		json:true,
		shownoresults:false,
		maxresults:6,
		callback: function (obj) {  
		    document.getElementById('no_penayah').value = obj.id; 
		    document.getElementById('namaayah').value = obj.value; 
		    document.getElementById('ttl1ayah').value = obj.tmpt; 
		    document.getElementById('ttl2ayah').value = obj.tgl;
		    document.getElementById('agmayah').selectedIndex = obj.agm; 
		    document.getElementById('kerjaayah').selectedIndex = obj.kerja; 
		    document.getElementById('almtayah').value = obj.almt;  
		    document.getElementById('rwayah').value = obj.rw;	
		    document.getElementById('rtayah').value = obj.rt;              
		$("#no_pen_cekayah").html("<img src='images/loading.gif' style='width:20px; height:20px;'/>");
var no_pen = $("#no_penayah").val();
	$.ajax({
	type:"GET",
	url:"inc/inc_ceknik.php?mod=nopen",
	data: "no_pen="+no_pen,
		success: function(data){
				if(data==0){ 
	 $("#no_pen_cekayah").html("<img src='images/error.ico' style='width:20px; height:20px;'/> <sup>Tidak Terverifikasi</sup>"); 
				}
				else{ 
	 $("#no_pen_cekayah").html("<img src='images/success.png' style='width:20px; height:20px;'/> <sup>Terverifikasi</sup>");
				}
		}
	}); 
	}
	};
	var as_json = new bsn.AutoSuggest('namaayah', ayah_pen);
	var as_json = new bsn.AutoSuggest('no_penayah', ayah_pen);	
		
	var ibu_pen = { 
		script:"inc/inc_sugest.php?data=nopensurat&jk=2&limit=20&",
		varname:"input",
		json:true,
		shownoresults:false,
		maxresults:6,
		callback: function (obj) {  
		    document.getElementById('no_penibu').value = obj.id; 
		    document.getElementById('namaibu').value = obj.value; 
		    document.getElementById('ttl1ibu').value = obj.tmpt; 
		    document.getElementById('ttl2ibu').value = obj.tgl;
		    document.getElementById('agmibu').selectedIndex = obj.agm; 
		    document.getElementById('kerjaibu').selectedIndex = obj.kerja; 
		    document.getElementById('almtibu').value = obj.almt;  
		    document.getElementById('rwibu').value = obj.rw;	
		    document.getElementById('rtibu').value = obj.rt;              
		$("#no_pen_cekibu").html("<img src='images/loading.gif' style='width:20px; height:20px;'/>");
var no_pen = $("#no_penibu").val();
	$.ajax({
	type:"GET",
	url:"inc/inc_ceknik.php?mod=nopen",
	data: "no_pen="+no_pen,
		success: function(data){
				if(data==0){ 
	 $("#no_pen_cekibu").html("<img src='images/error.ico' style='width:20px; height:20px;'/> <sup>Tidak Terverifikasi</sup>"); 
				}
				else{ 
	 $("#no_pen_cekibu").html("<img src='images/success.png' style='width:20px; height:20px;'/> <sup>Terverifikasi</sup>");
				}
		}
	});
	}
	};
	var as_json = new bsn.AutoSuggest('namaibu', ibu_pen);
	var as_json = new bsn.AutoSuggest('no_penibu', ibu_pen);
	
			 
</script> 
    
    <script type="text/javascript">
$(document).ready(function(){ 
    
$("#no_pen").keyup(function(){
	 $("#no_pen_cek").html("<img src='images/loading.gif' style='width:20px; height:20px;'/>");
var no_pen = $("#no_pen").val();
	$.ajax({
	type:"GET",
	url:"inc/inc_ceknik.php?mod=nopen",
	data: "no_pen="+no_pen,
		success: function(data){
				if(data==0){ 
	 $("#no_pen_cek").html("<img src='images/error.ico' style='width:20px; height:20px;'/> <sup>Tidak Terverifikasi</sup>"); 
				}
				else{ 
	 $("#no_pen_cek").html("<img src='images/success.png' style='width:20px; height:20px;'/> <sup>Terverifikasi</sup>");
				}
		}
	});
}); 
  
 
    
$("#no_kk").change(function(){
	 $("#no_kk_cek").html("<img src='images/loading.gif' style='width:20px; height:20px;'/>");
var no_kk = $("#no_kk").val();
	$.ajax({
	type:"GET",
	url:"inc/inc_ceknik.php?mod=nokk",
	data: "no_kk="+no_kk,
		success: function(data){
				if(data==0){ 
	 $("#no_kk_cek").html("<img src='images/error.ico' style='width:20px; height:20px;'/> <sup>Tidak Terverifikasi</sup>"); 
				}
				else{ 
	 $("#no_kk_cek").html("<img src='images/success.png' style='width:20px; height:20px;'/> <sup>Terverifikasi</sup>");
	 $("#no_kk_tbh").html("");
				}
		}
	});
}); 
  
 
}); 
</script>
    
    <script type="text/javascript">
	function openpop () { 
				$("#popup2").fadeIn("fast");
				$("#popup1").fadeIn("slow");
 
    }
	$(document).ready(function(){ 			
			 	
				 
			$(".popup_close").click(function(){
				$("#popup2").fadeOut("fast");
				$("#popup1").fadeOut("slow");
				$("#popup").fadeOut("slow");
				return false;
			});
			$("#popup").click(function(){
				$("#popup2").fadeOut("fast");
				$("#popup1").fadeOut("fast");
				$("#popup").fadeOut("slow");
				return false;
			});
			$("#popup_open").live("click",function(){
		
		var element = $(this);
		var get = element.attr("data-get");
		var id = element.attr("data-id");
		var dataPage = get+'.php?';
		var dataString = 'id='+id;
				$("#popup").fadeIn("slow");
				$("#popup1").load('ktpmenu.php?'+dataString);
				$("#popup1").fadeIn("slow"); 
				$("#popup2").fadeIn("slow"); 
				$("#popup2").html("<div style='margin:auto; width:20px; height:20px;'><img src='images/loading.gif' style='width:16px; height:16px;' /></div>"); 
				$("#popup2").load(dataPage+dataString);
				
			  $.ajaxSetup ({ cache: false });	
				return false;
			});
 
		});
		
	</script>
    
    
    <script type="text/javascript">
$('.number').on('keypress', function(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    return !(charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57));
});

$('.number').on('focusout', function() {
    var value = $(this).val();
    
    $(this).val(value.replace(/[^0-9]/g, ''));
}); 
    </script>
          
</body></html> 
  <?php 
} 
}
?>