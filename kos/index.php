<?php
//Koneksi
$host = "localhost";
$user = "root";
$password = "";
$db = "db_sig";
$con = mysqli_connect($host, $user, $password, $db);
session_start();
if (!empty($_SESSION['username'])) {
	echo "<font color=black>Nama : ";
	echo $_SESSION['username'];
	echo "</font>";
}
?>
<html>

<head>
	<title><?php if (isset($_GET['beranda'])) {
				echo "Kost dan Kontrakan Bukittinggi";
			} else if (isset($_GET['kost'])) {
				echo "Rumah Kost Bukittinggi";
			} else if (isset($_GET['kontrakan'])) {
				echo "Rumah Kontrakan Bukittinggi";
			} else if (isset($_GET['bt'])) {
				echo "Buku Tamu";
			} else if (isset($_GET['mlogin'])) {
				echo "Login";
			} else if (isset($_GET['mregister'])) {
				echo "Register Member";
			} else if (isset($_POST['detailkoskon'])) {
				echo "Detail Kost / Kontrakan Bukittinggi";
			} else if (isset($_GET['keluar'])) {
				echo "Kost dan Kontrakan Bukittinggi";
			} else if (isset($_GET['akun'])) {
				echo "Akun Saya";
			} else if (isset($_GET['admin'])) {
				echo "Administrator Kost dan Kontrakan Bukittinggi";
			} else if (isset($_GET['laporan'])) {
				echo "Laporan";
			} else if (isset($_GET['koskon'])) {
				echo "Tambah Kost dan Kontrakan";
			} else if (isset($_GET['iwilayah'])) {
				echo "Input Wilayah";
			} else if (isset($_GET['amember'])) {
				echo "Atur Member";
			} else if (isset($_GET['akoskon'])) {
				echo "Atur Kost dan Kontrakan";
			} else if (isset($_GET['abooking'])) {
				echo "Atur Booking Kost dan Kontrakan";
			} else if (isset($_GET['abt'])) {
				echo "Atur Buku Tamu";
			} else if (isset($_GET['tadmin'])) {
				echo "Atur Admin";
			}
			?></title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<style type="text/css">
		#map,
		#map2 {
			margin: 10px;
			width: 100%;
			height: 400px;
			padding: 10px;

		}

		#petakon,
		#petakost {
			width: 100%;
			height: 400px;

		}

		a {
			text-decoration: none;
			font-family: times new roman;
		}

		#cs {
			background: orange;
			width: 100%;
			height: 40;
			line-height: 40px;
			font-size: 18;
			margin-top: 5;
		}

		#cs:hover {
			background: white;
			color: purple;
		}

		body {
			color: white;
		}

		#csadmin {
			background: orange;
			color: purple;
			width: 50%;
			height: 40;
			line-height: 40px;
			font-size: 18;
			margin-top: 5px;
		}

		#csadmin:hover {
			background: white;
		}

		#csadmin1 {
			background: orange;
			color: purple;
			width: 16%;
			margin-left: 5px;
			height: 40;
			line-height: 40px;
			font-size: 17;
			margin-top: 5px;
			float: left;
		}

		#csadmin1:hover {
			background: white;
		}

		input:hover {
			background: darkred;
			color: white;
		}

		select:hover {
			background: darkred;
			color: white;
		}
	</style>
	<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
</head>

