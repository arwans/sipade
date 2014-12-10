 <?php
session_start();
error_reporting(0); 
if($_SESSION[login]==0){
  header("location:inc/logout.php");
} 
include "../fungsi/koneksi.php";

 $rule_std = mysql_query("select * from pengaturan where id='2'"); 
	$rule=mysql_fetch_array($rule_std);
	$rule_cap = mysql_query("select * from pengaturan where id='1'"); 
	$rulecap=mysql_fetch_array($rule_cap);	
	$set_pejabat = mysql_query("select * from pejabat where id='$_POST[ybt]' "); 
	$setpejabat=mysql_fetch_array($set_pejabat);
	$RULEDESA = $rule['desa'];
	$RULEKODEDESA = $rule['kodedesa'];
	$RULEKEC = $rule['kecamatan']; 
	$RULEKAB = $rule['kabupaten'];
	$RULEKODEKAB = $rule['kodekab'];
	$RULEPROV = $rule['provinsi'];
	$RULEALMT = $rule['alamat'];
	$RULEKODEPOS = $rule['kodepos'];
	$RULEKEPDESA = $rule['kepaladesa'];
	$RULEINSTALL = $rule['install'];
	
	$RULECAPDESA = $rulecap['desa'];
	$RULECAPKODEDESA = $rulecap['kodedesa'];
	$RULECAPKEC = $rulecap['kecamatan']; 
	$RULECAPKAB = $rulecap['kabupaten'];
	$RULECAPKODEKAB = $rulecap['kodekab'];
	$RULECAPPROV = $rulecap['provinsi'];
	$RULECAPALMT = $rulecap['alamat'];
	$RULECAPKODEPOS = $rulecap['kodepos'];
	$RULECAPKEPDESA = $rulecap['kepaladesa'];
	$RULECAPINSTALL = $rulecap['install'];
	
	?>
 