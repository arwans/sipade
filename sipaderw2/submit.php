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
include "fungsi/fungsi_indotgl.php"; 
include "fungsi/terbilang.php"; 
include "fungsi/ubahkarakter.php"; 
include "fungsi/umur.php"; 

// LEMBAR KTP
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
	
	$RULECAPDESA = $rulecap['desa'];
	$RULECAPKODEDESA = $rulecap['kodedesa'];
	$RULECAPKEC = $rulecap['kecamatan']; 
	$RULECAPKAB = $rulecap['kabupaten'];
	$RULECAPKODEKAB = $rulecap['kodekab'];
	$RULECAPPROV = $rulecap['provinsi'];
	$RULECAPALMT = $rulecap['alamat'];
	$RULECAPKODEPOS = $rulecap['kodepos'];
		if ($_POST[ybt]=='1'){	// Yang bertandatangan (kades=1) maka nama kepala desa yang dipakai	
$AN = "KEPALA DESA $rulecap[desa]";	
$KADES = $rulecap['kepaladesa'];
$KECAMATAN = $rulecap['kecamatan'];
		}
		else { // selain kades=1 (kepala desa) maka nama pejabat yang dipilihlah yang dipakai
$AN = "a/n KEPALA DESA $rulecap[desa] \n $setpejabat[ket]";	
$KADES = $setpejabat[nama_cap];
$KECAMATAN = $rulecap['kecamatan'];
		}

	$arsip_pekerjaan = mysql_query("select * from arsip_pekerjaan where id_pekerjaan='$_POST[kerja]' "); 
	$pekerjaan=mysql_fetch_array($arsip_pekerjaan);	
$PEKERJAAN = $pekerjaan[pekerjaan];
	$arsip_status = mysql_query("select * from arsip_status where id_status='$_POST[status]' "); 
	$status=mysql_fetch_array($arsip_status);	
$STATUS = $status[status];
$KET = $_POST['ket'];
$KET = ubah_huruf_awal(". ",$KET);
$NAMA = $_POST['nama'];
$NAMA = ubah_huruf_ke_besar($NAMA);
$NAMAYBS = $_POST['nama'];
$NAMAYBS = ubah_huruf_ke_besar($NAMAYBS);
$KOTALAHIR = $_POST['ttl1'];
$KOTALAHIR = ubah_huruf_ke_kecil($KOTALAHIR);
$KOTALAHIR = ubah_huruf_awal(". ",$KOTALAHIR);
$TGLLAHIR = $_POST['ttl2'];


		if ($_POST[jk]=='1'){ // menentukan jenis kelamin (1=laki-laki)
$JK = "Laki-laki";
		}
		else {			
$JK = "Perempuan";
			}
			

		if ($_POST[wn]=='1'){ // menentukan kewarganegaraan (1=WNI)
$WN = "WNI";
		}
		else {			
$WN = "WNA";
			} 
	
	$arsip_agama = mysql_query("select * from arsip_agama WHERE id_agama='$_POST[agm]'"); 
	$agama=mysql_fetch_array($arsip_agama);$AGAMA = $agama['agama'];
