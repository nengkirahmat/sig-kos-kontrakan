<html><head><title>Laporan Semua Member</title></head>
<body onLoad="window.print()">
<?php
$host = "localhost";
$user="root";
$pass="";
$db="db_sig";
$con =mysqli_connect ($host,$user,$pass,$db);
$member="Member";
if (isset($_POST['lm'])) {
$query=mysqli_query($con,"select * from tbl_member where level='$member' order by nama asc");
$no=1;
?>
<table border="1" align="center" cellpadding="4" cellspacing="0" width="100%">
<tr><td colspan="7" align="center" bgcolor="yellow"><br><font size="4"><b>Sistem Informasi Geografis Rumah Kost dan Kontrakan<br>Kota Bukittinggi<br>Laporan Semua Member</b></font><br><br></td></tr>
<tr><td align="center">No</td><td align="center">Nama Member</td><td align="center">Gender</td><td align="center">Alamat</td><td align="center">Tanggal Lahir</td><td align="center">Alamat Email</td><td align="center">Waktu Daftar</td></tr>
<?php
while ($row=mysqli_fetch_array($query)){
echo "<tr><td align=center>"; echo $no; echo "</td><td>"; echo $row['nama']; echo "</td><td align=center>"; echo $row['gender']; echo "</td><td>"; echo $row['alamat']; echo "</td><td align=center>"; echo $row['tgl']; echo "-"; echo $row['bln']; echo "-"; echo $row['thn']; echo "</td><td>"; echo $row['email']; echo "</td><td align=center>"; echo $row['waktu_daftar']; echo "</td></tr>";
$no++;
}
?>
</table>
<?php

}
?>
</body>
</html>