<body>

	<?PHP //background="body.jpg" 
	?>
	<table border="5" bordercolor="red" width="100%" bgcolor="body.jpg" align="center" cellpadding="10" cellspacing="0">
		<tr>
			<td width="20%" valign="top" align="center">

				<div id="cs" style="background:darkred; color:white;">Menu</div>
				<hr>
				<a href="?beranda">
					<div id="cs">Beranda</div>
				</a>
				<a href="?kost">
					<div id="cs">Rumah Kost</div>
				</a>
				<a href="?kontrakan">
					<div id="cs">Rumah Kontrakan</div>
				</a>
				<a href="?bt">
					<div id="cs">Buku Tamu</div>
				</a>
				<?php if (empty($_SESSION['username'])) {
				?>
					<br>
					<a href="?mlogin">
						<div id="cs">Login</div>
					</a>
					<a href="?mregister">
						<div id="cs">Register</div>
					</a>
				<?php
				}
				?>
				<hr>
				<?php if (!empty($_SESSION['username'])) { ?>
					<a href="?akun">
						<div id="cs">Akun Saya</div>
					</a>
					<a href="?koskon">
						<div id="cs">Tambah Kost / Kontrakan</div>
					</a>
					<hr>
					<?php
					$nama = $_SESSION['username'];
					$query = mysqli_query($con, "select * from tbl_member where nama='$nama'");
					$row = mysqli_fetch_array($query);
					if ($row['level'] == "Admin") { ?>
						<a href="?admin">
							<div id="cs">Administrator</div>
						</a>
						<a href="?laporan">
							<div id="cs">Laporan</div>
						</a>

					<?php
					}
					?>
					<br>
					<a href="?keluar">
						<div id="cs">Keluar</div>
					</a>
				<?php }
				if (isset($_GET['keluar'])) {
					unset($_SESSION['username']);
					header('location:?beranda');
				}
				?>
			</td>

			<td width="100%" valign="top" align="center">

				<?php
				//Menampilkan Beranda
				if (isset($_GET['beranda'])) {

				?>
					<table border="0" width="100%" cellpadding="10" cellspacing="0">
						<tr>
							<td colspan="2" align="center" bgcolor="orange">
								<font size="4">Halaman Beranda
							</td>
						</tr>
						<tr>
							<td align="center" colspan="4">
								<hr>
								<font size="4">Lokasi Rumah Kost / Kontrakan</font>
								<hr>
								<div id="petakost"></div>

								<script type="text/javascript">
									(function() {
										window.onload = function() {
											var map;
											//Parameter Google maps
											var options = {
												zoom: 14, //level zoom
												//posisi tengah peta
												center: new google.maps.LatLng(-0.3038764, 100.3729242),
												mapTypeId: google.maps.MapTypeId.ROADMAP
											};

											// Buat peta di 
											var map = new google.maps.Map(document.getElementById('petakost'), options);
											// Tambahkan Marker 
											var locations = [
												<?php
												$query = mysqli_query($con, "select tbl_gambar.gambar,tbl_koskon.kategori,tbl_koskon.kode_koskon,tbl_koskon.nama_koskon,tbl_wilayah.kelurahan,tbl_koskon.jalan,tbl_koskon.phone,tbl_koskon.lat,tbl_koskon.lng from tbl_koskon,tbl_wilayah,tbl_gambar where tbl_gambar.kode_koskon=tbl_koskon.kode_koskon and tbl_gambar.profil='Yes' and tbl_koskon.publish='Yes' and tbl_wilayah.kode_wilayah=tbl_koskon.kode_wilayah");
												while ($row = mysqli_fetch_array($query)) {
													echo "['<img width=150 height=150 src=gambar/" . $row['gambar'] . "></img>";
													echo "<br><font color=black>Nama Kost :";
													echo $row['nama_koskon'];
													echo "<br>Kategori :";
													echo $row['kategori'];
													echo "<br>Kelurahan :";
													echo $row['kelurahan'];
													echo "<br>Jalan :";
													echo $row['jalan'];
													echo "<br>Phone :";
													echo $row['phone'];
													echo "<br></font><form action=?id=" . $row['kode_koskon'] . " method=POST><input type=submit name=detailkoskon value=Detail>"; ?> <?php echo "</form>";
																																														echo "',";
																																														echo  $row['lat'];
																																														echo ",";
																																														echo $row['lng'];
																																														echo "],";
																																													}
																																														?>

											];
											var infowindow = new google.maps.InfoWindow();

											var marker, i;
											/* kode untuk menampilkan banyak marker */
											for (i = 0; i < locations.length; i++) {
												marker = new google.maps.Marker({
													position: new google.maps.LatLng(locations[i][1], locations[i][2]),
													map: map,
													draggable: false
												});
												/* menambahkan event clik untuk menampikan
     	 infowindows dengan isi sesuai denga
	    marker yang di klik */

												google.maps.event.addListener(marker, 'click', (function(marker, i) {
													return function() {
														infowindow.setContent(locations[i][0]);
														infowindow.open(map, marker);
													}
												})(marker, i));
											}


										};
									})();
								</script>
								<hr>
							</td>
						</tr>
						<tr>
							<td align="center">Daftar Kos-Kosan
								<hr>
							</td>
							<td align="center">Daftar Kontrakan
								<hr>
							</td>
						</tr>
						<tr>
							<td width="50%" align="center" valign="top">
								<?php
								$query = mysqli_query($con, "select tbl_koskon.kode_koskon,tbl_koskon.nama_koskon,tbl_gambar.gambar,tbl_wilayah.kelurahan,tbl_koskon.jalan,tbl_koskon.phone from tbl_koskon,tbl_wilayah,tbl_gambar where tbl_gambar.profil='Yes' and tbl_koskon.publish='Yes' and tbl_wilayah.kode_wilayah=tbl_koskon.kode_wilayah and tbl_gambar.kode_koskon=tbl_koskon.kode_koskon and tbl_wilayah.kode_wilayah=tbl_koskon.kode_wilayah and tbl_koskon.kategori='Kost' and tbl_gambar.profil='Yes'");
								while ($row = mysqli_fetch_array($query)) {
									echo "<table border=0 width=100% bgcolor=orange height=150>";
									echo "<tr><td width=35% height=150 rowspan=6><img width=100%  height=100% src=gambar/";
									echo $row['gambar'];
									echo "></img></td></tr>";
									echo "<tr><td>";
									echo "Nama Kost/Kontrakan";
									echo "</td><td>";
									echo $row['nama_koskon'];
									echo "</td></tr>";
									echo "<tr><td>";
									echo "Kelurahan";
									echo "</td><td>";
									echo $row['kelurahan'];
									echo "</td></tr>";
									echo "<tr><td>";
									echo "Jalan ";
									echo "</td><td>";
									echo $row['jalan'];
									echo "</td></tr>";
									echo "<tr><td>";
									echo "Phone ";
									echo "</td><td>";
									echo $row['phone'];
									echo "</td></tr>";
									echo "<tr><form action=?id=";
									echo $row['kode_koskon'];
									echo " method=POST><td colspan=2><input type=submit name=detailkoskon value="; ?>"Detail" style="width:100%;"><?php echo "</td></form></tr>";
																																					echo "</table> <br>";
																																				}
																																					?>
							</td>
							<td width="50%" align="center" valign="top">
								<?php
								$query = mysqli_query($con, "select tbl_koskon.kode_koskon,tbl_koskon.nama_koskon,tbl_gambar.gambar,tbl_wilayah.kelurahan,tbl_koskon.jalan,tbl_koskon.phone from tbl_koskon,tbl_wilayah,tbl_gambar where tbl_gambar.profil='Yes' and tbl_koskon.publish='Yes' and tbl_wilayah.kode_wilayah=tbl_koskon.kode_wilayah and tbl_gambar.kode_koskon=tbl_koskon.kode_koskon and tbl_koskon.kategori='Kontrakan'");
								while ($row = mysqli_fetch_array($query)) {
									echo "<table border=0 width=100% bgcolor=orange height=150>";
									echo "<tr><td width=35%  height=150  rowspan=6><img width=100%  height=100% src=gambar/";
									echo $row['gambar'];
									echo "></img></td></tr>";
									echo "<tr><td>";
									echo "Nama Kos/Kontrakan";
									echo "</td><td>";
									echo $row['nama_koskon'];
									echo "</td></tr>";
									echo "<tr><td>";
									echo "Kelurahan";
									echo "</td><td>";
									echo $row['kelurahan'];
									echo "</td></tr>";
									echo "<tr><td>";
									echo "Jalan ";
									echo "</td><td>";
									echo $row['jalan'];
									echo "</td></tr>";
									echo "<tr><td>";
									echo "Phone ";
									echo "</td><td>";
									echo $row['phone'];
									echo "</td></tr>";
									echo "<tr><form action=?id=";
									echo $row['kode_koskon'];
									echo " method=POST><td colspan=2><input type=submit name=detailkoskon value="; ?>"Detail" style="width:100%;"><?php echo "</td></form></tr>";
																																					echo "</table> <br>";
																																				}
																																					?>
							</td>
						</tr>
					</table>
				<?php
				}
				?>



				<?php
				//Menampilkan Kos-Kosan

				if (isset($_GET['kost'])) {
				?>
					<table border="0" width="100%" align="center">
						<tr>
							<td colspan="2" align="center" bgcolor="orange">
								<font size="4">Halaman Rumah Kost
							</td>
						</tr>
						<tr>
							<form action="#" method="GET">
								<td height="30" colspan="2">Wilayah : <select name="wilayah">
										<option>-</option>
										<?php
										$query = mysqli_query($con, "select * from tbl_wilayah order by kelurahan asc");
										$kode_wilayah = $_POST['wilayah'];
										while ($row = mysqli_fetch_array($query)) {
										?><option value="<?php echo $row['kode_wilayah']; ?> "><?php echo $row['kecamatan'];
																								echo " - ";
																								echo $row['kelurahan'];
																								echo "</option>";
																							}
																								?>
									</select>
									<input type="submit" name="carikost" value="Cari" style="background:orange;">
								</td>
							</form>
						</tr>
						<tr>
							<td colspan="2" align="center">
								<div id="petakost"></div>

								<script type="text/javascript">
									(function() {
										window.onload = function() {
											var map;
											//Parameter Google maps
											var options = {
												zoom: 14, //level zoom
												//posisi tengah peta
												center: new google.maps.LatLng(-0.3038764, 100.3729242),
												mapTypeId: google.maps.MapTypeId.ROADMAP
											};

											// Buat peta di 
											var map = new google.maps.Map(document.getElementById('petakost'), options);
											// Tambahkan Marker 
											var locations = [
												<?php
												$query = mysqli_query($con, "select tbl_gambar.gambar,tbl_koskon.kode_koskon,tbl_koskon.nama_koskon,tbl_wilayah.kelurahan,tbl_koskon.jalan,tbl_koskon.phone,tbl_koskon.lat,tbl_koskon.lng from tbl_gambar,tbl_koskon,tbl_wilayah where tbl_koskon.publish='Yes' and tbl_wilayah.kode_wilayah=tbl_koskon.kode_wilayah and tbl_koskon.kategori='Kost' and tbl_gambar.kode_koskon=tbl_koskon.kode_koskon and tbl_gambar.profil='Yes'");
												while ($row = mysqli_fetch_array($query)) {
													echo "['<img width=150 height=150 src=gambar/" . $row['gambar'] . "></img>";
													echo "<br><font color=black>Nama Kost :";
													echo $row['nama_koskon'];
													echo "<br>Kelurahan :";
													echo $row['kelurahan'];
													echo "<br>Jalan :";
													echo $row['jalan'];
													echo "<br>Phone :";
													echo $row['phone'];
													echo "<br></font><form action=?id=" . $row['kode_koskon'] . " method=POST><input type=submit name=detailkoskon value=Detail"; ?> style = "width:100%; background:orange;"
												<?php echo "></form>";
													echo "',";
													echo  $row['lat'];
													echo ",";
													echo $row['lng'];
													echo "],";
												}
												?>

											];
											var infowindow = new google.maps.InfoWindow();

											var marker, i;
											/* kode untuk menampilkan banyak marker */
											for (i = 0; i < locations.length; i++) {
												marker = new google.maps.Marker({
													position: new google.maps.LatLng(locations[i][1], locations[i][2]),
													map: map,
													icon: 'kost-icon.png'
												});
												/* menambahkan event clik untuk menampikan
     	 infowindows dengan isi sesuai denga
	    marker yang di klik */

												google.maps.event.addListener(marker, 'click', (function(marker, i) {
													return function() {
														infowindow.setContent(locations[i][0]);
														infowindow.open(map, marker);
													}
												})(marker, i));
											}


										};
									})();
								</script>

							</td>
						</tr>
						<?php
						if (!empty($_SESSION['username'])) { ?>
							<tr>
								<form action="#" method="POST">
									<td colspan="2"><br><input type="submit" name="koskon" value="Tambahkan Kost/Kontrakan" style="background:orange; width:25%; height:40;"></td>
								</form>
							</tr>
							<tr>
							<?php
						}

							?>



							<?php
							$query = mysqli_query($con, "select tbl_koskon.kode_koskon,tbl_koskon.nama_koskon,tbl_gambar.gambar,tbl_wilayah.kelurahan,tbl_koskon.jalan,tbl_koskon.phone,tbl_koskon.lat,tbl_koskon.lng from tbl_koskon,tbl_wilayah,tbl_gambar where tbl_gambar.profil='Yes' and tbl_koskon.publish='Yes' and tbl_wilayah.kode_wilayah=tbl_koskon.kode_wilayah and tbl_gambar.kode_koskon=tbl_koskon.kode_koskon and tbl_koskon.kategori='Kost'");
							$b = 0;
							while ($row = mysqli_fetch_array($query)) {
								echo "<td align=center width=50%><br><table border=0 width=100% bgcolor=orange height=150>";
								echo "<tr><td width=35% height=150 rowspan=6><img width=100% height=100% src=gambar/";
								echo $row['gambar'];
								echo "></img></td><td>";
								echo "Nama Kost";
								echo "</td><td>";
								echo $row['nama_koskon'];
								echo "</td></tr>";
								echo "<tr><td>";
								echo "Kelurahan";
								echo "</td><td>";
								echo $row['kelurahan'];
								echo "</td></tr>";
								echo "<tr><td>";
								echo "Jalan ";
								echo "</td><td>";
								echo $row['jalan'];
								echo "</td></tr>";
								echo "<tr><td>";
								echo "Phone ";
								echo "</td><td>";
								echo $row['phone'];
								echo "</td></tr>";
								echo "<tr><form action=?id=";
								echo $row['kode_koskon'];
								echo " method=POST><td colspan=2><input type=submit name=detailkoskon value="; ?>"Detail" style="width:100%; background:orange;"><?php echo "</td></form></tr>";
																																									echo "</table></td>";
																																									$b++;
																																									if ($b >= 2) {
																																										echo "</tr><tr>";
																																										$b = 0;
																																									}
																																								}
																																									?>

						<?php
					}
						?>


						<?php
						//Mencari Kost Berdasarkan Kelurahan

						if (isset($_GET['carikost'])) {
						?>
							<table border="0" width="100%" align="center">
								<tr>
									<td colspan="2" align="center" bgcolor="orange">
										<font size="4">Halaman Rumah Kost
									</td>
								</tr>
								<tr>
									<form action="#" method="GET">
										<td>Wilayah : <select name="wilayah">
												<?php
												$kode_wilayah = $_GET['wilayah'];
												$queryw = mysqli_query($con, "select * from tbl_wilayah where kode_wilayah='$kode_wilayah'");
												$rw = mysqli_fetch_array($queryw);
												?>
												<option value="<?php echo $rw['kode_wilayah']; ?>"><?php echo $rw['kecamatan'];
																									echo " - ";
																									echo $rw['kelurahan']; ?></option>
												<?php
												$query = mysqli_query($con, "select * from tbl_wilayah order by kelurahan asc");
												while ($row = mysqli_fetch_array($query)) {
												?><option value="<?php echo $row['kode_wilayah']; ?> "><?php echo $row['kecamatan'];
																										echo " - ";
																										echo $row['kelurahan'];
																										echo "</option>";
																									}
																										?>
											</select>
											<input type="submit" name="carikost" value="Cari" style="background:orange;">
										</td>
									</form>
								</tr>
								<tr>
									<td colspan="2" align="center">
										<div id="petakost" align="center"></div>

										<script type="text/javascript">
											(function() {
												window.onload = function() {
													var map;
													//Parameter Google maps
													var options = {
														zoom: 14, //level zoom
														//posisi tengah peta
														center: new google.maps.LatLng(-0.3038764, 100.3729242),
														mapTypeId: google.maps.MapTypeId.ROADMAP
													};

													// Buat peta di 
													var map = new google.maps.Map(document.getElementById('petakost'), options);
													// Tambahkan Marker 
													var locations = [
														<?php
														$query = mysqli_query($con, "select tbl_gambar.gambar,tbl_koskon.kode_koskon,tbl_koskon.nama_koskon,tbl_wilayah.kelurahan,tbl_koskon.jalan,tbl_koskon.phone,tbl_koskon.lat,tbl_koskon.lng from tbl_gambar,tbl_koskon,tbl_wilayah where tbl_koskon.publish='Yes' and tbl_wilayah.kode_wilayah='$kode_wilayah' and tbl_koskon.kategori='Kost' and tbl_koskon.kode_wilayah=tbl_wilayah.kode_wilayah and tbl_gambar.kode_koskon=tbl_koskon.kode_koskon and tbl_gambar.profil='Yes'");
														while ($row = mysqli_fetch_array($query)) {
															echo "['<img width=150 height=150 src=gambar/" . $row['gambar'] . "></img>";
															echo "<br><font color=black>Nama Kost :";
															echo $row['nama_koskon'];
															echo "<br>Kelurahan :";
															echo $row['kelurahan'];
															echo "<br>Jalan :";
															echo $row['jalan'];
															echo "<br>Phone :";
															echo $row['phone'];
															echo "<br></font><form action=?id=" . $row['kode_koskon'] . " method=POST><input type=submit name=detailkoskon value=Detail "; ?> style = "width:25%; background:orange;"
														<?php echo "></form>";
															echo "',";
															echo  $row['lat'];
															echo ",";
															echo $row['lng'];
															echo "],";
														}
														?>

													];
													var infowindow = new google.maps.InfoWindow();

													var marker, i;
													/* kode untuk menampilkan banyak marker */
													for (i = 0; i < locations.length; i++) {
														marker = new google.maps.Marker({
															position: new google.maps.LatLng(locations[i][1], locations[i][2]),
															map: map,
															icon: 'kost-icon.png'
														});
														/* menambahkan event clik untuk menampikan
     	 infowindows dengan isi sesuai denga
	    marker yang di klik */

														google.maps.event.addListener(marker, 'click', (function(marker, i) {
															return function() {
																infowindow.setContent(locations[i][0]);
																infowindow.open(map, marker);
															}
														})(marker, i));
													}


												};
											})();
										</script>

									</td>
								</tr>
								<?php
								if (!empty($_SESSION['username'])) { ?>
									<tr>
										<form action="#" method="POST">
											<td><br><input type="submit" name="koskon" value="Tambahkan Kost/Kontrakan" style="background:orange; width:200; height:40;"></td>
										</form>
									</tr>
									<tr>
									<?php
								}

									?>

									<?php
									$query = mysqli_query($con, "select tbl_koskon.kode_koskon,tbl_koskon.nama_koskon,tbl_gambar.gambar,tbl_wilayah.kelurahan,tbl_koskon.jalan,tbl_koskon.phone,tbl_koskon.lat,tbl_koskon.lng from tbl_koskon,tbl_wilayah,tbl_gambar where tbl_koskon.publish='Yes' and tbl_wilayah.kode_wilayah='$kode_wilayah' and tbl_gambar.kode_koskon=tbl_koskon.kode_koskon and tbl_gambar.profil='Yes' and tbl_koskon.kategori='Kost' and tbl_koskon.kode_wilayah=tbl_wilayah.kode_wilayah");
									$b = 0;
									while ($row = mysqli_fetch_array($query)) {
										echo "<td align=center width=50%><br><table border=0 width=100% bgcolor=orange height=150>";
										echo "<tr><td width=35% height=150  rowspan=6><img width=100% height=100% src=gambar/";
										echo $row['gambar'];
										echo "></img></td><td>";
										echo "Nama Kost";
										echo "</td><td>";
										echo $row['nama_koskon'];
										echo "</td></tr>";
										echo "<tr><td>";
										echo "Kelurahan";
										echo "</td><td>";
										echo $row['kelurahan'];
										echo "</td></tr>";
										echo "<tr><td>";
										echo "Jalan ";
										echo "</td><td>";
										echo $row['jalan'];
										echo "</td></tr>";
										echo "<tr><td>";
										echo "Phone ";
										echo "</td><td>";
										echo $row['phone'];
										echo "</td></tr>";
										echo "<tr><form action=?id=";
										echo $row['kode_koskon'];
										echo " method=POST><td colspan=2><input type=submit name=detailkoskon value="; ?>"Detail" style="width:100%; background:orange;"><?php echo "</td></form></tr>";
																																											echo "</table></td>";
																																											$b++;
																																											if ($b >= 2) {
																																												echo "</tr><tr>";
																																												$b = 0;
																																											}
																																										}
																																											?>

								<?php
							}
								?>



								<?php
								//Kontrakan

								if (isset($_GET['kontrakan'])) {
								?>
									<table border="0" width="100%" align="center">
										<tr>
											<td colspan="2" align="center" bgcolor="orange">
												<font size="4">Halaman Rumah Kontrakan
											</td>
										</tr>
										<tr>
											<form action="#" method="GET">
												<td>Wilayah : <select name="wilayah">
														<?php
														if (isset($_POST['wilayah'])) {
															$kode_wilayah = $_POST['wilayah'];
														} else {
															$kode_wilayah = '13';
														}
														$queryw = mysqli_query($con, "select * from tbl_wilayah where kode_wilayah='$kode_wilayah'");
														$rw = mysqli_fetch_array($queryw);
														?>
														<option value="<?php echo $rw['kode_wilayah']; ?>"><?php echo $rw['kecamatan'];
																											echo " - ";
																											echo $rw['kelurahan']; ?></option>
														<?php
														$query = mysqli_query($con, "select * from tbl_wilayah order by kelurahan asc");
														while ($row = mysqli_fetch_array($query)) {
														?><option value="<?php echo $row['kode_wilayah']; ?> "><?php echo $row['kecamatan'];
																												echo " - ";
																												echo $row['kelurahan'];
																												echo "</option>";
																											}
																												?>
													</select>
													<input type="submit" name="carikontrakan" value="Cari" style="background:orange;">
												</td>
											</form>
										</tr>
										<tr>
											<td colspan="2" align="center">
												<div id="petakost"></div>

												<script type="text/javascript">
													(function() {
														window.onload = function() {
															var map;
															//Parameter Google maps
															var options = {
																zoom: 14, //level zoom
																//posisi tengah peta
																center: new google.maps.LatLng(-0.3038764, 100.3729242),
																mapTypeId: google.maps.MapTypeId.ROADMAP
															};

															// Buat peta di 
															var map = new google.maps.Map(document.getElementById('petakost'), options);
															// Tambahkan Marker 
															var locations = [
																<?php
																$query = mysqli_query($con, "select tbl_gambar.gambar,tbl_koskon.kode_koskon,tbl_koskon.nama_koskon,tbl_wilayah.kelurahan,tbl_koskon.jalan,tbl_koskon.phone,tbl_koskon.lat,tbl_koskon.lng from tbl_gambar,tbl_koskon,tbl_wilayah where tbl_koskon.publish='Yes' and tbl_koskon.kategori='Kontrakan' and tbl_koskon.kode_wilayah=tbl_wilayah.kode_wilayah and tbl_gambar.kode_koskon=tbl_koskon.kode_koskon and tbl_gambar.profil='Yes'");
																while ($row = mysqli_fetch_array($query)) {
																	echo "['<img width=150 height=150 src=gambar/" . $row['gambar'] . "></img>";
																	echo "<br><font color=black>Nama Kost :";
																	echo $row['nama_koskon'];
																	echo "<br>Kelurahan :";
																	echo $row['kelurahan'];
																	echo "<br>Jalan :";
																	echo $row['jalan'];
																	echo "<br>Phone :";
																	echo $row['phone'];
																	echo "<br></font><form action=?id=" . $row['kode_koskon'] . " method=POST><input type=submit name=detailkoskon value=Detail"; ?> style = "width:100%; background:orange;"
																<?php echo "></form>";
																	echo "',";
																	echo  $row['lat'];
																	echo ",";
																	echo $row['lng'];
																	echo "],";
																}
																?>

															];
															var infowindow = new google.maps.InfoWindow();

															var marker, i;
															/* kode untuk menampilkan banyak marker */
															for (i = 0; i < locations.length; i++) {
																marker = new google.maps.Marker({
																	position: new google.maps.LatLng(locations[i][1], locations[i][2]),
																	map: map,
																	icon: 'kont-icon.png'
																});
																/* menambahkan event clik untuk menampikan
     	 infowindows dengan isi sesuai denga
	    marker yang di klik */

																google.maps.event.addListener(marker, 'click', (function(marker, i) {
																	return function() {
																		infowindow.setContent(locations[i][0]);
																		infowindow.open(map, marker);
																	}
																})(marker, i));
															}


														};
													})();
												</script>

											</td>
										</tr>
										<?php
										if (!empty($_SESSION['username'])) { ?>
											<tr>
												<form action="#" method="POST">
													<td><br><input type="submit" name="koskon" value="Tambahkan Kost/Kontrakan" style="background:orange; width:25%; height:40;"></td>
												</form>
											</tr>
											<tr>
											<?php
										}

											?>

											<?php
											$query = mysqli_query($con, "select tbl_koskon.kode_koskon,tbl_koskon.nama_koskon,tbl_gambar.gambar,tbl_wilayah.kelurahan,tbl_koskon.jalan,tbl_koskon.phone,tbl_koskon.lat,tbl_koskon.lng from tbl_koskon,tbl_wilayah,tbl_gambar where tbl_koskon.publish='Yes' and tbl_gambar.kode_koskon=tbl_koskon.kode_koskon and tbl_gambar.profil='Yes' and tbl_koskon.kategori='Kontrakan' and tbl_koskon.kode_wilayah=tbl_wilayah.kode_wilayah");
											$b = 0;
											while ($row = mysqli_fetch_array($query)) {
												echo "<td align=center><br><table border=0 width=100% bgcolor=orange height=150>";
												echo "<tr><td width=35%  height=150  rowspan=6><img width=100% height=100% src=gambar/";
												echo $row['gambar'];
												echo "></img></td><td>";
												echo "Nama Kontrakan";
												echo "</td><td>";
												echo $row['nama_koskon'];
												echo "</td></tr>";
												echo "<tr><td>";
												echo "Kelurahan";
												echo "</td><td>";
												echo $row['kelurahan'];
												echo "</td></tr>";
												echo "<tr><td>";
												echo "Jalan ";
												echo "</td><td>";
												echo $row['jalan'];
												echo "</td></tr>";
												echo "<tr><td>";
												echo "Phone ";
												echo "</td><td>";
												echo $row['phone'];
												echo "</td></tr>";
												echo "<tr><form action=?id=";
												echo $row['kode_koskon'];
												echo " method=POST><td colspan=2><input type=submit name=detailkoskon value="; ?>"Detail" style="width:100%; background:orange;"><?php echo "</td></form></tr>";
																																													echo "</table></td>";
																																													$b++;
																																													if ($b >= 2) {
																																														echo "</tr><tr>";
																																														$b = 0;
																																													}
																																												}
																																													?>

										<?php
									}
										?>


										<?php
										//Mencari Kontrakan Berdasarkan Kelurahan

										if (isset($_GET['carikontrakan'])) {
										?>
											<table border="0" width="100%" align="center">
												<tr>
													<td colspan="2" align="center" bgcolor="orange">
														<font size="4">Halaman Rumah Kontrakan
													</td>
												</tr>
												<tr>
													<form action="#" method="GET">
														<td>Wilayah : <select name="wilayah">
																<?php
																$kode_wilayah = $_GET['wilayah'];
																$queryw = mysqli_query($con, "select * from tbl_wilayah where kode_wilayah='$kode_wilayah'");
																$rw = mysqli_fetch_array($queryw);
																?>
																<option value="<?php echo $rw['kode_wilayah']; ?>"><?php echo $rw['kecamatan'];
																													echo " - ";
																													echo $rw['kelurahan']; ?></option>
																<?php
																$query = mysqli_query($con, "select * from tbl_wilayah order by kelurahan asc");
																while ($row = mysqli_fetch_array($query)) {
																?><option value="<?php echo $row['kode_wilayah']; ?> "><?php echo $row['kecamatan'];
																														echo " - ";
																														echo $row['kelurahan'];
																														echo "</option>";
																													}
																														?>
															</select>
															<input type="submit" name="carikontrakan" value="Cari" style="background:orange;">
														</td>
													</form>
												</tr>
												<tr>
													<td colspan="2" align="center">
														<div id="petakost"></div>

														<script type="text/javascript">
															(function() {
																window.onload = function() {
																	var map;
																	//Parameter Google maps
																	var options = {
																		zoom: 14, //level zoom
																		//posisi tengah peta
																		center: new google.maps.LatLng(-0.3038764, 100.3729242),
																		mapTypeId: google.maps.MapTypeId.ROADMAP
																	};

																	// Buat peta di 
																	var map = new google.maps.Map(document.getElementById('petakost'), options);
																	// Tambahkan Marker 
																	var locations = [
																		<?php
																		$query = mysqli_query($con, "select tbl_gambar.gambar,tbl_koskon.kode_koskon,tbl_koskon.nama_koskon,tbl_wilayah.kelurahan,tbl_koskon.jalan,tbl_koskon.phone,tbl_koskon.lat,tbl_koskon.lng from tbl_gambar,tbl_koskon,tbl_wilayah where tbl_koskon.publish='Yes' and tbl_wilayah.kode_wilayah='$kode_wilayah' and tbl_koskon.kategori='Kontrakan' and tbl_koskon.kode_wilayah=tbl_wilayah.kode_wilayah and tbl_gambar.kode_koskon=tbl_koskon.kode_koskon and tbl_gambar.profil='Yes'");
																		while ($row = mysqli_fetch_array($query)) {
																			echo "['<img width=150 height=150 src=gambar/" . $row['gambar'] . "></img>";
																			echo "<br><font color=black>Nama Kost :";
																			echo $row['nama_koskon'];
																			echo "<br>Kelurahan :";
																			echo $row['kelurahan'];
																			echo "<br>Jalan :";
																			echo $row['jalan'];
																			echo "<br>Phone :";
																			echo $row['phone'];
																			echo "<br></font><form action=?id=" . $row['kode_koskon'] . " method=POST><input type=submit name=detailkoskon value=Detail"; ?> style = "width:100%; background:orange;"
																		<?php echo "></form>";
																			echo "',";
																			echo  $row['lat'];
																			echo ",";
																			echo $row['lng'];
																			echo "],";
																		}
																		?>

																	];
																	var infowindow = new google.maps.InfoWindow();

																	var marker, i;
																	/* kode untuk menampilkan banyak marker */
																	for (i = 0; i < locations.length; i++) {
																		marker = new google.maps.Marker({
																			position: new google.maps.LatLng(locations[i][1], locations[i][2]),
																			map: map,
																			icon: 'kont-icon.png'
																		});
																		/* menambahkan event clik untuk menampikan
     	 infowindows dengan isi sesuai denga
	    marker yang di klik */

																		google.maps.event.addListener(marker, 'click', (function(marker, i) {
																			return function() {
																				infowindow.setContent(locations[i][0]);
																				infowindow.open(map, marker);
																			}
																		})(marker, i));
																	}


																};
															})();
														</script>

													</td>
												</tr>
												<?php
												if (!empty($_SESSION['username'])) { ?>
													<tr>
														<form action="#" method="POST">
															<td><br><input type="submit" name="koskon" value="Tambahkan Kost/Kontrakan" style="background:orange; width:25%; height:40;"></td>
														</form>
													</tr>
													<tr>
													<?php
												}

													?>

													<?php
													$query = mysqli_query($con, "select tbl_koskon.kode_koskon,tbl_koskon.nama_koskon,tbl_gambar.gambar,tbl_wilayah.kelurahan,tbl_koskon.jalan,tbl_koskon.phone,tbl_koskon.lat,tbl_koskon.lng from tbl_koskon,tbl_wilayah,tbl_gambar where tbl_koskon.publish='Yes' and tbl_wilayah.kode_wilayah='$kode_wilayah' and tbl_gambar.kode_koskon=tbl_koskon.kode_koskon and tbl_gambar.profil='Yes' and tbl_koskon.kategori='Kontrakan' and tbl_koskon.kode_wilayah=tbl_wilayah.kode_wilayah");
													$b = 0;
													while ($row = mysqli_fetch_array($query)) {
														echo "<td align=center><br><table border=0 width=100% bgcolor=orange height=150>";
														echo "<tr><td width=35%  height=150  rowspan=6><img width=100% height=100% src=gambar/";
														echo $row['gambar'];
														echo "></img></td><td>";
														echo "Nama Kontrakan";
														echo "</td><td>";
														echo $row['nama_koskon'];
														echo "</td></tr>";
														echo "<tr><td>";
														echo "Kelurahan";
														echo "</td><td>";
														echo $row['kelurahan'];
														echo "</td></tr>";
														echo "<tr><td>";
														echo "Jalan ";
														echo "</td><td>";
														echo $row['jalan'];
														echo "</td></tr>";
														echo "<tr><td>";
														echo "Phone ";
														echo "</td><td>";
														echo $row['phone'];
														echo "</td></tr>";
														echo "<tr><form action=?id=";
														echo $row['kode_koskon'];
														echo " method=POST><td colspan=2><input type=submit name=detailkoskon value="; ?>"Detail" style="width:100%; background:orange;"><?php echo "</td></form></tr>";
																																															echo "</table></td>";
																																															$b++;
																																															if ($b >= 2) {
																																																echo "</tr><tr>";
																																																$b = 0;
																																															}
																																														}
																																															?>

												<?php
											}
												?>



												<?php
												//Menampilkan Login
												if (isset($_GET['mlogin'])) {
												?>
													<br>
													<br>
													<table border="0" width="50%" cellpadding="5" cellspacing="5" align="center">
														<form action="#" method="POST">
															<tr>
																<td colspan="2" height="30" align="center" bgcolor="orange">
																	<font size="5">Login</font>
																</td>
															</tr>
															<tr>
																<td width="50%" height="30">Alamat Email</td>
																<td width="50%"><input type="text" name="email" size="35"></td>
															</tr>
															<tr>
																<td height="30">Password</td>
																<td><input type="password" name="pass" size="35"></td>
															</tr>
															<tr>
																<td height="40"><input type="submit" name="login" value="Masuk" style="width:100%; background:orange; height:30px;"></td>
																<td><input type="reset" value="Batal" style="width:100%; background:orange; height:30px;"></td>
															</tr>
														</form>
													</table>
												<?php
												}
												?>


												<?php
												//Proses Login
												if (isset($_POST['login'])) {
													$email = $_POST['email'];
													$pass = $_POST['pass'];
													if ($email == "") {
														echo "Sepertinya Anda Belum Memasukkan Email..!!!";
													} else
	  if ($pass = "") {
														echo "Sepertinya Anda Belum Memasukkan Password..!!!";
													} else {
														$email = $_POST['email'];
														$pass = $_POST['pass'];
														$query = mysqli_query($con, "select * from tbl_member where email='$email' and pass='$pass'");
														$row = mysqli_fetch_array($query);
														if ($row['email'] == $email and $row['pass'] == $pass) {
															if ($row['level'] == 'Admin') {
																session_start();
																$_SESSION['username'] = $row['nama'];
																header('location:?admin');
															} else {
																session_start();
																$_SESSION['username'] = $row['nama'];
																header('location:?akun');
															}
														} else {
															echo "Email atau Password Tidak Valid..!!!";
														}
													}
												}
												?>

												<?php
												//Simpan Member
												if (isset($_POST['register'])) {
													if (empty($_POST['nama'])) {
														echo "Anda Belum Memasukkan Nama..!!!";
													} else
	if (empty($_POST['gender'])) {
														echo "Anda Belum Memilih Jenis Kelamin..!!!";
													} else
	if (empty($_POST['alamat'])) {
														echo "Harap Masukkan Alamat..!!!";
													} else
	if (empty($_POST['tgl'])) {
														echo "Harap Pilih Tanggal Lahir..!!!";
													} else
	if (empty($_POST['bln'])) {
														echo "Harap Pilih Bulan Lahir..!!!";
													} else
	if (empty($_POST['thn'])) {
														echo "Harap Pilih Tahun Lahir..!!!";
													} else
	if (empty($_POST['email'])) {
														echo "Anda Belum Memasukkan Alamat Email..!!!";
													} else
	if (empty($_POST['pass'])) {
														echo "Anda Belum Memasukkan Password..!!!";
													} else
	if (empty($_POST['rpass'])) {
														echo "Harap Ulangi Password..!!!";
													} else
	if ($_POST['pass'] <> $_POST['rpass']) {
														echo "Password Tidak Sama..!!!";
													} else {
														$nama = $_POST['nama'];
														$query = mysqli_query($con, "select * from tbl_member where nama='$nama'");
														if ($query) {
												?>
															<a href="?mregister">
																<div id="csadmin">Nama Sudah Digunakan...Klik Disini Untuk Melanjutkan Pendaftaran</div>
															</a>
												<?php
														} else {
															$nama = $_POST['nama'];
															$gender = $_POST['gender'];
															$alamat = $_POST['alamat'];
															$phone = $_POST['phone'];
															$tgl = $_POST['tgl'];
															$bln = $_POST['bln'];
															$thn = $_POST['thn'];
															$email = $_POST['email'];
															$pass = $_POST['pass'];
															$level = 'Member';
															$query = mysqli_query($con, "insert into tbl_member values ('','$nama','$gender','$alamat','$phone','$tgl','$bln','$thn','$email','$pass','$level',Now())");
															if ($query) {
																header('location:?mlogin');
															}
														}
													}
												}
												?>


												<?php
												//Menampilkan Register
												if (isset($_GET['mregister'])) {
												?>
													<form action="#" method="post">
														<table width="67%" border="1" background="isi.jpg" bordercolor="orange" align="center" cellpadding="10" cellspacing="0">
															<tr>
																<th colspan="2" scope="col" bgcolor="orange">Register Member Baru </th>
															</tr>
															<tr>
																<td width="39%">Nama Lengkap</td>
																<td width="61%"><input name="nama" type="text" size="40" maxlength="30">&nbsp;</td>
															</tr>
															<tr>
																<td>Gender </td>
																<td><input name="gender" type="radio" value="Pria">
																	Pria <input name="gender" type="radio" value="Wanita">Wanita&nbsp;</td>
															</tr>
															<tr>
																<td>Alamat</td>
																<td><input name="alamat" type="text" size="50" maxlength="50">&nbsp;</td>
															</tr>
															<tr>
																<td>No Telp. </td>
																<td><input name="phone" type="text" size="20" maxlength="20">&nbsp;</td>
															</tr>
															<tr>
																<td>Tanggal Lahir </td>
																<td><select name="tgl"><?php $t = '1';
																						while ($t <= 31) {
																							echo "<option value=$t>$t</option>";
																							$t++;
																						} ?></select>&nbsp;<select name="bln">
																		<option value="01">Januari</option>
																		<option value="02">Februari</option>
																		<option value="03">Maret</option>
																		<option value="04">April</option>
																		<option value="05">Mei</option>
																		<option value="06">Juni</option>
																		<option value="07">Juli</option>
																		<option value="08">Agustus</option>
																		<option value="09">September</option>
																		<option value="10">Oktober</option>
																		<option value="11">November</option>
																		<option value="12">Desember</option>
																	</select><select name="thn"><?php $th = '2015';
																								while ($th >= 1960) {
																									echo "<option value=$th>$th</option>";
																									$th--;
																								} ?></select></td>
															</tr>
															<tr>
																<td>Alamat Email</td>
																<td><input name="email" type="text" size="40" maxlength="50">&nbsp;</td>
															</tr>
															<tr>
																<td>Password</td>
																<td><input name="pass" type="password" size="30" maxlength="30">&nbsp;</td>
															</tr>
															<tr>
																<td>Ulangi Password </td>
																<td><input name="rpass" type="password" size="30">&nbsp;</td>
															</tr>
															<tr>
																<td colspan="2"><input name="register" type="submit" value="Simpan" style="background:orange; width:20%; height:40;"> &nbsp;
																	<input name="" type="reset" value="Batal" style="background:orange; width:20%; height:40;">
																</td>
															</tr>
														</table>
													</form>
												<?php
												}
												?>


												<?php
												//Proses SIMPAN Koskon
												if (isset($_POST['simpan'])) {
													$nama = $_POST['nama'];
													$phone = $_POST['phone'];
													$idkelurahan = $_POST['kelurahan'];
													$jalan = $_POST['jalan'];
													$kategori = $_POST['kategori'];
													$lat = $_POST['lat'];
													$lng = $_POST['lng'];
													$keterangan = $_POST['keterangan'];
													$user = $_SESSION['username'];
													$cari = mysqli_query($con, "select * from tbl_member where nama='$user'");
													if ($row = mysqli_fetch_array($cari)) {
														$kodemember = $row['kode_member'];
													}
													$publish = "No";
													//Simpan Koskon
													$query = mysqli_query($con, "insert into tbl_koskon values ('','$nama','$phone','$idkelurahan','$jalan','$kategori','$lat','$lng','$keterangan','$kodemember',Now(),'$publish')");
													if ($query) {
														$query = mysqli_query($con, "select * from tbl_koskon where nama_koskon='$nama' order by kode_koskon desc");
														$row = mysqli_fetch_array($query);
														$kode_koskon = $row['kode_koskon'];
														//Simpan Gambar
														if (empty($_FILES['gambar']['name'])) {
															$profil = 'Yes';
															$gambar = 'any.jpg';
															mysqli_query($con, "insert into tbl_gambar values ('','$kode_koskon','$gambar','$profil')");
														} else {
															$folder = "C:/wamp/www/kos/gambar/";
															$folder = $folder . basename($_FILES['gambar']['name']);
															$gambar = ($_FILES['gambar']['name']);
															move_uploaded_file($_FILES['gambar']['tmp_name'], $folder);
															$profil = 'Yes';
															mysqli_query($con, "insert into tbl_gambar values ('','$kode_koskon','$gambar','$profil')");
														}
												?>

														<form action="?id=<?php echo $row['kode_koskon']; ?>" method="POST">
															<?php
															if ($row['kategori'] == 'Kost') {
															?>
																Kost Anda Telah Berhasil di Simpan...<br>Anda dapat menambahkan Kamar untuk melengkapi <br>informasi kos yang anda iklankan, Sehingga calon penyewa <br> dapat menentukan Kamar Pilihannya. .<br> <br>
																<input type="submit" name="inputkamar" value="Tambahkan Kamar" style="width:20%; background:orange;">
															<?php
															} else
if ($row['kategori'] == 'Kontrakan') {
															?>
																Kost Anda Telah Berhasil di Simpan...<br>Harap menambahkan detail kontrakan <br> untuk melengkapi informasi iklan anda. . <br><br>
																<input type="submit" name="inputdetail" value="Tambahkan Detail Kontrakan" style="width:20%; background:orange;">
																<script type="text/javascript">
																	alert('Kontrakan Anda Berhasil di Simpan...!!!');
																</script>
															<?php
															}
															?>

														</form>
												<?php
													}
												}

												?>


												<?php
												//Input Data Kos atau Kontrakan
												if (isset($_GET['koskon'])) {
												?>
													<form action="#" enctype="multipart/form-data" method="POST">
														<table border="1" background="isi.jpg" bordercolor="orange" cellpadding="10" cellspacing="0" width="90%" align="center">
															<tr>
																<td align="center" colspan="2" height=35 bgcolor="orange">
																	<font size="5">Tambah Kos / Kontrakan</font>
																</td>
															</tr>
															<tr>
																<td height="35">
																	<font size="4">Nama Kos/Kontrakan</font>
																</td>
																<td><input type="text" name="nama" size="30"></td>
															</tr>
															<tr>
																<td height="35">
																	<font size="4">Phone</font>
																</td>
																<td><input type="text" name="phone" size="20"></td>
															</tr>
															<tr>
																<td height="35">
																	<font size="4">Wilayah</font>
																</td>
																<td>
																	<select name="kelurahan">
																		<?php
																		$query = mysqli_query($con, "select kode_wilayah,kecamatan,kelurahan from tbl_wilayah order by kecamatan asc");
																		while ($row = mysqli_fetch_array($query)) {
																			echo "<option value=";
																			echo $row['kode_wilayah'];
																			echo ">";
																			echo $row['kecamatan'];
																			echo " - ";
																			echo $row['kelurahan'];
																			echo "</option>";
																		}
																		?>
																	</select>
																</td>
															</tr>
															<tr>
																<td width="35%" height="35">
																	<font size="4">Jalan</font>
																</td>
																<td><input type="text" name="jalan" size="50"></td>
															</tr>
															<tr>
																<td height="35">
																	<font size="4">Kategori</font>
																</td>
																<td><select name="kategori">
																		<option value="Kost">Kost</option>
																		<option value="Kontrakan">Kontrakan</td>
															</tr>
															<tr>
																<td height="35" colspan="2">
																	<font color="white" size="4" align="center">Tentukan lokasi kost atau kontrakan anda dengan cara memindahkan gambar balon merah pada peta..!!</font><br>
																	<div id="map" style="width:95%"></div>
																</td>
															</tr>
															<tr>
																<td height="35">
																	<font size="4">Latitude</font>
																</td>
																<td><input type="text" name="lat" id="latitude" size="30"></td>
															</tr>
															<tr>
																<td height="35">
																	<font size="4">Longitude</font>
																</td>
																<td><input type="text" name="lng" id="longitude" size="30"></td>
															</tr>
															<tr>
																<td height="35">
																	<font size="4">Upload Gambar</font>
																</td>
																<td><input type="file" name="gambar" accept="image/*">
																	<font size="2" color="blue">Pastikan nama file gambar tidak mengandung Spasi (contoh salah : foto kos.jpg)</font>
																</td>
															</tr>
															<tr>
																<td>
																	<font size="4">Keterangan</font>
																</td>
																<td><textarea name="keterangan" cols="40" rows="5"></textarea></td>
															</tr>
															<tr>
																<td height="40" colspan="2" align="center"><input type="submit" name="simpan" value="SIMPAN" style="background:orange; width:20%; height:30px;"> <input type="reset" value="BATAL" style="width:20%; background:orange; height:30px;"></td>
															</tr>
														</table>
													</form>
												<?php
												}
												?>




												<?php
												//Input Detail Kamar
												if (isset($_POST['inputkamar'])) {
												?>
													<form action="#" method="POST">
														<table border="1" bordercolor="orange" cellpadding="10" cellspacing="0" width="70%">
															<tr>
																<td colspan="2" align="center" bgcolor="orange">
																	<font size="4">Input Informasi Kamar
																</td>
															</tr>
															<tr>
																<td width="35%">Nomor Kamar</td>
																<td><input type="text" name="nomor" size="5"></td>
															</tr>
															<tr>
																<td>Gender</td>
																<td><input type="radio" name="gender" value="Pria">Pria <input type="radio" name="gender" value="Wanita">Wanita</td>
															</tr>
															<tr>
																<td>Ukuran Kamar</td>
																<td><input type="text" name="ukuran1" size="5"> X <input type="text" name="ukuran2" size="5"></td>
															</tr>
															<tr>
																<td>Muatan Kamar</td>
																<td><input type="text" name="muatan" size="5"> Orang</td>
															</tr>
															<tr>
																<td>Harga/Orang</td>
																<td><input type="text" name="harga" size="10"> Per <select name="per">
																		<option value="Minggu">Minggu</option>
																		<option value="Bulan">Bulan</option>
																		<option value="Tahun">Tahun</option>
																	</select></td>
															</tr>
															<tr>
																<td>Fasilitas</td>
																<td><input type="text" name="fasilitas" size="50"></td>
															</tr>
															<tr>
																<td colspan="2"><input type="submit" name="simpankamar" value="Simpan" style="width:20%; background:orange;"> <input type="reset" value="Batal" style="width:20%; background:orange;"></td>
															</tr>
														</table>
													</form>
												<?php
												}
												?>

												<?php
												//Simpan Detail Kamar
												if (isset($_POST['simpankamar'])) {
													$kode_koskon = $_GET['id'];
													$nomor = $_POST['nomor'];
													$gender = $_POST['gender'];
													$ukuran1 = $_POST['ukuran1'];
													$ukuran2 = $_POST['ukuran2'];
													$muatan = $_POST['muatan'];
													$harga = $_POST['harga'];
													$per = $_POST['per'];
													$fasilitas = $_POST['fasilitas'];
													$status = 'Tersedia';
													$query = mysqli_query($con, "insert into tbl_kamar (kode_koskon,nomor_kamar,gender,ukuran1,ukuran2,muatan,harga,per,fasilitas,status) values ('$kode_koskon','$nomor','$gender','$ukuran1','$ukuran2','$muatan','$harga','$per','$fasilitas','$status')");
													if ($query) {
												?>
														<form action="?id=<?php echo $kode_koskon; ?>" method="POST">
															<input type="submit" name="inputkamar" value="Lanjutkan" style="width:20%; background:orange;">
															<input type="submit" name="detailkoskon" value="Detail Kost" style="width:20%; background:orange;">
															<script type="text/javascript">
																alert('Berhasil Menambahkan Kamar...!!!');
															</script>
														</form>
												<?php
													}
												}
												?>

												<?php
												//Input Detail Kontrakan
												if (isset($_POST['inputdetail'])) {
												?>
													<form action="#" method="POST">
														<table border="1" bordercolor="orange" cellpadding="10" cellspacing="0" width="70%">
															<tr>
																<td colspan="2" align="center" bgcolor="orange">
																	<font size="4">Halaman Input Detail Kontrakan
																</td>
															</tr>
															<tr>
																<td width="35%">Ukuran / Luas (M)</td>
																<td><input type="text" name="ukuran1" size="5"> X <input type="text" name="ukuran2" size="5"></td>
															</tr>
															<tr>
																<td>Jumlah Kamar</td>
																<td><input type="text" name="jumlah" size="5"></td>
															</tr>
															<tr>
																<td>Harga</td>
																<td><input type="text" name="harga" size="10"> Per <select name="per">
																		<option value="Minggu">Minggu</option>
																		<option value="Bulan">Bulan</option>
																		<option value="Tahun">Tahun</option>
																	</select></td>
															</tr>
															<tr>
																<td>Fasilitas</td>
																<td><input type="text" name="fasilitas" size="50"></td>
															</tr>
															<tr>
																<td colspan="2"><input type="submit" name="simpankontrakan" value="Simpan" style="width:20%; background:orange;"><input type="reset" value="Batal" style="width:20%; background:orange;"></td>
															</tr>
														</table>
													</form>
												<?php
												}
												?>



												<?php
												//Simpan Detail Kontrakan
												if (isset($_POST['simpankontrakan'])) {
													$kode_koskon = $_GET['id'];
													$ukuran1 = $_POST['ukuran1'];
													$ukuran2 = $_POST['ukuran2'];
													$jumlah = $_POST['jumlah'];
													$harga = $_POST['harga'];
													$per = $_POST['per'];
													$fasilitas = $_POST['fasilitas'];
													$status = 'Tersedia';
													$query = mysqli_query($con, "insert into tbl_kamar (kode_koskon,ukuran1,ukuran2,jumlah,harga,per,fasilitas,status) values ('$kode_koskon','$ukuran1','$ukuran2','$jumlah','$harga','$per','$fasilitas','$status')");
													if ($query) {
												?>
														<form action="?id=<?php echo $kode_koskon; ?>" method="POST">
															<input type="submit" name="detailkoskon" value="Detail Kontrakan" style="width:20%; background:orange;">
															<script type="text/javascript">
																alert('Berhasil Menyimpan Detail Kontrakan...!!!');
															</script>
														</form>
												<?php
													}
												}
												?>


												<?php
												//Edit Detail Kontrakan
												if (isset($_POST['editdetail'])) {
													$kode_koskon = $_GET['id'];
													$query = mysqli_query($con, "select * from tbl_kamar where kode_koskon='$kode_koskon'");
													$row = mysqli_fetch_array($query);
												?>
													<form action="?id=<?php echo $row['kode_kamar']; ?>" method="POST">
														<table border="1" bordercolor="orange" cellpadding="10" cellspacing="0" width="70%">
															<tr>
																<td colspan="2" align="center" bgcolor="orange">
																	<font size="4">Halaman Edit Detail Kontrakan
																</td>
															</tr>
															<tr>
																<td width="20%">Ukuran / Luas (M)</td>
																<td><input type="text" name="ukuran1" value="<?php echo $row['ukuran1']; ?>" size="10"> X <input type="text" name="ukuran2" value="<?php echo $row['ukuran2']; ?>" size="5"></td>
															</tr>
															<tr>
																<td>Jumlah Kamar</td>
																<td><input type="text" name="jumlah" value="<?php echo $row['jumlah']; ?>" size="5"></td>
															</tr>
															<tr>
																<td>Harga</td>
																<td><input type="text" name="harga" value="<?php echo $row['harga']; ?>" size="10"> Per <select name="per"><?php echo "<option value=";
																																											echo $row['per'];
																																											echo ">";
																																											echo $row['per'];
																																											echo "</option>"; ?><option value="Minggu">Minggu</option>
																		<option value="Bulan">Bulan</option>
																		<option value="Tahun">Tahun</option>
																	</select></td>
															</tr>
															<tr>
																<td>Fasilitas</td>
																<td><input type="text" name="fasilitas" value="<?php echo $row['fasilitas']; ?>" size="50"></td>
															</tr>
															<tr>
																<td colspan="2"><input type="submit" name="editkontrakan" value="Update" style="width:20%; background:orange;"><input type="reset" value="Batal" style="width:20%; background:orange;"></td>
															</tr>
														</table>
													</form>
												<?php
												}
												?>


												<?php
												//edit Detail Kontrakan
												if (isset($_POST['editkontrakan'])) {
													$kode_kamar = $_GET['id'];
													$ukuran1 = $_POST['ukuran1'];
													$ukuran2 = $_POST['ukuran2'];
													$jumlah = $_POST['jumlah'];
													$harga = $_POST['harga'];
													$per = $_POST['per'];
													$fasilitas = $_POST['fasilitas'];
													$query = mysqli_query($con, "update tbl_kamar set ukuran1='$ukuran1',ukuran2='$ukuran2',jumlah='$jumlah',harga='$harga',per='$per',fasilitas='$fasilitas' where kode_kamar='$kode_kamar'");
													if ($query) {
												?>
														<form action="?id=<?php echo $kode_koskon; ?>" method="POST">
															<input type="submit" name="detailkoskon" value="Detail Kontrakan" style="width:20%; background:orange;">
															<script type="text/javascript">
																alert('Berhasil Update Detail Kontrakan...!!!');
															</script>
														</form>
												<?php
													}
												}
												?>

												<?php
												if (isset($_POST['hapus'])) {
													echo "Apakah anda yakin untuk menghapus?<br>";
													$id = $_GET['id'];
												?>
													<form action="#?id=<?php echo $id; ?>" method="POST">
														<input type="submit" name="hapusya" value="Ya" style="width:10%;">
														<input type="submit" name="detailkoskon" value="Tidak" style="width:10%;">
													</form>
												<?php
												}
												?>

												<?php
												//Hapus Koskon
												if (isset($_POST['hapusya'])) {
													$id = $_GET['id'];
													$qkoskon = mysqli_query($con, "delete from tbl_koskon where kode_koskon='$id'");
													$qkamar = mysqli_query($con, "delete from tbl_kamar where kode_koskon='$id'");
													$qbooking = mysqli_query($con, "delete from tbl_booking where kode_koskon='$id'");
													$qgambar = mysqli_query($con, "delete from tbl_gambar where kode_koskon='$id'");
													if ($qkoskon and $qbooking and $qkamar and $qgambar) {
														echo "<form action=# method=GET>";
														$user = $_SESSION['username'];
														$query = mysqli_query($con, "select * from tbl_member where nama='$user'");
														$row = mysqli_fetch_array($query);
														if ($row['level'] == "Admin") {
															header('location:?akoskon');
														} else {
															header('location:?akun');
														}
														echo "</form>";
													}
												}
												?>


												<?php
												//Menampilkan Edit Data Kos atau Kontrakan
												if (isset($_POST['edit'])) {
													$id = $_GET['id'];
													$query = mysqli_query($con, "select * from tbl_koskon where kode_koskon='$id'");
													while ($row = mysqli_fetch_array($query)) {
														echo "<form action=?id=";
														echo $row['kode_koskon'];
														echo " enctype=multipart/form-data method=POST>";
												?>
														<table border="1" bordercolor="yellow" background="isi.jpg" cellpadding="10" cellspacing="0" width="90%" align="center">
															<tr>
																<td height="35" colspan="2" align="center" bgcolor="orange">
																	<font size="4">Edit Data Kost / Data Kontrakan</font>
																</td>
															</tr>
															<tr>
																<td height="35">
																	<font size="4">Nama Kost/Kontrakan</font>
																</td>
																<td><input type="text" name="nama_koskon" value="<?php echo $row['nama_koskon']; ?>" size="30"></td>
															</tr>
															<tr>
																<td height="35">
																	<font size="4">Phone</font>
																</td>
																<td><input type="text" name="phone" value="<?php echo $row['phone'];
																										} ?>" size="20"></td>
															</tr>
															<tr>
																<td height="35">
																	<font size="4">Wilayah</font>
																</td>
																<td>
																	<select name="wilayah">
																		<?php
																		$query = mysqli_query($con, "select kode_wilayah,kecamatan,kelurahan from tbl_wilayah order by kecamatan asc");
																		while ($row = mysqli_fetch_array($query)) {
																			echo "<option value=";
																			echo $row['kode_wilayah'];
																			echo ">";
																			echo $row['kecamatan'];
																			echo " - ";
																			echo $row['kelurahan'];
																			echo "</option>";
																		}

																		$id = $_GET['id'];
																		$query = mysqli_query($con, "select * from tbl_koskon where kode_koskon='$id'");
																		$row = mysqli_fetch_array($query);
																		?>
																	</select>
																</td>
															</tr>
															<tr>
																<td width="35%" height="35">
																	<font size="4">Jalan</font>
																</td>
																<td><input type="text" name="jalan" value="<?php echo $row['jalan']; ?>" size="50"></td>
															</tr>
															<tr>
																<td height="35" colspan="2">
																	<font color="red" size="4">Tentukan lokasi kost atau kontrakan anda dengan cara memindahkan gambar balon merah pada peta..!!</font><br>
																	<div id="map"></div>

																	<script type="text/javascript">
																		//* Fungsi untuk mendapatkan nilai latitude longitude
																		function updateMarkerPosition(latLng) {
																			document.getElementById('latitude').value = [latLng.lat()]
																			document.getElementById('longitude').value = [latLng.lng()]
																		}

																		var map = new google.maps.Map(document.getElementById('map'), {
																			zoom: 14,
																			center: new google.maps.LatLng(-0.3038764, 100.3729242),
																			mapTypeId: google.maps.MapTypeId.ROADMAP
																		});
																		//posisi awal marker   

																		var latLng = new google.maps.LatLng(<?php echo $row['lat'];
																											echo ",";
																											echo $row['lng']; ?>);

																		/* buat marker yang bisa di drag lalu 
																		  panggil fungsi updateMarkerPosition(latLng)
																		 dan letakan posisi terakhir di id=latitude dan id=longitude
																		 */
																		var marker = new google.maps.Marker({
																			position: latLng,
																			title: 'lokasi',
																			map: map,
																			draggable: true
																		});

																		updateMarkerPosition(latLng);
																		google.maps.event.addListener(marker, 'drag', function() {
																			// ketika marker di drag, otomatis nilai latitude dan longitude
																			//menyesuaikan dengan posisi marker 
																			updateMarkerPosition(marker.getPosition());
																		});
																	</script>

																</td>
															</tr>
															<tr>
																<td height="35">
																	<font size="4">Latitude</font>
																</td>
																<td><input type="text" name="lat" id="latitude" value="<?php echo $row['lat']; ?>" size="30"></td>
															</tr>
															<tr>
																<td height="35">
																	<font size="4">Longitude</font>
																</td>
																<td><input type="text" name="lng" id="longitude" value="<?php echo $row['lng']; ?>" size="30"></td>
															</tr>
															<tr>
																<td height="35">
																	<font size="4">Upload Gambar</font>
																</td>
																<td><input type="file" name="gambar" accept="image/*">
																	<font size="2" color="blue">Pastikan nama file gambar tidak mengandung Spasi (contoh salah : foto kos.jpg)</font>
																</td>
															</tr>
															<tr>
																<td>
																	<font size="4">Keterangan</font>
																</td>
																<td><textarea name="keterangan" cols="40" rows="5"><?php echo $row['keterangan']; ?></textarea></td>
															</tr>
															<tr>
																<td height="40" colspan="2" align="center"><input type="submit" name="update" value="Update" style="background:orange; width:20%; height:30px;"> <input type="reset" value="BATAL" style="background:orange; width:20%; height:30px;"></td>
															</tr>
														</table>
														</form>
													<?php
												}

													?>


													<?php
													//Proses Update Koskon
													if (isset($_POST['update'])) {
														$id = $_GET['id'];
														$user = $_SESSION['username'];
														$query = mysqli_query($con, "select * from tbl_member where nama='$user'");
														$row = mysqli_fetch_array($query);
														$kode_member = $row['kode_member'];
														$nama = $_POST['nama_koskon'];
														$phone = $_POST['phone'];
														$kode_wilayah = $_POST['wilayah'];
														$jalan = $_POST['jalan'];
														$keterangan = $_POST['keterangan'];
														$lat = $_POST['lat'];
														$lng = $_POST['lng'];
														$publish = "Yes";
														$query = mysqli_query($con, "update tbl_koskon set nama_koskon='$nama',phone='$phone',kode_wilayah='$kode_wilayah',jalan='$jalan',keterangan='$keterangan',lat='$lat',publish='$publish',kode_member='$kode_member',lng='$lng' where kode_koskon='$id'");
														if ($query) {
															//Simpan Gambar
															if (empty($_FILES['gambar']['name'])) {
													?>
																<script type="text/javascript">
																	alert('Berhasil Di Perbaharui...!!!');
																</script>
															<?php
															} else {
																$folder = "gambar/";
																$folder = $folder . basename($_FILES['gambar']['name']);
																$gambar = ($_FILES['gambar']['name']);
																move_uploaded_file($_FILES['gambar']['tmp_name'], $folder);
																$profil = 'Yes';
																mysqli_query($con, "update tbl_gambar set gambar='$gambar' where kode_koskon='$id' and profil='$profil'");
															?>
																<script type="text/javascript">
																	alert('Berhasil Di Perbaharui...!!!');
																</script>
													<?php
															}
														}
													}
													?>


													<?php
													if (isset($_GET['admin'])) {
													?>

														<form action="#" method="POST">
															<table border="0" width="100%" align="center" height="280">
																<tr>
																	<td align="center"><br><br>
																		<div id="cs" style="background:darkred; color:white; width:50%">Menu Administrator</div>
																		<a href="?iwilayah">
																			<div id="csadmin">Input Wilayah</div>
																		</a>
																		<a href="?amember">
																			<div id="csadmin">Atur Member</div>
																		</a>
																		<a href="?akoskon">
																			<div id="csadmin">Atur Kost/Kontrakan</div>
																		</a>
																		<a href="?abooking">
																			<div id="csadmin">Atur Booking</div>
																		</a>
																		<a href="?abt">
																			<div id="csadmin">Atur Buku Tamu</div>
																		</a>
																		<a href="?tadmin">
																			<div id="csadmin">Tambah Admin</div>
																		</a>
																	</td>
																</tr>
															</table>
														</form>
													<?php
													}
													?>

													<?php
													//Menampilkan Edit Member
													if (isset($_POST['editmember'])) {
														$id = $_GET['id'];
														$query = mysqli_query($con, "select * from tbl_member where id='$id'");
														while ($row = mysqli_fetch_array($query)) {
													?>
															<table border="0" width="600" align="center" cellpadding="10" cellspacing="0">
																<form action="?id=<?php echo $row['id']; ?>" method="POST">
																	<tr>
																		<td colspan="2" height="30" align="center">
																			<font size="5">Edit Data Member</font>
																			<hr>
																		</td>
																	</tr>
																	<tr>
																		<td width="50%">Nama Lengkap</td>
																		<td width="50%"><input type="text" value="<?php echo $row['nama']; ?>" name="nama" size="35"></td>
																	</tr>

																	<tr>
																		<td height="30">Jenis Kelamin</td>
																		<td><input type="radio" name="jk" value="Laki-Laki" <?php if ($row['jk'] == "Laki-Laki") {
																																echo "checked=checked";
																															} ?>>Laki-Laki<input type="radio" name="jk" value="Perempuan" <?php if ($row['jk'] == "Perempuan") {
																																																echo "checked=checked";
																																															} ?>>Perempuan</td>
																	</tr>

																	<tr>
																		<td height="30">Tanggal Lahir</td>
																		<td><select name="tgl"><?php echo "<option value=";
																								echo $row['tgl'];
																								echo ">";
																								echo $row['tgl'];
																								echo "</option>";
																								$t = 1;
																								while ($t <= 31) {
																									echo "<option value=$t>$t</option>";
																									$t++;
																								} ?></select><select name="bln"><?php echo "<option value=";
																																echo $row['bln'];
																																echo ">";
																																echo $row['bln'];
																																echo "</option>"; ?><option value="Januari">Januari</option>
																				<option value="Februari">Februari</option>
																				<option value="Maret">Maret</option>
																				<option value="April">April</option>
																				<option value="Mei">Mei</option>
																				<option value="Juni">Juni</option>
																				<option value="Juli">Juli</option>
																				<option value="Agustus">Agustus</option>
																				<option value="September">September</option>
																				<option value="Oktober">Oktober</option>
																				<option value="November">November</option>
																				<option value="Desember">Desember</option>
																			</select><select name="thn"><?php echo "<option value=";
																										echo $row['thn'];
																										echo ">";
																										echo $row['thn'];
																										echo "</option>";
																										$th = 1950;
																										while ($th <= 2015) {
																											echo "<option value=$th>$th</option>";
																											$th++;
																										} ?></select></td>
																	</tr>

																	<tr>
																		<td height="30">Alamat</td>
																		<td><input type="text" name="alamat" value="<?php echo $row['alamat']; ?>" size="50"></td>
																	</tr>

																	<tr>
																		<td height="30">Email</td>
																		<td><input type="text" name="email" value="<?php echo $row['email']; ?>" size="40"></td>
																	</tr>

																	<tr>
																		<td height="30">Password</td>
																		<td><input type="password" name="pass1" value="<?php echo $row['pass']; ?>" size="30"></td>
																	</tr>

																	<tr>
																		<td height="30">Ulangi Password</td>
																		<td><input type="password" name="pass2" size="30"></td>
																	</tr>
																	<tr>
																		<td height="40"><input type="submit" name="updatemember" value="Update" style="background:orange; width:100%; height:30px;"></td>
																		<td><input type="reset" value="Batal" style="background:orange; width:100%; height:30px;"></td>
																	</tr>
																</form>
															</table>
													<?php
														}
													}
													?>


													<?php
													//Proses Update Member
													if (isset($_POST['updatemember'])) {
														$id = $_GET['id'];
														$nama = $_POST['nama'];
														$jk = $_POST['jk'];
														$tgl = $_POST['tgl'];
														$bln = $_POST['bln'];
														$thn = $_POST['thn'];
														$alamat = $_POST['alamat'];
														$email = $_POST['email'];
														$pass1 = $_POST['pass1'];
														$query = mysqli_query($con, "update tbl_member set nama='$nama',jk='$jk',tgl='$tgl',bln='$bln',thn='$thn',alamat='$alamat',email='$email',pass='$pass1' where id='$id'");
														if ($query) {
															$level = 'member';
															mysqli_query($con, "insert into tbl_login values ('$nama','$email','$pass1','$level')");
															$_SESSION['username'] = $_POST['nama'];
															echo "Data Anda Berhasil di Update..!!!<br><form action=# method=GET><input type=submit name=beranda value=Lanjutkan "; ?> style="background:orange;" <?php echo "></form>";
																																																				} else {
																																																					echo "Gagal Update";
																																																				}
																																																			}
																																																					?>


													<?php
													//Hapus Member
													if (isset($_POST['hapusmember'])) {
														$id = $_GET['id'];
														$query = mysqli_query($con, "delete from tbl_member where kode_member='$id'");
														if ($query) {
															header('location:?amember');
														}
													}
													?>


													<?php
													//Input Wilayah
													if (isset($_GET['iwilayah']) or isset($_POST['iwilayah'])) {
													?>

														<form action="#" method="POST">
															<table border="0" width="100%" align="center">
																<tr>
																	<td align="center">
																		<a href="?iwilayah">
																			<div id="csadmin1">Input Wilayah</div>
																		</a>
																		<a href="?amember">
																			<div id="csadmin1">Atur Member</div>
																		</a>
																		<a href="?akoskon">
																			<div id="csadmin1">Atur Kost/Kontrakan</div>
																		</a>
																		<a href="?abooking">
																			<div id="csadmin1">Atur Booking</div>
																		</a>
																		<a href="?abt">
																			<div id="csadmin1">Atur Buku Tamu</div>
																		</a>
																		<a href="?tadmin">
																			<div id="csadmin1">Tambah Admin</div>
																		</a>
																	</td>
																</tr>
															</table>
														</form>


														<form action="#" method="POST">
															<table border="0" background="isi.jpg" bordercolor="yellow" cellpadding="10" cellspacing="0" align="center" width="70%">
																<tr>
																	<td colspan="2" align="center" bgcolor="orange">
																		<font color="black">Input Data Wilayah</font>
																	</td>
																</tr>
																<tr>
																	<td width="150">Kecamatan</td>
																	<td><input type="text" name="kecamatan" size="50"></td>
																</tr>
																<tr>
																	<td>Kelurahan</td>
																	<td><input type="text" name="kelurahan" size="50"></td>
																</tr>
																<tr>
																	<td colspan="2"><input type="submit" name="swilayah" value="Simpan" style="background:orange; width:20%;"> <input type="reset" value="Batal" style="background:orange; width:20%;"></td>
																</tr>
															</table>
														</form>

														<table border="1" bordercolor="yellow" cellpadding="10" cellspacing="0" width="70%">
															<tr>
																<td align="center" colspan="4" bgcolor="orange">
																	<font color="black">Daftar Wilayah</font>
																</td>
															</tr>
															<tr>
																<td align="center">No</td>
																<td align="center">Kecamatan</td>
																<td align="center">Kelurahan</td>
																<td align="center">Aksi</td>
															</tr>
															<?php
															//Menampilkan Wilayah
															$query = mysqli_query($con, "select * from tbl_wilayah order by kecamatan asc");
															$no = 1;
															while ($row = mysqli_fetch_array($query)) {
																echo "<tr><td>";
																echo $no;
																echo "</td><td>";
																echo $row['kecamatan'];
																echo "</td><td>";
																echo $row['kelurahan'];
																echo "</td><form action=?id=";
																echo $row['kode_wilayah'];
																echo " method=POST><td><input type=submit name=hapuswilayah value=Hapus style="; ?> "width:80%; heihgt:20; font-size:10; background:orange; color=red;" <?php echo "></td></form></tr>";
																																																						$no++;
																																																					}
																																																						?>
														</table>
													<?php
													}
													?>

													<?php
													//Hapus Wilayah
													if (isset($_POST['hapuswilayah'])) {
														$id = $_GET['id'];
														$query = mysqli_query($con, "delete from tbl_wilayah where kode_wilayah='$id'");
														if ($query) {
															header('location:?iwilayah');
														}
													}
													?>

													<?php
													//Simpan Wilayah
													if (isset($_POST['swilayah'])) {
														$kecamatan = $_POST['kecamatan'];
														$kelurahan = $_POST['kelurahan'];
														$query = mysqli_query($con, "insert into tbl_wilayah values ('','$kecamatan','$kelurahan')");
														if ($query) {
															header('location:?iwilayah');
														}
													}
													?>

													<?php
													//Tambah Admin
													if (isset($_GET['tadmin'])) {
													?>

														<table border="0" width="100%" align="center">
															<tr>
																<td align="center">
																	<a href="?iwilayah">
																		<div id="csadmin1">Input Wilayah</div>
																	</a>
																	<a href="?amember">
																		<div id="csadmin1">Atur Member</div>
																	</a>
																	<a href="?akoskon">
																		<div id="csadmin1">Atur Kost/Kontrakan</div>
																	</a>
																	<a href="?abooking">
																		<div id="csadmin1">Atur Booking</div>
																	</a>
																	<a href="?abt">
																		<div id="csadmin1">Atur Buku Tamu</div>
																	</a>
																	<a href="?tadmin">
																		<div id="csadmin1">Tambah Admin</div>
																	</a>
																</td>
															</tr>
														</table>


														<form action="#" method="POST">
															<table border="0" background="isi.jpg" bordercolor="yellow" cellpadding="10" cellspacing="0" align="center" width="50%">
																<tr>
																	<td colspan="2" align="center" bgcolor="orange">Tambah Admin</td>
																</tr>
																<tr>
																	<td width="40%">Nama Lengkap</td>
																	<td><input type="text" name="nama" size="40"></td>
																</tr>
																<tr>
																	<td>Email</td>
																	<td><input type="text" name="email" size="40"></td>
																</tr>
																<tr>
																	<td>Password</td>
																	<td><input type="password" name="pass1" size="40"></td>
																</tr>
																<tr>
																	<td>Ulangi Password</td>
																	<td><input type="password" name="pass2" size="40"></td>
																</tr>
																<tr>
																	<td colspan="2" align="center"><input type="submit" name="sadmin" value="Simpan" style="background:orange; width:49%; height:30;"> <input type="reset" value="Batal" style="background:orange; width:49%; height:30;"></td>
																</tr>
															</table>
														</form>
													<?php
													}
													?>

													<?php
													//Proses Simpan Admin
													if (isset($_POST['sadmin'])) {
														if ($_POST['pass1'] <> $_POST['pass2']) {
															echo "Password Tidak Sama..!!!";
														} else {
															$nama = $_POST['nama'];
															$email = $_POST['email'];
															$pass = $_POST['pass1'];
															$level = "Admin";
															$query = mysqli_query($con, "insert into tbl_member (nama,email,pass,level,waktu_daftar) values ('$nama','$email','$pass','$level',Now())");
															if ($query) {
																echo "<form action=# method=GET><input type=submit name=tadmin value=Lanjutkan "; ?> style="background:orange; height:40;" <?php echo "></form>";
																																															?>
																<script type="text/javascript">
																	alert('Berhasil Menambahkan Admin!!!');
																</script>
															<?php
															} else {
															?>
																<script type="text/javascript">
																	alert('Gagal Menambahkan Admin!!!');
																</script>
													<?php
															}
														}
													}
													?>

													<?php
													//Atur Member
													if (isset($_GET['amember'])) {
													?>

														<table border="0" width="100%" align="center">
															<tr>
																<td align="center">
																	<a href="?iwilayah">
																		<div id="csadmin1">Input Wilayah</div>
																	</a>
																	<a href="?amember">
																		<div id="csadmin1">Atur Member</div>
																	</a>
																	<a href="?akoskon">
																		<div id="csadmin1">Atur Kost/Kontrakan</div>
																	</a>
																	<a href="?abooking">
																		<div id="csadmin1">Atur Booking</div>
																	</a>
																	<a href="?abt">
																		<div id="csadmin1">Atur Buku Tamu</div>
																	</a>
																	<a href="?tadmin">
																		<div id="csadmin1">Tambah Admin</div>
																	</a>
																</td>
															</tr>

														</table>


														<table border="1" bordercolor="yellow" cellpadding="5" cellspacing="0">
															<tr>
																<td colspan="10" align="center" bgcolor="orange">
																	<font size="4">Atur Member</font>
																</td>
															</tr>
															<tr>
																<td align="center">
																	<font color="white">No</font>
																</td>
																<td align="center">
																	<font color="white">Nama Member</font>
																</td>
																<td align="center">
																	<font color="white">Jenis Kelamin</font>
																</td>
																<td align="center">
																	<font color="white">Alamat</font>
																</td>
																<td align="center">
																	<font color="white">Phone</font>
																</td>
																<td align="center">
																	<font color="white">Tgl Lahir</font>
																</td>
																<td align="center">
																	<font color="white">Email</font>
																</td>
																<td align="center">
																	<font color="white">Level</font>
																</td>
																<td align="center">
																	<font color="white">Waktu Daftar</font>
																</td>
																<td align="center">
																	<font color="white">Aksi</font>
																</td>
															</tr>
															<?php
															$no = 1;
															$query = mysqli_query($con, "select * from tbl_member order by waktu_daftar desc");
															while ($row = mysqli_fetch_array($query)) {
																echo "<tr><td align=center>";
																echo $no;
																echo "</td><td align=center>";
																echo $row['nama'];
																echo "</td><td align=center>";
																echo $row['gender'];
																echo "</td><td align=center>";
																echo $row['alamat'];
																echo "</td><td align=center>";
																echo $row['phone'];
																echo "</td><td align=center>";
																echo $row['tgl'];
																echo "-";
																echo $row['bln'];
																echo "-";
																echo $row['thn'];
																echo "</td><td align=center>";
																echo $row['email'];
																echo "</td><td align=center>";
																echo $row['level'];
																echo "</td><td align=center>";
																echo $row['waktu_daftar'];
																echo "</td><form action=?id=";
																echo $row['kode_member'];
																echo " method=POST><td align=center><input type=submit name=hapusmember value=Hapus style="; ?> " heihgt:20; font-size:10; background:orange; color=red;" <?php echo "></td></form></tr>";
																																																							$no++;
																																																						}
																																																							?>
														</table>

													<?php
													}
													?>




													<?php
													//Atur Kos dan Kontrakan
													if (isset($_GET['akoskon'])) {
													?>

														<table border="0" width="100%" align="center">
															<tr>
																<td align="center">
																	<a href="?iwilayah">
																		<div id="csadmin1">Input Wilayah</div>
																	</a>
																	<a href="?amember">
																		<div id="csadmin1">Atur Member</div>
																	</a>
																	<a href="?akoskon">
																		<div id="csadmin1">Atur Kost/Kontrakan</div>
																	</a>
																	<a href="?abooking">
																		<div id="csadmin1">Atur Booking</div>
																	</a>
																	<a href="?abt">
																		<div id="csadmin1">Atur Buku Tamu</div>
																	</a>
																	<a href="?tadmin">
																		<div id="csadmin1">Tambah Admin</div>
																	</a>
																</td>
															</tr>
														</table>


														<table border="1" bordercolor="yellow" width="100%" cellpadding="5" cellspacing="0">
															<tr>
																<td colspan="10" bgcolor="orange" align="center">Daftar Kos dan Kontrakan</td>
															</tr>
															<tr>
																<td align="center">No</td>
																<td align="center">Nama Kos/Kontrakan</td>
																<td align="center">Phone</td>
																<td align="center">Kelurahan</td>
																<td align="center">Alamat/Jl</td>
																<td align="center">Kategori</td>
																<td align="center">Publish</td>
																<td align="center">Aksi</td>
															</tr>
															<?php
															$query = mysqli_query($con, "select tbl_koskon.kode_koskon,tbl_koskon.nama_koskon,tbl_koskon.phone,tbl_wilayah.kelurahan,tbl_koskon.jalan,tbl_koskon.kategori,tbl_koskon.publish from tbl_koskon,tbl_wilayah where tbl_wilayah.kode_wilayah=tbl_koskon.kode_wilayah order by waktu asc");
															$no = 1;
															while ($row = mysqli_fetch_array($query)) {
																echo "<tr><td align=center><font size=2>";
																echo $no;
																echo "</font></td><td><font size=2>";
																echo $row['nama_koskon'];
																echo "</font></td><td align=center><font size=2>";
																echo $row['phone'];
																echo "</font></td><td><font size=2>";
																echo $row['kelurahan'];
																echo "</font></td><td><font size=2>";
																echo $row['jalan'];
																echo "</font></td><td align=center><font size=2>";
																echo $row['kategori'];
																echo "</font></td><td align=center><font size=2>";
																echo $row['publish'];
																echo "</font></td><form action=?id=";
																echo $row['kode_koskon'];
																echo " method=POST><td align=center width=25%><input type=submit name=detailkoskon value=Detail style="; ?> "width:25%; heihgt:20; font-size:12; background:orange; color=red;" <?php echo "> <input type=submit name=";
																																																												if ($row['publish'] == 'No') {
																																																													echo "publish";
																																																												} else {
																																																													echo "unpublish";
																																																												}
																																																												echo " value=";
																																																												if ($row['publish'] == 'No') {
																																																													echo "Publish";
																																																												} else {
																																																													echo "Unpublish";
																																																												}
																																																												echo " style="; ?> "width:35%; heihgt:20; font-size:12; background:orange; color=red;" <?php echo "> <input type=submit name=hapus value=Hapus style="; ?> "width:25%; heihgt:20; font-size:12; background:orange; color=red;" <?php echo "></td></form></tr>";
																																																																																																																																																																																																																																						$no++;
																																																																																																																																																																																																																																					}
																																																																																																																																																																																																																																						?>
														</table>
													<?php
													}
													?>


													<?php
													//Proses Publikasi
													if (isset($_POST['publish'])) {
														$id = $_GET['id'];
														$publish = "Yes";
														$query = mysqli_query($con, "update tbl_koskon set publish='$publish' where kode_koskon='$id'");
														if ($query) {
															echo "<form action=# method=GET><input type=submit name=akoskon value=Lanjutkan "; ?> style="background:orange;" <?php echo "></form>";
																																												?>
															<script type="text/javascript">
																alert('Berhasil Di Publikasikan...!!!');
															</script>
													<?php
														}
													}
													?>

													<?php
													//Proses Membatalkan Publikasi
													if (isset($_POST['unpublish'])) {
														$id = $_GET['id'];
														$publish = "No";
														$query = mysqli_query($con, "update tbl_koskon set publish='$publish' where kode_koskon='$id'");
														if ($query) {
															echo "<form action=# method=GET><input type=submit name=akoskon value=Lanjutkan "; ?> style="background:orange;" <?php echo "></form>";
																																												?>
															<script type="text/javascript">
																alert('Tidak Di Publikasikan...!!!');
															</script>
													<?php
														}
													}
													?>

													<?php
													if (isset($_POST['batal'])) {
														$id = $_GET['id'];
													?>
														Apakah ingin membatalkan Booking?<br>
														<form action="#?id=<?php echo $id; ?>" method="POST">
															<input type="submit" name="batalya" value="Ya" style="width:10%">
															<input type="submit" name="akun" value="Tidak" style="width:10%">
														</form>
													<?php
													}
													?>

													<?php
													if (isset($_POST['batalya'])) {
														$kode_booking = $_GET['id'];
														$query = mysqli_query($con, "select * from tbl_booking where kode_booking='$kode_booking'");
														$row = mysqli_fetch_array($query);
														$kode_kamar = $row['kode_kamar'];
														$query = mysqli_query($con, "update tbl_kamar set status='Tersedia' where kode_kamar='$kode_kamar'  ");
														if ($query) {
															$query = mysqli_query($con, "delete from tbl_booking where kode_booking='$kode_booking'");
															if ($query) {
													?>
																<form action="#" method="POST">
																	<input type="submit" name="beranda" value="Beranda" style="background:orange; width:20%; height:40;">
																	<script type="text/javascript">
																		alert('Berhasil Membatalkan Booking...!!!');
																	</script>
																</form>
													<?php
															}
														}
													}

													?>
													<?php
													//Buku Tamu
													if (isset($_GET['bt'])) {
													?>

														<table border="0" background="isi.jpg" bordercolor="yellow" cellpadding="10" cellspacing="0" width="90%" align="center">
															<form action="#" method="POST">
																<tr>
																	<td colspan="2" align="center">
																		<font size="4">Buku Tamu</font>
																	</td>
																</tr>
																<tr>
																	<td width="20%">Nama</td>
																	<td><input type="text" name="nama" size="30"></td>
																</tr>
																<tr>
																	<td>Alamat</td>
																	<td><input type="text" name="alamat" size="50"></td>
																</tr>
																<tr>
																	<td>Link Website</td>
																	<td><input type="text" name="web" size="60"></td>
																</tr>
																<tr>
																	<td>Subject</td>
																	<td><input type="text" name="subject" size="40"></td>
																</tr>
																<tr>
																	<td>Isi</td>
																	<td><textarea name="isi" cols="50" rows="4"></textarea></td>
																</tr>
																<tr>
																	<td colspan="2"><input type="submit" name="sbt" value="Kirim" style="width:20%; background:orange; height:40;"> <input type="reset" value="Batal" style="width:20%; background:orange; height:40;"></td>
																</tr>
															</form>
														</table>
														<hr>

														<table border="1" bordercolor="yellow" background="isi.jpg" cellpadding="10" cellspacing="0" width="90%">
															<tr>
																<td bgcolor="orange">
																	<font size="4">Daftar Buku Tamu</font>
																</td>
															</tr>
															<?php
															//Menampilkan isi buku tamu
															$query = mysqli_query($con, "select * from tbl_bt order by waktu desc");
															$no = 1;
															while ($row = mysqli_fetch_array($query)) {
															?>
																<tr>
																	<td>
																		<table border="0" cellpadding="10" cellspacing="0" width="90%">
																			<tr>
																				<td width="25%">Nama</td>
																				<td><?php echo $row['nama'];
																					echo " <font size=1 color=black>";
																					echo $row['waktu'];
																					echo "</font> "; ?></td>
																			</tr>
																			<tr>
																				<td>Subject</td>
																				<td><?php echo $row['subject']; ?></td>
																			</tr>
																			<tr>
																				<td>Isi</td>
																				<td><?php echo $row['isi']; ?></td>
																			</tr>
																			<tr>
																				<td>Website</td>
																				<td><a href="http://<?php echo $row['web']; ?>"><?php echo $row['web']; ?></a></td>
																			</tr>
																			<tr>
																				<td>Alamat</td>
																				<td><?php echo $row['alamat']; ?></td>
																			</tr>
																			</form>
																		</table>
																	</td>
																</tr>
														<?php
																$no++;
															}
															echo "</table>";
														}
														?>

														<?php
														//Simpan Buku Tamu
														if (isset($_POST['sbt'])) {
															$nama = $_POST['nama'];
															$alamat = $_POST['alamat'];
															$web = $_POST['web'];
															$subject = $_POST['subject'];
															$isi = $_POST['isi'];
															$query = mysqli_query($con, "insert into tbl_bt values ('','$nama','$alamat','$web','$subject','$isi',Now())");
															if ($query) {
																echo "<form action=# method=POST><input type=submit name=bt value=BukuTamu "; ?> style="background:orange;" <?php echo "></form>";
																																											?>
																<script type="text/javascript">
																	alert('Berhasil Mengisi Buku Tamu...!!!');
																</script>
														<?php
																header('location:?bt');
															}
														}
														?>

														<?php
														//Atur Buku Tamu
														if (isset($_GET['abt'])) {
														?>

															<table border="0" width="100%" align="center">
																<tr>
																	<td align="center">
																		<a href="?iwilayah">
																			<div id="csadmin1">Input Wilayah</div>
																		</a>
																		<a href="?amember">
																			<div id="csadmin1">Atur Member</div>
																		</a>
																		<a href="?akoskon">
																			<div id="csadmin1">Atur Kost/Kontrakan</div>
																		</a>
																		<a href="?abooking">
																			<div id="csadmin1">Atur Booking</div>
																		</a>
																		<a href="?abt">
																			<div id="csadmin1">Atur Buku Tamu</div>
																		</a>
																		<a href="?tadmin">
																			<div id="csadmin1">Tambah Admin</div>
																		</a>
																	</td>
																</tr>
															</table>



															<table border="1" bordercolor="yellow" cellpadding="5" cellspacing="0" width="100%">
																<tr>
																	<td colspan="6" align="center" bgcolor="orange">Daftar isi Buku Tamu</td>
																</tr>
																<tr>
																	<td align="center">No</td>
																	<td align="center">Nama</td>
																	<td align="center">Subject</td>
																	<td align="center">Isi</td>
																	<td align="center">Waktu</td>
																	<td align="center">Aksi</td>
																</tr>
																<?php
																//Atur Buku Tamu
																$query = mysqli_query($con, "select * from tbl_bt order by waktu desc");
																$no = 1;
																while ($row = mysqli_fetch_array($query)) {
																	echo "<tr><td align=center>";
																	echo $no;
																	echo "</td><td align=center>";
																	echo $row['nama'];
																	echo "</td><td align=center>";
																	echo $row['subject'];
																	echo "</td><td align=center>";
																	echo $row['isi'];
																	echo "</td><td align=center>";
																	echo $row['waktu'];
																	echo "</td><form action=?id=";
																	echo $row['kode_bt'];
																	echo " method=POST><td align=center><input type=submit name=hapusbt value=Hapus "; ?> style="background:orange;" <?php echo "></td></form></tr>";
																																														$no++;
																																													}
																																														?>
															</table>
														<?php
														}
														?>

														<?php
														//Proses Hapus Buku Tamu
														if (isset($_POST['hapusbt'])) {
															$id = $_GET['id'];
															$query = mysqli_query($con, "delete from tbl_bt where kode_bt='$id'");
															if ($query) {
																header('location:?abt');
															}
														}
														?>


														<?php
														if (isset($_GET['abooking'])) {
														?>
															<table border="0" width="100%" align="center">
																<tr>
																	<td align="center">
																		<a href="?iwilayah">
																			<div id="csadmin1">Input Wilayah</div>
																		</a>
																		<a href="?amember">
																			<div id="csadmin1">Atur Member</div>
																		</a>
																		<a href="?akoskon">
																			<div id="csadmin1">Atur Kost/Kontrakan</div>
																		</a>
																		<a href="?abooking">
																			<div id="csadmin1">Atur Booking</div>
																		</a>
																		<a href="?abt">
																			<div id="csadmin1">Atur Buku Tamu</div>
																		</a>
																		<a href="?tadmin">
																			<div id="csadmin1">Tambah Admin</div>
																		</a>
																	</td>
																</tr>
															</table>

															<?php
															$query = mysqli_query($con, "select tbl_booking.kode_booking,tbl_booking.kode_member,tbl_member.nama,tbl_booking.kode_koskon,tbl_koskon.nama_koskon,tbl_booking.kode_kamar,tbl_booking.tgl,tbl_booking.status from tbl_booking,tbl_member,tbl_koskon where tbl_member.kode_member=tbl_booking.kode_member and tbl_koskon.kode_koskon=tbl_booking.kode_koskon order by tbl_booking.kode_booking desc");
															?>
															<table border="1" bordercolor="yellow" width="100%" cellpadding="5" cellspacing="0">
																<tr>
																	<td colspan="9" align="center" bgcolor="orange">Daftar Booking Kost</td>
																</tr>
																<tr>
																	<td width="12%" align="center">Kode Booking</td>
																	<td width="12%" align="center">Kode Member</td>
																	<td align="center">Nama Lengkap</td>
																	<td width="10%" align="center">Kode Kost</td>
																	<td align="center">Nama Kost</td>
																	<td width="12%" align="center">Kode Kamar</td>
																	<td width="10%" align="center">Tanggal</td>
																	<td width="8%" align="center">Status</td>
																	<td width="20%" align="center">Aksi</td>
																</tr>
																<?php
																while ($row = mysqli_fetch_array($query)) {
																	echo "<tr><td align=center>";
																	echo $row['kode_booking'];
																	echo "</td><td align=center>";
																	echo $row['kode_member'];
																	echo "</td><td>";
																	echo $row['nama'];
																	echo "</td><td align=center>";
																	echo $row['kode_koskon'];
																	echo "</td><td>";
																	echo $row['nama_koskon'];
																	echo "</td><td align=center>";
																	echo $row['kode_kamar'];
																	echo "</td><td align=center>";
																	echo $row['tgl'];
																	echo "</td><td align=center>";
																	echo $row['status'];
																	echo "</td><form action=?id=";
																	echo $row['kode_booking'];
																	echo " method=POST><td align=center><input type=submit name=";
																	if ($row['status'] <> "Booking") {
																		echo "izinkan";
																	} else {
																		echo "batal";
																	} ?> value="<?php if ($row['status'] <> "Booking") {
																					echo "Izinkan";
																				} else {
																					echo "Batalkan";
																				} ?>" style="background:orange;" <?php echo "> <input type=submit name=hapusbooking value=Hapus "; ?> style="background:orange;" <?php echo "></td></form></tr>";
																																																																																																																																																																																									}
																																																																																																																																																																																										?>
															</table>
														<?php
														}
														?>

														<?php
														if (isset($_POST['izinkan'])) {
															$id = $_GET['id'];
															$query = mysqli_query($con, "update tbl_booking set status='Booking' where kode_booking='$id'");
															if ($query) {
																header('location:?abooking');
															}
														}

														?>
														<?php
														if (isset($_POST['hapusbooking'])) {
															$id = $_GET['id'];
														?>
															Apakah ingin menghapus Booking?<br>
															<form action="#?id=<?php echo $id; ?>" method="POST">
																<input type="submit" name="hapusbookingya" value="Ya" style="width:10%">
																<input type="submit" name="akun" value="Tidak" style="width:10%">
															</form>
														<?php
														}
														?>

														<?php
														if (isset($_POST['hapusbookingya'])) {
															$kode_booking = $_GET['id'];
															$kamar = mysqli_query($con, "select * from tbl_booking where kode_booking='$kode_booking'");
															$query = mysqli_query($con, "delete from tbl_booking where kode_booking='$kode_booking'");
															if ($query) {
																$row = mysqli_fetch_array($kamar);
																$kode_kamar = $row['kode_kamar'];
																mysqli_query($con, "update tbl_kamar set status='Tersedia' where kode_kamar='$kode_kamar'");
																echo "<form action=# method=GET><input type=submit name=akun value=Lanjutkan "; ?> style="background:orange;" <?php echo "></form>";
																																												?>
																<script type="text/javascript">
																	alert('Berhasil Menghapus Booking...!!!');
																</script>
														<?php
															}
														}
														?>

														<?php
														//Account Member
														if (isset($_GET['akun'])) {
															echo "<font size=5 color=green>";
															echo $_SESSION['username'];
															echo "</form><hr>";
														?>
															<form action="#" method="GET"><br><input type="submit" name="koskon" value="Tambahkan Kost/Kontrakan" style="background:orange; width:100%; height:40;"></form>
															<table border="1" bordercolor="yellow" width="100%" cellpadding="10" cellspacing="0">
																<tr>
																	<td colspan="10" align="center" bgcolor="orange">
																		<font color="black">Daftar Kos dan Kontrakan</font>
																	</td>
																</tr>
																<tr>
																	<td align="center">No</td>
																	<td align="center">Nama Kost/Kontrakan</td>
																	<td align="center">Phone</td>
																	<td align="center">Kelurahan</td>
																	<td align="center">Jalan</td>
																	<td align="center">Kategori</td>
																	<td align="center">Publish</td>
																	<td align="center">Aksi</td>
																</tr>
																<?php
																$user = $_SESSION['username'];
																$query = mysqli_query($con, "select tbl_koskon.kode_koskon,tbl_koskon.nama_koskon,tbl_koskon.phone,tbl_wilayah.kelurahan,tbl_koskon.jalan,tbl_koskon.kategori,tbl_koskon.publish,tbl_member.nama from tbl_koskon,tbl_wilayah,tbl_member where tbl_koskon.kode_member=tbl_member.kode_member and tbl_wilayah.kode_wilayah=tbl_koskon.kode_wilayah and tbl_member.nama='$user' order by waktu asc");
																$no = 1;
																while ($row = mysqli_fetch_array($query)) {
																	echo "<tr><td align=center><font size=2>";
																	echo $no;
																	echo "</font></td><td><font size=2>";
																	echo $row['nama_koskon'];
																	echo "</font></td><td align=center><font size=2>";
																	echo $row['phone'];
																	echo "</font></td><td><font size=2>";
																	echo $row['kelurahan'];
																	echo "</font></td><td><font size=2>";
																	echo $row['jalan'];
																	echo "</font></td><td align=center><font size=2>";
																	echo $row['kategori'];
																	echo "</font></td><td align=center><font size=2>";
																	echo $row['publish'];
																	echo "</font></td><form action=?id=";
																	echo $row['kode_koskon'];
																	echo " method=POST><td align=center width=25%><input type=submit name=detailkoskon value=Detail style="; ?> "width:25%; heihgt:20; font-size:12; background:orange; color=red;" <?php echo "> <input type=submit name=edit value=Edit style="; ?> "width:25%; heihgt:20; font-size:12; background:orange; color=red;"> <?php echo " <input type=submit name=hapus value=Hapus style="; ?> "width:25%; heihgt:20; background:orange; font-size:12; color=red;" <?php echo "></td></form></tr>";
																																																																																																																																	$no++;
																																																																																																																																}
																																																																																																																																	?>
															</table><br><br>

															<?php
															$user = $_SESSION['username'];
															$query = mysqli_query($con, "select * from tbl_member where nama='$user'");
															$row = mysqli_fetch_array($query);
															$kode_member = $row['kode_member'];
															$query = mysqli_query($con, "select tbl_koskon.kategori,tbl_kamar.kode_kamar,tbl_kamar.nomor_kamar,tbl_kamar.kode_koskon,tbl_kamar.gender,tbl_koskon.nama_koskon,tbl_kamar.jumlah,tbl_kamar.muatan,tbl_kamar.status from tbl_kamar,tbl_koskon where tbl_koskon.kode_koskon=tbl_kamar.kode_koskon and tbl_koskon.kode_member='$kode_member' order by tbl_kamar.kode_koskon desc");
															if ($query) {
															?>
																<table border="1" bordercolor="yellow" width="100%" cellpadding="10" cellspacing="0">
																	<tr>
																		<td colspan="7" align="center" bgcolor="orange">
																			<font color="black">Daftar Kamar Kost</font>
																		</td>
																	</tr>
																	<tr>
																		<td width="12%" align="center">Kode Kamar</td>
																		<td width="20%" align="center">Nama Kost / Kontrakan</td>
																		<td width="12%" align="center">No Kamar</td>
																		<td align="center">Gender</td>
																		<td align="center">Muatan Kamar</td>
																		<td width="12%" align="center">Status</td>
																		<td width="8%" align="center">Aksi</td>
																	</tr>
																	<?php
																	$query = mysqli_query($con, "select tbl_koskon.kategori,tbl_kamar.kode_kamar,tbl_kamar.nomor_kamar,tbl_kamar.kode_koskon,tbl_kamar.gender,tbl_koskon.nama_koskon,tbl_kamar.jumlah,tbl_kamar.muatan,tbl_kamar.status from tbl_kamar,tbl_koskon where tbl_koskon.kode_koskon=tbl_kamar.kode_koskon and tbl_koskon.kode_member='$kode_member' and tbl_koskon.kategori='Kost' order by tbl_kamar.kode_koskon desc");
																	while ($row = mysqli_fetch_array($query)) {
																		echo "<tr><td align=center>";
																		echo $row['kode_kamar'];
																		echo "</td><td align=center>";
																		echo $row['nama_koskon'];
																		echo "</td><td align=center>";
																		echo $row['nomor_kamar'];
																		echo "</td><td>";
																		echo $row['gender'];
																		echo "</td><td align=center>";
																		echo $row['muatan'];
																		echo "</td><td align=center>";
																		echo $row['status'];
																		echo "</td><form action=?id=";
																		echo $row['kode_kamar'];
																		echo " method=POST><td align=center>";
																		if ($row['status'] == 'Penuh') {
																			echo "-";
																		} else if ($row['kategori'] == 'Kost') {
																			echo "<input type=submit name=full "; ?> value="Klik disini Jika Kamar Sudah Full" style="background:orange;" <?php echo ">";
																																														} else {
																																															echo "<input type=submit name=full "; ?> value="Klik disini Jika Sudah Dikontrakan" style="background:orange;" <?php  }
																																																																																																																																																																																echo "</td></form></tr>";
																																																																																																																																																																															}
																																																																																																																																																																															echo "<table>";
																																																																																																																																																																														}
																																																																																																																																																																																	?>

																<br><br>

																<?php
																$user = $_SESSION['username'];
																$query = mysqli_query($con, "select * from tbl_member where nama='$user'");
																$row = mysqli_fetch_array($query);
																$kode_member = $row['kode_member'];
																$query = mysqli_query($con, "select tbl_booking.kode_booking,tbl_booking.kode_member,tbl_member.nama,tbl_booking.kode_koskon,tbl_koskon.nama_koskon,tbl_booking.kode_kamar,tbl_booking.tgl,tbl_booking.status from tbl_booking,tbl_member,tbl_koskon where tbl_member.kode_member=tbl_booking.kode_member and tbl_koskon.kode_koskon=tbl_booking.kode_koskon and tbl_koskon.kode_member='$kode_member' order by tbl_booking.kode_booking desc");
																if ($query) {
																?>
																	<table border="1" bordercolor="yellow" width="100%" cellpadding="10" cellspacing="0">
																		<tr>
																			<td colspan="9" align="center" bgcolor="orange">
																				<font color="black">Daftar Kost/Kontrakan Anda Yang Di Booking</font>
																			</td>
																		</tr>
																		<tr>
																			<td width="12%" align="center">Kode Booking</td>
																			<td width="12%" align="center">Kode Member</td>
																			<td align="center">Nama Lengkap</td>
																			<td width="10%" align="center">Kode Kost</td>
																			<td align="center">Nama Kost</td>
																			<td width="12%" align="center">Kode Kamar</td>
																			<td width="10%" align="center">Tanggal</td>
																			<td width="8%" align="center">Status</td>
																			<td width="8%" align="center">Aksi</td>
																		</tr>
																		<?php
																		while ($row = mysqli_fetch_array($query)) {
																			echo "<tr><td align=center>";
																			echo $row['kode_booking'];
																			echo "</td><td align=center>";
																			echo $row['kode_member'];
																			echo "</td><td>";
																			echo $row['nama'];
																			echo "</td><td align=center>";
																			echo $row['kode_koskon'];
																			echo "</td><td>";
																			echo $row['nama_koskon'];
																			echo "</td><td align=center>";
																			echo $row['kode_kamar'];
																			echo "</td><td align=center>";
																			echo $row['tgl'];
																			echo "</td><td align=center>";
																			echo $row['status'];
																			echo "</td><form action=?id=";
																			echo $row['kode_booking'];
																			echo " method=POST><td align=center><input type=submit name=hapusbooking value=Hapus "; ?> style="background:orange;" <?php echo "></td></form></tr>";
																																																}
																																																echo "<table>";
																																															}
																																																	?>

																	<br><br>

																	<?php
																	$user = $_SESSION['username'];
																	$query = mysqli_query($con, "select * from tbl_member where nama='$user'");
																	$row = mysqli_fetch_array($query);
																	$kode_member = $row['kode_member'];
																	$query = mysqli_query($con, "select tbl_booking.kode_booking,tbl_booking.kode_member,tbl_member.nama,tbl_booking.kode_koskon,tbl_koskon.nama_koskon,tbl_booking.kode_kamar,tbl_booking.tgl,tbl_booking.status from tbl_booking,tbl_member,tbl_koskon where tbl_booking.kode_member='$kode_member' and tbl_member.kode_member=tbl_booking.kode_member and tbl_koskon.kode_koskon=tbl_booking.kode_koskon order by tbl_booking.kode_booking desc");
																	if ($query) {
																	?>
																		<table border="1" bordercolor="yellow" width="100%" cellpadding="10" cellspacing="0">
																			<tr>
																				<td colspan="9" align="center" bgcolor="orange">
																					<font color="black">Kost/Kontrakan Yang Anda Booking</font>
																				</td>
																			</tr>
																			<tr>
																				<td width="12%" align="center">Kode Booking</td>
																				<td width="12%" align="center">Kode Member</td>
																				<td align="center">Nama Lengkap</td>
																				<td width="10%" align="center">Kode Kost</td>
																				<td align="center">Nama Kost</td>
																				<td width="12%" align="center">Kode Kamar</td>
																				<td width="10%" align="center">Tanggal</td>
																				<td width="8%" align="center">Status</td>
																				<td width="8%" align="center">Aksi</td>
																			</tr>
																			<?php
																			while ($row = mysqli_fetch_array($query)) {
																				echo "<tr><td align=center>";
																				echo $row['kode_booking'];
																				echo "</td><td align=center>";
																				echo $row['kode_member'];
																				echo "</td><td>";
																				echo $row['nama'];
																				echo "</td><td align=center>";
																				echo $row['kode_koskon'];
																				echo "</td><td>";
																				echo $row['nama_koskon'];
																				echo "</td><td align=center>";
																				echo $row['kode_kamar'];
																				echo "</td><td align=center>";
																				echo $row['tgl'];
																				echo "</td><td align=center>";
																				echo $row['status'];
																				echo "</td><form action=?id=";
																				echo $row['kode_booking'];
																				echo " method=POST><td align=center><input type=submit name=batal "; ?> value="Batalkan" style="background:orange;"> <?php echo "</td></form></tr>";
																																																	}
																																																	echo "<table>";
																																																}
																																															}
																																																		?>

																	<?php
																	if (isset($_POST['full'])) {
																		$kode_kamar = $_GET['id'];
																		$query = mysqli_query($con, "update tbl_kamar set status='Penuh' where kode_kamar='$kode_kamar'");
																		if ($query) {
																			header('location:?akun');
																		}
																	}
																	?>


																	<?php
																	//Laporan
																	if (isset($_GET['laporan'])) {
																	?>
																		<table border="1" bordercolor="yellow" width="100%" cellpadding="10" cellspacing="0">
																			<tr>
																				<td align="center" colspan="2" bgcolor="orange">
																					<font size=5 color="orange">Menu Laporan Sistem Informasi Kos dan Kontrakan</font>
																				</td>
																			</tr>
																			<tr>
																				<td valign="top" width="50%"><br>
																					<center>Laporan Kos dan Kontrakan</center>
																					<hr style="height:10; background:yellow">
																					Laporan Berdasarkan Kategori
																					<hr>

																					<form action="lapkoskon.php" method="POST" target="_blank">
																						<select name="kategori">
																							<option value="Kost">Kos-Kosan</option>
																							<option value="Kontrakan">Kontrakan</option>
																						</select>
																						<input type="submit" name="lkkk" value="Tampilkan" style="background:orange;">
																					</form>
																					<hr>
																					Laporan Per Bulan
																					<hr>
																					<form action="lapkoskon.php" method="POST" target="_blank">
																						Bulan <select name="bln">
																							<option value="01">Januari</option>
																							<option value="02">Februari</option>
																							<option value="03">Maret</option>
																							<option value="04">April</option>
																							<option value="05">Mei</option>
																							<option value="06">Juni</option>
																							<option value="07">Juli</option>
																							<option value="08">Agustus</option>
																							<option value="09">September</option>
																							<option value="10">Oktober</option>
																							<option value="11">November</option>
																							<option value="12">Desember</option>
																						</select>
																						Tahun <select name="thn"><?php $t = 2015;
																													while ($t <= 2020) {
																														echo "<option value=$t>$t</option>";
																														$t++;
																													} ?></select>
																						<input type="submit" name="lkkb" value="Tampilkan" style="background:orange;">
																					</form>
																					<hr>
																					Laporan Berdasarkan Wilayah
																					<hr>
																					<form action="lapkoskon.php" method="POST" target="_blank">
																						<select name="kelurahan">
																							<?php
																							$query = mysqli_query($con, "select * from tbl_wilayah");
																							while ($row = mysqli_fetch_array($query)) {
																							?> <option value="<?php echo $row['kelurahan']; ?>"><?php echo $row['kecamatan'];
																																				echo " - ";
																																				echo $row['kelurahan']; ?></option>
																							<?php
																							}
																							?>
																						</select>
																						<input type="submit" name="lkkw" value="Tampilkan" style="background:orange;">
																					</form>
																					<hr>
																					Laporan Semua Kos dan Kontrakan
																					<hr>
																					<form action="lapkoskon.php" method="POST" target="_blank">
																						<input type="submit" name="lkks" value="Tampilkan Semua" style="background:orange;">
																					</form>
																				</td>
																				<td valign="top" width="50%"><br>
																					<center>Laporan Booking Kos dan Kontrakan</center>
																					<hr style="height:10; background:yellow">
																					Laporan Booking Kost Per Bulan
																					<hr>
																					<form action="lapbooking.php" method="POST" target="_blank">
																						Bulan <select name="bln">
																							<option value="01">Januari</option>
																							<option value="02">Februari</option>
																							<option value="03">Maret</option>
																							<option value="04">April</option>
																							<option value="05">Mei</option>
																							<option value="06">Juni</option>
																							<option value="07">Juli</option>
																							<option value="08">Agustus</option>
																							<option value="09">September</option>
																							<option value="10">Oktober</option>
																							<option value="11">November</option>
																							<option value="12">Desember</option>
																						</select>
																						Tahun <select name="thn"><?php $t = 2015;
																													while ($t <= 2020) {
																														echo "<option value=$t>$t</option>";
																														$t++;
																													} ?></select>
																						<input type="submit" name="lbkost" value="Tampilkan" style="background:orange;">
																					</form>
																					<hr>
																					Laporan Booking Kontrakan Per Bulan
																					<hr>
																					<form action="lapbooking.php" method="POST" target="_blank">
																						Bulan <select name="bln">
																							<option value="01">Januari</option>
																							<option value="02">Februari</option>
																							<option value="03">Maret</option>
																							<option value="04">April</option>
																							<option value="05">Mei</option>
																							<option value="06">Juni</option>
																							<option value="07">Juli</option>
																							<option value="08">Agustus</option>
																							<option value="09">September</option>
																							<option value="10">Oktober</option>
																							<option value="11">November</option>
																							<option value="12">Desember</option>
																						</select>
																						Tahun <select name="thn"><?php $t = 2015;
																													while ($t <= 2020) {
																														echo "<option value=$t>$t</option>";
																														$t++;
																													} ?></select>
																						<input type="submit" name="lbkontrakan" value="Tampilkan" style="background:orange;">
																					</form>
																					<hr>
																					Laporan Booking Kontrakan dan Kost
																					<hr>
																					<form action="lapbooking.php" method="POST" target="_blank">
																						<input type="submit" name="lks" value="Tampilkan Semua" style="background:orange;">
																					</form>
																				</td>
																			</tr>
																			<tr>
																				<td colspan="2">
																					Laporan Member
																					<hr>
																					<form action="lapmember.php" method="POST" target="_blank">
																						<input type="submit" name="lm" value="Tampilkan Semua" style="background:orange;">
																				</td>
																			</tr>
																		</table>
																	<?php
																	}
																	?>


																	<?php
																	if (isset($_POST['tambahgambar'])) {
																		$kode_koskon = $_GET['id'];
																	?>
																		<form action="?id=<?php echo $kode_koskon; ?>" method="POST" enctype="multipart/form-data">
																			Menambahkan File Gambar Rumah Kost/Kontrakan
																			<hr>
																			<font size="4">Pilih Gambar </font> <input type="file" name="gambar" accept="image/*">
																			<font size="4" color="orange"><br>Pastikan nama file gambar tidak mengandung Spasi (contoh salah : foto kos.jpg)</font>
																			<hr>
																			<input type="submit" name="sgambar" value="Simpan" style="background:orange; width:200;"><input type="reset" value="Batal" style="background:orange; width:200;">
																		</form>
																	<?php
																	}
																	?>

																	<?php
																	if (isset($_POST['sgambar'])) {
																		$kode_koskon = $_GET['id'];
																		if (!empty($_FILES['gambar']['name'])) {
																			$folder = "C:/wamp/www/kos/gambar/";
																			$folder = $folder . basename($_FILES['gambar']['name']);
																			$gambar = ($_FILES['gambar']['name']);
																			move_uploaded_file($_FILES['gambar']['tmp_name'], $folder);
																			$profil = 'No';
																			$query = mysqli_query($con, "insert into tbl_gambar values ('','$kode_koskon','$gambar','$profil')");
																			if ($query) {
																				echo "Berhasil Menambahkan Gambar..!!!";
																	?>
																				<form action="?id=<?php echo $kode_koskon; ?>" method="POST">
																					<input type="submit" name="tambahgambar" value="Tambah Gambar" style="background:orange; width:200;">
																					<input type="submit" name="detailkoskon" value="Selesai" style="background:orange; width:200;">
																					<script type="text/javascript">
																						alert('Berhasil Menambahkan Gambar...!!!');
																					</script>
																				</form>
																	<?php
																			}
																		}
																	}
																	?>


																	<?php
																	//Menampilkan Detail Koskon
																	if (isset($_POST['detailkoskon']) or isset($_GET['detailkoskon'])) {
																		echo "<table border=1 width=100% align=left cellpadding=10 cellspacing=0><tr><td colspan=2>";

																	?>
																		<table border="0" width="100%" align="left" cellpadding="10" cellspacing="0">
																			<tr>
																				<td align="center" colspan="4">
																					<font size="4">Foto Rumah Kost / Kontrakan</font>
																					<hr>
																				</td>
																			</tr>
																			<tr>
																				<?php
																				$id = $_GET['id'];
																				$query = mysqli_query($con, "select * from tbl_gambar where kode_koskon='$id'");
																				$g = 0;
																				while ($row = mysqli_fetch_array($query)) {
																					echo "<td colspan=2 align=center><img width=100% src=gambar/";
																					echo $row['gambar'];
																					echo "></img></td>";
																					$g++;
																					if ($g >= 2) {
																						echo "</tr><tr>";
																						$g = 0;
																					}
																				}
																				?>

																			<tr>
																				<td align="center" colspan="4">
																					<hr>
																					<font size="4">Lokasi Rumah Kost / Kontrakan</font>
																					<hr>
																					<div id="petakon"></div>

																					<script type="text/javascript">
																						(function() {
																							window.onload = function() {
																								var map;
																								//Parameter Google maps
																								var options = {
																									zoom: 18, //level zoom
																									//posisi tengah peta
																									center: new google.maps.LatLng(
																										<?php
																										$id = $_GET['id'];
																										$query = mysqli_query($con, "select * from tbl_koskon where tbl_koskon.kode_koskon='$id'");
																										$row = mysqli_fetch_array($query);
																										echo $row['lat'];
																										echo ",";
																										echo $row['lng'];  ?>
																									),
																									mapTypeId: google.maps.MapTypeId.ROADMAP
																								};

																								// Buat peta di 
																								var map = new google.maps.Map(document.getElementById('petakon'), options);
																								// Tambahkan Marker 
																								var locations = [
																									<?php
																									$id = $_GET['id'];
																									$query = mysqli_query($con, "select tbl_gambar.gambar,tbl_koskon.kategori,tbl_koskon.nama_koskon,tbl_wilayah.kelurahan,tbl_koskon.jalan,tbl_koskon.phone,tbl_koskon.lat,tbl_koskon.lng from tbl_gambar,tbl_koskon,tbl_wilayah where tbl_koskon.kode_koskon='$id' and tbl_wilayah.kode_wilayah=tbl_koskon.kode_wilayah and tbl_gambar.kode_koskon=tbl_koskon.kode_koskon and tbl_gambar.profil='Yes'");
																									$row = mysqli_fetch_array($query);
																									echo "['<img width=150 height=150 src=gambar/" . $row['gambar'] . "></img>";
																									echo "<br><font color=black>Nama Kost :";
																									echo $row['nama_koskon'];
																									echo "<br><font color=black>Kategori :";
																									echo $row['kategori'];
																									echo "<br>Kelurahan :";
																									echo $row['kelurahan'];
																									echo "<br>Jalan :";
																									echo $row['jalan'];
																									echo "<br>Phone :";
																									echo $row['phone'];
																									echo "',";
																									echo  $row['lat'];
																									echo ",";
																									echo $row['lng'];
																									echo "],";
																									?>

																								];
																								var infowindow = new google.maps.InfoWindow();

																								var marker, i;
																								/* kode untuk menampilkan banyak marker */
																								for (i = 0; i < locations.length; i++) {
																									marker = new google.maps.Marker({
																										position: new google.maps.LatLng(locations[i][1], locations[i][2]),
																										map: map,
																										<?php
																										$id = $_GET['id'];
																										$query = mysqli_query($con, "select * from tbl_koskon where kode_koskon='$id'");
																										$row = mysqli_fetch_array($query);
																										if ($row['kategori'] == 'Kost') {
																										?>
																											icon: 'kost-icon.png'
																										<?php
																										} else {
																										?>
																											icon: 'kont-icon.png'
																										<?php
																										}
																										?>
																									});
																									/* menambahkan event clik untuk menampikan
     	 infowindows dengan isi sesuai denga
	    marker yang di klik */

																									google.maps.event.addListener(marker, 'click', (function(marker, i) {
																										return function() {
																											infowindow.setContent(locations[i][0]);
																											infowindow.open(map, marker);
																										}
																									})(marker, i));
																								}


																							};
																						})();
																					</script>

																				</td>
																			</tr>

																			<tr>
																				<td colspan="4" cellpadding="0" cellspacing="0" align="center" bgcolor="orange">
																					<font size="4">Infomasi Kost/Kontrakan</font>
																				</td>
																			</tr>
																			<?php
																			$id = $_GET['id'];
																			$query = mysqli_query($con, "select tbl_member.nama,tbl_koskon.kode_koskon,tbl_koskon.nama_koskon,tbl_kamar.jumlah,tbl_koskon.phone,tbl_wilayah.kelurahan,tbl_koskon.jalan,tbl_koskon.kategori,tbl_kamar.ukuran1,tbl_kamar.ukuran2,tbl_kamar.harga,tbl_kamar.per,tbl_kamar.fasilitas,tbl_kamar.status,tbl_koskon.keterangan,tbl_koskon.lat,tbl_koskon.lng,tbl_koskon.publish from tbl_koskon,tbl_kamar,tbl_wilayah,tbl_member where tbl_koskon.kode_koskon='$id' and tbl_kamar.kode_koskon='$id' and tbl_wilayah.kode_wilayah=tbl_koskon.kode_wilayah and tbl_member.kode_member=tbl_koskon.kode_member");
																			$row = mysqli_fetch_array($query);
																			echo "<tr><td height=30 width=15%><font size=4>Nama Kost/Kontrakan</td><td width=35%>: <font size=4 color=black>";
																			if(isset($row['nama_koskon'])){
																			echo $row['nama_koskon'];
																			}
																			echo "</td><td width=15% height=30><font size=4>Phone</td><td width=35%>: <font size=4 color=black>";
																			echo $row['phone'];
																			echo "</td></tr>";
																			echo "<tr><td height=30><font size=4>Wilayah</td><td>: <font size=4 color=black>";
																			echo $row['kelurahan'];
																			echo "</td><td width=20% height=30><font size=4>Jalan</td><td>: <font size=4 color=black>";
																			echo $row['jalan'];
																			echo "</td></tr>";
																			if (!empty($row['kategori']) and $row['kategori'] == 'Kontrakan') {
																				echo "<tr><td height=30><font size=4>Jumlah Kamar</td><td>: <font size=4 color=black>";
																				echo $row['jumlah'];
																				echo "</td><td height=30><font size=4>Kategori</td><td>: <font size=4 color=black>";
																				echo $row['kategori'];
																				echo "</td></tr>";
																				echo "<tr><td height=30><font size=4>Ukuran Rumah</td><td>: <font size=4 color=black>";
																				echo $row['ukuran1'];
																				echo " X ";
																				echo $row['ukuran2'];
																				echo "</td><td height=30><font size=4>Harga Kontrakan</td><td>: <font size=4 color=black>";
																				echo $row['harga'];
																				echo " / ";
																				echo $row['per'];
																				echo "</td></tr>";
																				echo "<tr><td><font size=4>Fasilitas</td><td colspan=3>: <font size=4 color=black> ";
																				echo $row['fasilitas'];
																				echo "</td></tr>";
																				echo "<tr><td><font size=4>Status</td><td colspan=3>: <font size=4 color=black><font color=red> ";
																				if ($row['status'] == 'Penuh') {
																					echo "Tidak Tersedia";
																				}
																				echo "</font></td></tr>";
																			}
																			echo "<tr><td><font size=4>Keterangan</td><td colspan=3>: <font size=4 color=black> ";
																			echo $row['keterangan'];
																			echo "</td></tr>";
																			if (!empty($row['kategori']) and $row['kategori'] == 'Kost') {
																			?>
																				<tr>
																					<td colspan="4">
																						<table border="0" background="isi.jpg" bordercolor="yellow" cellpadding="5" cellspacing="0" align="center" width="100%">
																							<tr>
																								<td colspan="8" align="center" bgcolor="orange">
																									<font size="4">Daftar Kamar Kost <?php echo $row['nama_koskon']; ?></font>
																								</td>
																							</tr>
																							<tr>
																								<td align="center" bgcolor="orange">Kode Kamar</td>
																								<td align="center" bgcolor="orange">Nomor Kamar</td>
																								<td align="center" bgcolor="orange">Gender</td>
																								<td align="center" bgcolor="orange">Ukuran</td>
																								<td align="center" bgcolor="orange">Muatan</td>
																								<td align="center" bgcolor="orange">Harga</td>
																								<td align="center" bgcolor="orange">Fasilitas</td>
																								<td align="center" bgcolor="orange">Status</td>
																							</tr>
																							<?php
																							$query = mysqli_query($con, "select * from tbl_kamar where kode_koskon='$id'");
																							while ($row = mysqli_fetch_array($query)) {
																								echo "<tr><td align=center width=12%>";
																								echo $row['kode_kamar'];
																								echo "</td><td align=center width=12%>";
																								echo $row['nomor_kamar'];
																								echo "</td><td align=center width=10%>";
																								echo $row['gender'];
																								echo "</td><td align=center width=10%>";
																								echo $row['ukuran1'];
																								echo " X ";
																								echo $row['ukuran2'];
																								echo "</td><td align=center width=10%>";
																								echo $row['muatan'];
																								echo " Orang</td><td align=center width=20%>";
																								echo $row['harga'];
																								echo " / ";
																								echo $row['per'];
																								echo "</td><td>";
																								echo $row['fasilitas'];
																								echo "</td><td width=10%>";
																								echo $row['status'];
																								echo "</td></tr>";
																							}
																							?>
																						</table>
																					</td>
																				</tr>

																				<?php
																			}
																			$query = mysqli_query($con, "select tbl_koskon.kode_koskon,tbl_koskon.kategori,tbl_member.kode_member,tbl_member.nama from tbl_koskon,tbl_member where kode_koskon='$id' and tbl_koskon.kode_member=tbl_member.kode_member");
																			$row = mysqli_fetch_array($query);
																			if (empty($_SESSION['username'])) {
																			} else {
																				if ($row['nama'] == $_SESSION['username']) {
																					echo "<tr><form action=?id=";
																					echo $row['kode_koskon'];
																					echo " method=POST><td height=40 colspan=4 align=center colspan=4><input type=submit name=edit"; ?> value="Edit <?php if ($row['kategori'] == "Kost") {
																																																		echo " Kost";
																																																	} else {
																																																		echo " Kontrakan";
																																																	} ?>" style="width:24%; background:orange; height:30px;"> <input type="submit" name="hapus" value="Hapus <?php if ($row['kategori'] == "Kost") {
																																																																						echo " Kost";
																																																																					} else {
																																																																						echo " Kontrakan";
																																																																					} ?>" style="width:24%; background:orange; height:30px;"><?php if ($row['kategori'] == 'Kost') { ?> <input type="submit" name="inputkamar" value="Tambahkan Kamar" style="width:24%; background:orange; height:30px;"><?php } ?><?php if ($row['kategori'] == 'Kontrakan') { ?> <input type="submit" name="editdetail" value="Edit Detail Kontrakan" style="width:24%; background:orange; height:30px;"><?php } ?> <input type="submit" name="tambahgambar" value="Tambahkan Gambar" style="width:24%; background:orange; height:30px;">
			</td>
			</form>
		</tr>
		<?php
																					$kode_koskon = $_GET['id'];
																					$kategori = mysqli_query($con, "select * from tbl_koskon where kode_koskon='$kode_koskon'");
																					$k = mysqli_fetch_array($kategori);
																					if ($k['kategori'] == 'Kost') {
																						$query = mysqli_query($con, "select tbl_booking.kode_booking,tbl_booking.kode_member,tbl_member.nama,tbl_kamar.kode_koskon,tbl_koskon.nama_koskon,tbl_booking.kode_kamar,tbl_kamar.nomor_kamar,tbl_booking.tgl,tbl_booking.status,tbl_booking.komentar from tbl_booking,tbl_member,tbl_koskon,tbl_kamar where tbl_member.kode_member=tbl_booking.kode_member and tbl_kamar.kode_koskon='$kode_koskon' and tbl_koskon.kode_koskon=tbl_kamar.kode_koskon and tbl_kamar.kode_kamar=tbl_booking.kode_kamar order by tbl_booking.kode_booking desc");
		?>
			<tr>
				<td colspan="4">
					<table border="1" background="isi.jpg" bordercolor="yellow" cellpadding="2" cellspacing="0" width="100%">
						<tr>
							<td colspan="9" align="center" bgcolor="orange">Daftar Booking Kost</td>
						</tr>
						<tr>
							<td align="center">Kode Booking</td>
							<td align="center">Kode Member</td>
							<td align="center">Nama Lengkap</td>
							<td align="center">Kode Kost</td>
							<td align="center">Nama Kost</td>
							<td align="center">No.Kamar</td>
							<td align="center">Tanggal</td>
							<td align="center">Keterangan</td>
							<td align="center">Status</td>
						</tr>
						<?php
																						while ($row = mysqli_fetch_array($query)) {
																							echo "<tr><td align=center>";
																							echo $row['kode_booking'];
																							echo "</td><td align=center>";
																							echo $row['kode_member'];
																							echo "</td><td>";
																							echo $row['nama'];
																							echo "</td><td align=center>";
																							echo $row['kode_koskon'];
																							echo "</td><td>";
																							echo $row['nama_koskon'];
																							echo "</td><td align=center>";
																							echo $row['nomor_kamar'];
																							echo "</td><td align=center>";
																							echo $row['tgl'];
																							echo "</td><td align=center>";
																							echo $row['komentar'];
																							echo "</td><td align=center>";
																							echo $row['status'];
																							echo "</td></tr>";
																						}
						?>
					</table>
				</td>
			</tr>
		<?php
																					}
																				} else {
		?>
		<tr>
			<td colspan="4">
				<?php
																					$query = mysqli_query($con, "select * from tbl_kamar where kode_koskon='$id' and status = 'Tersedia'");
																					echo "<form action=?id=";
																					echo $row['kode_koskon'];
																					echo " method=POST>";
				?>
				<table border="0" background="isi.jpg" bordercolor="yellow" width="100%" cellpadding="10" cellspacing="0">
					<tr>
						<td colspan="2" align="center" bgcolor="orange">Booking Kost/Kontrakan</td>
					</tr>
					<?php
																					if ($row['kategori'] == 'Kost') {
					?>
						<tr>
							<td>Kode Kamar</td>
							<td><select name="kode_kamar"><?php while ($row = mysqli_fetch_array($query)) {
																							echo "<option value=";
																							echo $row['kode_kamar'];
																							echo ">";
																							echo $row['kode_kamar'];
																							echo "</option>";
																						}  ?></select></td>
						</tr>
					<?php
																					}
					?>
					<tr>
						<td>Tanggal Booking</td>
						<td><select name="tgl"><?php $t = '1';
																					while ($t <= 31) {
																						echo "<option value=$t>$t</option>";
																						$t++;
																					} ?></select>&nbsp;<select name="bln">
								<option value="01">Januari</option>
								<option value="02">Februari</option>
								<option value="03">Maret</option>
								<option value="04">April</option>
								<option value="05">Mei</option>
								<option value="06">Juni</option>
								<option value="07">Juli</option>
								<option value="08">Agustus</option>
								<option value="09">September</option>
								<option value="10">Oktober</option>
								<option value="11">November</option>
								<option value="12">Desember</option>
							</select> <select name="thn"><?php $th = '2015';
																					while ($th <= 2020) {
																						echo "<option value=$th>$th</option>";
																						$th++;
																					} ?></select></td>
					</tr>
					<tr>
						<td>Komentar</td>
						<td><textarea name="komentar" cols="40" rows="4"></textarea></td>
					</tr>
					<tr>
						<td colspan="2"><input type="submit" name="sbooking" value="Booking" style="width:20%; height:40px; background:orange;"><input type="submit" value="Batal" style="width:20%; height:40px; background:orange;"></td>
					</tr>
				</table>
				</form>

				<?php
																					$kode_koskon = $_GET['id'];
																					$kategori = mysqli_query($con, "select * from tbl_koskon where kode_koskon='$kode_koskon'");
																					$k = mysqli_fetch_array($kategori);
																					if ($k['kategori'] == 'Kost') {
																						$query = mysqli_query($con, "select tbl_kamar.nomor_kamar,tbl_booking.kode_booking,tbl_booking.kode_member,tbl_member.nama,tbl_kamar.kode_koskon,tbl_koskon.nama_koskon,tbl_booking.kode_kamar,tbl_booking.tgl,tbl_booking.status,tbl_booking.komentar from tbl_booking,tbl_member,tbl_koskon,tbl_kamar where tbl_member.kode_member=tbl_booking.kode_member and tbl_kamar.kode_koskon='$kode_koskon' and tbl_koskon.kode_koskon=tbl_kamar.kode_koskon and tbl_kamar.kode_kamar=tbl_booking.kode_kamar order by tbl_booking.kode_booking desc");
				?>
					<table border="1" bordercolor="yellow" cellpadding="5" cellspacing="0" width="100%">
						<tr>
							<td colspan="9" align="center" bgcolor="orange">Daftar Booking Kost</td>
						</tr>
						<tr>
							<td align="center">Kode Booking</td>
							<td align="center">Kode Member</td>
							<td align="center">Nama Lengkap</td>
							<td align="center">Kode Kost</td>
							<td align="center">Nama Kost</td>
							<td align="center">Kode Kamar</td>
							<td align="center">Tanggal</td>
							<td align="center">Keterangan</td>
							<td align="center">Status</td>
						</tr>
						<?php
																						while ($row = mysqli_fetch_array($query)) {
																							echo "<tr><td align=center>";
																							echo $row['kode_booking'];
																							echo "</td><td align=center>";
																							echo $row['kode_member'];
																							echo "</td><td>";
																							echo $row['nama'];
																							echo "</td><td align=center>";
																							echo $row['kode_koskon'];
																							echo "</td><td>";
																							echo $row['nama_koskon'];
																							echo "</td><td align=center>";
																							echo $row['kode_kamar'];
																							echo "</td><td align=center>";
																							echo $row['tgl'];
																							echo "</td><td align=center>";
																							echo $row['komentar'];
																							echo "</td><td align=center>";
																							echo $row['status'];
																							echo "</td></tr>";
																						}
						?>
					</table>
				<?php
																					}
				?>
			</td>
		</tr>
<?php
																				}
																			}
																			echo "</table>";
																		}