$NOID = $_POST['noid'];
$NOKK = $_POST['nokk'];
$RT = $_POST['rt'];
$RW	 = $_POST['rw']; 
$ALMT = $_POST['almt'];
$DESA = $_POST['desa'];
$KEC = $_POST['kec'];
$KAB = $_POST['kab'];
$TGLBUAT = $_POST['tglbuat']; 
$DBTGLBUAT = tgldb("$TGLBUAT");
$DBTGLLAHIR = tgldb("$TGLLAHIR");
$TGLNAMAFILE = tglnmfile("$TGLBUAT");
	$JWS = $_POST['surat'];
	$JWS = mysql_query("select * from arsip_surat WHERE id_surat='$JWS'"); 
	$JWS=mysql_fetch_array($JWS);
	$JWS = $JWS['jw'];	

		if ($_POST[surat]=='1'){
// SKU   
$ALMT = "$ALMT RT. 0$RT / RW. 0$RW Desa $DESA Kecamatan $KEC Kabupaten $KAB";
$TTL =$KOTALAHIR.', '.$TGLLAHIR;
$TGLAKHIRRESI = tgl_jw($JWS,$TGLBUAT);  // Menyesuaikan jangka waktu berlaku surat
$TGLBUAT = tgl_mod1($TGLBUAT); 
// End SKU
//simpankedb
mysql_query("INSERT INTO pelayanan(no_pen, tgl, nl, tgl_lhr, jk, agm, kerja, almt, js, ket, uname)	
		 VALUES('$NOID', '$DBTGLBUAT', '$NAMA', '$DBTGLLAHIR', '$JK', '$AGAMA', '$PEKERJAAN', '$ALMT', 'RESI', '$KET', '$_SESSION[namauser]')");
//End simpandb

 
$document = file_get_contents("template_surat/sk_resi.rtf");
$document = str_replace("%%RULEDESA%%", $RULECAPDESA, $document); 
$document = str_replace("%%RULEKEC%%", $RULECAPKEC, $document);
$document = str_replace("%%RULEKAB%%", $RULECAPKAB, $document);
$document = str_replace("%%RULEPROV%%", $RULECAPPROV, $document);
$document = str_replace("%%RULEALMT%%", $RULEALMT, $document);
$document = str_replace("%%RULEKODEPOS%%", $RULEKODEPOS, $document); 
$document = str_replace("%%RULEKECA%%", $RULEKEC, $document);
$document = str_replace("%%RULEKABU%%", $RULEKAB, $document);

$document = str_replace("%%NAMA%%", $NAMA, $document);
$document = str_replace("%%TTL%%", $TTL, $document);
$document = str_replace("%%JK%%", $JK, $document);
$document = str_replace("%%WN%%", $WN, $document);
$document = str_replace("%%ALMT%%", $ALMT, $document);
$document = str_replace("%%AGAMA%%", $AGAMA, $document);
$document = str_replace("%%PEKERJAAN%%", $PEKERJAAN, $document);
$document = str_replace("%%KET%%", $KET, $document);
$document = str_replace("%%TGLBUAT%%", $TGLBUAT, $document);
$document = str_replace("%%TGLAKHIR%%", $TGLAKHIRRESI, $document);
$document = str_replace("%%AN%%", $AN, $document);
$document = str_replace("%%KADES%%", $KADES, $document);
header("Content-disposition: inline; filename=$TGLNAMAFILE-RESI-$NOID.rtf");

}
		elseif ($_POST[surat]=='2'){
// DOMISILI   
$ALMT = "$ALMT RT. 0$RT / RW. 0$RW Desa $DESA Kecamatan $KEC Kabupaten $KAB";
$TTL =$KOTALAHIR.', '.$TGLLAHIR;

$TGLAKHIRDOMISILI = tgl_jw($JWS,$TGLBUAT);  // Menyesuaikan jangka waktu berlaku surat
$TGLBUAT = tgl_mod1($TGLBUAT);
// End SKU
//simpankedb
mysql_query("INSERT INTO pelayanan(no_pen, tgl, nl, tgl_lhr, jk, agm, kerja, almt, js, ket, uname)	
		 VALUES('$NOID', '$DBTGLBUAT', '$NAMA', '$DBTGLLAHIR', '$JK', '$AGAMA', '$PEKERJAAN', '$ALMT', 'DOMISILI', '$KET', '$_SESSION[namauser]')");
//End simpandb

 
$document = file_get_contents("template_surat/sk_domisili.rtf");
$document = str_replace("%%RULEDESA%%", $RULECAPDESA, $document); 
$document = str_replace("%%RULEKEC%%", $RULECAPKEC, $document);
$document = str_replace("%%RULEKAB%%", $RULECAPKAB, $document);
$document = str_replace("%%RULEPROV%%", $RULECAPPROV, $document);
$document = str_replace("%%RULEALMT%%", $RULEALMT, $document);
$document = str_replace("%%RULEKODEPOS%%", $RULEKODEPOS, $document); 
$document = str_replace("%%RULEKECA%%", $RULEKEC, $document);
$document = str_replace("%%RULEKABU%%", $RULEKAB, $document);

$document = str_replace("%%NAMA%%", $NAMA, $document);
$document = str_replace("%%NAMAYBS%%", $NAMA, $document);
$document = str_replace("%%TTL%%", $TTL, $document);
$document = str_replace("%%JK%%", $JK, $document);
$document = str_replace("%%WN%%", $WN, $document);
$document = str_replace("%%NOID%%", $NOID, $document);
$document = str_replace("%%ALMT%%", $ALMT, $document);
$document = str_replace("%%AGAMA%%", $AGAMA, $document);
$document = str_replace("%%PEKERJAAN%%", $PEKERJAAN, $document);
$document = str_replace("%%KET%%", $KET, $document);
$document = str_replace("%%TGLBUAT%%", $TGLBUAT, $document);
$document = str_replace("%%TGLAKHIR%%", $TGLAKHIRDOMISILI, $document);
$document = str_replace("%%AN%%", $AN, $document);
$document = str_replace("%%KADES%%", $KADES, $document);
header("Content-disposition: inline; filename=$TGLNAMAFILE-DOMISILI-$NOID.rtf");

}
		elseif ($_POST[surat]=='3'){
// SKU   
$ALMT = "$ALMT RT. 0$RT / RW. 0$RW Desa $DESA Kecamatan $KEC Kabupaten $KAB";
$TTL =$KOTALAHIR.', '.$TGLLAHIR;
$BU = $_POST['sku_bu'];
$NP = $_POST['sku_np'];
$JU = $_POST['sku_ju'];
$LU = $_POST['almtsku_lu']." RT. 0".$_POST['rtsku_lu']." RW. 0".$_POST['rwsku_lu']." Desa ".$_POST['desasku_lu']." Kecamatan ".$_POST['kecsku_lu']." Kabupaten ".$_POST['kabsku_lu'];
$DB_LU = $_POST['almtsku_lu']."+".$_POST['rtsku_lu']."+".$_POST['rwsku_lu']."+".$_POST['desasku_lu']."+".$_POST['kecsku_lu']."+".$_POST['kabsku_lu'];

$TGLAKHIRSKU = tgl_jw($JWS,$TGLBUAT);  // Menyesuaikan jangka waktu berlaku surat
$TGLBUAT = tgl_mod1($TGLBUAT);
// End SKU
 
//simpankedb
mysql_query("INSERT INTO pelayanan(no_pen, tgl, nl, tgl_lhr, jk, agm, kerja, almt, js, ket, uname)	
		 VALUES('$NOID', '$DBTGLBUAT', '$NAMA', '$DBTGLLAHIR', '$JK', '$AGAMA', '$PEKERJAAN', '$ALMT', 'SKU', '$BU#$NP#$JU#$DB_LU#$KET', '$_SESSION[namauser]')");
//End simpandb

$document = file_get_contents("template_surat/sk_usaha.rtf");
$document = str_replace("%%RULEDESA%%", $RULECAPDESA, $document); 
$document = str_replace("%%RULEKEC%%", $RULECAPKEC, $document);
$document = str_replace("%%RULEKAB%%", $RULECAPKAB, $document);
$document = str_replace("%%RULEPROV%%", $RULECAPPROV, $document);
$document = str_replace("%%RULEALMT%%", $RULEALMT, $document);
$document = str_replace("%%RULEKODEPOS%%", $RULEKODEPOS, $document); 
$document = str_replace("%%RULEKECA%%", $RULEKEC, $document);
$document = str_replace("%%RULEKABU%%", $RULEKAB, $document);

$document = str_replace("%%NAMA%%", $NAMA, $document);
$document = str_replace("%%NAMAYBS%%", $NAMAYBS, $document);
$document = str_replace("%%TTL%%", $TTL, $document);
$document = str_replace("%%JK%%", $JK, $document);
$document = str_replace("%%WN%%", $WN, $document);
$document = str_replace("%%NOID%%", $NOID, $document);
$document = str_replace("%%ALMT%%", $ALMT, $document);
$document = str_replace("%%BU%%", $BU, $document);
$document = str_replace("%%NP%%", $NP, $document);
$document = str_replace("%%JU%%", $JU, $document);
$document = str_replace("%%LU%%", $LU, $document);
$document = str_replace("%%TGLBUAT%%", $TGLBUAT, $document);
$document = str_replace("%%TGLAKHIR%%", $TGLAKHIRSKU, $document);
$document = str_replace("%%AN%%", $AN, $document);
$document = str_replace("%%KADES%%", $KADES, $document);
header("Content-disposition: inline; filename=$TGLNAMAFILE-SKU-$NOID.rtf");

}


		elseif ($_POST[surat]=='4'){
// SKDU  
$ALMT = "$ALMT RT. 0$RT / RW. 0$RW Desa $DESA Kecamatan $KEC Kabupaten $KAB";
$TTL =$KOTALAHIR.', '.$TGLLAHIR;
$DNP = $_POST['skdu_np'];
$DJU = $_POST['skdu_ju'];
$DLTU = $_POST['skdu_ltu'];
$DLTUBILANG = terbilang($DLTU);
$DJMLKAR = $_POST['skdu_jk'];
$DJMLKARBILANG = terbilang($DJMLKAR);
$DSTATUSTNH = $_POST['skdu_stb']; 
$DLU = $_POST['almtskdu_almt']." RT. 0".$_POST['rtskdu_almt']." RW. 0".$_POST['rtskdu_almt']." Desa $rule[desa] Kecamatan $rule[kecamatan] Kabupaten $rule[kabupaten]";
$DB_DLU = $_POST['almtskdu_almt']."+".$_POST['rtskdu_almt']."+".$_POST['rtskdu_almt']."+".$rule['desa']."+".$rule['kecamatan']."+".$rule['kabupaten'];
$DNILAIINVEST = $_POST['skdu_nip'];
$DNILAIINVESTBILANG = terbilang($DNILAIINVEST);
$TGLBUAT = tgl_mod1($TGLBUAT);
// End SKDU
//simpankedb
mysql_query("INSERT INTO pelayanan(no_pen, tgl, nl, tgl_lhr, jk, agm, kerja, almt, js, ket, uname)	
		 VALUES('$NOID', '$DBTGLBUAT', '$NAMA', '$DBTGLLAHIR', '$JK', '$AGAMA', '$PEKERJAAN', '$ALMT', 'SKDU', '$DNP#$DJU#$DLTU#$DB_DLU#$DJMLKAR#$DSTATUSTNH#$DNILAIINVEST#$KET', '$_SESSION[namauser]')");
//End simpandb
 
$document = file_get_contents("template_surat/sk_domisili_usaha.rtf");
$document = str_replace("%%RULEDESA%%", $RULECAPDESA, $document); 
$document = str_replace("%%RULEKEC%%", $RULECAPKEC, $document);
$document = str_replace("%%RULEKAB%%", $RULECAPKAB, $document);
$document = str_replace("%%RULEPROV%%", $RULECAPPROV, $document);
$document = str_replace("%%RULEALMT%%", $RULEALMT, $document);
$document = str_replace("%%RULEKODEPOS%%", $RULEKODEPOS, $document); 
$document = str_replace("%%RULEKECA%%", $RULEKEC, $document);
$document = str_replace("%%RULEKABU%%", $RULEKAB, $document);

$document = str_replace("%%NAMA%%", $NAMA, $document);
$document = str_replace("%%NAMAYBS%%", $NAMAYBS, $document);
$document = str_replace("%%TTL%%", $TTL, $document);
$document = str_replace("%%JK%%", $JK, $document);
$document = str_replace("%%AGAMA%%", $AGAMA, $document);
$document = str_replace("%%WN%%", $WN, $document);
$document = str_replace("%%ALMT%%", $ALMT, $document);
$document = str_replace("%%DLU%%", $DLU, $document);
$document = str_replace("%%DNP%%", $DNP, $document);
$document = str_replace("%%DJU%%", $DJU, $document);
$document = str_replace("%%DLTU%%", "$DLTU ($DLTUBILANG)", $document);
$document = str_replace("%%DJMLKAR%%", "$DJMLKAR ($DJMLKARBILANG)", $document);
$document = str_replace("%%DSTATUSTNH%%", $DSTATUSTNH, $document);
$document = str_replace("%%DNILAIINVEST%%", "$DNILAIINVEST ($DNILAIINVESTBILANG Rupiah)", $document);
$document = str_replace("%%KET%%", $KET, $document);
$document = str_replace("%%TGLBUAT%%", $TGLBUAT, $document);
$document = str_replace("%%AN%%", $AN, $document);
$document = str_replace("%%KADES%%", $KADES, $document);
header("Content-disposition: inline; filename=$TGLNAMAFILE-SKDU-$NOID.rtf");

}
	
		elseif ($_POST[surat]=='5'){
// SKTM   
if ($_POST[sktmgunakannomor]=='1'){
$NOKTPKK = $NOID;
}
else { $NOKTPKK = $NOKK; }

$NAMAORTU = $_POST['ortu'];
$ALMT = "$ALMT RT. 0$RT / RW. 0$RW Desa $DESA Kecamatan $KEC Kabupaten $KAB";
$TTL =$KOTALAHIR.', '.$TGLLAHIR;
$TGLBUAT = tgl_mod1($TGLBUAT);
// End SKTM
//simpankedb
mysql_query("INSERT INTO pelayanan(no_pen, tgl, nl, tgl_lhr, jk, agm, kerja, almt, js, ket, uname)	
		 VALUES('$NOID', '$DBTGLBUAT', '$NAMA', '$DBTGLLAHIR', '$JK', '$AGAMA', '$PEKERJAAN', '$ALMT', 'SKTM', '$KET', '$_SESSION[namauser]')");
//End simpandb

 
$document = file_get_contents("template_surat/sk_tm.rtf");
$document = str_replace("%%RULEDESA%%", $RULECAPDESA, $document); 
$document = str_replace("%%RULEKEC%%", $RULECAPKEC, $document);
$document = str_replace("%%RULEKAB%%", $RULECAPKAB, $document);
$document = str_replace("%%RULEPROV%%", $RULECAPPROV, $document);
$document = str_replace("%%RULEALMT%%", $RULEALMT, $document);
$document = str_replace("%%RULEKODEPOS%%", $RULEKODEPOS, $document); 
$document = str_replace("%%RULEKECA%%", $RULEKEC, $document);
$document = str_replace("%%RULEKABU%%", $RULEKAB, $document);

$document = str_replace("%%NOKTPKK%%", $NOKTPKK, $document);
$document = str_replace("%%NAMA%%", $NAMA, $document);
$document = str_replace("%%TTL%%", $TTL, $document);
$document = str_replace("%%JK%%", $JK, $document);
$document = str_replace("%%WN%%", $WN, $document);
$document = str_replace("%%ALMT%%", $ALMT, $document);
$document = str_replace("%%AGAMA%%", $AGAMA, $document);
$document = str_replace("%%PEKERJAAN%%", $PEKERJAAN, $document);
$document = str_replace("%%NAMAORTU%%", $NAMAORTU, $document);
$document = str_replace("%%KET%%", $KET, $document);
$document = str_replace("%%TGLBUAT%%", $TGLBUAT, $document);
$document = str_replace("%%TGLAKHIR%%", $TGLAKHIRRESI, $document);
$document = str_replace("%%AN%%", $AN, $document);
$document = str_replace("%%KADES%%", $KADES, $document);
header("Content-disposition: inline; filename=$TGLNAMAFILE-SKTM-$NOID.rtf");

}
 
		elseif ($_POST[surat]=='6'){
// SKKM   
if ($_POST[skkmgunakannomor]=='1'){
$NOKTPKK = $NOID;
}
else { $NOKTPKK = $NOKK; }

$NAMAORTU = $_POST['ortu'];
$ALMT = "$ALMT RT. 0$RT / RW. 0$RW Desa $DESA Kecamatan $KEC Kabupaten $KAB";
$TTL =$KOTALAHIR.', '.$TGLLAHIR; 
$TGLBUAT = tgl_mod1($TGLBUAT);
// End SKTM
//simpankedb
mysql_query("INSERT INTO pelayanan(no_pen, tgl, nl, tgl_lhr, jk, agm, kerja, almt, js, ket, uname)	
		 VALUES('$NOID', '$DBTGLBUAT', '$NAMA', '$DBTGLLAHIR', '$JK', '$AGAMA', '$PEKERJAAN', '$ALMT', 'SKKM', '$KET', '$_SESSION[namauser]')");
//End simpandb

 
$document = file_get_contents("template_surat/sk_km.rtf");
$document = str_replace("%%RULEDESA%%", $RULECAPDESA, $document); 
$document = str_replace("%%RULEKEC%%", $RULECAPKEC, $document);
$document = str_replace("%%RULEKAB%%", $RULECAPKAB, $document);
$document = str_replace("%%RULEPROV%%", $RULECAPPROV, $document);
$document = str_replace("%%RULEALMT%%", $RULEALMT, $document);
$document = str_replace("%%RULEKODEPOS%%", $RULEKODEPOS, $document); 
$document = str_replace("%%RULEKECA%%", $RULEKEC, $document);
$document = str_replace("%%RULEKABU%%", $RULEKAB, $document);

$document = str_replace("%%NOKTPKK%%", $NOKTPKK, $document);
$document = str_replace("%%NAMA%%", $NAMA, $document);
$document = str_replace("%%TTL%%", $TTL, $document);
$document = str_replace("%%JK%%", $JK, $document);
$document = str_replace("%%WN%%", $WN, $document);
$document = str_replace("%%ALMT%%", $ALMT, $document);
$document = str_replace("%%AGAMA%%", $AGAMA, $document);
$document = str_replace("%%PEKERJAAN%%", $PEKERJAAN, $document);
$document = str_replace("%%STATUS%%", $STATUS, $document);
$document = str_replace("%%NAMAORTU%%", $NAMAORTU, $document);
$document = str_replace("%%KET%%", $KET, $document);
$document = str_replace("%%TGLBUAT%%", $TGLBUAT, $document);
$document = str_replace("%%TGLAKHIR%%", $TGLAKHIRRESI, $document);
$document = str_replace("%%AN%%", $AN, $document);
$document = str_replace("%%KADES%%", $KADES, $document);
header("Content-disposition: inline; filename=$TGLNAMAFILE-SKKM-$NOID.rtf");

}
 
		elseif ($_POST[surat]=='7'){
// SKKM   
if ($_POST[skkbgunakannomor]=='1'){
$NOKTPKK = $NOID;
}
else { $NOKTPKK = $NOKK; }

$NAMAORTU = $_POST['ortu'];
$ALMT = "$ALMT RT. 0$RT / RW. 0$RW Desa $DESA Kecamatan $KEC Kabupaten $KAB";
$TTL =$KOTALAHIR.', '.$TGLLAHIR; 
$TGLBUAT = tgl_mod1($TGLBUAT);
// End SKTM
//simpankedb
mysql_query("INSERT INTO pelayanan(no_pen, tgl, nl, tgl_lhr, jk, agm, kerja, almt, js, ket, uname)	
		 VALUES('$NOID', '$DBTGLBUAT', '$NAMA', '$DBTGLLAHIR', '$JK', '$AGAMA', '$PEKERJAAN', '$ALMT', 'SKKB', '$KET', '$_SESSION[namauser]')");
//End simpandb

 
$document = file_get_contents("template_surat/sk_kb.rtf");
$document = str_replace("%%RULEDESA%%", $RULECAPDESA, $document); 
$document = str_replace("%%RULEKEC%%", $RULECAPKEC, $document);
$document = str_replace("%%RULEKAB%%", $RULECAPKAB, $document);
$document = str_replace("%%RULEPROV%%", $RULECAPPROV, $document);
$document = str_replace("%%RULEALMT%%", $RULEALMT, $document);
$document = str_replace("%%RULEKODEPOS%%", $RULEKODEPOS, $document); 
$document = str_replace("%%RULEKECA%%", $RULEKEC, $document);
$document = str_replace("%%RULEKABU%%", $RULEKAB, $document);

$document = str_replace("%%NOKTPKK%%", $NOKTPKK, $document);
$document = str_replace("%%NAMA%%", $NAMA, $document);
$document = str_replace("%%TTL%%", $TTL, $document);
$document = str_replace("%%JK%%", $JK, $document);
$document = str_replace("%%WN%%", $WN, $document);
$document = str_replace("%%ALMT%%", $ALMT, $document);
$document = str_replace("%%AGAMA%%", $AGAMA, $document);
$document = str_replace("%%PEKERJAAN%%", $PEKERJAAN, $document);
$document = str_replace("%%STATUS%%", $STATUS, $document);
$document = str_replace("%%NAMAORTU%%", $NAMAORTU, $document);
$document = str_replace("%%KET%%", $KET, $document);
$document = str_replace("%%TGLBUAT%%", $TGLBUAT, $document);
$document = str_replace("%%TGLAKHIR%%", $TGLAKHIRRESI, $document);
$document = str_replace("%%AN%%", $AN, $document);
$document = str_replace("%%KADES%%", $KADES, $document);
$document = str_replace("%%KECAMATAN%%", $KECAMATAN, $document);
header("Content-disposition: inline; filename=$TGLNAMAFILE-SKKB-$NOID.rtf");

}


		elseif ($_POST[surat]=='8'){
// KELAHIRAN   
$TGLBUAT = tgl_mod1($TGLBUAT);

$ALMTLENGKAP = "$ALMT RT. 0$RT / RW. 0$RW Desa $DESA Kecamatan $KEC Kabupaten $KAB";
$JAM = $_POST['jamlahir'];
$ZONA = $_POST['zonawaktu'];
$JAMLAHIR = $JAM.' '.$ZONA;
$ANAKKE = $_POST['anakke'];
$ANAKKEBILANG = terbilang($_POST['anakke']);

if ($_POST[dari]=='1' || $_POST[dari]=='0'){
 
$DARI = '-';
$DB_DARI = '-';
}
else {
$DARI = terbilang($_POST['dari']).' Bersaudara';
$DB_DARI = $_POST['dari'];
}
$tanggal = strtotime("$_POST[ttl2]");
$hari_en = date('l', $tanggal);
$hari_ar = array("Monday"=>"Senin", "Tuesday"=>"Selasa", "Wednesday"=>"Rabu", "Thursday"=>"Kamis", "Friday"=>"Jumat", "Saturday"=>"Sabtu", "Sunday"=>"Minggu");
$hari_id = $hari_ar[$hari_en];
$HARILAHIR = $hari_id;

if ($_POST[pupusayah]=='1'){
 
$NAMAAYAH = $_POST['namaayah'];
$NAMAAYAH = ubah_huruf_ke_besar($NAMAAYAH). ' (Almarhum)';
$TTLAYAH = '-';	
$AGAMAAYAH = '-';
$KTPAYAH = '-';
$KERJAAYAH =  '-';
$ALMTAYAH = '-';
$RTAYAH = '-';
$RWAYAH =  '-';
$DESAAYAH = '-';
$KECAYAH = '-';
$KABAYAH =  '-';
$ALMTAYAH = '-';
}
else {
//ayah
$NAMAAYAH = $_POST['namaayah'];
$NAMAAYAH = ubah_huruf_ke_besar($NAMAAYAH);
$TTLAYAH = $_POST['ttl1ayah'].', '.$_POST['ttl2ayah'];
	$arsip_agamaayah = mysql_query("select * from arsip_agama WHERE id_agama='$_POST[agmayah]'"); 
	$agamaayah=mysql_fetch_array($arsip_agamaayah);	
$AGAMAAYAH = $agamaayah['agama'];
$KTPAYAH = $_POST['noidayah'];
	$arsip_pekerjaanayah = mysql_query("select * from arsip_pekerjaan where id_pekerjaan='$_POST[kerjaayah]' "); 
	$pekerjaanayah=mysql_fetch_array($arsip_pekerjaanayah);	
$KERJAAYAH = $pekerjaanayah['pekerjaan'];
$ALMTAYAH = $_POST['almtayah'];
$RTAYAH = $_POST['rtayah'];
$RWAYAH = $_POST['rwayah'];
$DESAAYAH = $_POST['desaayah'];
$KECAYAH = $_POST['kecayah'];
$KABAYAH = $_POST['kabayah'];
$ALMTAYAH = "$ALMTAYAH RT. 0$RTAYAH / RW. 0$RWAYAH Desa $DESAAYAH Kecamatan $KECAYAH Kabupaten $KABAYAH";
}

if ($_POST[pupusibu]=='1'){
 
$NAMAIBU = $_POST['namaibu'];
$NAMAIBU = ubah_huruf_ke_besar($NAMAIBU). ' (Almarhumah)';
$TTLIBU = '-';	
$AGAMAIBU = '-';
$KTPIBU = '-';
$KERJAIBU =  '-';
$ALMTIBU = '-';
$RTIBU = '-';
$RWIBU =  '-';
$DESAIBU = '-';
$KECIBU = '-';
$KABIBU =  '-';
$ALMTIBU = '-';
}
else {
//ibu
$NAMAIBU = $_POST['namaibu'];
$NAMAIBU = ubah_huruf_ke_besar($NAMAIBU);
$TTLIBU = $_POST['ttl1ibu'].', '.$_POST['ttl2ibu'];
	$arsip_agamaibu = mysql_query("select * from arsip_agama WHERE id_agama='$_POST[agmibu]'"); 
	$agamaibu=mysql_fetch_array($arsip_agamaibu);	
$AGAMAIBU = $agamaibu['agama'];
$KTPIBU = $_POST['noidibu'];
	$arsip_pekerjaanibu = mysql_query("select * from arsip_pekerjaan where id_pekerjaan='$_POST[kerjaibu]' "); 
	$pekerjaanibu=mysql_fetch_array($arsip_pekerjaanibu);	
$KERJAIBU = $pekerjaanibu['pekerjaan'];
$ALMTIBU = $_POST['almtibu'];
$RTIBU = $_POST['rtibu'];
$RWIBU = $_POST['rwibu'];
$DESAIBU = $_POST['desaibu'];
$KECIBU = $_POST['kecibu'];
$KABIBU = $_POST['kabibu'];
$ALMTIBU = "$ALMTIBU RT. 0$RTIBU / RW. 0$RWIBU Desa $DESAIBU Kecamatan $KECIBU Kabupaten $KABIBU";
}

// End KELAHIRAN
//simpankedb
mysql_query("INSERT INTO pelayanan(no_pen, tgl, nl, tgl_lhr, jk, agm, kerja, almt, js, ket, uname)	
		 VALUES('$NOID', '$DBTGLBUAT', '$NAMA', '$DBTGLLAHIR', '$JK', '$AGAMA', '$PEKERJAAN', '$ALMTLENGKAP', 'KELAHIRAN', '$JAM+$ZONA#$ANAKKE+$DB_DARI#$KET', '$_SESSION[namauser]')");
//End simpandb

 
$document = file_get_contents("template_surat/sk_kelahiran.rtf");
$document = str_replace("%%RULEDESA%%", $RULEDESA, $document); 
$document = str_replace("%%RULEKEC%%", $RULEKEC, $document);
$document = str_replace("%%RULEKAB%%", $RULECAPKAB, $document); 

$document = str_replace("%%NAMA%%", $NAMA, $document);
$document = str_replace("%%ANAKKE%%", $ANAKKE, $document);
$document = str_replace("%%ANAKKEBILANG%%", $ANAKKEBILANG, $document);
$document = str_replace("%%DARI%%", $DARI, $document);
$document = str_replace("%%KOTALAHIR%%", $KOTALAHIR, $document);
$document = str_replace("%%TGLLAHIR%%", $TGLLAHIR, $document);
$document = str_replace("%%HARILAHIR%%", $HARILAHIR, $document);
$document = str_replace("%%JAMLAHIR%%", $JAMLAHIR, $document);
$document = str_replace("%%JK%%", $JK, $document);

$document = str_replace("%%NAMAAYAH%%", $NAMAAYAH, $document);
$document = str_replace("%%TTLAYAH%%", $TTLAYAH, $document); 
$document = str_replace("%%ALMTAYAH%%", $ALMTAYAH, $document);
$document = str_replace("%%AGAMAAYAH%%", $AGAMAAYAH, $document);
$document = str_replace("%%KERJAAYAH%%", $KERJAAYAH, $document);
$document = str_replace("%%KTPAYAH%%", $KTPAYAH, $document);

$document = str_replace("%%NAMAIBU%%", $NAMAIBU, $document);
$document = str_replace("%%TTLIBU%%", $TTLIBU, $document); 
$document = str_replace("%%ALMTIBU%%", $ALMTIBU, $document);
$document = str_replace("%%AGAMAIBU%%", $AGAMAIBU, $document);
$document = str_replace("%%KERJAIBU%%", $KERJAIBU, $document);
$document = str_replace("%%KTPIBU%%", $KTPIBU, $document);

$document = str_replace("%%TGLBUAT%%", $TGLBUAT, $document);
$document = str_replace("%%AN%%", $AN, $document);
$document = str_replace("%%KADES%%", $KADES, $document);
header("Content-disposition: inline; filename=$TGLNAMAFILE-SKK-$NOID.rtf");

}

		elseif ($_POST[surat]=='9'){
// SKKK
$WAKTURAME = $_POST['wakturame'];
$WAKTURAME = tgl_mod1($WAKTURAME);
$JENISRAME = $_POST['jenisrame'];
$MAKSUDRAME = $_POST['maksudrame'];   
$ALMT = "$ALMT RT. 0$RT / RW. 0$RW Desa $DESA Kecamatan $KEC Kabupaten $KAB";
$TTL =$KOTALAHIR.', '.$TGLLAHIR;
$TGLBUAT = tgl_mod1($TGLBUAT);
// End SKU
//simpankedb
mysql_query("INSERT INTO pelayanan(no_pen, tgl, nl, tgl_lhr, jk, agm, kerja, almt, js, ket, uname)	
		 VALUES('$NOID', '$DBTGLBUAT', '$NAMA', '$DBTGLLAHIR', '$JK', '$AGAMA', '$PEKERJAAN', '$ALMT', 'SKKK', '$JENISRAME#$WAKTURAME#$MAKSUDRAME#$KET', '$_SESSION[namauser]')");
//End simpandb

 
$document = file_get_contents("template_surat/sk_kk.rtf");
$document = str_replace("%%RULEDESA%%", $RULECAPDESA, $document); 
$document = str_replace("%%RULEKEC%%", $RULECAPKEC, $document);
$document = str_replace("%%RULEKAB%%", $RULECAPKAB, $document);
$document = str_replace("%%RULEPROV%%", $RULECAPPROV, $document);
$document = str_replace("%%RULEALMT%%", $RULEALMT, $document);
$document = str_replace("%%RULEKODEPOS%%", $RULEKODEPOS, $document); 
$document = str_replace("%%RULEKECA%%", $RULEKEC, $document);
$document = str_replace("%%RULEKABU%%", $RULEKAB, $document);

$document = str_replace("%%NAMA%%", $NAMA, $document);
$document = str_replace("%%TTL%%", $TTL, $document);
$document = str_replace("%%JK%%", $JK, $document);
$document = str_replace("%%WN%%", $WN, $document);
$document = str_replace("%%NOID%%", $NOID, $document);
$document = str_replace("%%ALMT%%", $ALMT, $document);
$document = str_replace("%%AGAMA%%", $AGAMA, $document);
$document = str_replace("%%PEKERJAAN%%", $PEKERJAAN, $document);
$document = str_replace("%%KET%%", $KET, $document);
$document = str_replace("%%TGLBUAT%%", $TGLBUAT, $document);
$document = str_replace("%%JENISRAME%%", $JENISRAME, $document);
$document = str_replace("%%WAKTURAME%%", $WAKTURAME, $document);
$document = str_replace("%%MAKSUDRAME%%", $MAKSUDRAME, $document);
$document = str_replace("%%AN%%", $AN, $document);
$document = str_replace("%%KADES%%", $KADES, $document);
header("Content-disposition: inline; filename=$TGLNAMAFILE-SKKK-$NOID.rtf");

}
		elseif ($_POST[surat]=='10'){ 
// SKKK
$TGLWAFAT = $_POST['tglwafat'];
$UMUR = umur2("$TGLLAHIR","$TGLWAFAT");
$HARIWAFAT = ketahuihari("$_POST[tglwafat]");
$TGLWAFAT = tgl_mod1($TGLWAFAT);
$KOTAWAFAT = $_POST['di']; 
$SEBABWAFAT = $_POST['sebabwafat']; 
$ALMT = "$ALMT RT. 0$RT / RW. 0$RW Desa $DESA Kecamatan $KEC Kabupaten $KAB";
$TGLBUAT = tgl_mod1($TGLBUAT);
// End SKU
//simpankedb 
		  $insertQuery = "INSERT INTO pelayanan(no_pen, tgl, nl, tgl_lhr, jk, agm, kerja, almt, js, ket, uname)	
		 VALUES('$NOID', '$DBTGLBUAT', '$NAMA', '$DBTGLLAHIR', '$JK', '$AGAMA', '$PEKERJAAN', '$ALMT', 'SKW', '$TGLWAFAT#$KOTAWAFAT#$SEBABWAFAT#$KET', '$_SESSION[namauser]')";

if( mysql_query($insertQuery) ){
  //on success run update query
  $updateQuery = "UPDATE penduduk SET wafat = 'N' WHERE no_pen= '$NOID'";
  mysql_query($updateQuery);
}
//End simpandb

 
$document = file_get_contents("template_surat/sk_w.rtf");
$document = str_replace("%%RULEDESA%%", $RULECAPDESA, $document); 
$document = str_replace("%%RULEKEC%%", $RULECAPKEC, $document);
$document = str_replace("%%RULEKAB%%", $RULECAPKAB, $document);
$document = str_replace("%%RULEPROV%%", $RULECAPPROV, $document);
$document = str_replace("%%RULEALMT%%", $RULEALMT, $document);
$document = str_replace("%%RULEKODEPOS%%", $RULEKODEPOS, $document); 
$document = str_replace("%%RULEKECA%%", $RULEKEC, $document);
$document = str_replace("%%RULEKABU%%", $RULEKAB, $document);

$document = str_replace("%%NAMA%%", $NAMA, $document); 
$document = str_replace("%%JK%%", $JK, $document);
$document = str_replace("%%ALMT%%", $ALMT, $document); 
$document = str_replace("%%PEKERJAAN%%", $PEKERJAAN, $document); 
$document = str_replace("%%TGLBUAT%%", $TGLBUAT, $document);
$document = str_replace("%%UMUR%%", $UMUR, $document);
$document = str_replace("%%HARIWAFAT%%", $HARIWAFAT, $document);
$document = str_replace("%%TGLWAFAT%%", $TGLWAFAT, $document);
$document = str_replace("%%KOTAWAFAT%%", $KOTAWAFAT, $document);
$document = str_replace("%%SEBABWAFAT%%", $SEBABWAFAT, $document); 
$document = str_replace("%%KADES%%", $KADES, $document);
header("Content-disposition: inline; filename=$TGLNAMAFILE-SKW-$NOID.rtf");

}
 
 		elseif ($_POST[surat]=='11'){
// SKPD//
//$ALMT = "$ALMT RT. 0$RT / RW. 0$RW Desa $DESA Kecamatan $KEC Kabupaten $KAB";
$NOKK = split_char($NOKK);
$NAMAKK = ubah_huruf_ke_besar($_POST['skpdkk']);
$ALMT = ubah_huruf_ke_besar($ALMT);
$RT = "0".$RT;
$RW = "0".$RW;
$RT = split_char($RT);
$RW = split_char($RW);

		if ($_POST['skpdtulisalasan']=='7'){
		$AP = "7";
		$APLAINNYA = $_POST['skpdtulisalasan2'];
		}
		else {			
		$AP = $_POST['skpdap'];
		$APLAINNYA = ".................";
			}

$ALMTT = ubah_huruf_ke_besar($_POST['skpdalmt']);
$RTT = "0".$_POST['skpdrt'];
$RWT = "0".$_POST['skpdrw'];
$RTT = split_char($RTT);
$RWT = split_char($RWT);
$DB_RTT = "0".$_POST['skpdrt'];
$DB_RWT = "0".$_POST['skpdrw'];
$DESAT = ubah_huruf_ke_besar($_POST['skpddesa']);
$KECT = ubah_huruf_ke_besar($_POST['skpdkec']);
$KABT = ubah_huruf_ke_besar($_POST['skpdkab']);
$PROVT = ubah_huruf_ke_besar($_POST['skpdprov']);
$JKP = $_POST['skpdjk'];
$KP = $_POST['skpdkp'];
$KKTP = $_POST['skpdnokktp'];
$KKP = $_POST['skpdnokkp'];
$TGLPINDAH = $_POST['skpdrtglpindah'];
			
$THNP = substr($TGLPINDAH ,6,4);
	$THNP = split_char($THNP);
$BLNP = substr($TGLPINDAH ,3,2);
	$BLNP = split_char($BLNP);
$TGLP = substr($TGLPINDAH ,0,2);	
	$TGLP = split_char($TGLP);	 
$TGLBUAT = tgl_indo3($TGLBUAT);
 
	 $ANGGPNDH = $NOID;
	 foreach ($_POST['anggkk'] as $selectedOption){	
	 if ($selectedOption!==$NOID){$ANGGPNDH .= "+". $selectedOption; }
	 }
	  
// End SKU
//simpankedb
mysql_query("INSERT INTO pelayanan(no_pen, tgl, nl, tgl_lhr, jk, agm, kerja, almt, js, ket, uname)	
		 VALUES('$NOID', '$DBTGLBUAT', '$NAMA', '$DBTGLLAHIR', '$JK', '$AGAMA', '$PEKERJAAN', '$ALMT', 'SKPD', '$NAMAKK#$AP+$APLAINNYA#$ALMTT+$DB_RTT+$DB_RWT+$DESAT+$KECT+$KABT+$PROVT#$KP#$JKP#$KKTP#$KKP#$TGLPINDAH#$ANGGPNDH#$KET', '$_SESSION[namauser]')");
//End simpandb

 
$document = file_get_contents("template_surat/sk_pd.rtf");
$document = str_replace("%%NOKK%%", "    ".$NOKK, $document); 
$document = str_replace("%%NAMAKK%%", $NAMAKK, $document); 
$document = str_replace("%%ALMT%%", $ALMT, $document); 
$document = str_replace("%%RT%%", " ".$RT, $document); 
$document = str_replace("%%RW%%", " ".$RW, $document); 
$document = str_replace("%%AP%%", $AP, $document); 
$document = str_replace("%%APLAINNYA%%", $APLAINNYA, $document); 
$document = str_replace("%%ALMTT%%", $ALMTT, $document); 
$document = str_replace("%%RTT%%", " ".$RTT, $document); 
$document = str_replace("%%RWT%%", " ".$RWT, $document); 
$document = str_replace("%%DESAT%%", $DESAT, $document); 
$document = str_replace("%%KECT%%", $KECT, $document); 
$document = str_replace("%%KABT%%", $KABT, $document); 
$document = str_replace("%%PROVT%%", $PROVT, $document); 
$document = str_replace("%%KP%%", $KP, $document); 
$document = str_replace("%%JKP%%", $JKP, $document); 
$document = str_replace("%%KKTP%%", $KKTP, $document); 
$document = str_replace("%%KKP%%", $KKP, $document); 
$document = str_replace("%%TGLP%%", $TGLP, $document); 
$document = str_replace("%%BLNP%%", $BLNP, $document); 
$document = str_replace("%%THNP%%", $THNP, $document); 
$document = str_replace("%%TGLBUAT%%", $TGLBUAT, $document); 
$document = str_replace("%%NAMAYBS%%", $NAMAYBS, $document);
 
	 
$no=1;
foreach ($_POST['anggkk'] as $selectedOption){	  
$document = str_replace("%%NO$no%%", $no, $document);  
$NOPEN = split_char($selectedOption);
$document = str_replace("%%NIK$no%%", " ".$NOPEN, $document);  
  $pen  = mysql_query("SELECT * FROM penduduk WHERE no_pen='$selectedOption'");
  $p=mysql_fetch_array($pen);
$document = str_replace("%%NAMA$no%%", $p['nama_pen'], $document); 
$document = str_replace("%%SHDK$no%%", $p['status_hdk_pen'], $document);  
	$no++;
	}
	
header("Content-disposition: inline; filename=$TGLNAMAFILE-SKPD-$NOID.rtf");

}
 
 

elseif ($_POST[surat]=='12'){
$TGLBUAT = tgl_mod1($TGLBUAT);
	  $NAMA = ubah_huruf_ke_besar($NAMA);
$ALMT = ubah_huruf_ke_besar($ALMT);
$RT = "0".$RT;
$RW = "0".$RW;
$RT = split_char($RT);
$RW = split_char($RW);
$PERMOHONAN = $_POST[permohonanktp];

if ($PERMOHONAN=="1"){	
$PERMOHONANTEXT = "Baru";
}
elseif ($PERMOHONAN=="2"){	
$PERMOHONANTEXT = "Perpanjangan";
}
elseif ($PERMOHONAN=="2"){	
$PERMOHONANTEXT = "Penggantian";
}
$NOID1 = $_POST[noid];

// End KTP
//simpankedb
mysql_query("INSERT INTO pelayanan(no_pen, tgl, nl, tgl_lhr, jk, agm, kerja, almt, js, ket, uname)	
		 VALUES('$NOID', '$DBTGLBUAT', '$NAMA', '$DBTGLLAHIR', '$JK', '$AGAMA', '$PEKERJAAN', '$ALMT', 'KTP', '$KET#$PERMOHONANTEXT', '$_SESSION[namauser]')");
//End simpandb


$HITUNGNAMA = strlen(preg_replace('/s+/', '', $NAMA));
if ($HITUNGNAMA >= 24){
$document = file_get_contents("template_surat/sk_tp/sk_tp_$HITUNGNAMA.rtf");
	}
	if ($HITUNGNAMA == 24){
$document = file_get_contents("template_surat/sk_tp.rtf");
}
	else {
$document = file_get_contents("template_surat/sk_tp/sk_tp_$HITUNGNAMA.rtf");
	}
	
if ($PERMOHONAN=="1"){	
$document = str_replace("%A%", "#", $document);
$document = str_replace("%B%", " ", $document);
$document = str_replace("%C%", " ", $document);
}
elseif ($PERMOHONAN=="2"){	
$document = str_replace("%A%", " ", $document);
$document = str_replace("%B%", "#", $document);
$document = str_replace("%C%", " ", $document);
}
elseif ($PERMOHONAN=="2"){	
$document = str_replace("%A%", " ", $document);
$document = str_replace("%B%", " ", $document);
$document = str_replace("%C%", "#", $document);
}

$PISAHNAMA = spliting($NAMA);
//looping dalam array
$noNAMA=1;  
foreach ($PISAHNAMA as $NAMA) {  
$document = str_replace("%$noNAMA%", $NAMA, $document);
$noNAMA++;
}  

//$NAMA = split_char($NAMA);
//$document = str_replace("%1", $NAMA, $document);

$PISAHNOKK = spliting($NOKK);
//looping dalam array
$noNOKK=49;  
foreach ($PISAHNOKK as $NOKK) {  
$document = str_replace("%$noNOKK%", $NOKK, $document);
$noNOKK++;
} 

$PISAHNOID = spliting($NOID);
//looping dalam array
$noNOID=65;  
foreach ($PISAHNOID as $NOID) {  
$document = str_replace("%$noNOID%", $NOID, $document);
$noNOID++;
}  

$document = str_replace("%81%", $ALMT, $document);
$document = str_replace("%82%", $RT, $document);
$document = str_replace("%83%", $RW, $document);
$document = str_replace("%84%", $rule[kodepos], $document);
$document = str_replace("%TGLBUAT%", $TGLBUAT, $document);
$document = str_replace("%KADES%", $KADES, $document);

header("Content-disposition: inline; filename=$TGLNAMAFILE-KTP-$NOID1.rtf");
	 
	 }
	 
else { 
$document = file_get_contents("template_surat/sk_error.rtf"); 
$document = str_replace("%%KET%%", "Tampaknya Anda Membuat Kesalahan, Pastikan Jenis Surat Sudah Di Pilih, Silahkan Kunjungi Halaman Bantuan / Hubungi http://fb.com/AdeArwans Jika Masalah Tidak Dapat Anda Atasi.", $document);

header("Content-disposition: inline; filename=errorSI_PADE.rtf");
}
header("Content-type: application/msword");
header("Content-length: " . strlen($document));
echo $document;

?>
 
  <?php 
} 
}
?>