<?php
//Koneksi
$host="localhost";
$user="root";
$password="";
$db="db_sig";
$con=mysqli_connect($host,$user,$password,$db);
//Laporan Berdasarkan Kelurahan
?>
<body onLoad="window.print()">

<?php
//Laporan Semua Kost/Kontrakan
if (isset($_POST['lkks'])){
?>
<table border="1" width="100%" cellpadding="1" cellspacing="1">
<tr><td colspan="14" bgcolor="yellow" align="center"><font size="5">Sistem Informasi Geografis Rumah Kost dan Kontrakan</font><br><?php echo "Tanggal  : " . date("Y-m-d") . "<br>"; ?></td></tr>
<tr><td align="center" bgcolor="white">No</td><td align="center" bgcolor="white">Nama Kost/Kontrakan</td><td align="center" bgcolor="white">Phone</td><td align="center" bgcolor="white">Kelurahan</td><td align="center" bgcolor="white">Jalan</td><td align="center" bgcolor="white">Member</td><td align="center" bgcolor="white">Publish</td><td align="center" bgcolor="white">Waktu</td></tr>
<?php
$query=mysqli_query($con,"select tbl_koskon.kode_koskon,tbl_koskon.nama_koskon,tbl_koskon.phone,tbl_wilayah.kelurahan,tbl_koskon.jalan,tbl_koskon.kategori,tbl_koskon.publish,tbl_koskon.waktu,tbl_member.nama from tbl_koskon,tbl_wilayah,tbl_member where tbl_wilayah.kode_wilayah=tbl_koskon.kode_wilayah and tbl_member.kode_member=tbl_koskon.kode_member order by waktu asc");
$no=1;
while ($row=mysqli_fetch_array($query)){
echo "<tr><td align=center><font size=2>"; echo $no; echo "</font></td><td><font size=2>"; echo $row['nama_koskon']; echo "</font></td><td align=center><font size=2>"; echo $row['phone']; echo "</font></td><td><font size=2>"; echo $row['kelurahan']; echo "</font></td><td><font size=2>"; echo $row['jalan']; echo "</font></td><td align=center><font size=2>"; echo $row['nama']; echo "</font></td><td align=center><font size=2>"; echo $row['publish']; echo "</font></td><td align=center><font size=2>"; echo $row['waktu']; echo "</font></td></tr>";
$no++;
}
?>
</table>
<?php
}
?>

<?php
//Laporan Berdasarkan Wilayah
if (isset($_POST['lkkw'])){
$kelurahan=$_POST['kelurahan'];
$w=mysqli_query($con,"select * from tbl_wilayah where kelurahan='$kelurahan'");
$rw=mysqli_fetch_array($w);
$kode_wilayah=$rw['kode_wilayah'];
?>
<table border="1" width="100%" cellpadding="1" cellspacing="1">
<tr><td colspan="14" bgcolor="yellow" align="center"><font size="5">Sistem Informasi Geografis Rumah Kost dan Kontrakan</font><br><?php echo "Kelurahan :"; echo $kelurahan; echo "<br>"; echo "Tanggal  : " . date("Y-m-d") . "<br>"; ?></td></tr>
<tr><td align="center" bgcolor="white">No</td><td align="center" bgcolor="white">Nama Kos/Kontrakan</td><td align="center" bgcolor="white">Phone</td><td align="center" bgcolor="white">Kelurahan</td><td align="center" bgcolor="white">Jalan</td><td align="center" bgcolor="white">Member</td><td align="center" bgcolor="white">Publish</td><td align="center" bgcolor="white">Waktu</td></tr>
<?php
$query=mysqli_query($con,"select tbl_koskon.kode_koskon,tbl_koskon.nama_koskon,tbl_koskon.phone,tbl_wilayah.kelurahan,tbl_koskon.jalan,tbl_koskon.kategori,tbl_koskon.publish,tbl_koskon.waktu,tbl_member.nama from tbl_koskon,tbl_wilayah,tbl_member where tbl_koskon.kode_wilayah='$kode_wilayah' and tbl_wilayah.kode_wilayah=tbl_koskon.kode_wilayah and tbl_member.kode_member=tbl_koskon.kode_member order by waktu asc");
$no=1;
while ($row=mysqli_fetch_array($query)){
echo "<tr><td align=center><font size=2>"; echo $no; echo "</font></td><td><font size=2>"; echo $row['nama_koskon']; echo "</font></td><td align=center><font size=2>"; echo $row['phone']; echo "</font></td><td><font size=2>"; echo $row['kelurahan']; echo "</font></td><td><font size=2>"; echo $row['jalan']; echo "</font></td><td align=center><font size=2>"; echo $row['nama']; echo "</font></td><td align=center><font size=2>"; echo $row['publish']; echo "</font></td><td align=center><font size=2>"; echo $row['waktu']; echo "</font></td></tr>";
$no++;
}
?>
</table>
<?php
}
?>

