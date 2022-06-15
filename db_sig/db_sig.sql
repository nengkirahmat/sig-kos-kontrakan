-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 16 Jun 2022 pada 00.52
-- Versi server: 10.4.14-MariaDB
-- Versi PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sig`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_booking`
--

CREATE TABLE `tbl_booking` (
  `kode_booking` int(10) NOT NULL,
  `kode_member` int(10) NOT NULL,
  `kode_koskon` int(10) NOT NULL,
  `kode_kamar` int(10) NOT NULL,
  `tgl` date NOT NULL,
  `komentar` text NOT NULL,
  `status` varchar(10) NOT NULL,
  `waktu` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_bt`
--

CREATE TABLE `tbl_bt` (
  `kode_bt` int(10) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `web` varchar(50) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `isi` text NOT NULL,
  `waktu` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_gambar`
--

CREATE TABLE `tbl_gambar` (
  `kode_gambar` int(10) NOT NULL,
  `kode_koskon` int(10) NOT NULL,
  `gambar` varchar(50) NOT NULL,
  `profil` varchar(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_gambar`
--

INSERT INTO `tbl_gambar` (`kode_gambar`, `kode_koskon`, `gambar`, `profil`) VALUES
(134, 113, 'features.png', 'Yes');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_kamar`
--

CREATE TABLE `tbl_kamar` (
  `kode_kamar` int(10) NOT NULL,
  `nomor_kamar` int(10) NOT NULL,
  `kode_koskon` int(10) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `ukuran1` int(5) NOT NULL,
  `ukuran2` int(5) NOT NULL,
  `jumlah` int(5) NOT NULL,
  `muatan` int(5) NOT NULL,
  `harga` double NOT NULL,
  `per` varchar(10) NOT NULL,
  `fasilitas` text NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_koskon`
--

CREATE TABLE `tbl_koskon` (
  `kode_koskon` int(10) NOT NULL,
  `nama_koskon` varchar(30) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `kode_wilayah` int(10) NOT NULL,
  `jalan` varchar(50) NOT NULL,
  `kategori` varchar(10) NOT NULL,
  `lat` varchar(30) NOT NULL,
  `lng` varchar(30) NOT NULL,
  `keterangan` text NOT NULL,
  `kode_member` int(10) NOT NULL,
  `waktu` datetime NOT NULL,
  `publish` varchar(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_koskon`
--

INSERT INTO `tbl_koskon` (`kode_koskon`, `nama_koskon`, `phone`, `kode_wilayah`, `jalan`, `kategori`, `lat`, `lng`, `keterangan`, `kode_member`, `waktu`, `publish`) VALUES
(113, 'Rumah Kos', '085265889195', 29, 'huhuhuhuj', 'Kost', '-0.3038764', '100.3729242', 'sefdsfds', 1, '2022-06-16 05:33:55', 'Yes');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_member`
--

CREATE TABLE `tbl_member` (
  `kode_member` int(10) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `tgl` int(2) NOT NULL,
  `bln` varchar(15) NOT NULL,
  `thn` int(4) NOT NULL,
  `email` varchar(50) NOT NULL,
  `pass` varchar(30) NOT NULL,
  `level` varchar(10) NOT NULL,
  `waktu_daftar` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_member`
--

INSERT INTO `tbl_member` (`kode_member`, `nama`, `gender`, `alamat`, `phone`, `tgl`, `bln`, `thn`, `email`, `pass`, `level`, `waktu_daftar`) VALUES
(1, 'Nengki Rahmat', 'Pria', 'Solok', '085766560081', 7, '04', 1994, 'Nengkirahmat@ymail.com', '1', 'Admin', '2015-09-25 16:47:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_wilayah`
--

CREATE TABLE `tbl_wilayah` (
  `kode_wilayah` int(10) NOT NULL,
  `kecamatan` varchar(30) NOT NULL,
  `kelurahan` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_wilayah`
--

INSERT INTO `tbl_wilayah` (`kode_wilayah`, `kecamatan`, `kelurahan`) VALUES
(29, 'Aur Birugo Tigo Baleh', 'Belakang Balok'),
(2, 'Aur Birugo Tigo Baleh', 'Aur Kuning'),
(3, 'Aur Birugo Tigo Baleh', 'Parit Antang'),
(4, 'Aur Birugo Tigo Baleh', 'Kubu Tanjung'),
(5, 'Aur Birugo Tigo Baleh', 'Pakan Labuah'),
(6, 'Aur Birugo Tigo Baleh', 'Ladang Cakiah'),
(7, 'Aur Birugo Tigo Baleh', 'Sapiran'),
(8, 'Aur Birugo Tigo Baleh', 'Birugo'),
(9, 'Guguak Panjang', 'Aur Tajungkang Tengah Sawah'),
(10, 'Guguak Panjang', 'Pakan Kurai'),
(11, 'Guguak Panjang', 'Benteng Pasar Atas'),
(12, 'Guguak Panjang', 'Bukit Apit Puhun'),
(13, 'Guguak Panjang', 'Kayu Kubu'),
(14, 'Guguak Panjang', 'Bukit Cangang Kayu Ramang'),
(15, 'Guguak Panjang', 'Tarok Dipo'),
(16, 'Mandiangin Koto Selayan', 'Campago Ipuh'),
(17, 'Mandiangin Koto Selayan', 'Kubu Gulai Bancah'),
(18, 'Mandiangin Koto Selayan', 'Puhun Pintu Kabun'),
(19, 'Mandiangin Koto Selayan', 'Puhun Tembok'),
(20, 'Mandiangin Koto Selayan', 'Pulai Anak Air'),
(21, 'Mandiangin Koto Selayan', 'Koto Selayan'),
(22, 'Mandiangin Koto Selayan', 'Garegeh'),
(23, 'Mandiangin Koto Selayan', 'Campago Guguk Bulek'),
(24, 'Mandiangin Koto Selayan', 'Manggis Ganting');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tbl_booking`
--
ALTER TABLE `tbl_booking`
  ADD PRIMARY KEY (`kode_booking`);

--
-- Indeks untuk tabel `tbl_bt`
--
ALTER TABLE `tbl_bt`
  ADD PRIMARY KEY (`kode_bt`);

--
-- Indeks untuk tabel `tbl_gambar`
--
ALTER TABLE `tbl_gambar`
  ADD PRIMARY KEY (`kode_gambar`);

--
-- Indeks untuk tabel `tbl_kamar`
--
ALTER TABLE `tbl_kamar`
  ADD PRIMARY KEY (`kode_kamar`);

--
-- Indeks untuk tabel `tbl_koskon`
--
ALTER TABLE `tbl_koskon`
  ADD PRIMARY KEY (`kode_koskon`);

--
-- Indeks untuk tabel `tbl_member`
--
ALTER TABLE `tbl_member`
  ADD PRIMARY KEY (`kode_member`);

--
-- Indeks untuk tabel `tbl_wilayah`
--
ALTER TABLE `tbl_wilayah`
  ADD PRIMARY KEY (`kode_wilayah`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbl_booking`
--
ALTER TABLE `tbl_booking`
  MODIFY `kode_booking` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT untuk tabel `tbl_bt`
--
ALTER TABLE `tbl_bt`
  MODIFY `kode_bt` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `tbl_gambar`
--
ALTER TABLE `tbl_gambar`
  MODIFY `kode_gambar` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT untuk tabel `tbl_kamar`
--
ALTER TABLE `tbl_kamar`
  MODIFY `kode_kamar` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT untuk tabel `tbl_koskon`
--
ALTER TABLE `tbl_koskon`
  MODIFY `kode_koskon` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT untuk tabel `tbl_member`
--
ALTER TABLE `tbl_member`
  MODIFY `kode_member` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `tbl_wilayah`
--
ALTER TABLE `tbl_wilayah`
  MODIFY `kode_wilayah` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
