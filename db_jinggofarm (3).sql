-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 09, 2018 at 08:37 PM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 5.6.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_jinggofarm`
--

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'operator', 'Operator'),
(3, 'investor', 'Investor');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `token_user`
--

CREATE TABLE `token_user` (
  `id` int(11) NOT NULL,
  `id_users` int(10) UNSIGNED DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `token_user`
--

INSERT INTO `token_user` (`id`, `id_users`, `token`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(8, 6, 'drdwAXFGclY:APA91bGz_sw7rtO13vaawWgLNjGuy0BXASWZmR2oGzd6NCnvuWxcmnhSv28a5E1RujNkx65NNEHNDDB6CFcEaT8OvX0890Vljep1AGUSrvg0uooce1xUPmmtb1pDuB5ONgjYE1t6Ycm9', '2018-05-15 22:50:04', 6, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t_config`
--

CREATE TABLE `t_config` (
  `sdk` longtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_foto_laporan`
--

CREATE TABLE `t_foto_laporan` (
  `id` int(11) NOT NULL,
  `id_laporanternak` int(11) DEFAULT NULL,
  `nama_foto` varchar(250) DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_foto_laporan`
--

INSERT INTO `t_foto_laporan` (`id`, `id_laporanternak`, `nama_foto`, `token`) VALUES
(13, 12, 'LAP_UWEWSGNW_20180402102741.jpeg', '0.4492101236050281'),
(14, 12, 'LAP_ZOKPVRTP_20180402102744.JPG', '0.12817224447383113'),
(15, 13, 'LAP_YYCZPFJI_20180402102835.jpeg', NULL),
(16, 13, 'LAP_NBIGYPDU_20180516095749.png', '0.9954427284574654'),
(17, 13, 'LAP_JNMRSUQB_20180516095818.png', '0.08519343569376137'),
(18, 14, 'LAP_XOELKNXP_20180516095905.png', '0.4504866300913102'),
(19, 15, 'LAP_HRROHQCC_20180516111740.png', NULL),
(20, 15, 'LAP_HBVOZOBU_20180517024330.png', NULL),
(21, 15, 'LAP_VEPQUQXL_20180517024828.png', '0.1515484871152124');

-- --------------------------------------------------------

--
-- Table structure for table `t_foto_ternak`
--

CREATE TABLE `t_foto_ternak` (
  `id` int(11) NOT NULL,
  `id_ternak` int(11) DEFAULT NULL,
  `nama_foto` varchar(250) DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_foto_ternak`
--

INSERT INTO `t_foto_ternak` (`id`, `id_ternak`, `nama_foto`, `token`) VALUES
(41, 11, 'CAT_PSFCHJTC_20180402100047.jpg', '0.707081569231869'),
(42, 11, 'CAT_SWFSCBOL_20180402100100.jpeg', '0.6668593602542987'),
(43, 12, 'CAT_DGFLBIFH_20180402100203.jpeg', '0.13283868982341462'),
(44, 12, 'CAT_PPZBYXMK_20180402100210.jpg', '0.5206977233495793'),
(45, 14, 'CAT_VQFJNPDN_20180402100315.jpg', '0.18512011997517464'),
(47, 15, 'CAT_BHHLUMRR_20180407111622.jpeg', '0.5353804203383075');

-- --------------------------------------------------------

--
-- Table structure for table `t_kandang`
--

CREATE TABLE `t_kandang` (
  `id` int(11) NOT NULL,
  `id_ternak` int(11) DEFAULT NULL,
  `id_kt` int(11) DEFAULT NULL,
  `status` enum('0','1','2','3') DEFAULT NULL COMMENT '0=menunggu investor,1:persiapan ternak,2:masa ternak,3:selesai'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_kategori_pengelola`
--

CREATE TABLE `t_kategori_pengelola` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_kategori_pengelola`
--

INSERT INTO `t_kategori_pengelola` (`id`, `nama`) VALUES
(1, 'Koordinator'),
(2, 'Peternak'),
(3, 'Ketua');

-- --------------------------------------------------------

--
-- Table structure for table `t_kategori_ternak`
--

CREATE TABLE `t_kategori_ternak` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `ketentuan` longtext,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_kategori_ternak`
--

INSERT INTO `t_kategori_ternak` (`id`, `nama`, `ketentuan`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Sapi Perah FH', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t_kelompok_ternak`
--

CREATE TABLE `t_kelompok_ternak` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `deskripsi` longtext,
  `foto` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_kelompok_ternak`
--

INSERT INTO `t_kelompok_ternak` (`id`, `nama`, `alamat`, `deskripsi`, `foto`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Sumber Lumintu', 'Desa Kaligondo, Genteng, Banyuwangi', 'lorem ipsum', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t_laporanternak`
--

CREATE TABLE `t_laporanternak` (
  `id` int(11) NOT NULL,
  `id_ternak` int(11) DEFAULT NULL,
  `jenis_laporan` enum('0','1','2') DEFAULT NULL COMMENT '0:perkembangaan, 1:dana, 2:penjualan hasil',
  `deskripsi` varchar(255) DEFAULT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_laporanternak`
--

INSERT INTO `t_laporanternak` (`id`, `id_ternak`, `jenis_laporan`, `deskripsi`, `foto`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(12, 12, '0', 'kondisi ternak sehat', NULL, '2018-04-02 10:27:47', 1, NULL, NULL),
(13, 11, '0', 'ternaknya sehat pak', NULL, '2018-05-16 21:58:24', 1, NULL, NULL),
(14, 11, '0', 'Ternaknya dalam kondisi baik', NULL, '2018-05-16 21:59:08', 1, NULL, NULL),
(15, 11, '0', 'lorem ipsum', NULL, '2018-05-17 02:54:44', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t_lap_keuangan`
--

CREATE TABLE `t_lap_keuangan` (
  `id` int(11) NOT NULL,
  `id_ternak` int(11) DEFAULT NULL,
  `jenis` enum('0','1') DEFAULT NULL COMMENT '0:penjualan, 1:penggunaan dana',
  `deskripsi` varchar(255) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `foto` varchar(50) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_lap_keuangan`
--

INSERT INTO `t_lap_keuangan` (`id`, `id_ternak`, `jenis`, `deskripsi`, `jumlah`, `foto`, `tanggal`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(4, 12, '0', 'penjualan susu 30 liter', 60000, NULL, '2018-04-02', '2018-04-02 10:28:35', 1, NULL, NULL),
(5, 12, '0', 'lorem', 60000, NULL, '2018-04-02', '2018-04-02 10:55:51', 1, NULL, NULL),
(6, 12, '0', 'lorem', 60000, NULL, '2018-04-04', '2018-04-04 06:30:37', 1, NULL, NULL),
(7, 12, '0', 'lorem', 40000, NULL, '2018-04-24', '2018-04-24 07:30:43', 1, NULL, NULL),
(8, 11, '0', 'Hasil penjualan susu', 30000, NULL, '2018-05-17', '2018-05-16 23:17:40', 1, NULL, NULL),
(9, 11, '0', 'test', 35000, NULL, '2018-05-17', '2018-05-17 02:43:30', 1, NULL, NULL),
(10, 11, '0', 'lorem', 20000, NULL, '2018-05-17', '2018-05-17 02:45:56', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t_pemilik_ternak`
--

CREATE TABLE `t_pemilik_ternak` (
  `id` int(11) NOT NULL,
  `id_ternak` int(11) DEFAULT NULL,
  `id_user` int(11) UNSIGNED DEFAULT NULL,
  `jumlah` int(11) UNSIGNED DEFAULT NULL,
  `status` enum('0','1') DEFAULT '0' COMMENT '0:aktif, 1:tidak aktif',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) UNSIGNED DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_pemilik_ternak`
--

INSERT INTO `t_pemilik_ternak` (`id`, `id_ternak`, `id_user`, `jumlah`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(15, 12, 6, 2, '0', '2018-04-02 10:19:57', 1, NULL, NULL),
(16, 12, 12, 2, '0', '2018-04-02 10:24:23', 1, NULL, NULL),
(17, 15, 13, 1, '0', '2018-04-24 07:22:26', 1, NULL, NULL),
(18, 11, 37, 1, '0', '2018-05-16 21:50:06', 1, NULL, NULL),
(19, 11, 6, 1, '0', '2018-05-16 21:55:56', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t_perkiraan`
--

CREATE TABLE `t_perkiraan` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `keterangan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_perkiraan`
--

INSERT INTO `t_perkiraan` (`id`, `nama`, `jumlah`, `keterangan`) VALUES
(1, 'Susu', 16800000, 'per hari selama 4 tahun'),
(2, 'Anak', 0, '3 ekor anak'),
(3, 'Daging', 18000000, 'Akhir periode ternak');

-- --------------------------------------------------------

--
-- Table structure for table `t_peternak`
--

CREATE TABLE `t_peternak` (
  `id` int(11) NOT NULL,
  `id_kt` int(11) DEFAULT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `alamat` varchar(50) DEFAULT NULL,
  `umur` tinyint(2) DEFAULT NULL,
  `lama_pengalaman` tinyint(4) DEFAULT NULL,
  `foto` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_peternak`
--

INSERT INTO `t_peternak` (`id`, `id_kt`, `id_kategori`, `nama`, `alamat`, `umur`, `lama_pengalaman`, `foto`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 1, 2, 'Lukman', NULL, 50, 10, 'CAT_VDIHLZRG_20180517021448.png', '2018-02-07 10:38:17', 1, '2018-05-17 02:14:48', 1),
(2, 1, 2, 'Hendriyanto', NULL, 12, 12, 'CAT_WLCQFKSH_20180517021459.png', '2018-03-16 09:43:41', 1, '2018-05-17 02:14:59', 1),
(3, NULL, 3, 'Toton Fathoni', NULL, 25, 10, 'CAT_TFBMCJJM_20180517021522.png', '2018-05-06 20:32:01', 1, '2018-05-17 02:15:22', 1);

-- --------------------------------------------------------

--
-- Table structure for table `t_rekening`
--

CREATE TABLE `t_rekening` (
  `id` int(11) NOT NULL,
  `id_user` int(11) UNSIGNED DEFAULT NULL,
  `nama_rek` varchar(50) DEFAULT NULL,
  `no_rek` varchar(50) DEFAULT NULL,
  `nama_bank` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_saldo_investor`
--

CREATE TABLE `t_saldo_investor` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED DEFAULT NULL,
  `id_lap_keuangan` int(10) DEFAULT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `nominal` int(11) DEFAULT NULL,
  `status` enum('0','1','2') NOT NULL DEFAULT '0',
  `periode` enum('1','2','3','4') NOT NULL DEFAULT '1',
  `status_ambil` enum('0','1') NOT NULL DEFAULT '0',
  `status_tarik` enum('0','1','2','3') NOT NULL DEFAULT '0' COMMENT '0: tdk ditarik. 1: request tarik, 2:konfirmasi transfer',
  `status_terima` enum('0','1') NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_saldo_investor`
--

INSERT INTO `t_saldo_investor` (`id`, `id_user`, `id_lap_keuangan`, `deskripsi`, `nominal`, `status`, `periode`, `status_ambil`, `status_tarik`, `status_terima`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(7, 6, 4, 'penjualan susu 30 liter', 18000, '0', '1', '1', '0', '0', '2018-04-02 10:28:35', 1, '2019-05-17 02:04:05', 6),
(8, 12, 4, 'penjualan susu 30 liter', 18000, '0', '1', '1', '0', '0', '2018-04-02 10:28:35', 1, '2019-05-17 02:04:05', 6),
(9, 6, 5, 'lorem', 18000, '0', '1', '1', '0', '0', '2018-04-02 10:55:51', 1, '2019-05-17 02:04:05', 6),
(10, 12, 5, 'lorem', 18000, '0', '1', '1', '0', '0', '2018-04-02 10:55:51', 1, '2019-05-17 02:04:05', 6),
(12, 6, NULL, 'Penarikan Saldo', 1000, '1', '1', '0', '1', '1', '2018-04-04 04:34:55', 6, '2018-05-06 19:09:37', 1),
(13, 6, NULL, 'Penarikan Saldo', 2000, '1', '1', '0', '1', '1', '2018-04-04 06:09:21', 6, '2018-05-06 19:08:35', 1),
(14, 6, NULL, 'Penarikan Saldo', 3000, '1', '1', '0', '1', '1', '2018-04-04 06:27:27', 6, '2018-04-06 08:22:25', 1),
(15, 6, 6, 'lorem', 18000, '0', '1', '1', '0', '0', '2018-04-04 06:30:37', 1, '2019-05-17 02:04:05', 6),
(16, 12, 6, 'lorem', 18000, '0', '1', '1', '0', '0', '2018-04-04 06:30:37', 1, '2019-05-17 02:04:05', 6),
(17, 6, NULL, 'Penarikan Saldo', 2000, '1', '1', '0', '1', '1', '2018-04-04 09:41:56', 6, '2018-05-06 19:20:45', 1),
(18, 6, 7, 'lorem', 12000, '0', '1', '1', '0', '0', '2018-04-24 07:30:44', 1, '2019-05-17 02:04:05', 6),
(19, 12, 7, 'lorem', 12000, '0', '1', '1', '0', '0', '2018-04-24 07:30:44', 1, '2019-05-17 02:04:05', 6),
(20, 37, 8, 'Hasil penjualan susu', 9000, '0', '1', '1', '0', '0', '2018-05-16 23:17:40', 1, '2019-05-17 02:04:05', 6),
(21, 6, 8, 'Hasil penjualan susu', 9000, '0', '1', '1', '0', '0', '2018-05-16 23:17:40', 1, '2019-05-17 02:04:05', 6),
(22, 37, 9, 'test', 10500, '0', '1', '0', '0', '0', '2018-05-17 02:43:30', 1, NULL, NULL),
(23, 6, 9, 'test', 10500, '0', '1', '0', '0', '0', '2018-05-17 02:43:30', 1, NULL, NULL),
(24, 37, 10, 'lorem', 6000, '0', '1', '0', '0', '0', '2018-05-17 02:45:56', 1, NULL, NULL),
(25, 6, 10, 'lorem', 6000, '0', '1', '0', '0', '0', '2018-05-17 02:45:56', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t_saldo_kt`
--

CREATE TABLE `t_saldo_kt` (
  `id` int(11) NOT NULL,
  `id_kt` int(11) NOT NULL DEFAULT '1',
  `id_lap_keuangan` int(11) NOT NULL DEFAULT '1',
  `deskripsi` varchar(150) DEFAULT NULL,
  `nominal` int(11) DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_saldo_kt`
--

INSERT INTO `t_saldo_kt` (`id`, `id_kt`, `id_lap_keuangan`, `deskripsi`, `nominal`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(3, 1, 4, 'penjualan susu 30 liter', 18000, '0', '2018-04-02 10:28:35', 1, NULL, NULL),
(4, 1, 5, 'lorem', 18000, '0', '2018-04-02 10:55:51', 1, NULL, NULL),
(5, 1, 6, 'lorem', 18000, '0', '2012-06-04 06:30:37', 1, NULL, NULL),
(6, 1, 7, 'lorem', 12000, '0', '2018-04-24 07:30:44', 1, NULL, NULL),
(7, 1, 8, 'Hasil penjualan susu', 9000, '0', '2018-05-16 23:17:40', 1, NULL, NULL),
(8, 1, 9, 'test', 10500, '0', '2018-05-17 02:43:30', 1, NULL, NULL),
(9, 1, 10, 'lorem', 6000, '0', '2018-05-17 02:45:56', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t_ternak`
--

CREATE TABLE `t_ternak` (
  `id` int(11) NOT NULL,
  `id_kt` int(11) NOT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `kode_ternak` varchar(10) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `slug` varchar(100) DEFAULT NULL,
  `deskripsi` longtext,
  `biaya` int(11) DEFAULT NULL COMMENT 'biaya per unit',
  `jumlah_sapi` int(11) DEFAULT NULL,
  `jumlah_unit` tinyint(4) DEFAULT NULL,
  `sisa_unit` tinyint(4) DEFAULT NULL,
  `lama_periode` tinyint(3) UNSIGNED DEFAULT NULL,
  `bghasil_peternak` tinyint(2) DEFAULT NULL,
  `bghasil_investor` tinyint(2) DEFAULT NULL,
  `ekspektasi_profit_min` tinyint(2) UNSIGNED DEFAULT NULL,
  `ekspektasi_profit_max` tinyint(2) UNSIGNED DEFAULT NULL,
  `biaya_operasional` int(10) DEFAULT NULL,
  `file` varchar(100) DEFAULT NULL,
  `foto` varchar(50) DEFAULT NULL,
  `status` enum('0','1','2','3','4') DEFAULT '0' COMMENT '0: cari investor, 1: dapat investor / persiapan ternak, 2:masa ternak. 3: ternak selesai',
  `tanggal_ternak` date DEFAULT NULL,
  `batas_periode` date DEFAULT NULL,
  `keterangan` varchar(200) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_ternak`
--

INSERT INTO `t_ternak` (`id`, `id_kt`, `id_kategori`, `kode_ternak`, `nama`, `slug`, `deskripsi`, `biaya`, `jumlah_sapi`, `jumlah_unit`, `sisa_unit`, `lama_periode`, `bghasil_peternak`, `bghasil_investor`, `ekspektasi_profit_min`, `ekspektasi_profit_max`, `biaya_operasional`, `file`, `foto`, `status`, `tanggal_ternak`, `batas_periode`, `keterangan`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(11, 1, 1, 'TK-001', 'Nama Ternak', 'nama-ternak-2', 'Sapi menjadi salah satu jenis hewan yang banyak diternakan oleh masyarakat Indonesia. Hewan berkaki empat ini mendatangkan keuntungan dengan nilai yang fantastis. Sapi memang banyak diternakan untuk diambil daging dan susunya. Jenis sapi perah memang menjadi salah satu jenis sapi yang banyak dibudidayakan oleh masyarakat kita. Sapi perah merupakan jenis sapi yang kini banyak dikembangkan di Indonesia. Sapi perah ini menghasilkan susu sapi yang banyak bermanfaat dalam berbagai kebutuhan. Banyak pabrik susu yang membutuhkan bahan ini dalam jumlah yang besar. Susu sediri menjadi salah satu bahan yang dibutuhkan masyarakat untuk konsumsi sehari-hari. Dimana susu ini bermanfaat baik pertumbuhan balita hingga manula. Tak heran jika permintaan susu sapi di  pasaran terbilang tinggi. Hal inipun membuka peluang usaha budidaya sapi perah yang menguntungkan. Budidaya sapi perah sendiri memang bukan jenis bisnis baru, sudah lama banyak orang yang berkecinampungan di dalamnya. Ini karena keuntungan dari bisnis budidaya sapi perah memang tak main-main. Mungkin Anda berminat menjalankan bisnis budidaya sapi perah? Jika Anda berminat menjalankan bisnis budidaya sapi perah tentu akan sangat menguntungkan. Memanag modal yang diperlukan dalam bisnis budidaya sapi perah tergolong besar. Namun keuntungan yang didapatkan dari bisnis budidaya sapi perah ini memang besar pula. Tunggu apalagi jika Anda memiliki modal yang besar maka Anda bisa memilih bisnis ini.', 26000000, 1, 2, 0, 4, 60, 40, 20, 40, 30000, NULL, NULL, '2', '2018-05-16', '2022-05-16', 'Untuk berinvestasi 1 ekor sapi perah, investasilah dengan jumlah 2 paket', '2018-04-02 10:01:11', 1, '2018-05-21 03:36:55', 1),
(12, 1, 1, 'TK-002', 'nama ternak', 'nama-ternak', 'Sapi menjadi salah satu jenis hewan yang banyak diternakan oleh masyarakat Indonesia. Hewan berkaki empat ini mendatangkan keuntungan dengan nilai yang fantastis. Sapi memang banyak diternakan untuk diambil daging dan susunya. Jenis sapi perah memang menjadi salah satu jenis sapi yang banyak dibudidayakan oleh masyarakat kita. Sapi perah merupakan jenis sapi yang kini banyak dikembangkan di Indonesia. Sapi perah ini menghasilkan susu sapi yang banyak bermanfaat dalam berbagai kebutuhan. Banyak pabrik susu yang membutuhkan bahan ini dalam jumlah yang besar. Susu sediri menjadi salah satu bahan yang dibutuhkan masyarakat untuk konsumsi sehari-hari. Dimana susu ini bermanfaat baik pertumbuhan balita hingga manula. Tak heran jika permintaan susu sapi di  pasaran terbilang tinggi. Hal inipun membuka peluang usaha budidaya sapi perah yang menguntungkan. Budidaya sapi perah sendiri memang bukan jenis bisnis baru, sudah lama banyak orang yang berkecinampungan di dalamnya. Ini karena keuntungan dari bisnis budidaya sapi perah memang tak main-main. Mungkin Anda berminat menjalankan bisnis budidaya sapi perah? Jika Anda berminat menjalankan bisnis budidaya sapi perah tentu akan sangat menguntungkan. Memanag modal yang diperlukan dalam bisnis budidaya sapi perah tergolong besar. Namun keuntungan yang didapatkan dari bisnis budidaya sapi perah ini memang besar pula. Tunggu apalagi jika Anda memiliki modal yang besar maka Anda bisa memilih bisnis ini.', 52000000, 2, 4, 0, 4, 60, 40, 10, 10, 60000, NULL, NULL, '2', '2018-04-02', '2022-04-02', 'Untuk melakukan investasi 1 ekor sapi perah, berinvestasilah dengan jumlah 2 paket', '2018-04-02 10:02:20', 1, '2018-06-04 08:42:07', 1),
(14, 1, 1, 'TK-003', 'nama ternak', 'nama-ternak-1', 'Sapi menjadi salah satu jenis hewan yang banyak diternakan oleh masyarakat Indonesia. Hewan berkaki empat ini mendatangkan keuntungan dengan nilai yang fantastis. Sapi memang banyak diternakan untuk diambil daging dan susunya. Jenis sapi perah memang menjadi salah satu jenis sapi yang banyak dibudidayakan oleh masyarakat kita. Sapi perah merupakan jenis sapi yang kini banyak dikembangkan di Indonesia. Sapi perah ini menghasilkan susu sapi yang banyak bermanfaat dalam berbagai kebutuhan. Banyak pabrik susu yang membutuhkan bahan ini dalam jumlah yang besar. Susu sediri menjadi salah satu bahan yang dibutuhkan masyarakat untuk konsumsi sehari-hari. Dimana susu ini bermanfaat baik pertumbuhan balita hingga manula. Tak heran jika permintaan susu sapi di  pasaran terbilang tinggi. Hal inipun membuka peluang usaha budidaya sapi perah yang menguntungkan. Budidaya sapi perah sendiri memang bukan jenis bisnis baru, sudah lama banyak orang yang berkecinampungan di dalamnya. Ini karena keuntungan dari bisnis budidaya sapi perah memang tak main-main. Mungkin Anda berminat menjalankan bisnis budidaya sapi perah? Jika Anda berminat menjalankan bisnis budidaya sapi perah tentu akan sangat menguntungkan. Memanag modal yang diperlukan dalam bisnis budidaya sapi perah tergolong besar. Namun keuntungan yang didapatkan dari bisnis budidaya sapi perah ini memang besar pula. Tunggu apalagi jika Anda memiliki modal yang besar maka Anda bisa memilih bisnis ini.', 26000000, 1, 1, 1, 4, 60, 40, 30, 50, 30000, NULL, NULL, '0', NULL, NULL, 'Bila ingin berinvestasi 1 ekor sapi perah, berinvestasilah dengan jumlah 1 paket', '2018-04-02 10:05:00', 1, '2018-06-04 08:43:35', 1),
(15, 1, 1, 'TK-004', 'nama ternak', 'nama-ternak-4', 'Sapi menjadi salah satu jenis hewan yang banyak diternakan oleh masyarakat Indonesia. Hewan berkaki empat ini mendatangkan keuntungan dengan nilai yang fantastis. Sapi memang banyak diternakan untuk diambil daging dan susunya. Jenis sapi perah memang menjadi salah satu jenis sapi yang banyak dibudidayakan oleh masyarakat kita. Sapi perah merupakan jenis sapi yang kini banyak dikembangkan di Indonesia. Sapi perah ini menghasilkan susu sapi yang banyak bermanfaat dalam berbagai kebutuhan. Banyak pabrik susu yang membutuhkan bahan ini dalam jumlah yang besar. Susu sediri menjadi salah satu bahan yang dibutuhkan masyarakat untuk konsumsi sehari-hari. Dimana susu ini bermanfaat baik pertumbuhan balita hingga manula. Tak heran jika permintaan susu sapi di pasaran terbilang tinggi. Hal inipun membuka peluang usaha budidaya sapi perah yang menguntungkan. Budidaya sapi perah sendiri memang bukan jenis bisnis baru, sudah lama banyak orang yang berkecinampungan di dalamnya. Ini karena keuntungan dari bisnis budidaya sapi perah memang tak main-main. Mungkin Anda berminat menjalankan bisnis budidaya sapi perah? Jika Anda berminat menjalankan bisnis budidaya sapi perah tentu akan sangat menguntungkan. Memanag modal yang diperlukan dalam bisnis budidaya sapi perah tergolong besar. Namun keuntungan yang didapatkan dari bisnis budidaya sapi perah ini memang besar pula. Tunggu apalagi jika Anda memiliki modal yang besar maka Anda bisa memilih bisnis ini.', 78000000, 3, 6, 5, 4, 60, 40, 20, 20, 90000, NULL, NULL, '0', NULL, NULL, NULL, '2018-04-07 11:16:48', 1, '2018-05-06 19:52:14', 1);

-- --------------------------------------------------------

--
-- Table structure for table `t_transaksi`
--

CREATE TABLE `t_transaksi` (
  `id` int(11) NOT NULL,
  `id_user` int(10) UNSIGNED DEFAULT NULL,
  `id_ternak` int(11) DEFAULT NULL,
  `kode_transaksi` varchar(10) DEFAULT NULL,
  `nama_transfer` varchar(50) DEFAULT NULL,
  `bukti_transfer` varchar(50) DEFAULT NULL,
  `unit` tinyint(4) DEFAULT NULL COMMENT 'jumlah unit',
  `total` int(11) DEFAULT NULL,
  `batas_bayar` datetime DEFAULT NULL,
  `status` enum('0','1','2','3','4','5') NOT NULL DEFAULT '0' COMMENT '0=belum konfirmasi, 1:bukti dikirim tapi belum validasi,2: gagal transaction, 3 = bukti valid, 4 = Bukti tidak valid',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_transaksi`
--

INSERT INTO `t_transaksi` (`id`, `id_user`, `id_ternak`, `kode_transaksi`, `nama_transfer`, `bukti_transfer`, `unit`, `total`, `batas_bayar`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(31, 6, 12, 'TR-001', 'Rahmat Ramadhan', 'TF_TTTLMFWT_20180402101920.jpg', 2, 26000000, '2018-04-02 16:13:27', '3', '2018-04-02 15:13:27', 6, '2018-04-02 10:19:56', 1),
(32, 12, 12, 'TR-002', 'Rahmat Ramadhan', 'TF_ZNWQKNUS_20180402102409.jpeg', 2, 26000000, '2018-04-02 16:23:51', '3', '2018-04-02 15:23:51', 12, '2018-04-02 10:24:23', 1),
(33, 14, 15, 'TR-003', NULL, NULL, 1, 13000000, '2018-04-07 17:20:50', '2', '2018-04-07 16:20:50', 14, '2018-04-08 02:20:56', NULL),
(34, 6, 15, 'TR-004', NULL, NULL, 1, 13000000, '2018-04-07 21:41:35', '2', '2018-04-07 20:41:35', 6, '2018-04-08 14:58:08', 6),
(35, 6, 11, 'TR-005', NULL, NULL, 2, 26000000, '2018-04-21 15:35:27', '2', '2018-04-21 14:37:27', 6, '2018-04-21 15:37:11', 6),
(36, 13, 15, 'TR-006', 'Toton fathoni', 'TF_DSIWCABX_20180424072200.jpg', 1, 13000000, '2018-04-24 13:16:52', '3', '2018-04-24 12:18:52', 13, '2018-04-24 07:22:26', 1),
(37, 6, 11, 'TR-007', NULL, NULL, 1, 13000000, '2018-04-24 13:22:27', '2', '2018-04-24 12:24:27', 6, '2018-06-03 16:23:04', 6),
(38, 29, 14, 'TR-008', NULL, NULL, 1, 26000000, '2018-05-01 12:06:10', '2', '2018-05-01 11:08:10', 29, '2018-05-01 06:08:28', 29),
(39, 37, 11, 'TR-009', 'Rahmat Ramadhan', 'TF_HXKXSWHX_20180516094415.png', 1, 13000000, '2018-05-17 03:41:45', '3', '2018-05-17 02:43:45', 37, '2018-05-16 21:50:05', 1),
(40, 6, 11, 'TR-010', 'Rahmat Ramadhan', 'TF_BEVCTUHB_20180516095537.png', 1, 13000000, '2018-05-17 03:53:23', '3', '2018-05-17 02:55:23', 6, '2018-05-16 21:55:56', 1),
(41, 41, 15, 'TR-011', NULL, NULL, 2, 26000000, '2018-05-24 13:39:12', '2', '2018-05-24 12:41:12', 41, '2018-06-04 19:27:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) NOT NULL,
  `email` varchar(254) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `activate_akun` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ip_address`, `group_id`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `created_at`, `created_by`, `updated_at`, `updated_by`, `last_login`, `active`, `activate_akun`, `first_name`, `last_name`, `company`, `phone`) VALUES
(1, '::1', 1, 'admin', '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36', '', 'admin@admin.com', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '2018-04-23 19:40:44', 1, 1528094392, 1, 0, 'Admin', 'Istrator', 'Admin', NULL),
(6, '::1', 3, 'rahmat', '$2y$10$TuyvO5gny00wXunG5KkQ9efZHBC3AU2qoWPxDz8cvL1JQZdGcb31q', '', 'rahmat@rahmat.com', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '2018-04-24 07:25:06', 6, 1528094808, 1, 0, 'Rahmat Ramadhan Putra', 'Ramadhan', NULL, '082146631959'),
(12, '::1', 3, NULL, '$2y$08$mpPHoEFM7MTGvBam5Lhb0OLGq4NXBrWWuX7uJ0haN3RZd1AI8Iz0K', '', 'messi@messi.com', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '2018-04-23 20:03:34', 12, 1524506592, 1, 0, 'Lionel Messi', NULL, NULL, '08573526745'),
(13, '192.168.137.9', 3, NULL, '$2y$08$zLsL2ZxgzWC7TcQk/FCOe.I0JZgIn5kxjjZPMhjykja5QE3eTwgzG', '', 'omahngedotz@yahoo.com', 'b73efffded1f78eb4734a40ef759adeea6fce207', NULL, NULL, NULL, '0000-00-00 00:00:00', '2018-04-24 12:06:40', 0, '0000-00-00 00:00:00', 0, 1524547132, 1, 0, 'Toton', NULL, NULL, '082234831992'),
(23, '::1', 3, NULL, '$2y$08$VHi9A3gXSXV2wl/CCw844.2rrnj2WFH.qMBQNAsmNU3TsPEChVSmu', '', 'rahmatramadhan.ti.poliwangi@gmail.com', NULL, 'J44TwOuozLNnGi-vD-uEJu6c4fcbfdd1cabda6f3', 1528009008, NULL, '0000-00-00 00:00:00', '2018-04-27 17:12:34', 0, '0000-00-00 00:00:00', 0, NULL, 1, 0, 'Rahmat Ramadhan Putra', NULL, NULL, '85735030674'),
(33, '::1', 3, NULL, '$2y$08$Gcnlx1hj2WeGC9c0Hmqy9.BOkAFtQ1oPzrEkjpU2oBvsbJ7A4o.Eu', '', 'rahmatrputra@gmail.com', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '2018-05-01 11:40:40', 0, '0000-00-00 00:00:00', 0, 1525149727, 1, 1, 'Rahmat', NULL, NULL, '85735030674'),
(37, '::1', 3, NULL, '$2y$08$ZG8iRYrTz7Xe76yxuAnsqOxrEEEzdzsj9nTjlaOHwvuxjvbhJX8Vu', '', 'sumantoshop101@gmail.com', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '2018-05-17 02:42:58', 0, '0000-00-00 00:00:00', 0, 1558050535, 1, 1, 'Sisillia Tri C.', NULL, NULL, '85735030674'),
(39, '::1', 3, NULL, '$2y$08$3gY5gtn/HVh7O766ph9K7.Fs/HyRViejm96cOUrMMYQtiZluZCDoG', '', 'rahmat@labkode.org', 'e3aa1c152596849271ead729a55481785671afcf', 'jQSk2fwre62TZKUGHd8Swebf74e2928a1826bef3', 1528056497, NULL, '0000-00-00 00:00:00', '2018-05-21 03:18:30', 0, '0000-00-00 00:00:00', 0, 1528014145, 1, 0, 'Rahmat', NULL, NULL, '85735030674'),
(41, '::1', 3, NULL, '$2y$08$Q.vl7Cvt3PiivZt8/CWKsOP6gwufX3mWj6gnrEW5uNcGtLA2wWDnC', '', 'akufarisqi@gmail.com', '985d9ec634b2d404a26556bf230cf69aaf413c40', NULL, NULL, NULL, '0000-00-00 00:00:00', '2018-05-24 12:37:27', 0, '0000-00-00 00:00:00', 0, 1527140296, 1, 0, 'farizqi panduardi', NULL, NULL, '082244680800'),
(43, '::1', 3, NULL, '$2y$08$HzOw5aGG51JPQTn9XajLZ.O7t3hisg7KPV0wpDMQ7nF5Na5B87cle', '', 'angon.team@gmail.com', '80f9bf1ef5fba13d3690d823b5c4db381ceaef86', NULL, NULL, NULL, '0000-00-00 00:00:00', '2018-06-03 14:33:11', 0, '0000-00-00 00:00:00', 0, NULL, 1, 0, 'Rahmat', NULL, NULL, '85735030674');

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE `users_groups` (
  `id` mediumint(9) NOT NULL,
  `name` varchar(10) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'operator', 'Operator'),
(3, 'investor', 'Investor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `token_user`
--
ALTER TABLE `token_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK__users` (`id_users`);

--
-- Indexes for table `t_foto_laporan`
--
ALTER TABLE `t_foto_laporan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_foto_ternak`
--
ALTER TABLE `t_foto_ternak`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_kandang`
--
ALTER TABLE `t_kandang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_t_kandang_t_ternak` (`id_ternak`),
  ADD KEY `FK_t_kandang_t_kelompok_ternak` (`id_kt`);

--
-- Indexes for table `t_kategori_pengelola`
--
ALTER TABLE `t_kategori_pengelola`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_kategori_ternak`
--
ALTER TABLE `t_kategori_ternak`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_kelompok_ternak`
--
ALTER TABLE `t_kelompok_ternak`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_laporanternak`
--
ALTER TABLE `t_laporanternak`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_t_laporanternak_t_ternak` (`id_ternak`);

--
-- Indexes for table `t_lap_keuangan`
--
ALTER TABLE `t_lap_keuangan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_t_keuntungan_t_ternak` (`id_ternak`);

--
-- Indexes for table `t_pemilik_ternak`
--
ALTER TABLE `t_pemilik_ternak`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_t_pemilik_ternak_t_ternak` (`id_ternak`),
  ADD KEY `FK_t_pemilik_ternak_users` (`id_user`);

--
-- Indexes for table `t_perkiraan`
--
ALTER TABLE `t_perkiraan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_peternak`
--
ALTER TABLE `t_peternak`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_t_peternak_t_kelompok_ternak` (`id_kt`),
  ADD KEY `FK_t_peternak_t_kategori_pengelola` (`id_kategori`);

--
-- Indexes for table `t_rekening`
--
ALTER TABLE `t_rekening`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_t_rekening_users` (`id_user`);

--
-- Indexes for table `t_saldo_investor`
--
ALTER TABLE `t_saldo_investor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_t_saldo_u_users` (`id_user`);

--
-- Indexes for table `t_saldo_kt`
--
ALTER TABLE `t_saldo_kt`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_ternak`
--
ALTER TABLE `t_ternak`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_t_ternak_t_kelompok_ternak` (`id_kt`),
  ADD KEY `FK_t_ternak_t_kategori_ternak` (`id_kategori`);

--
-- Indexes for table `t_transaksi`
--
ALTER TABLE `t_transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK__users` (`id_user`),
  ADD KEY `FK__t_ternak` (`id_ternak`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_users_groups` (`group_id`);

--
-- Indexes for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `token_user`
--
ALTER TABLE `token_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `t_foto_laporan`
--
ALTER TABLE `t_foto_laporan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `t_foto_ternak`
--
ALTER TABLE `t_foto_ternak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `t_kandang`
--
ALTER TABLE `t_kandang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_kategori_pengelola`
--
ALTER TABLE `t_kategori_pengelola`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `t_kategori_ternak`
--
ALTER TABLE `t_kategori_ternak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `t_kelompok_ternak`
--
ALTER TABLE `t_kelompok_ternak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `t_laporanternak`
--
ALTER TABLE `t_laporanternak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `t_lap_keuangan`
--
ALTER TABLE `t_lap_keuangan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `t_pemilik_ternak`
--
ALTER TABLE `t_pemilik_ternak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `t_perkiraan`
--
ALTER TABLE `t_perkiraan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `t_peternak`
--
ALTER TABLE `t_peternak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `t_rekening`
--
ALTER TABLE `t_rekening`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_saldo_investor`
--
ALTER TABLE `t_saldo_investor`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `t_saldo_kt`
--
ALTER TABLE `t_saldo_kt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `t_ternak`
--
ALTER TABLE `t_ternak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `t_transaksi`
--
ALTER TABLE `t_transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `t_kandang`
--
ALTER TABLE `t_kandang`
  ADD CONSTRAINT `FK_t_kandang_t_kelompok_ternak` FOREIGN KEY (`id_kt`) REFERENCES `t_kelompok_ternak` (`id`),
  ADD CONSTRAINT `FK_t_kandang_t_ternak` FOREIGN KEY (`id_ternak`) REFERENCES `t_ternak` (`id`);

--
-- Constraints for table `t_laporanternak`
--
ALTER TABLE `t_laporanternak`
  ADD CONSTRAINT `FK_t_laporanternak_t_ternak` FOREIGN KEY (`id_ternak`) REFERENCES `t_ternak` (`id`);

--
-- Constraints for table `t_lap_keuangan`
--
ALTER TABLE `t_lap_keuangan`
  ADD CONSTRAINT `FK_t_keuntungan_t_ternak` FOREIGN KEY (`id_ternak`) REFERENCES `t_ternak` (`id`);

--
-- Constraints for table `t_pemilik_ternak`
--
ALTER TABLE `t_pemilik_ternak`
  ADD CONSTRAINT `FK_t_pemilik_ternak_t_ternak` FOREIGN KEY (`id_ternak`) REFERENCES `t_ternak` (`id`),
  ADD CONSTRAINT `FK_t_pemilik_ternak_users` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `t_peternak`
--
ALTER TABLE `t_peternak`
  ADD CONSTRAINT `FK_t_peternak_t_kategori_pengelola` FOREIGN KEY (`id_kategori`) REFERENCES `t_kategori_pengelola` (`id`),
  ADD CONSTRAINT `FK_t_peternak_t_kelompok_ternak` FOREIGN KEY (`id_kt`) REFERENCES `t_kelompok_ternak` (`id`);

--
-- Constraints for table `t_rekening`
--
ALTER TABLE `t_rekening`
  ADD CONSTRAINT `FK_t_rekening_users` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `t_saldo_investor`
--
ALTER TABLE `t_saldo_investor`
  ADD CONSTRAINT `FK_t_saldo_u_users` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `t_ternak`
--
ALTER TABLE `t_ternak`
  ADD CONSTRAINT `FK_t_ternak_t_kategori_ternak` FOREIGN KEY (`id_kategori`) REFERENCES `t_kategori_ternak` (`id`),
  ADD CONSTRAINT `FK_t_ternak_t_kelompok_ternak` FOREIGN KEY (`id_kt`) REFERENCES `t_kelompok_ternak` (`id`);

--
-- Constraints for table `t_transaksi`
--
ALTER TABLE `t_transaksi`
  ADD CONSTRAINT `FK__t_ternak` FOREIGN KEY (`id_ternak`) REFERENCES `t_ternak` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