<?php
//Laporan Per Bulan
if (isset($_POST['lkkb'])){
$bln=$_POST['bln'];
$thn=$_POST['thn'];
?>
<table border="1" width="100%" cellpadding="1" cellspacing="1">
<tr><td colspan="14" bgcolor="yellow" align="center"><font size="5">Sistem Informasi Geografis Rumah Kost dan Kontrakan</font><br><?php echo "Bulan : "; if ($bln=='01'){echo "Januari";} else if ($bln=='02'){echo "Februari";} else if ($bln=='03'){echo "Maret";} else if ($bln=='03'){echo "April";} else if ($bln=='05'){echo "Mei";} else if ($bln=='06'){echo "Juni";} else if ($bln=='07'){echo "Juli";} else if ($bln=='08'){echo "Agustus";} else if ($bln=='09'){echo "September";} else if ($bln=='10'){echo "Oktober";} else if ($bln=='11'){echo "November";} else if ($bln=='12'){echo "Desember";} echo "<br>"; echo "Tahun : "; echo $thn; echo "<br>"; echo "Tanggal  : " . date("Y-m-d") . "<br>"; ?></td></tr>
<tr><td align="center" bgcolor="white">No</td><td align="center" bgcolor="white">Nama Kos/Kontrakan</td><td align="center" bgcolor="white">Phone</td><td align="center" bgcolor="white">Kelurahan</td><td align="center" bgcolor="white">Jalan</td><td align="center" bgcolor="white">Member</td><td align="center" bgcolor="white">Publish</td><td align="center" bgcolor="white">Waktu</td></tr>
<?php
$query=mysqli_query($con,"select tbl_koskon.kode_koskon,tbl_koskon.nama_koskon,tbl_koskon.phone,tbl_wilayah.kelurahan,tbl_koskon.jalan,tbl_koskon.kategori,tbl_koskon.publish,tbl_koskon.waktu,tbl_member.nama from tbl_koskon,tbl_wilayah,tbl_member where  year(tbl_koskon.waktu)='$thn' and month(waktu)='$bln' and tbl_wilayah.kode_wilayah=tbl_koskon.kode_wilayah and tbl_member.kode_member=tbl_koskon.kode_member order by waktu asc");
$no=1;
while ($row=mysqli_fetch_array($query)){
echo "<tr><td align=center><font size=2>"; echo $no; echo "</font></td><td><font size=2>"; echo $row['nama_koskon']; echo "</font></td><td align=center><font size=2>"; echo $row['phone']; echo "</font></td><td><font size=2>"; echo $row['kelurahan']; echo "</font></td><td><font size=2>"; echo $row['jalan']; echo "</font></td><td align=center><font size=2>"; echo $row['nama']; echo "</font></td><td align=center><font size=2>"; echo $row['publish']; echo "</font></td><td align=center><font size=2>"; echo $row['waktu']; echo "</font></td></tr>";
$no++;
}
?>
</table>
<?php
}
?>


<?php
if (isset($_POST['lkkk'])){
$kategori=$_POST['kategori'];
?>
<table border="1" width="100%" cellpadding="1" cellspacing="1">
<tr><td colspan="14" bgcolor="yellow" align="center"><font size="5">Sistem Informasi Geografis Rumah Kost dan Kontrakan</font><br><?php echo "<font size=4>Kategori  : "; echo $kategori; echo "<br>";  echo "Tanggal  : " . date("Y-m-d") . "<br>"; ?></td></tr>
<tr><td align="center" bgcolor="white">No</td><td align="center" bgcolor="white">Nama Kost/Kontrakan</td><td align="center" bgcolor="white">Phone</td><td align="center" bgcolor="white">Kelurahan</td><td align="center" bgcolor="white">Jalan</td><td align="center" bgcolor="white">Member</td><td align="center" bgcolor="white">Publish</td><td align="center" bgcolor="white">Waktu</td></tr>
<?php
$query=mysqli_query($con,"select tbl_koskon.kode_koskon,tbl_koskon.nama_koskon,tbl_koskon.phone,tbl_wilayah.kelurahan,tbl_koskon.jalan,tbl_koskon.kategori,tbl_koskon.publish,tbl_koskon.waktu,tbl_member.nama from tbl_koskon,tbl_wilayah,tbl_member where kategori='$kategori' and tbl_wilayah.kode_wilayah=tbl_koskon.kode_wilayah and tbl_member.kode_member=tbl_koskon.kode_member order by waktu asc");
$no=1;
while ($row=mysqli_fetch_array($query)){
echo "<tr><td align=center><font size=2>"; echo $no; echo "</font></td><td><font size=2>"; echo $row['nama_koskon']; echo "</font></td><td align=center><font size=2>"; echo $row['phone']; echo "</font></td><td><font size=2>"; echo $row['kelurahan']; echo "</font></td><td><font size=2>"; echo $row['jalan']; echo "</font></td><td align=center><font size=2>"; echo $row['nama']; echo "</font></td><td align=center><font size=2>"; echo $row['publish']; echo "</font></td><td align=center><font size=2>"; echo $row['waktu']; echo "</font></td></tr>";
$no++;
}
?>
</table>
<?php
}
?>
</body>