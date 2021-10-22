-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 28 Des 2019 pada 02.52
-- Versi Server: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pilketos`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_admin`
--

CREATE TABLE `tb_admin` (
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_admin`
--

INSERT INTO `tb_admin` (`username`, `password`) VALUES
('admin', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_datapilketos`
--

CREATE TABLE `tb_datapilketos` (
  `id` int(1) NOT NULL DEFAULT '1',
  `tapel` varchar(10) NOT NULL,
  `tgl` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_datapilketos`
--

INSERT INTO `tb_datapilketos` (`id`, `tapel`, `tgl`) VALUES
(1, '', '0000-00-00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_identitassekolah`
--

CREATE TABLE `tb_identitassekolah` (
  `npsn` varchar(15) NOT NULL,
  `nm_sekolah` varchar(32) NOT NULL,
  `jln` varchar(32) DEFAULT NULL,
  `desa` varchar(32) DEFAULT NULL,
  `kec` varchar(32) DEFAULT NULL,
  `kab` varchar(32) DEFAULT NULL,
  `kpl_sekolah` varchar(32) DEFAULT NULL,
  `nip` varchar(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_identitassekolah`
--

INSERT INTO `tb_identitassekolah` (`npsn`, `nm_sekolah`, `jln`, `desa`, `kec`, `kab`, `kpl_sekolah`, `nip`) VALUES
('1234567', 'SMK Muhammadiyah Marioriwawo', 'Takalala', 'Tettikenrarae', 'Marioriwawo', 'Soppeng', 'Dra.Hj.Syamsiar, M.Si', '33333333333');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kelas`
--

CREATE TABLE `tb_kelas` (
  `kd_kelas` int(3) NOT NULL,
  `nm_kelas` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_kelas`
--

INSERT INTO `tb_kelas` (`kd_kelas`, `nm_kelas`) VALUES
(1, 'X TKJ 1'),
(2, 'X TKJ 2'),
(3, 'X AKUN'),
(4, 'XI TKJ 1'),
(5, 'XI TKJ 2'),
(6, 'XI AKUN'),
(7, 'XII TKJ 1'),
(8, 'XII TKJ 2'),
(9, 'XII AKUN');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pilih`
--

CREATE TABLE `tb_pilih` (
  `id_pilih` int(11) NOT NULL,
  `nisn` varchar(32) NOT NULL,
  `username` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pilihan`
--

CREATE TABLE `tb_pilihan` (
  `nisn` varchar(32) NOT NULL,
  `nama` varchar(32) NOT NULL,
  `photo` varchar(32) NOT NULL,
  `no` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_siswa`
--

CREATE TABLE `tb_siswa` (
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `nm_siswa` varchar(32) DEFAULT NULL,
  `jk` char(1) NOT NULL,
  `kd_kelas` int(3) DEFAULT NULL,
  `hadir` varchar(12) NOT NULL DEFAULT 'Tidak Hadir'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_daftarhadir`
--
CREATE TABLE `view_daftarhadir` (
`NISN` varchar(32)
,`nm_siswa` varchar(32)
,`nm_kelas` varchar(32)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_vote`
--
CREATE TABLE `view_vote` (
`nisn` varchar(32)
,`nama` varchar(32)
,`photo` varchar(32)
,`no` int(1)
,`username` varchar(32)
);

-- --------------------------------------------------------

--
-- Struktur untuk view `view_daftarhadir`
--
DROP TABLE IF EXISTS `view_daftarhadir`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_daftarhadir`  AS  select `tb_siswa`.`username` AS `NISN`,`tb_siswa`.`nm_siswa` AS `nm_siswa`,`tb_kelas`.`nm_kelas` AS `nm_kelas` from ((`tb_siswa` join `tb_kelas` on((`tb_kelas`.`kd_kelas` = `tb_siswa`.`kd_kelas`))) join `tb_pilih` on((`tb_siswa`.`username` = `tb_pilih`.`username`))) ;

-- --------------------------------------------------------

--
-- Struktur untuk view `view_vote`
--
DROP TABLE IF EXISTS `view_vote`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_vote`  AS  select `tb_pilihan`.`nisn` AS `nisn`,`tb_pilihan`.`nama` AS `nama`,`tb_pilihan`.`photo` AS `photo`,`tb_pilihan`.`no` AS `no`,`tb_siswa`.`username` AS `username` from ((`tb_pilih` join `tb_pilihan` on((`tb_pilihan`.`nisn` = `tb_pilih`.`nisn`))) join `tb_siswa` on((`tb_siswa`.`username` = `tb_pilih`.`username`))) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `tb_datapilketos`
--
ALTER TABLE `tb_datapilketos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_identitassekolah`
--
ALTER TABLE `tb_identitassekolah`
  ADD PRIMARY KEY (`npsn`);

--
-- Indexes for table `tb_kelas`
--
ALTER TABLE `tb_kelas`
  ADD PRIMARY KEY (`kd_kelas`);

--
-- Indexes for table `tb_pilih`
--
ALTER TABLE `tb_pilih`
  ADD PRIMARY KEY (`id_pilih`);

--
-- Indexes for table `tb_pilihan`
--
ALTER TABLE `tb_pilihan`
  ADD PRIMARY KEY (`nisn`);

--
-- Indexes for table `tb_siswa`
--
ALTER TABLE `tb_siswa`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_kelas`
--
ALTER TABLE `tb_kelas`
  MODIFY `kd_kelas` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `tb_pilih`
--
ALTER TABLE `tb_pilih`
  MODIFY `id_pilih` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
