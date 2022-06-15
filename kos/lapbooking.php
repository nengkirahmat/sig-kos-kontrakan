<?php
//Koneksi
$host="localhost";
$user="root";
$password="";
$db="db_sig";
$con=mysqli_connect($host,$user,$password,$db);
//Laporan Berdasarkan Kelurahan
?>
<head><title>|</title></head>
<body onLoad="window.print()">

<?php
if (isset($_POST['lks'])){
$query=mysqli_query($con,"select tbl_booking.kode_booking,tbl_booking.kode_member,tbl_member.nama,tbl_booking.kode_koskon,tbl_koskon.nama_koskon,tbl_booking.kode_kamar,tbl_booking.tgl,tbl_booking.status from tbl_booking,tbl_member,tbl_koskon where tbl_member.kode_member=tbl_booking.kode_member and tbl_koskon.kode_koskon=tbl_booking.kode_koskon order by tbl_booking.kode_booking desc");
?>
<table border="1" width="100%">
<tr><td colspan="14" bgcolor="yellow" align="center"><font size="5">Sistem Informasi Geografis Rumah Kost dan Kontrakan</font><br>Laporan Booking Kost dan Kontrakan<br><?php echo "Tanggal  : " . date("Y-m-d") . "<br>"; ?></td></tr>
<tr><td width="12%" align="center">Kode Booking</td><td width="12%" align="center">Kode Member</td><td align="center">Nama Lengkap</td><td width="10%" align="center">Kode Kost</td><td align="center">Nama Kost</td><td width="12%" align="center">Kode Kamar</td><td width="10%" align="center">Tanggal</td><td width="8%" align="center">Status</td></tr>
<?php
while ($row=mysqli_fetch_array($query)){
echo "<tr><td align=center>"; echo $row['kode_booking']; echo "</td><td align=center>"; echo $row['kode_member']; echo "</td><td>"; echo $row['nama']; echo "</td><td align=center>"; echo $row['kode_koskon']; echo "</td><td>"; echo $row['nama_koskon']; echo "</td><td align=center>"; echo $row['kode_kamar']; echo "</td><td align=center>"; echo $row['tgl']; echo "</td><td align=center>"; echo $row['status']; echo "</td></tr>";
}
?>
</table>
<?php
}
?>

<?php
//Laporan Booking Per Bulan
if (isset($_POST['lbkost'])){
$bln=$_POST['bln'];
$thn=$_POST['thn'];
$query=mysqli_query($con,"select tbl_booking.kode_booking,tbl_booking.kode_member,tbl_member.nama,tbl_booking.kode_koskon,tbl_koskon.nama_koskon,tbl_booking.kode_kamar,tbl_booking.tgl,tbl_booking.status,tbl_koskon.kategori from tbl_booking,tbl_member,tbl_koskon where tbl_member.kode_member=tbl_booking.kode_member and tbl_koskon.kode_koskon=tbl_booking.kode_koskon and year(tbl_booking.waktu)='$thn' and month(tbl_booking.waktu)='$bln' and tbl_koskon.kategori='Kost' order by tbl_booking.kode_booking desc");
?>
<table border="1" width="100%">
<tr><td colspan="14" bgcolor="yellow" align="center"><font size="5">Sistem Informasi Geografis Rumah Kost dan Kontrakan</font><br>Laporan Booking Kost<br><?php echo "Bulan : "; if ($bln=='01'){echo "Januari";} else if ($bln=='02'){echo "Februari";} else if ($bln=='03'){echo "Maret";} else if ($bln=='03'){echo "April";} else if ($bln=='05'){echo "Mei";} else if ($bln=='06'){echo "Juni";} else if ($bln=='07'){echo "Juli";} else if ($bln=='08'){echo "Agustus";} else if ($bln=='09'){echo "September";} else if ($bln=='10'){echo "Oktober";} else if ($bln=='11'){echo "November";} else if ($bln=='12'){echo "Desember";} echo "<br>"; echo "Tahun : "; echo $thn; echo "<br>"; echo "Tanggal  : " . date("Y-m-d") . "<br>"; ?></td></tr>
<tr><td width="12%" align="center">Kode Booking</td><td width="12%" align="center">Kode Member</td><td align="center">Nama Lengkap</td><td width="10%" align="center">Kode Kost</td><td align="center">Nama Kost</td><td width="12%" align="center">Kode Kamar</td><td width="10%" align="center">Tanggal</td><td width="8%" align="center">Status</td></tr>
<?php
while ($row=mysqli_fetch_array($query)){
echo "<tr><td align=center>"; echo $row['kode_booking']; echo "</td><td align=center>"; echo $row['kode_member']; echo "</td><td>"; echo $row['nama']; echo "</td><td align=center>"; echo $row['kode_koskon']; echo "</td><td>"; echo $row['nama_koskon']; echo "</td><td align=center>"; echo $row['kode_kamar']; echo "</td><td align=center>"; echo $row['tgl']; echo "</td><td align=center>"; echo $row['status']; echo "</td></tr>";
}
?>
</table>
<?php
}
?>

