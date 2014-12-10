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
  <link href="rakstrap/css/loadingindicator.css" rel="stylesheet">
</head>

<body class="pace-done">
<?php include "inc/ui_top_panel.php"; ?>
<div class="container clearfix">
<div class="header clearfix"> 
     
<div class="row">
  <div class="col-md-4"><h2>#Penghitung </h2></div>
  <div class="col-md-4" style="text-align:center;"><h1>STATISTIK DATA</h1></div>
  <div class="col-md-4" style="text-align:right;"> 
</div> 
</div> 
  
    
    <div class="clear"> </div><hr>
<div class="informasi" align="center">
    [!] Statistik terhitung berdasarkan informasi yang tersimpan dalam data dasar SI PA'DE
   
     <div class="clear"></div> 
     </div>
    
     <div class="clear"></div>
     <hr> 
	 </div>
     <div class="content">
	  
            <table border="0" class="list" id="DPTTable"><caption><h4 >DATA PENDUDUK TERKINI</h4 ><hr /></caption>
       <thead>
        <tr valign="middle" align="center">
            <td colspan="3" align="center" valign="middle">&nbsp;</td>
              <td colspan="12" align="center" valign="middle">Mutasi Penduduk</td> 
         </tr>
            <tr>
              <td colspan="3" align="center" valign="middle">Jumlah Data Penduduk Tersimpan</td>
            <td colspan="3" align="center" valign="middle">Meninggal</td>
            <td colspan="3" align="center" valign="middle">Pindah</td>
              <td colspan="3" align="center" valign="middle">Jumlah Penduduk Terkalkulasi</td>
              <td  align="center" valign="middle">Kartu Keluarga</td>
              <td colspan="2" align="center" valign="middle">Kartu Penduduk</td>
           </tr>
         </thead> 
         <tr class="subtitle">
           <td>L</td>
           <td>P</td>
           <td>JML</td>
           <td>L</td>
           <td>P</td>
           <td>JML</td>
           <td>L</td>
           <td>P</td>
           <td>JML</td>
           <td>L</td>
           <td>P</td>
           <td>JML</td>
           <td>W</td> 
           <td>W</td>
           <td>B</td>
         </tr>
         <tbody>
         <?php 
$pendudukwftl=mysql_query("SELECT * FROM  penduduk WHERE statusnya='3' AND kelamin_pen='1'");
  $jmldatawftl = mysql_num_rows($pendudukwftl);
$pendudukwftp=mysql_query("SELECT * FROM  penduduk WHERE statusnya='3' AND kelamin_pen='2'");
  $jmldatawftp = mysql_num_rows($pendudukwftp);
  $jmldatawft = $jmldatawftp+$jmldatawftl;
  
$pendudukpinl=mysql_query("SELECT * FROM  penduduk WHERE statusnya='2' AND kelamin_pen='1'");
  $jmldatapinl = mysql_num_rows($pendudukpinl);
$pendudukpinp=mysql_query("SELECT * FROM  penduduk WHERE statusnya='2' AND kelamin_pen='2'");
  $jmldatapinp = mysql_num_rows($pendudukpinp);
  $jmldatapin = $jmldatapinp+$jmldatapinl;
  
$penduduk=mysql_query("SELECT * FROM  penduduk");
  $jmldata = mysql_num_rows($penduduk);
  
$pendudukp=mysql_query("SELECT * FROM  penduduk WHERE kelamin_pen='2'");
  $jmldatap = mysql_num_rows($pendudukp);
  $jmldatal = $jmldata-$jmldatap;
  
  $jmldataak = $jmldata-$jmldatapin-$jmldatawft;
  
  $jmldatapak = $jmldatap-$jmldatapinp-$jmldatawftp;
  $jmldatalak = $jmldatal-$jmldatapinl-$jmldatawftl;
  
  $jmldatalak = $jmldataak-$jmldatapak;