?>

<?php
//Proses Booking Kost / Kontrakan
if (isset($_POST['sbooking'])) {
	$kode_koskon = $_GET['id'];
	$kategori = mysqli_query($con, "select * from tbl_koskon where kode_koskon='$kode_koskon'");
	$k = mysqli_fetch_array($kategori);
	//Jika Kategori Kost
	if ($k['kategori'] == 'Kost') {
		if (empty($_POST['kode_kamar'])) {
?>
			<form action="?id=<?php echo $kode_koskon; ?>" method="POST">
				<input type="submit" name="detailkoskon" value="Kembali" style="background:orange;">
				<script type="text/javascript">
					alert('Tidak Ada Kamar Terpilih / Kamar Sudah Penuh..!!!');
				</script>
			</form>
			<?php
		} else {
			$kode_kamar = $_POST['kode_kamar'];
			$query = mysqli_query($con, "select * from tbl_kamar where kode_kamar='$kode_kamar' ");
			$nama = $_SESSION['username'];
			$member = mysqli_query($con, "select * from tbl_member where nama='$nama'");
			$row = mysqli_fetch_array($query);
			$m = mysqli_fetch_array($member);

			//Jika Gender Tidak Sesuai
			if ($row['gender'] <> $m['gender']) {
			?>
				<script type="text/javascript">
					alert('Gender Anda Tidak Cocok dengan Kamar yang Anda Pilih..!!!');
				</script>
				<form action="?id=<?php echo $kode_koskon; ?>" method="POST">
					<input type="submit" name="detailkoskon" value="Kembali" style="background:orange;">
					<form>
						<?php
					} else {
						$nama = $_SESSION['username'];
						$member = mysqli_query($con, "select * from tbl_member where nama='$nama'");
						$m = mysqli_fetch_array($member);
						$kode_member = $m['kode_member'];
						$booking = mysqli_query($con, "select * from tbl_booking where kode_member='$kode_member'");
						$b = mysqli_fetch_array($booking);
						//Jika Telah Melakukan Booking Sebelumnya
						if ($b['kode_member'] == $m['kode_member']) {
						?>
							<script type="text/javascript">
								alert('Kamu Sudah Melakukan Booking Sebelumnya..!!!');
							</script>
							<form action="?id=<?php echo $kode_koskon; ?>" method="POST">
								<input type="submit" name="detailkoskon" value="Kembali" style="background:orange;">
								<form>
									<?php
								} else
								//Simpan Booking Kamar Kost
								{
									$kode_kamar = $_POST['kode_kamar'];
									$tgl = $_POST['thn'] . "-" . $_POST['bln'] . "-" . $_POST['tgl'];
									$komentar = $_POST['komentar'];
									$status = 'Menunggu';
									$query = mysqli_query($con, "insert into tbl_booking values ('','$kode_member','$kode_koskon','$kode_kamar','$tgl','$komentar','$status',Now())");
									if ($query) {
										$qbooking = mysqli_query($con, "select count(tbl_booking.kode_kamar) as m,tbl_kamar.muatan from tbl_kamar,tbl_booking where tbl_kamar.kode_kamar='$kode_kamar' and tbl_kamar.kode_kamar=tbl_booking.kode_kamar ");
										$qb = mysqli_fetch_array($qbooking);
										if ($qb['m'] >= $qb['muatan']) {
											mysqli_query($con, "update tbl_kamar set status='Penuh' where kode_kamar='$kode_kamar'");
									?>
											<form action="lapbooking.php?id=<?php echo $kode_kamar; ?>" target="_blank" method="POST">
												<input type="submit" name="cetak" value="Cetak Faktur Booking" style="background:orange; height:40;">
											</form>
										<?php
										}
										?>
										<form action="lapbooking.php?id=<?php echo $kode_kamar; ?>" target="_blank" method="POST">
											<input type="submit" name="cetak" value="Cetak Faktur Booking" style="background:orange; height:40;">
										</form>
							<?php
									}
								}
							}
						}
					} else
					//Jika Kategori Kontrakan
					{
						$nama = $_SESSION['username'];
						$member = mysqli_query($con, "select * from tbl_member where nama='$nama'");
						$m = mysqli_fetch_array($member);
						$kode_member = $m['kode_member'];
						$booking = mysqli_query($con, "select * from tbl_booking where kode_member='$kode_member'");
						$b = mysqli_fetch_array($booking);
						//Jika Telah Melakukan Booking Sebelumnya
						if ($b['kode_member'] == $m['kode_member']) {
							?>
							<script type="text/javascript">
								alert('Kamu Sudah Melakukan Booking Sebelumnya..!!!');
							</script>
							<form action="?id=<?php echo $kode_koskon; ?>" method="POST">
								<input type="submit" name="detailkoskon" value="Kembali" style="background:orange;">
								<form>
									<?php
								} else {
									//Simpan Booking Kontrakan
									$kamar = mysqli_query($con, "select * from tbl_kamar where kode_koskon='$kode_koskon'");
									$k = mysqli_fetch_array($kamar);
									if ($k['status'] == 'Penuh') {
									?>
										<script type="text/javascript">
											alert('Kontrakan Sudah Di Booking..!!!');
										</script>
										<form action="?id=<?php echo $kode_koskon; ?>" method="POST">
											<input type="submit" name="detailkoskon" value="Kembali" style="background:orange;">
											<form>
												<?php
											} else {
												$kode_kamar = $k['kode_kamar'];
												$tgl = $_POST['thn'] . "-" . $_POST['bln'] . "-" . $_POST['tgl'];
												$komentar = $_POST['komentar'];
												$status = 'Menunggu';
												$query = mysqli_query($con, "insert into tbl_booking values ('','$kode_member','$kode_koskon','$kode_kamar','$tgl','$komentar','$status',Now())");
												if ($query) {
													mysqli_query($con, "update tbl_kamar set status='Penuh' where kode_kamar=$kode_kamar");
												?>
													<form action="lapbooking.php?id=<?php echo $kode_kamar; ?>" target="_blank" method="POST">
														<input type="submit" name="cetak" value="Cetak Faktur Booking" style="background:orange;">
													</form>
								<?php
												}
											}
										}
									}
								}

								?>


								</td>
								</tr>

	</table>
	</td>
	</tr>
	</table>
	<script type="text/javascript">
		//* Fungsi untuk mendapatkan nilai latitude longitude
		function updateMarkerPosition(latLng) {
			document.getElementById('latitude').value = [latLng.lat()]
			document.getElementById('longitude').value = [latLng.lng()]
		}

		var map = new google.maps.Map(document.getElementById('map'), {
			zoom: 14,
			center: new google.maps.LatLng(-0.3038764, 100.3729242),
			mapTypeId: google.maps.MapTypeId.ROADMAP
		});
		//posisi awal marker   

		var latLng = new google.maps.LatLng(-0.3038764, 100.3729242);

		/* buat marker yang bisa di drag lalu 
		  panggil fungsi updateMarkerPosition(latLng)
		 dan letakan posisi terakhir di id=latitude dan id=longitude
		 */
		var marker = new google.maps.Marker({
			position: latLng,
			title: 'lokasi',
			map: map,
			draggable: true
		});

		updateMarkerPosition(latLng);
		google.maps.event.addListener(marker, 'drag', function() {
			// ketika marker di drag, otomatis nilai latitude dan longitude
			//menyesuaikan dengan posisi marker 
			updateMarkerPosition(marker.getPosition());
		});
	</script>



</body>

</html>