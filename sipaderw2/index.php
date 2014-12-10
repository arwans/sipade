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
  header('location:auth');
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
?>
 
 <?php 

if (isset($_GET['no_kk'])){ 
 
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM kk where no_kk='$_GET[no_kk]'"));
	
			  if ($jmldata > 0){} else {header('location:!beranda'); }  
				   ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>SI PA'DE | Sistem Informasi Pelayanan Desa</title>
	<link rel="shortcut icon" href="images/favicon.gif">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">  
	<link type="text/css" href="rakstrap/css/style.css" rel="stylesheet">    
  <link href="rakstrap/css/loadingindicator.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
</head>

<body class="pace-done">
<?php include "inc/ui_top_panel.php"; ?>
<div class="container clearfix">
<div class="header clearfix">
<?php

	$cekkk = mysql_num_rows(mysql_query("SELECT * FROM penduduk where no_kk_pen='$_GET[no_kk]'"));
	
			  if ($cekkk > 0){
			  
	$hdkpen = mysql_num_rows(mysql_query("SELECT * FROM penduduk where no_kk_pen='$_GET[no_kk]' AND status_hdk_pen='1'"));
	
			  if ($hdkpen=="1"){ //ada satu pen yang berstatus kep. kk
	
$kepalakeluarga=mysql_query("SELECT * FROM  penduduk,arsip_alamat,arsip_rt,arsip_rw 
							where arsip_alamat.id_alamat=penduduk.alamat_pen
							AND arsip_rt.id_rt=penduduk.rt_pen
							AND arsip_rw.id_rw=penduduk.rw_pen
							AND status_hdk_pen='1'
							AND no_kk_pen='$_GET[no_kk]'");
$k=mysql_fetch_array($kepalakeluarga);

 $nokk = $k['no_kk_pen'];
 $namakk = $k['nama_pen'];
 $alamatkk = $k['alamat'];
 $alamatrtkk = $k['rt'];
 $alamatrwkk = $k['rw'];
 $alamatdesakk = $k['desa'];
 $alamatkeckk = $k['kecamatan'];
 $alamatkabkk = $k['kabupaten_kota'];
 $alamatprovkk = $k['provinsi'];
 $alamatkodeposkk = $k['kode_pos'];
 $kepalakeluarga = "1"; //ada kepala keluarga 
 }
			  elseif ($hdkpen > 1){ //ada lebih dari satu pen yang berstatus kep. kk
	
$kepalakeluarga=mysql_query("SELECT * FROM  penduduk,arsip_alamat,arsip_rt,arsip_rw 
							where arsip_alamat.id_alamat=penduduk.alamat_pen
							AND arsip_rt.id_rt=penduduk.rt_pen
							AND arsip_rw.id_rw=penduduk.rw_pen
							AND status_hdk_pen='1'
							AND no_kk_pen='$_GET[no_kk]'");
$k=mysql_fetch_array($kepalakeluarga);

 $nokk = $k['no_kk_pen'];
 $namakk = $k['nama_pen'];
 $alamatkk = $k['alamat'];
 $alamatrtkk = $k['rt'];
 $alamatrwkk = $k['rw'];
 $alamatdesakk = $k['desa'];
 $alamatkeckk = $k['kecamatan'];
 $alamatkabkk = $k['kabupaten_kota'];
 $alamatprovkk = $k['provinsi'];
 $alamatkodeposkk = $k['kode_pos'];
 $kepalakeluarga = "2"; //ada banyak kepala keluarga 
 }
 
else {
$querycekk=mysql_query("SELECT * FROM kk,arsip_alamat,arsip_rt,arsip_rw  WHERE arsip_alamat.id_alamat=kk.alamat
							AND arsip_rt.id_rt=kk.rt
							AND arsip_rw.id_rw=kk.rw
							AND no_kk='$_GET[no_kk]'");
$k=mysql_fetch_array($querycekk);
$rule=mysql_query("SELECT * FROM pengaturan WHERE id='2'");
$rule=mysql_fetch_array($rule);

 $nokk = $k['no_kk'];
 $namakk = "<span style='background:#df5;'>".$k['catatan']."</span>";
 $alamatkk = $k['alamat'];
 $alamatrtkk = $k['rt'];
 $alamatrwkk = $k['rw'];
 $alamatdesakk = $rule['desa'];
 $alamatkeckk = $rule['kecamatan'];
 $alamatkabkk = $rule['kabupaten'];
 $alamatprovkk = $rule['provinsi'];
 $alamatkodeposkk = $rule['kodepos'];
 $kepalakeluarga = "0"; //tidak ada kepala keluarga
 }
}   
?>
     
<div class="row">
  <div class="col-md-4"><h2> No. <?php echo "$nokk";?></h2></div>
  <div class="col-md-4" style="text-align:center;"><h1>KARTU KELUARGA</h1></div>
  <div class="col-md-4" style="text-align:right;">
<div class="btn-group">
    <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button">
      <span class="glyphicon glyphicon-tasks"></span> Kelola
      <span class="caret"></span>
    </button>
    <ul class='dropdown-menu pull-right'>
      <li><a data-load='modal_edit_kk.php?id=<?php echo "$nokk";?>&mode=1' data-toggle='modal' data-target='#myModal' data-backdrop="static">Perbaharui Data KK</a></li>
	  <li><a data-load='modal_t_pen.php?id=<?php echo "$nokk";?>&mode=1' data-toggle='modal' data-target='#myModal' data-backdrop="static">Tambah Anggota</a></li>
	  <li><a data-load='getprint-<?php echo "$nokk";?>' data-toggle='modal' data-target='#myModal'>Lihat Versi Siap Cetak / Print</a></li>
	</ul>
	</div>
</div> 
</div> 
  
    
    <div class="clear"> </div><hr>
<div class="informasi">
    <div class="headl2"><table border="0" width="100%">
  <tbody><tr>
    <td width="9%">&nbsp;</td>
    <td width="39%">Nama Kepala Keluarga</td>
    <td width="4%">:</td>
    <td width="48%"><?php echo "$namakk";?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Alamat</td>
    <td>:</td>
    <td><?php echo "$alamatkk";?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>RT/RW</td>
    <td>:</td>
    <td><?php echo "$alamatrtkk / $alamatrwkk";?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Desa/Keluarahan</td>
    <td>:</td>
    <td><?php echo "$alamatdesakk";?></td>
  </tr>
</table>
</div>
    <div class="headc2"><br>
</div>
    <div class="headr2">
   
    <table width="100%" border="0">
  <tr>
    <td width="20%">&nbsp;</td>
    <td width="36%">Kecamatan</td>
    <td width="4%">:</td>
    <td width="40%"><?php echo "$alamatkeckk";?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Kabupaten/Kota</td>
    <td>:</td>
    <td><?php echo "$alamatkabkk";?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Kode Pos</td>
    <td>:</td>
    <td><?php echo "$alamatkodeposkk";?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Provinsi</td>
    <td>:</td>
    <td><?php echo "$alamatprovkk";?></td>
  </tr>
</table>
    </div> 
     <div class="clear"></div> 
     </div>
    
     <div class="clear"></div>
     <hr> <?php if($kepalakeluarga == "0"){ //tidak ada kepala keluarga
	 echo "<div class='alert alert-danger' style='text-align:center;'><span class='glyphicon glyphicon-info-sign'></span> Tidak ada satupun yang berstatus <b>kepala keluarga</b>, tetapkan salah satu data dibawah ini sebagai <b>kepala keluarga</b></div><hr/>";} 
	 if($kepalakeluarga == "2"){ //ada lebih dari satu kepala keluarga 
	 echo "<div class='alert alert-danger' style='text-align:center;'><span class='glyphicon glyphicon-info-sign'></span> Ada lebih dari satu yang berstatus <b>kepala keluarga</b>, ubah dan sisakan satu data dibawah ini sebagai <b>kepala keluarga</b></div><hr/>";} 
	  ?>
	 </div>
     <div class="content"><form id="editstatus">
       <table class="list" border="0" width="100%">
       <thead>
            <tr>
            
           <td width="3%">No.</td>
           <td width="3%">#</td>
           <td>Nama Lengkap</td>
           <td>NIK</td>
           <td>Jns Kelamin</td>
           <td>Tpt Lahir</td>
           <td>Tgl Lahir</td>
           <td>Agama</td>
           <td>Pendidikan</td>
           <td>Jenis Pekerjaan</td>
            </tr>
          </thead> 
         <tbody><tr class="subtitle">
           <td>-</td>
           <td>	
	   <?php  
			  if ($cekkk > 0){ ?><input id="idpenselectall" type="checkbox"> <?php } ?></td>
           <td>(1)</td>
           <td>(2)</td>
           <td>(3)</td>
           <td>(4)</td>
           <td>(5)</td>
           <td>(6)</td>
           <td>(7)</td>
           <td>(8)</td>
         </tr>
         </tbody><tbody id="dataanggota">
         <?php 
			  if ($cekkk > 0){
$penduduk=mysql_query("SELECT * FROM  penduduk, arsip_agama, arsip_alamat, arsip_kelamin,arsip_goldar, arsip_kewarganegaraan, arsip_pekerjaan, arsip_pendidikan, arsip_rt, arsip_rw, arsip_status, arsip_status_hdk
WHERE arsip_agama.id_agama=penduduk.agama_pen
AND arsip_alamat.id_alamat=penduduk.alamat_pen
AND arsip_kelamin.id_kelamin=penduduk.kelamin_pen
AND arsip_kewarganegaraan.id_kewarganegaraan=penduduk.kewarganegaraan_pen
AND arsip_pekerjaan.id_pekerjaan=penduduk.pekerjaan_pen
AND arsip_pendidikan.id_pendidikan=penduduk.pendidikan_pen
AND arsip_rt.id_rt=penduduk.rt_pen
AND arsip_rw.id_rw=penduduk.rw_pen
AND arsip_status.id_status=penduduk.status_pen
AND arsip_status_hdk.id_status_hdk=penduduk.status_hdk_pen
AND arsip_goldar.id_goldar=penduduk.goldar_pen
AND penduduk.no_kk_pen='$_GET[no_kk]' ORDER BY status_hdk_pen ");
	$no=1;
	while($p=mysql_fetch_array($penduduk)){	
	$tgllahir = tgl_indo2($p['tanggal_lahir_pen']);
	
		if ($p['statusnya']=="3") {
		echo "<tr class='sts2_kuning' data-id='$no' id='datafirst$no' onmouseover=\"document.getElementById('datasecond$no').className='sts2_kuning highlight';\"
            onmouseout=\"document.getElementById('datasecond$no').className='sts2_kuning';\" title='Info : Sudah Wafat'>";
		}
		elseif ($p['statusnya']=="2") {
		echo "<tr class='sts2_hijau' data-id='$no' id='datafirst$no' onmouseover=\"document.getElementById('datasecond$no').className='sts2_hijau highlight';\"
            onmouseout=\"document.getElementById('datasecond$no').className='sts2_hijau';\" title='Info : Sudah Pindah'>";
		}
		else {
		echo "<tr class='sts2_std' data-id='datasecond$no' id='datafirst$no' onmouseover=\"document.getElementById('datasecond$no').className='sts2_std highlight';\"
            onmouseout=\"document.getElementById('datasecond$no').className='sts2_std';\">";
		}
		 echo "
           <td class='nomor'>$no</td>
           <td class='nomor'><input type='checkbox'  name='idpenselect[]' class='case' value='$p[no_pen]'></td>
           <td><a id='popedit' data-container='body' data-html='true' data-toggle='popover' data-title='Pilih Lanjutan' data-placement='top' data-content=\"<div class='btn-group'><button type='button' class='btn btn-default' data-load='modal_ktp.php?id=$p[no_pen]&kk=$p[no_kk_pen]&mode=1' data-toggle='modal' data-target='#myModal'><span class='glyphicon glyphicon-credit-card'></span> E-KTP</button><button type='button' class='btn btn-default' data-load='modal_edit_pen.php?id=$p[no_pen]&kk=$p[no_kk_pen]&mode=1' data-toggle='modal' data-target='#myModal' data-backdrop='static'><span class='glyphicon glyphicon-edit'></span> Perubahan</button></div>\">$p[nama_pen]</a></td>
           <td>$p[no_pen]</td>
           <td>$p[kelamin]</td>
           <td>$p[tempat_lahir_pen]</td>
           <td>$tgllahir</td>
           <td>$p[agama]</td>
           <td>$p[pendidikan]</td>
           <td>$p[pekerjaan]</td>
         </tr>";
		 	
	$no++;
	}
	}
	else { echo "<tr><td colspan='10'><div class='alert alert-warning'><p align='center'>Tidak ada satupun data dalam [ kk ] ini, silahkan tambahkan data. awali dengan menambahkan data (kepala keluarga), lanjutkan dengan menambah data (anggota).</p></div></td></tr>";}
	
         ?>  
         <tr>
          
         </tbody>
       </table><hr>
	   
	   <?php  
			  if ($cekkk > 0){ ?>
	<div class="input-group" id="btnstatusnya" style="width:400px; display:none;">
	<div class="btn-group">
	<button class="btn btn-default" id="idpenselectlenght" type="button" data-toggle="tooltip" data-placement="top" title="Data yang dicentang"><b>Yang ditandai : </b></button> 
	
	<div class="btn-group">
	<select name="set" id="set" class="form-control" style="border:1px solid #ccc; width:240px;"  data-validation="number" data-validation-error-msg="&nbsp;?&nbsp;&nbsp;"> 
       <option value="a" style="background:#ddd; padding:2px 5px; cursor:not-allowed;" readonly>Ubah / Tentukan Status</option>
       <option value="2" style="background:#5f5; padding:5px; cursor:pointer;">Sudah tidak di desa ini (Pindah)</option>
       <option value="3" style="background:#ff5; padding:5px; cursor:pointer;">Sudah Meninggal (Wafat)</option>
       <option value="1" style="background:#fff; padding:5px; cursor:pointer;">Masih berdomisili di desa ini</option>
	</select>
	</div>

	<div class="btn-group">
	<button id="statusnyasubmit" class="btn btn-default dropdown-toggle" type="submit"><span class="glyphicon glyphicon-edit"></span></button>
	</div> 
	
	</div><button type="reset" id="resetstatusnya" hidden=""></button>
	</div>
	
     
	<?php } ?>
	
    <div class="clearfix"></div></form>
       </div>
       <div class="center"><br></div>
       <div class="content">
       <table class="list" border="0" width="100%">
       <thead class="part2">
            <tr> 
              <td rowspan="2" width="3%"><br>
              No.</td>
              <td rowspan="2" width="15%"><br>
              Status Perkawinan</td>
              <td rowspan="2" width="13%"><br>
              Status HDK</td>
              <td rowspan="2" width="13%"><br>
              Kewarganegaraan</td>
              <td colspan="2">Dokumen Imigrasi</td>
              <td colspan="2">Nama Orang Tua</td>
            </tr>
            <tr>
            
           <td width="12%">No. Paspor</td>
           <td width="12%">No. KITAS/KITAP</td>
           <td width="15%">Ayah</td>
           <td width="15%">Ibu</td>
           </tr>
          </thead> 
         <tbody><tr class="subtitle"> 
           <td>-</td>
           <td>(9)</td>
           <td>(10)</td>
           <td>(11)</td>
           <td>(12)</td>
           <td>(13)</td>
           <td>(14)</td>
           <td>(15)</td>
         </tr>
		 </tbody>
		 <tbody id="dataanggota2">
         <?php
			  if ($cekkk > 0){
$penduduk2=mysql_query("SELECT * FROM  penduduk, arsip_agama, arsip_alamat, arsip_kelamin,arsip_goldar, arsip_kewarganegaraan, arsip_pekerjaan, arsip_pendidikan, arsip_rt, arsip_rw, arsip_status, arsip_status_hdk
WHERE arsip_agama.id_agama=penduduk.agama_pen
AND arsip_alamat.id_alamat=penduduk.alamat_pen
AND arsip_kelamin.id_kelamin=penduduk.kelamin_pen
AND arsip_kewarganegaraan.id_kewarganegaraan=penduduk.kewarganegaraan_pen
AND arsip_pekerjaan.id_pekerjaan=penduduk.pekerjaan_pen
AND arsip_pendidikan.id_pendidikan=penduduk.pendidikan_pen
AND arsip_rt.id_rt=penduduk.rt_pen
AND arsip_rw.id_rw=penduduk.rw_pen
AND arsip_status.id_status=penduduk.status_pen
AND arsip_status_hdk.id_status_hdk=penduduk.status_hdk_pen
AND arsip_goldar.id_goldar=penduduk.goldar_pen
AND penduduk.no_kk_pen='$_GET[no_kk]'  ORDER BY status_hdk_pen ");
	$no=1;
	while($p=mysql_fetch_array($penduduk2)){	
	$tgllahir = tgl_indo($p['tanggal_lahir_pen']);
	
		if ($p['statusnya']=="3") {
		echo "<tr class='sts2_kuning' id='datasecond$no' onmouseover=\"document.getElementById('datafirst$no').className='sts2_kuning highlight';\"
            onmouseout=\"document.getElementById('datafirst$no').className='sts2_kuning';\" title='Info : Sudah Wafat'>";
		}
		elseif ($p['statusnya']=="2") {
		echo "<tr class='sts2_hijau' id='datasecond$no' onmouseover=\"document.getElementById('datafirst$no').className='sts2_hijau highlight';\"
            onmouseout=\"document.getElementById('datafirst$no').className='sts2_hijau';\" title='Info : Sudah Pindah'>";
		}
		else {
		echo "<tr class='sts2_std' id='datasecond$no' onmouseover=\"document.getElementById('datafirst$no').className='sts2_std highlight';\"
            onmouseout=\"document.getElementById('datafirst$no').className='sts2_std';\">";
		}
	echo " 
           <td class='nomor'><span class='casesecond'>$no</span></td>
           <td>$p[status]</td>
           <td>$p[status_hdk]</td>
           <td>$p[kewarganegaraan]</td>
           <td>$p[paspor_pen]</td>
           <td>$p[kitas_kitap_pen]</td>
		   <td>$p[ayah_pen]</td>
		   <td>$p[ibu_pen]</td>
          </tr>";
		  $no++;
	}
	}
	else { echo "<tr><td colspan='10'><div class='alert alert-warning'><p align='center'>Tidak ada satupun data dalam [ kk ] ini, silahkan tambahkan data. awali dengan menambahkan data (kepala keluarga), lanjutkan dengan menambah data (anggota).</p></div></td></tr>";}
	
	?>
		  	   
       </tbody></table>
     </div>   
  </div> 

<div class="footer clearfix"><div style="float:left; width:300px; text-align:left;">SI PA'DE v.2.0 &nbsp;&nbsp;&nbsp;&nbsp; | Use updated Internet browser for best performer</div><div style="float:right; width:300px; text-align:right;">© 2014 Ade A S | RakIT Solution <br></div></div>
<br/>
	 

<!-- Modal -->
<?php include "inc/ui_modal.php"; ?>
	
	
	
<script src="rakstrap/jquery-2.1.1.min.js"></script>
<script src="bootstrap/js/bootstrap.js"></script> 
<script src="bootstrap/js/bootstrap-growl.min.js"></script> 
<script src="rakstrap/js/pace.min.js"></script>
<script type="text/javascript" src="rakstrap/js/date_time.js"></script>
<script type="text/javascript">window.onload = date_time('date_time');</script>
<script type="text/javascript">   
$('body').tooltip({
    selector: '[data-toggle=tooltip]'
}); 
	  
$('[data-toggle=tooltip]').on('hidden.bs.tooltip', function (e) {
   $(this).removeData('bs.tooltip'); 
   
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

    <script src="print/jquery.printPage.js" type="text/javascript"></script>
	    
  <script src="rakstrap/js/jquery.form-validator.js"></script>

<script>
  $.validate({ 
    validateOnBlur : true // disable validation when input looses focus 
 
  });
  
</script>  
 <script type="text/javascript">
	function refresh (timeoutPeriod){ 
		refresh = setTimeout(function(){window.location.reload(true);},timeoutPeriod); 
	} 
	function refreshto (timeoutPeriod,to){ 
		refresh = setTimeout(function(){location.href="" + to + "";},timeoutPeriod); 
	} 
	function modalreload (eleshow,alert,text) {
	if (alert=="success") { $(eleshow + " .modal-body .alert-cont").html("<div class='alert alert-success'>" + text + "</div>"); }
	if (alert=="warning") { $(eleshow + " .modal-body .alert-cont").html("<div class='alert alert-warning'>" + text + "</div>"); }
	if (alert=="danger") { $(eleshow + " .modal-body .alert-cont").html("<div class='alert alert-danger'>" + text + "</div>"); }
	if (alert=="info") { $(eleshow + " .modal-body .alert-cont").html("<div class='alert alert-info'>" + text + "</div>"); }
	
	$(eleshow).modal({ backdrop: 'static', keyboard: false })
	}	
	function modalalert (eleshow,alert,text) { 
	if (alert=="success") { $(eleshow + " .modal-body .alert-cont").html("<div class='alert alert-success'>" + text + "</div>"); }
	if (alert=="warning") { $(eleshow + " .modal-body .alert-cont").html("<div class='alert alert-warning'>" + text + "</div>"); }
	if (alert=="danger") { $(eleshow + " .modal-body .alert-cont").html("<div class='alert alert-danger'>" + text + "</div>"); }
	if (alert=="info") { $(eleshow + " .modal-body .alert-cont").html("<div class='alert alert-info'>" + text + "</div>"); }
	
	$(eleshow).modal({ backdrop: 'static', keyboard: false })
	}	
	
	
		
</script>

<script type="text/javascript">  


		$(function(){
		$(".case, #idpenselectall").prop("checked", false);
    // add multiple select / deselect functionality
    $("#idpenselectall").click(function () {
        var checkAll = $("#idpenselectall").prop('checked');
        if (checkAll) {
            $(".case").prop("checked", true);
            $("#btnstatusnya").fadeIn("medium");
			var lenght = $(".case:checked").length;
			$("#idpenselectlenght").html("<b>" + lenght + " data terpilih</b>");								
             $(".case").parents("tr").css("background-color","#ffd");						
             $(".casesecond").parents("tr").css("background-color","#ffd"); 
        } else {
            $(".case").prop("checked", false);
            $("#btnstatusnya").fadeOut("medium");
			var lenght = $(".case:checked").length;
			$("#idpenselectlenght").html("<b>" + lenght + " data terpilih</b>");							
             $(".case").parents("tr").css("background-color","");	
             $(".casesecond").parents("tr").css("background-color","");
        }
    }); 
	 			
    // if all checkbox are selected, check the selectall checkbox and vice versa
    $(".case").change(function(){
            $("#btnstatusnya").fadeIn("medium");
			
        if($(".case").length == $(".case:checked").length) {
            $("#idpenselectall").prop("checked", true);
			var lenght = $(".case:checked").length;
			$("#idpenselectlenght").html("<b>" + lenght + " data terpilih</b>");	
        } 
		else {
		if ($(".case:checked").length == 0 ) { 
            $("#btnstatusnya").fadeOut("medium");
			var lenght = $(".case:checked").length;
			$("#idpenselectlenght").html("<b>" + lenght + " data terpilih</b>");
		}
		else {	
            $("#btnstatusnya").fadeIn("medium");}			
            $("#idpenselectall").prop("checked", false);
			var lenght = $(".case:checked").length;
			$("#idpenselectlenght").html("<b>" + lenght + " data terpilih</b>");	 
        }
    });
	
	
       $(".list input:checkbox").click(function (){
         if($(this).is(":checked"))
         { 
             var idSecond = $(this).parents("tr:first").data('id');
             $(this).parents("tr:first").css("background-color","#ffd");			
             $("#" + idSecond).css("background-color","#ffd");
         }
         else
         {
             var idSecond = $(this).parents("tr:first").data('id');
             $(this).parents("tr:first").css("background-color","");			
             $("#" + idSecond).css("background-color","");
         }
    }); 
	  
});
</script> 
 

    <script type="text/javascript">
$(document).ready(function(){ 
  
   
    $("#editstatus").submit(function (ev) {
		
				$("#statusnyasubmit").addClass("disabled"); 
			
    if ($('.error').length > 0) {
	modalalert('#alert','warning','Silahkan ubah / tentukan status !'); 
				$("#statusnyasubmit").removeClass("disabled"); 
        }
		else { 	
	    var frm = $("#editstatus");	 
	var values = frm.serialize();
    var settype = $("#btneditstatus").attr("data-id");
        $.ajax({
            type: "post",
            url: "inc/edit_status_simpan.php?set="+settype,
            data: values,
            success: function (data) {  		
             modalreload('#reload','success',data); refresh(3000) 
				$("#statusnyasubmit").removeClass("disabled"); 
            },
        error:function(){
              modalreload('#myModal','#reload','danger','Terjadi Galat Kode #AjaxError, SI PA\'DE Akan Menyegarkan Halaman Dalam 5 dtk'); refresh(5000) 
				$("#statusnyasubmit").removeClass("disabled"); 
		}
        });
		}

        ev.preventDefault(); 	
	
    });
});
    
	</script>        
<script language="JavaScript">
function bukajendela(url) {
 window.open(url, "window_baru", "width=950,height=700,left=50,top=10,resizable=1,scrollbars=1");
}
</script>
	
</body></html>
  <?php
}
}
}
?>