$kk=mysql_query("SELECT * FROM  kk");
  $jmldatakk = mysql_num_rows($kk);
         ?>  
         <tr valign="middle" align="center"> 
           <td>&nbsp;</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td> 
           <td>&nbsp;</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
         </tr>
         <tr valign="middle" align="center" height="50px">
           <td><?php echo $jmldatal; ?></td>
           <td><?php echo $jmldatap; ?></td>
           <td><?php echo $jmldata; ?></td> 
           <td><?php echo $jmldatawftl; ?></td> 
           <td><?php echo $jmldatawftp; ?></td> 
           <td><?php echo $jmldatawft; ?></td> 
           <td><?php echo $jmldatapinl; ?></td> 
           <td><?php echo $jmldatapinp; ?></td> 
           <td><?php echo $jmldatapin; ?></td> 
           <td><?php echo $jmldatalak; ?></td>
           <td><?php echo $jmldatapak; ?></td>
           <td><?php echo $jmldataak; ?></td>
           <td><?php echo $jmldatakk; ?></td> 
           <?php 
$diumuran = mysql_query("SELECT * FROM statistik where tipe='wajibktp'");
$u = mysql_fetch_array($diumuran);

    $diumur=explode("-",$u['data']);
$data ="SELECT nama_pen, DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tanggal_lahir_pen)), '%Y')+0 AS Umur FROM penduduk where statusnya='0' AND DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(tanggal_lahir_pen, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(tanggal_lahir_pen, '00-%m-%d')) between ".$diumur['0']." and ".$diumur['1']."";
$data = mysql_query($data);
$jmlwajibktp = mysql_num_rows($data); 
$jmlblmktp = $jmldataak-$jmlwajibktp; 
?>
           <td><?php echo $jmlwajibktp; ?></td> 
           <td><?php echo $jmlblmktp; ?></td>
           </tr>
         <tr>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td> 
           <td>&nbsp;</td> 
           <td>&nbsp;</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
         </tr>
         </tbody>
       </table>
       <hr/>     
      <div class="btn-group">
  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-print"></span></button>

  <div class="btn-group">
    <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button">
      <span class="glyphicon glyphicon-file"></span> Ekspor DPT
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
      <li class=""><a href="#" onclick="tableToExcel('DPTTable', 'Data Penduduk Terkini')">.xls</a></li>
      
    </ul>
  </div> 
</div>
       <hr/>
       <table class="list" id="JPBUTable"><caption><h4 >JUMLAH PENDUDUK BERDASARKAN USIA</h4 ><hr /></caption>
       <thead>
            <tr>
              <td align="center" valign="middle">Usia</td>
              <td colspan="3" align="center" valign="middle">Rincian</td> 
           </tr>
         <tr class="subtitle">
           <th>Tahun</th>
           <th>Laki-laki</th>
           <th>Perempuan</th>
           <th>Jumlah</th>
         </tr> 
         </thead> 
         <tbody>
         
         <?php 
$diumuran = mysql_query("SELECT * FROM statistik where tipe='umur' order by id");
while ($u = mysql_fetch_array($diumuran))
{
    $diumur=explode("-",$u['data']);
$data ="SELECT nama_pen, DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tanggal_lahir_pen)), '%Y')+0 AS Umur FROM penduduk  where statusnya='0' AND DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(tanggal_lahir_pen, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(tanggal_lahir_pen, '00-%m-%d')) between ".$diumur['0']." and ".$diumur['1']."";
$data = mysql_query($data);
$jml = mysql_num_rows($data);
//data laki-laki
$datalk ="SELECT nama_pen, DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tanggal_lahir_pen)), '%Y')+0 AS Umur FROM penduduk  where statusnya='0' AND kelamin_pen='1' AND  DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(tanggal_lahir_pen, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(tanggal_lahir_pen, '00-%m-%d')) between ".$diumur['0']." and ".$diumur['1']."";
$datalk = mysql_query($datalk);
$jmllk = mysql_num_rows($datalk); 
$jmlper = $jml-$jmllk;
while ($d = mysql_fetch_array($data)){
echo "<tr valign='middle' align='center'>
           <td class='nomor'>&nbsp;".$diumur['0']." - ".$diumur['1']."&nbsp;</td>";
		   $data .= " AND kelamin_pen='1'";   
			$datal = mysql_query($data);
			$jmll = mysql_num_rows($datal);
			echo "
           <td>$jmllk</td>
           <td>$jmlper</td> 
           <td>$jml</td> 
           </tr>";
} 
}

