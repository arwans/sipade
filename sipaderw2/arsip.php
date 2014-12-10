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
  include"fungsi/fungsi_combobox.php";
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
</head>

<body class="pace-done">
<?php include "inc/ui_top_panel.php"; ?>
<div class="container clearfix">
<div class="header clearfix"> 
     
<div class="row">
  <div class="col-md-4 head-left"><h2>#Pencatatan</h2></div>
  <div class="col-md-4 head-center"><h1>CATATAN PELAYANAN</h1></div>
  <div class="col-md-4 head-right"> 
</div> 
</div> 
  
    
    <div class="clear"> </div><hr>
<div class="informasi">
<?php    
echo '<form method="GET"><div class="input-group" style="width:515px; margin:auto;">';   
      combotglarsip(1,31,'tanggal',$tgl_skrg,'form-control noborder-bottom','width:65px; margin-right:5px');
        combonamabln1('bulan',$bln_sekarang,'form-control noborder-bottom','width:115px; margin-right:5px');
echo '<select name="tahun" id="tahun" class="form-control noborder-bottom" style="width:80px; margin-right:5px">'; 
 
$tahun = "SELECT DISTINCT date_format(tgl, '%Y') as tahun FROM pelayanan order by tgl DESC";  
$tahun = mysql_query($tahun);  
while ($data = mysql_fetch_array($tahun))  
{   
   echo '<option value="'.$data['tahun'].'">'.$data['tahun'].'</option>';  
}  
         echo "<option value='0'>----</option>";
echo '</select>';   if(isset($_GET['no_pen']) | $_GET['no_pen']!==''){ $no_penquery = $_GET[no_pen];} 
 echo " <input type='text' class='form-control noborder-bottom' name='no_pen' id='no_pen' value='$no_penquery' placeholder='Atas Nama / no. ID ?'  style='width:165px;'><span id='no_pen_cek' style='position: absolute;right: -100px;top: 5px;';>&nbsp;</span>";

echo '<span class="input-group-btn"><button type="submit" name="submit" value="Saring" class="btn btn-default"><span class="glyphicon glyphicon-filter"></span>Saring</button></span>';

 echo '</div></form>';  
  
