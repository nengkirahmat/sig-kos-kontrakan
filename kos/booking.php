<?php
$host="localhost";
$user="root";
$password="";
$db="db_sig";
$con=mysql_connect($host,$user,$password);
mysql_select_db($db,$con);
$query=mysql_query("select tbl_booking.kode_booking,tbl_booking.kode_member,tbl_kamar.nomor_kamar,tbl_member.nama,tbl_booking.kode_koskon,tbl_koskon.nama_koskon,tbl_booking.kode_kamar,tbl_booking.tgl,tbl_booking.status from tbl_booking,tbl_member,tbl_koskon,tbl_kamar where tbl_kamar.kode_kamar=tbl_booking.kode_kamar and tbl_member.kode_member=tbl_booking.kode_member and tbl_booking.kode_koskon=tbl_koskon.kode_koskon and tbl_koskon.kode_koskon=tbl_booking.kode_koskon order by tbl_booking.kode_booking desc");
$row=mysql_fetch_array($query);
$kode_booking=$row['kode_booking'];
$kode_member=$row['kode_member'];
$nama_member=$row['nama'];
$kode_koskon=$row['kode_koskon'];
$nama_koskon=$row['nama_koskon'];
$kode_kamar=$row['kode_kamar'];
$nomor=$row['nomor_kamar'];
$tgl=$row['tgl'];
$status=$row['status'];
require_once("dompdf/dompdf_config.inc.php");

$html="<table border=1 width=400px><tr><td colspan=2><center>Sistem Informasi Geografis Rumah Kost dan Kontrakan<br>Faktur Booking<br>Tanggal : " . date('d-m-Y') . "</center></td></tr><tr><td width=200px>Kode Booking</td><td width=200px>: " .$kode_booking. "</td></tr><tr><td>Nama Calon Penyewa</td><td>: " .$nama_member. "</td></tr><tr><td>Nama Kost/Kontrakan</td><td>: " .$nama_koskon. "</td></tr><tr><td>Nomor Kamar</td><td>: " .$nomor. "</td></tr><tr><td>Tanggal Booking</td><td>: " .$tgl. "</td></tr><tr><td>Status</td><td>: " .$status. "</td></tr></table>";
$d=new DOMPDF();
$d->load_html($html);
$d->render();
$d->stream("laporan.pdf");
?>