$datajml = "SELECT * FROM penduduk where statusnya='0' ";
			$jmltotal = mysql_num_rows(mysql_query($datajml));
$datajml.= " AND kelamin_pen='1'"; 
			$datalaki = mysql_query($datajml);
			$jmllaki = mysql_num_rows($datalaki);
			$jmlperempuan = $jmltotal-$jmllaki;
echo "<tr valign='middle' align='center'>
           <td class='nomor'><b>Jumlah</b></td>
           <td>$jmllaki</td>
           <td>$jmlperempuan</td> 
           <td>$jmltotal</td> 
           </tr>";
?> 
         </tbody>
       </table><hr/>
      <div class="btn-group">
  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-print"></span></button>

  <div class="btn-group">
    <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button">
      <span class="glyphicon glyphicon-file"></span> Ekspor DJPBU 
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
      <li class=""><a href="#" onclick="tableToExcel('JPBUTable', 'JML PEN USIA')">.xls</a></li>
      
    </ul>
  </div> 
</div>
<hr /> <div id="grafikperumur"></div>
            
       <hr/>
       <table class="list" id="JPBRWTable"><caption><h4 >JUMLAH PENDUDUK BERDASARKAN RW</h4 ><hr /></caption>
       <thead>
            <tr>
              <td align="center" valign="middle">Rukun Warga</td>
              <td colspan="3" align="center" valign="middle">Rincian</td> 
           </tr>
         <tr class="subtitle">
           <th>RW</th>
           <th>Laki-laki</th>
           <th>Perempuan</th>
           <th>Jumlah</th>
         </tr> 
         </thead> 
         <tbody>
         
         <?php 
$rw = mysql_query("SELECT * FROM arsip_rw order by id_rw");
while ($r = mysql_fetch_array($rw))
{ 
$datarwall = mysql_query("SELECT * FROM penduduk where statusnya='0' AND rw_pen='$r[id_rw]'");
$datarwall = mysql_num_rows($datarwall); 
$dataperrw = mysql_query("SELECT * FROM penduduk where statusnya='0' AND kelamin_pen='1' AND rw_pen='$r[id_rw]'");
$jmllkperrw = mysql_num_rows($dataperrw);  
$jmlperperrw = $datarwall-$jmllkperrw;  
 echo "<tr valign='middle' align='center'>
           <td class='nomor'>$r[rw]</td>
           <td>$jmllkperrw</td>
           <td>$jmlperperrw</td> 
           <td>$datarwall</td> 
           </tr>";
} 

$perrw = mysql_query("SELECT * FROM penduduk where statusnya='0'");
$jmlperrw = mysql_num_rows($perrw); 
$perrwlk = mysql_query("SELECT * FROM penduduk  where statusnya='0' AND kelamin_pen='1'");
$jmlperrwlk = mysql_num_rows($perrwlk);   
$jmlperrwper = $jmlperrw-$jmlperrwlk;  
 echo "<tr valign='middle' align='center'>
           <td class='nomor'><b>Jumlah</b></td>
           <td>$jmlperrwlk</td> 
           <td>$jmlperrwper</td>
           <td>$jmlperrw</td> 
           </tr>";
?> 
         </tbody>
       </table><hr/>
      <div class="btn-group">
  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-print"></span></button>

  <div class="btn-group">
    <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button">
      <span class="glyphicon glyphicon-file"></span> Ekspor DJPBRW 
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
      <li class=""><a href="#" onclick="tableToExcel('JPBRWTable', 'JML PEN RW')">.xls</a></li>
      
    </ul>
  </div> 
</div><hr/> 
       <table border="0" class="list" id="JPBITable"><caption><h4 >JUMLAH PELAYANAN PER TAHUN 
	   <?php if(isset($_POST['tahunpel'])){
  echo "$_POST[tahunpel]";
  }
  else {
  echo "$thn_sekarang";
  } ?></h4 ><hr /></caption>
       <thead>
             <tr>
             <td><?php if(isset($_POST['tahunpel'])){
  echo "$_POST[tahunpel]";
  }
  else {
  echo "$thn_sekarang";
  } ?></td>
             
         <?php 