?> 
     </div>
    
     <div class="clear"></div>
     <hr> 
	 </div>
     <div class="content"> <?php
	 if(isset($_GET[submit])){ 
	 
	 if(isset($_GET['tahun']) AND $_GET['bulan']=='13' AND  $_GET['tanggal']=='32'){ 
$blnthterpilih = $_GET['tahun'];
	 }
	 
	 elseif(isset($_GET['bulan']) AND   $_GET['tahun']=='0' AND  $_GET['tanggal']=='32'){ 
$blnthterpilih = blnindo($_GET['bulan']);     
	 }
	 
	 elseif(isset($_GET['tahun']) AND  isset($_GET['bulan']) AND $_GET['tanggal']=='32'){ 
$blnthterpilih = blnindo($_GET['bulan']).' '.$_GET['tahun']; 
	 }
	 elseif(isset($_GET['tahun']) AND  isset($_GET['bulan']) AND  isset($_GET['tanggal'])){ 
$blnthterpilih = $_GET['tanggal'].' '.blnindo($_GET['bulan']).' '.$_GET['tahun'];   
	 }
	 else { 
	 $blnthterpilih = $tgl_skrg.' '.blnindo($bln_sekarang).' '.$thn_sekarang;
	 }
	  ?> 
	  <table width="100%" border="0" class="list" id="arsipTable"><caption><h4>CATATAN PELAYANAN / <?php echo $blnthterpilih;
 if(isset($_GET['no_pen'])){ 
  $anggota  = mysql_query("SELECT * FROM penduduk WHERE no_pen='$_GET[no_pen]'");
$a=mysql_fetch_array($anggota);	 
if($_GET['no_pen']!==""){
	$jml = mysql_num_rows($anggota);
	if ($jml=="0"){
		echo "<br/>$_GET[no_pen] (Tidak Dikenali)";
		}
	else {
	 echo " <br/>".$a[no_pen]." ( $a[nama_pen] )";
	}
}
else {}}     ?></h4><hr /></caption>
       <thead class="part2">
            <tr>
              <td width="3%">No.</td>
              <td width="12%">Tanggal</td>
              <td width="20%">Nama</td>
              <td width="12%">Tanggal Lahir</td>
              <td width="5%">JK</td>
              <td width="10%">Agama</td>
              <td width="18%">Alamat</td>
              <td width="5%">Jenis</td>
            </tr>
          </thead> 
         <tr class="subtitle">
           <td>&nbsp;</td>
           <td>[1]</td>
           <td>[2]</td>
           <td>[3]</td>
           <td>[4]</td>
           <td>[5]</td>
           <td>[6]</td>
           <td>[7]</td>
         </tr> 
           
      <?php
	  
 if(!isset($_GET['no_pen']) | $_GET['no_pen']==''){ $riwayat = " "; $riwayat2=" ORDER BY tgl DESC"; } else { $riwayat = " no_pen='$_GET[no_pen]'  AND "; $riwayat2=" ORDER BY tgl DESC"; }
 if($_SESSION[leveluser]=='1'){ $level=" uname='$_SESSION[namauser]' AND ";} else {$level="";}
	 if(isset($_GET['tahun']) AND $_GET['bulan']=='13' AND  $_GET['tanggal']=='32'){ 
$blnth = $_GET['tahun'];   
$query = "SELECT * FROM pelayanan WHERE ".$level.$riwayat."date_format(tgl, '%Y') = '$blnth' ". $riwayat2;  
	 }
	 
	 elseif(isset($_GET['bulan']) AND   $_GET['tahun']=='0' AND  $_GET['tanggal']=='32'){ 
$blnth = $_GET['bulan'];   
$query = "SELECT * FROM pelayanan WHERE ".$level.$riwayat."date_format(tgl, '%m') = '$blnth' ". $riwayat2;  
	 }
	 
	 elseif(isset($_GET['tahun']) AND  isset($_GET['bulan']) AND $_GET['tanggal']=='32'){ 
$blnth = $_GET['bulan'].' '.$_GET['tahun'];   
$query = "SELECT * FROM pelayanan WHERE ".$level.$riwayat."date_format(tgl, '%m %Y') = '$blnth' ". $riwayat2;  
	 }
	 elseif(isset($_GET['tahun']) AND  isset($_GET['bulan']) AND  isset($_GET['tanggal'])){ 
$blnth = $_GET['tanggal'].' '.$_GET['bulan'].' '.$_GET['tahun'];   
$query = "SELECT * FROM pelayanan WHERE ".$level.$riwayat."date_format(tgl, '%d %m %Y') = '$blnth' ". $riwayat2;  
	 }
	 else { 
	 $blnth = $tgl_skrg.' '.$bln_sekarang.' '.$thn_sekarang;
$query = "SELECT * FROM pelayanan WHERE ".$level.$riwayat."date_format(tgl, '%d %m %Y') = '$blnth' ". $riwayat2;  
	 }
	 
$hasil = mysql_query($query);
  $ketemu = mysql_num_rows($hasil);  
  
  if ($ketemu!=''){  
$no=1;
while($r=mysql_fetch_array($hasil)){
	$tgl = tgl_indo2($r[tgl]);
	$tgl_lhr = tgl_indo2($r[tgl_lhr]);
	echo "<tr>
           <td class='nomor'>$no</td>
           <td><span data-toggle='tooltip' title='$r[jam] | $r[uname]'>$tgl</span></td>
           <td><a title='$r[no_pen]&nbsp;'>$r[nl]</a></td>
           <td>$tgl_lhr</td>
           <td>$r[jk]</td>
           <td>$r[agm]</td>
           <td><div class='datahide'>$r[almt]</div></td>
           <td><a title='$r[ket]'>$r[js]</a></td>
         </tr>";
		 $no++;
	}
  }
  else {
	echo "<tr>
           <td colspan='8'>&nbsp</td>
         </tr>";
	  echo "<tr>
           <td colspan='8'><div class='alert alert-warning' style='margin:5px;'><p align='center'>Tidak ditemukan data dengan kasifikasi yang ditetapkan saat ini : <b>[";
		   echo $blnthterpilih;		
		   
 if(isset($_GET['no_pen'])){ 
  $anggota  = mysql_query("SELECT * FROM penduduk WHERE no_pen='$_GET[no_pen]'");
$a=mysql_fetch_array($anggota);	 
if($_GET['no_pen']!==''){
	 echo " a/n $a[nama_pen] ( ".$a[no_pen]." )";}
 }
		   echo"]</b></p></div></td>
           </tr>";
		 }
	
	echo "<tr>
           <td colspan='8'>&nbsp</td>
         </tr>";
	?>
    
        
       </table>
       
          <hr />
      <div class="btn-group">
  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-print"></span></button>

  <div class="btn-group">
    <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button">
      <span class="glyphicon glyphicon-file"></span> Ekspor
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
      <li class=""><a href="#" onclick="tableToExcel('arsipTable', 'Pelayanan <?php echo $blnthterpilih;
?>')">.xls</a></li>
    </ul>
  </div> 
</div><hr />
       	<?php } 
		else {
			?>
            
       <table width="100%" border="0" class="list">
       <thead class="part2">
            <tr>
              <td> Klik Tombol &quot;Saring&quot; Untuk Melihat Data Pelayanan</td>
            </tr>
          </thead> 
          </table>
          <?php
			}?>
       
</div>   
    
     <div class="clear"></div>
  </div> 

<div class="footer clearfix"><div style="float:left; width:300px; text-align:left;">SI PA'DE v.2.0 &nbsp;&nbsp;&nbsp;&nbsp; | Use updated Internet browser for best performer</div><div style="float:right; width:300px; text-align:right;">© 2014 Ade A S | RakIT Solution <br></div></div>
<br/>

<!-- Modal -->
<?php include "inc/ui_modal.php"; ?>
	
	
	
<script src="rakstrap/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.js"></script> 
<script src="rakstrap/js/pace.min.js"></script>
<script type="text/javascript" src="rakstrap/js/date_time.js"></script>
<script type="text/javascript">window.onload = date_time('date_time');</script>
<script type="text/javascript" src="rakstrap/js/bsn.AutoSuggest_2.1.3.js" charset="utf-8"></script>

<script type="text/javascript">
	var no_pen = { 
		script:"inc/inc_sugest.php?data=penpelayanan&limit=6&",
		varname:"input",
		json:true,
		shownoresults:false,
		maxresults:6,
		callback: function (obj) {  
		document.getElementById('no_pen').value = obj.id;            
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
		    
				  
		}
		   
	};
	var as_json = new bsn.AutoSuggest('no_pen', no_pen); 
		
			 
</script> 
<script type='text/javascript'>//<![CDATA[ 

var tableToExcel = (function() {
  var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
  return function(table, name) {
    if (!table.nodeType) table = document.getElementById(table)
    var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
    window.location.href = uri + base64(format(template, ctx))
  }
})()
//]]>  

</script>
<script type="text/javascript">  

		    document.getElementById('tahun').value = <?php if(isset($_GET[tahun])) {echo $_GET[tahun];} ?>; 
		    document.getElementById('bulan').selectedIndex = '<?php if(isset($_GET[bulan])) {echo $_GET[bulan]-1;} ?>'; 
		    document.getElementById('tanggal').selectedIndex = '<?php if(isset($_GET[tanggal])) {echo $_GET[tanggal]-1;} ?>'; 
			</script>
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
   $(".modal-content").html("<div class=\"modal-header\"><button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">&times;</button><h4 class=\"modal-title\" id=\"myModalLabel\">INFORMASI</h4></div><div class=\"modal-body\"><div class=\"progress progress-striped active\"><div class=\"progress-bar\"  role=\"progressbar\" aria-valuenow=\"45\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: 100%\"><span class=\"sr-only\">Memuat</span></div></div></div>");
})
	  
