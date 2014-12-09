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
  header('location:modal_login.php?ref='.$_GET[kk].'&id='.$_GET[id].'&mode='.$_GET[mode].'&refname=edit_kk');
}
else{
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser']) AND $_SESSION['login']==0){
  echo "Anda harus masuk terlebih dahulu !";
}
else{
?><?php
include "fungsi/koneksi.php";
include "fungsi/fungsi_indotgl.php";
$kk=mysql_query("SELECT * FROM kk WHERE no_kk='$_GET[id]'");
	$kk=mysql_fetch_array($kk);
$alamat=mysql_query("SELECT * FROM arsip_alamat");
$rw=mysql_query("SELECT * FROM arsip_rw");
	
$rule=mysql_query("SELECT * FROM pengaturan WHERE id='2'");
$rule=mysql_fetch_array($rule);  
$arsip_agama = mysql_query("select * from arsip_agama"); 
$arsip_status = mysql_query("select * from arsip_status"); 
$arsip_status_hdk = mysql_query("select * from arsip_status_hdk"); 
$arsip_pendidikan = mysql_query("select * from arsip_pendidikan"); 
$arsip_pekerjaan = mysql_query("select * from arsip_pekerjaan"); 
$arsip_goldar = mysql_query("select * from arsip_goldar"); 
?><div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">PENAMBAHAN DATA KK</h4>
      </div> 
	   <div class="modal-body">
<div class="alert alert-info fade in clearfix" style="margin-bottom:10px;"  data-dismiss="alert" >
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<span class="glyphicon glyphicon-exclamation-sign"></span> Hindari kesalahan penulisan data dengan Lebih teliti dan waspada.
			</div>

<form action="inc/t_kk_simpan.php" method="POST" id="formeditkk">
<table width="100%">
  <tr valign="top">
    <td width="23%" valign="top"><b>Nomor KK</b></td>
    <td width="1%" valign="top">:</td>
    <td width="66%" valign="top">
<input name="no_kk" type="text" id="tkk_no_kk" placeholder="<?php echo $rule['kodekab']; ?>" value="<?php echo $rule['kodekab']; ?>" style="width:200px" data-validation="number" data-validation-error-msg="&nbsp;?&nbsp;&nbsp;" />
</td>
  </tr>
  <tr valign="top">
    <td valign="top">Alamat</td>
    <td valign="top">:</td>
    <td valign="top"><select name="alamat" id="tkk_alamat" data-validation="number" data-validation-error-msg="&nbsp;?&nbsp;&nbsp;" style="width:200px">
<option value="" selected="selected">Alamat</option>
<?php
while($a=mysql_fetch_array($alamat)){
	echo "<option value='$a[id_alamat]'>$a[alamat]</option>";
}
?> 
</select></td>
  </tr>
  <tr valign="top">
    <td valign="top">RW/RT</td>
    <td valign="top">:</td>
    <td valign="top"><select id="tkk_rw" name="rw" data-validation="number" data-validation-error-msg="&nbsp;?&nbsp;&nbsp;">
<option value="" selected="selected">RW</option>
<?php
while($a=mysql_fetch_array($rw)){
echo "<option value='$a[id_rw]'>$a[rw]</option>";
}
?>
</select> / 
<select id="tkk_rt" name="rt" data-validation="number" data-validation-error-msg="&nbsp;?&nbsp;&nbsp;">
<option value="" selected="selected">RT</option>
</select> </td>
  </tr> 
  <tr valign="top">
    <td rowspan="2" valign="top"> </td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>   
</table>

<hr/>
    Data Kepala Keluarga
	<hr/>
<table border="0" width="100%">
  <tbody>
		<tr>
		<td><b>NIK </b></td>
		<td width="0%">:</td>
		<td colspan="3"> <input name="no" id="no" placeholder="<?php echo $rule['kodekab']; ?>" value="<?php echo $rule['kodekab']; ?>" style="width: 310px;" data-validation="number" data-validation-error-msg="&nbsp;?&nbsp;&nbsp;" type="text">
		<span id="no_pen_cek">&nbsp;</span>  <span id="no_pen_tbh"></span></td>
		</tr> 
		<tr>
		<td>Nama</td>
		<td width="0%">:</td>
		<td colspan="3"><input name="nama" id="e_nama" style="width:310px;" data-validation="custom" data-validation-regexp="^[a-zA-Z\.\(\)\-\s]+$" data-validation-error-msg="&nbsp;?&nbsp;&nbsp;" type="text"></td>
		</tr>
		<tr>
		<td>Tempat/Tgl Lahir</td>
		<td>:</td>
		<td colspan="3"><input name="tempat_lahir" id="e_ttl1"  data-validation="custom" data-validation-regexp="^[a-zA-Z\.\-\s]+$" data-validation-error-msg="&nbsp;?&nbsp;&nbsp;" style="width:200px;"  type="text">,<input size="16" id="e_ttl2" data-date-format="dd-mm-yyyy"  name="tanggal_lahir"  value="<?php echo $tgllhr; ?>" style="width:105px;" data-validation="date" data-validation-error-msg="&nbsp;?&nbsp;&nbsp;" data-validation-format="dd-mm-yyyy" maxlength="10" readonly="" type="text">
		</td>
		</tr>
		<tr>
		<td>Jenis Kelamin</td>
		<td>:</td>
		<td width="52%"><select name="kelamin" id="e_kelamin" data-validation="number" data-validation-error-msg="&nbsp;?&nbsp;&nbsp;" style="width:105px;">
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
		<td><select name="agama" id="e_agama" data-validation="number" data-validation-error-msg="&nbsp;?&nbsp;&nbsp;" style="width:105px;">
		<option value="a" selected="selected"> </option>
		<?php 
		while($agama=mysql_fetch_array($arsip_agama)){
		echo "<option value='$agama[id_agama]'>$agama[agama]</option>";
		}
		?>
		</select>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>
		<tr>
		<td>Pendidikan</td>
		<td>:</td>
		<td><select name="pendidikan" id="e_pendidikan" data-validation="number" data-validation-error-msg="&nbsp;?&nbsp;&nbsp;" style="width:310px;">
		<option value="a"> </option>    

		<?php 
		while($didik=mysql_fetch_array($arsip_pendidikan)){
		echo "<option value='$didik[id_pendidikan]'>$didik[pendidikan]</option>";
		}
		?>
		</select></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>
		<tr>
		<td>Pekerjaan</td>
		<td>:</td>
		<td><select name="pekerjaan" id="e_pekerjaan" data-validation="number" data-validation-error-msg="&nbsp;?&nbsp;&nbsp;" style="width:310px;">
		<option value="a"> </option>    

		<?php 
		while($kerja=mysql_fetch_array($arsip_pekerjaan)){
		echo "<option value='$kerja[id_pekerjaan]'>$kerja[pekerjaan]</option>";
		}
		?>
		</select></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>
		<tr>
		<td>Status Nikah</td>
		<td>:</td>
		<td><select name="status" id="e_status" data-validation="number" data-validation-error-msg="&nbsp;?&nbsp;&nbsp;" style="width:105px;">
		<option value="a"> </option>	
		<?php 
		while($status=mysql_fetch_array($arsip_status)){
		echo "<option value='$status[id_status]'>$status[status]</option>";
		}
		?>
		</select></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>
		<tr>
		<td>Nama AYAH</td>
		<td>:</td>
		<td colspan="3"><input name="ayah" id="e_ayah" style="width:310px;"  data-validation="custom" data-validation-regexp="^[a-zA-Z\.\(\)\-\s]+$" data-validation-error-msg="&nbsp;?&nbsp;&nbsp;" type="text"></td>
		</tr>
		<tr>
		<td>Nama IBU</td>
		<td>:</td>
		<td colspan="3"><input name="ibu" id="e_ibu" style="width:310px;"  data-validation="custom" data-validation-regexp="^[a-zA-Z\.\(\)\-\s]+$" data-validation-error-msg="&nbsp;?&nbsp;&nbsp;" type="text"></td>
		</tr>  
		<tr>
		<td>Gol Darah</td>
		<td>:</td>
		<td><select name="goldar" id="e_goldar" data-validation="number" data-validation-error-msg="&nbsp;?&nbsp;&nbsp;">
		<option value="a"> </option>
		<?php 
		while($goldar=mysql_fetch_array($arsip_goldar)){
		echo "<option value='$goldar[id_goldar]'>$goldar[goldar]</option>";
		}
		?>
		</select></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>
	
		<tr>
		<td colspan="5"></td>
		</tr>
		<tr>
		<td colspan="5"><hr/>
		<div id="accordion">
		<div>
		<div align="center"> 
		<a data-toggle="collapse" data-parent="#accordion" href="#collapseTpen">
		<span id="tooltip" data-toggle="tooltip" data-placement="top" title="Klik Untuk Menampilkan">[Data Tambahan]</span>
		</a> 
		</div>
		<div id="collapseTpen" class="panel-collapse collapse">
		<div><hr/>
        <table width="100%" border="none">
		<tr>
		<td width="25%">Kewarganegaraan</td>
		<td width="1%">:</td>
		<td><select name="kewarganegaraan" id="e_kewarganegaraan" data-validation="number" data-validation-error-msg="&nbsp;?&nbsp;&nbsp;" style="width:105px;">
		<option value="a"> </option>
		<option value="1" selected>WNI</option>
		<option value="2">WNA</option>
		</select></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>	
		<tr>
		<td>No. Paspor</td>
		<td width="0%">:</td>
		<td colspan="3"><input name="paspor" id="e_paspor" value="-" style="width:310px;" data-validation="custom" data-validation-regexp="^[a-zA-Z\.\(\)\-\s]+$" data-validation-error-msg="&nbsp;?&nbsp;&nbsp;" type="text"></td>
		</tr>
		<tr>
		<td>No. KITAS/KITAP</td>
		<td width="0%">:</td>
		<td colspan="3"><input name="kitas_kitap" id="e_kitas_kitap" value="-" style="width:310px;" data-validation="custom" data-validation-regexp="^[a-zA-Z\.\(\)\-\s]+$" data-validation-error-msg="&nbsp;?&nbsp;&nbsp;" type="text"></td>
		</tr>
		</table>
		</div>
		</div>
		</div>
		</div>
		</td> 
		</tr>
      </tbody>
	  </table> 
       

 <div class="modal-footer"> 
		<div class="btn-group">
		<button type="submit" name="nokkinputsubmit" id="nokkinputsubmit" value="Simpan" data-loading-text="Memproses..." class="btn  btn-default disabled"><span class="glyphicon glyphicon-floppy-open"></span> PROSES</button> 
		</div>  <input type="checkbox" class="btn btn-primary" id="aktifkan"> Cek Jika Data Sudah Benar
		<button type="button" class="btn btn-default" style="float:right;" data-dismiss="modal">Tutup</button>
</form>    

       </div> 
       </div>  

			
  <script src="rakstrap/js/jquery.form-validator.js"></script>
<script>
  $.validate({ 
    validateOnBlur : true // disable validation when input looses focus 
 
  });
  
</script>  
	   
<script type="text/javascript" src="bootstrap/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="bootstrap/js/locales/bootstrap-datetimepicker.id.js" charset="UTF-8"></script>
      
<script type='text/javascript'>   
	$('#e_ttl2').datetimepicker({
        language:  'id',  
		autoclose: 1,
		todayHighlight: 1, 
		minView: 2, 
		weekStart: 1, 
		pickerPosition: "bottom-right",
		forceParse: 0
    });
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
$('#aktifkan').click(function(){ // enable submit button via checkbox
         $(this).toggleClass('active');
         $('#nokkinputsubmit').toggleClass('disabled');
         $('#nokkinputsubmit').toggleClass('btn-default');
         $('#nokkinputsubmit').toggleClass('btn-primary');
});
</script>

    <script type="text/javascript">
		$(function(){
  $("#tkk_rw").change(function(){
    $.getJSON("select.php",{id: $(this).val(), ajax: 'true'}, function(j){
      var options = '';
      for (var i = 0; i < j.length; i++) {
        options += '<option value="' + j[i].optionValue + '">' + j[i].optionDisplay + '</option>';
      }
      $("#tkk_rt").html(options);   
    })
  })
})

  </script>
            
<script type='text/javascript'> 
$("#formeditkk").submit(function (ev) {
	var btn = $("#nokkinputsubmit")
    btn.button('loading')
    if ($('.error').length > 0) {
	modalalert('#alert','warning','Masih ada data yang tidak terisi atau kurang tepat, silahkan periksa lagi !'); 
    btn.button('reset')
        }
		else { 
    var actionurl = $("#formeditkk").attr("action");
    var method = $("#formeditkk").attr("method");
    var values = $("#formeditkk").serialize();
        $.ajax({
            type: method,
            url: actionurl,
            data: values,
            success: function (data) {    
            if(data==0){ modalalert('#alert','warning','Masih ada data yang tidak terisi atau kurang tepat, silahkan periksa lagi !'); }	
            else if(data==1){ modalalert('#alert','danger','Nomor KK Sudah Digunakan, silahkan periksa lagi ! !'); }		
            else if(data==2){ modalreload('#reload','success','Data Berhasil Disimpan, SI PA\'DE Akan Menyegarkan Halaman Untuk Anda'); refresh(3000) }
            else if(data==3){ modalalert('#alert','danger','Data gagal disimpan, #serverError !');  }			
            else if(data==4){ modalalert('#alert','warning','NIK kepala keluarga Sudah terpakai, gunakan Nomor  lain !'); }	
            else { modalreload('#reload','success','Data Berhasil Disimpan, SI PA\'DE Akan Menyegarkan Halaman Untuk Anda'); refreshto('3000',data) }	
			btn.button('reset')			
            },
        error:function(){
              modalreload('#myModal','#reload','danger','Terjadi Galat Kode #AjaxError, SI PA\'DE Akan Menyegarkan Halaman Dalam 5 dtk'); refresh(5000) 
			btn.button('reset') 
		}
        });		
		}		       
		ev.preventDefault(); 	
	
}); 
</script>
<?php 
} 
}
?>