$surat = mysql_query("SELECT * FROM statistik where tipe='surat'  AND aktif='Y' order by id");
$col = mysql_num_rows($surat);
$colspan = $col;
?>
              <td colspan="<?php echo $colspan ?>" align="center" valign="middle">Jenis Pelayanan</td>
           <td align="center" valign="middle">Jumlah</td>
           </tr>
         </thead> 
         <tr class="subtitle">
         <td>BULAN</td>
         <?php 
while ($s = mysql_fetch_array($surat)){
	echo "<td>$s[data]</td>"; } ?>
    
           <td>Total</td>
         </tr> 
         <tbody>
         <?php
		 
  if(isset($_POST['tahunpel'])){
  $tahunpel = $_POST['tahunpel'];
  }
  else {
  $tahunpel = $thn_sekarang;
  }
		 
$PISAH = spliting2("010203040506070809101112"); //setiap dua digit menyimbolkan satu bulan (saat ini diset hingga 12 bulan)
//looping dalam array
$nobln=1;  
foreach ($PISAH as $BLN) {  
	 $blnth = $BLN.' '.$tahunpel; 
	 $blnindo = getBulan(substr($BLN,0,2));
         echo "
         <tr valign='middle' align='center'>";
        echo "<td>$blnindo</td>";
$surat = mysql_query("SELECT * FROM statistik where tipe='surat' AND aktif='Y' order by id");
while ($s = mysql_fetch_array($surat)){
	echo "<td>";
$query = "SELECT * FROM pelayanan WHERE date_format(tgl, '%m %Y') = '$blnth' AND js='$s[data]'";  
$hasil = mysql_query($query);
  $ketemu = mysql_num_rows($hasil);  
   if ($ketemu!=''){ echo "$ketemu"; }
   else { echo "-"; }
   }
   echo "</td>";
   
$total = "SELECT * FROM pelayanan WHERE date_format(tgl, '%m %Y') = '$blnth'";  
$total = mysql_query($total);
  $jtotal = mysql_num_rows($total);
           echo "<td>$jtotal</td></tr> "; 
$nobln++;
}  

		 ?>  
         </tbody>
         </table><hr/><div class="btn-group">
  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-print"></span></button>

  <div class="btn-group">
    <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button">
      <span class="glyphicon glyphicon-file"></span> Ekspor DJP
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
      <li class=""><a href="#" onclick="tableToExcel('JPBITable', 'JML Pelayanan')">.xls</a></li>
      
    </ul>
  </div> </div>
  <div style="float:right;">
 <form method="post"> <div class="input-group" style="width:240px"><div class="btn-group">
  <button class="btn btn-default" type="button">Lihat Per Tahun </button> 
 <div class="btn-group">
 <select name="tahunpel" id="tahunpel" class="form-control" style="border-bottom:1px solid #ccc;border-top:1px solid #ccc"> 
 <?php  
$tahun = "SELECT DISTINCT date_format(tgl, '%Y') as tahun FROM pelayanan order by tgl DESC";  
$tahun = mysql_query($tahun);  
while ($data = mysql_fetch_array($tahun))  
{   
   echo '<option value="'.$data['tahun'].'">'.$data['tahun'].'</option>';  
}    
 ?> </select></div>
  
  <div class="btn-group">
    <button class="btn btn-default dropdown-toggle" type="submit"><span class="glyphicon glyphicon-zoom-in"></span></button>
        
      </div> 
    </div></div>
      </form>
	</div>
<div class="clearfix"></div>
<hr />
   <div id="grafikpelayanan"></div>
   </div>   
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

<script src="rakstrap/js/highcharts.js" type="text/javascript"></script>
<script src="rakstrap/js/jquery.highchartTable.js" type="text/javascript"></script>
<script src="rakstrap/js/modules/exporting.js"></script>

    <script type="text/javascript">
	