$('#myModal').on('hidden.bs.modal', function (e) {
   $(this).removeData('bs.modal');
})
</script>

   <script type="text/javascript">
$(document).ready(function(){  
    $('.lembar2').hide(); 
   $('.trigger').click(function() {
	this.checked = true;
    $('.lembar2').hide();   
	$('.btn').removeClass('active');
    $('#' + $(this).data('rel')).addClass('active');
    $('.' + $(this).data('rel')).show('');
    $('.surat_' + $(this).data('rel')).show('');
});
   
});
</script> 
<script type="text/javascript">  
// menandai semua checkbox
   $(function() {
    $("#idpenselectall").on("click", function() {
        $("input#idpenselect").prop("checked", this.checked);
            $("#jmlch").html($("input#idpenselect[type=checkbox]:checked").length);
        if ($("input#idpenselect:checked").length == 0 ) {

            $("#btnstatusnya").fadeOut("medium") ;

        }else {
            
            // without visibility verification, it is unnecesary :)
            $("#btnstatusnya").fadeIn ("medium") ; 
        }
    });
});

// menandai checkbox satu per satu 
   $(function() { 
    $("#idpenselect").live('change', function () {

        if ($("input#idpenselect:checked").length == 0 ) {

        $("#resetstatusnya").click();
            $("#btnstatusnya").fadeOut("medium") ;

        } else {
            
            // without visibility verification, it is unnecesary :)
            $("#btnstatusnya").fadeIn("medium");
            $("#jmlch").html($("input#idpenselect[type=checkbox]:checked").length);
        }

    });
     
    
});
</script> 
 

    <script type="text/javascript">
$(document).ready(function(){ 
  
   
    $("#editstatus").submit(function (ev) {
		
				$("#submitstatus").addClass("disabled");
				$("#submitstatus").html("<span class='glyphicon glyphicon-refresh'></span> Memproses...");
	    var frm = $("#editstatus");	 
	var values = frm.serialize();
    var settype = $("#btneditstatus").attr("data-id");
        $.ajax({
            type: "post",
            url: "inc/edit_status_simpan.php?set="+settype,
            data: values,
            success: function (data) {  	
				$("#submitstatus").html("<span class='glyphicon glyphicon-refresh'></span> Berhasil !");
		  window.location.reload()
            },
        error:function(){
            alert("GAGAL");
		}
        });

        ev.preventDefault(); 	
	
    });
});
    
	</script>         
</body></html>  

  <?php 
} 
}
?>