<?php
//Laporan Booking Per Bulan
if (isset($_POST['lbkontrakan'])){
$bln=$_POST['bln'];
$thn=$_POST['thn'];
$query=mysqli_query($con,"select tbl_booking.kode_booking,tbl_booking.kode_member,tbl_member.nama,tbl_booking.kode_koskon,tbl_koskon.nama_koskon,tbl_booking.kode_kamar,tbl_booking.tgl,tbl_booking.status,tbl_koskon.kategori from tbl_booking,tbl_member,tbl_koskon where tbl_member.kode_member=tbl_booking.kode_member and tbl_koskon.kode_koskon=tbl_booking.kode_koskon and year(tbl_booking.waktu)='$thn' and month(tbl_booking.waktu)='$bln' and tbl_koskon.kategori='Kontrakan' order by tbl_booking.kode_booking desc");
?>
<table border="1" width="100%">
<tr><td colspan="14" bgcolor="yellow" align="center"><font size="5">Sistem Informasi Geografis Rumah Kost dan Kontrakan</font><br>Laporan Booking Kontrakan<br><?php echo "Bulan : "; if ($bln=='01'){echo "Januari";} else if ($bln=='02'){echo "Februari";} else if ($bln=='03'){echo "Maret";} else if ($bln=='03'){echo "April";} else if ($bln=='05'){echo "Mei";} else if ($bln=='06'){echo "Juni";} else if ($bln=='07'){echo "Juli";} else if ($bln=='08'){echo "Agustus";} else if ($bln=='09'){echo "September";} else if ($bln=='10'){echo "Oktober";} else if ($bln=='11'){echo "November";} else if ($bln=='12'){echo "Desember";} echo "<br>"; echo "Tahun : "; echo $thn; echo "<br>"; echo "Tanggal  : " . date("Y-m-d") . "<br>"; ?></td></tr>
<tr><td width="12%" align="center">Kode Booking</td><td width="12%" align="center">Kode Member</td><td align="center">Nama Lengkap</td><td width="10%" align="center">Kode Kost</td><td align="center">Nama Kost</td><td width="12%" align="center">Kode Kamar</td><td width="10%" align="center">Tanggal</td><td width="8%" align="center">Status</td></tr>
<?php
while ($row=mysqli_fetch_array($query)){
echo "<tr><td align=center>"; echo $row['kode_booking']; echo "</td><td align=center>"; echo $row['kode_member']; echo "</td><td>"; echo $row['nama']; echo "</td><td align=center>"; echo $row['kode_koskon']; echo "</td><td>"; echo $row['nama_koskon']; echo "</td><td align=center>"; echo $row['kode_kamar']; echo "</td><td align=center>"; echo $row['tgl']; echo "</td><td align=center>"; echo $row['status']; echo "</td></tr>";
}
?>
</table>
<?php
}
?>

<?php
//Faktur Booking
if (isset($_POST['cetak'])){
$kode_kamar=$_GET['id'];
$query=mysqli_query($con,"select tbl_koskon.kategori,tbl_booking.komentar,tbl_booking.kode_booking,tbl_booking.kode_member,tbl_kamar.nomor_kamar,tbl_member.nama,tbl_booking.kode_koskon,tbl_koskon.nama_koskon,tbl_booking.kode_kamar,tbl_booking.tgl,tbl_booking.status from tbl_booking,tbl_member,tbl_koskon,tbl_kamar where tbl_kamar.kode_kamar=tbl_booking.kode_kamar and tbl_member.kode_member=tbl_booking.kode_member and tbl_booking.kode_koskon=tbl_koskon.kode_koskon and tbl_koskon.kode_koskon=tbl_booking.kode_koskon and tbl_booking.kode_kamar='$kode_kamar'");
$row=mysqli_fetch_array($query);
echo "<table border=1 width=400px><tr><td colspan=2><center>Sistem Informasi Geografis Rumah Kost dan Kontrakan<br>Faktur Booking<br>Tanggal : " . date('d-m-Y') . "</center></td></tr><tr><td width=200px>Kode Booking</td><td width=200px>: ";
echo $row['kode_booking']; echo "</td></tr><tr><td>Nama Calon Penyewa</td><td>: "; 
echo $row['nama']; echo "</td></tr><tr><td>Nama Kost/Kontrakan</td><td>: "; 
echo $row['nama_koskon']; echo "</td></tr>"; if ($row['kategori']=="Kontrakan"){} else  if ($row['kategori']=="Kost"){echo "<tr><td>Nomor Kamar</td><td>: "; echo $row['nomor_kamar']; echo "</td></tr>";} 
echo "<tr><td>Tanggal Booking</td><td>: ";
echo $row['tgl']; echo "</td></tr><tr><td>Komentar</td><td>: ";
echo $row['komentar']; echo "</td></tr><tr><td>Status</td><td>: ";
echo $row['status']; echo "</td></tr></table>";
}
?>

</body>