(function($){ // encapsulate jQuery
//surat
$(function () {
    $('#grafikpelayanan').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Grafik Persentase Pelayanan Tahun Ini, Total : <?php 
	 $blnth = $tahunpel; 
$total = "SELECT * FROM pelayanan WHERE date_format(tgl, '%Y') = '$blnth'";  
$total = mysql_query($total);
  $jtotal = mysql_num_rows($total);
           echo "$jtotal Surat"; ?>'
        },
        tooltip: {
    	    pointFormat: '{series.name}: <b>{point.y} Surat</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    color: '#000000',
                    connectorColor: '#000000',
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Jumlah',
            data: [<?php 
		 
$surat = mysql_query("SELECT * FROM statistik where tipe='surat' AND aktif='Y'  order by id");
while ($s = mysql_fetch_array($surat)){
$query = "SELECT * FROM pelayanan WHERE date_format(tgl, '%Y') = '$blnth' AND js='$s[data]'";  
$hasil = mysql_query($query);
  $ketemu = mysql_num_rows($hasil);  
   if ($ketemu!=''){ echo "['$s[data]', $ketemu],"; }
   else { echo "['$s[data]',   0],"; }
   } 
   
?>]
        }]
    });
});
    //usia
$(function () {
    var chart,
        categories = [<?php 
$diumuran = mysql_query("SELECT * FROM statistik where tipe='umur'  AND aktif='Y' order by id");
while ($u = mysql_fetch_array($diumuran))
{
    $diumur=explode("-",$u['data']);
echo "'".$diumur['0']."-".$diumur['1']."',";
} ?>];
    $(document).ready(function() {
        $('#grafikperumur').highcharts({
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Piramida Penduduk Berdasarkan Usia'
            },
            subtitle: {
                text: ''
            },
            xAxis: [{
                categories: categories,
                reversed: false,
                labels: {
                    step: 1
                }
            }, { // mirror axis on right side
                opposite: true,
                reversed: false,
                categories: categories,
                linkedTo: 0,
                labels: {
                    step: 1
                }
            }],
            yAxis: {
                title: {
                    text: null
                },
                labels: {
                    formatter: function(){
                        return (Math.abs(this.value)) + ' Jiwa';
                    }
                },
                min: -1000,
                max: 1000
            },
    
            plotOptions: {
                series: {
                    stacking: 'normal'
                }
            },
    
            tooltip: {
                formatter: function(){
                    return '<b>'+ this.series.name +', Usia '+ this.point.category +'</b><br/>'+
                         Highcharts.numberFormat(Math.abs(this.point.y), 0) +' Jiwa';
                }
            },
    
            series: [{
                name: 'Laki-laki',
                data: [<?php 
$diumuran1 = mysql_query("SELECT * FROM statistik where tipe='umur' AND aktif='Y'  order by id");
while ($u = mysql_fetch_array($diumuran1))
{
    $diumur=explode("-",$u['data']);
//data laki-laki
$datalk ="SELECT nama_pen, DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tanggal_lahir_pen)), '%Y')+0 AS Umur FROM penduduk  where statusnya='0' AND kelamin_pen='1' AND  DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(tanggal_lahir_pen, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(tanggal_lahir_pen, '00-%m-%d')) between ".$diumur['0']." and ".$diumur['1']."";
$datalk = mysql_query($datalk);
$jmllk = mysql_num_rows($datalk); 
echo "-".$jmllk.", ";}?>]
            },
			{   name: 'Perempuan',
                data: [<?php 
$diumuran1 = mysql_query("SELECT * FROM statistik where tipe='umur'  AND aktif='Y' order by id");
while ($u = mysql_fetch_array($diumuran1))
{
    $diumur=explode("-",$u['data']);
//data laki-laki
$dataper ="SELECT nama_pen, DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tanggal_lahir_pen)), '%Y')+0 AS Umur FROM penduduk where statusnya='0' AND kelamin_pen='2' AND  DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(tanggal_lahir_pen, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(tanggal_lahir_pen, '00-%m-%d')) between ".$diumur['0']." and ".$diumur['1']."";
$dataper = mysql_query($dataper);
$jmlper = mysql_num_rows($dataper); 
echo $jmlper.", ";}?>]
            }]
        });
    });
    
});
})(jQuery);
$(document).ready(function(){ 	 
  $('table.highchart').highchartTable();
}); 
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