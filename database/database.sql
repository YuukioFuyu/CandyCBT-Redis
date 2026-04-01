-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 10 Mar 2026 pada 16.46
-- Versi server: 10.4.17-MariaDB
-- Versi PHP: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ruang1_smksa`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi`
--

CREATE TABLE `absensi` (
  `absId` int(11) NOT NULL COMMENT 'id absen',
  `absIdSiswa` int(11) DEFAULT NULL COMMENT 'id siswa',
  `absIdKelas` int(11) DEFAULT NULL COMMENT 'id kelas',
  `absTgl` date DEFAULT NULL COMMENT 'tanggal absen',
  `absJamIn` time DEFAULT NULL COMMENT 'jam masuk',
  `absJamOut` time DEFAULT NULL COMMENT 'jam keluar',
  `absStatus` varchar(5) DEFAULT NULL COMMENT 'H,T,S,I,B',
  `absJenis` int(1) DEFAULT 1,
  `absFoto` varchar(255) DEFAULT NULL,
  `absUrlFoto` varchar(255) DEFAULT NULL,
  `absCreated` timestamp NULL DEFAULT current_timestamp(),
  `absKeterangan` text DEFAULT NULL COMMENT 'Keterangan',
  `absKeterangan2` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi_mapel`
--

CREATE TABLE `absensi_mapel` (
  `amId` int(11) NOT NULL COMMENT 'id absen mapel',
  `amKode` varchar(10) DEFAULT NULL,
  `amKelas` int(11) DEFAULT NULL COMMENT 'id kelas',
  `amIdMapel` int(11) DEFAULT NULL COMMENT 'id mapel',
  `amIdGuru` int(11) DEFAULT NULL COMMENT 'id guru',
  `amNamaMapel` varchar(100) DEFAULT NULL COMMENT 'nama mapel',
  `amSlag` varchar(100) DEFAULT NULL,
  `amJamMulai` time DEFAULT NULL,
  `amJamAkhir` time DEFAULT NULL,
  `amHari` varchar(25) DEFAULT NULL,
  `amStatus` int(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi_mapel_anggota`
--

CREATE TABLE `absensi_mapel_anggota` (
  `amaId` int(11) NOT NULL COMMENT 'id absen anggota mapel',
  `amaIdAbsenMapel` int(11) DEFAULT NULL COMMENT 'id absen mapel',
  `amaIdSiswa` int(11) DEFAULT NULL COMMENT 'id siswa',
  `amaIdKelas` int(11) DEFAULT NULL COMMENT 'id kelas',
  `amaIdMapel` int(11) DEFAULT NULL COMMENT 'id mapel',
  `amaTgl` date DEFAULT NULL,
  `amaJamIn` time DEFAULT NULL,
  `amaStatus` varchar(5) DEFAULT NULL,
  `amaUrlFoto` varchar(255) DEFAULT NULL,
  `amaFoto` varchar(255) DEFAULT NULL,
  `amaCreated` timestamp NULL DEFAULT current_timestamp(),
  `amaKeterangan` text DEFAULT NULL COMMENT 'keterangan izin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `berita`
--

CREATE TABLE `berita` (
  `id_berita` int(10) NOT NULL,
  `id_mapel` int(10) NOT NULL,
  `sesi` varchar(10) NOT NULL,
  `ruang` varchar(20) NOT NULL,
  `jenis` varchar(30) NOT NULL,
  `ikut` varchar(10) DEFAULT NULL,
  `susulan` varchar(10) DEFAULT NULL,
  `no_susulan` text DEFAULT NULL,
  `mulai` varchar(10) DEFAULT NULL,
  `selesai` varchar(10) DEFAULT NULL,
  `nama_proktor` varchar(50) DEFAULT NULL,
  `nip_proktor` varchar(50) DEFAULT NULL,
  `nama_pengawas` varchar(50) DEFAULT NULL,
  `nip_pengawas` varchar(50) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `tgl_ujian` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `bot_telegram`
--

CREATE TABLE `bot_telegram` (
  `botId` int(11) NOT NULL,
  `botNama` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `botKode` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `botToken` text CHARACTER SET latin1 DEFAULT NULL,
  `botChatId` varchar(255) DEFAULT NULL,
  `botCreated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `botActive` int(1) DEFAULT 1,
  `botSendAbsenMapel` int(1) DEFAULT 1 COMMENT 'Send Absen Mapel',
  `botSendAbsenSekolah` int(1) DEFAULT 1 COMMENT 'Send Absen Sekolah',
  `botSendTugas` int(1) DEFAULT 1 COMMENT 'Send Absne Tugas'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `bot_telegram`
--

INSERT INTO `bot_telegram` (`botId`, `botNama`, `botKode`, `botToken`, `botChatId`, `botCreated_at`, `botActive`, `botSendAbsenMapel`, `botSendAbsenSekolah`, `botSendTugas`) VALUES
(1, 'BUDUT', NULL, '1317xxxxxx:AAxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx', '-41571xxxxxxxx', '2024-03-08 11:40:32', 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `dapodik`
--

CREATE TABLE `dapodik` (
  `dpId` int(11) NOT NULL,
  `dpToken` varchar(100) DEFAULT NULL,
  `dpUrl` varchar(100) DEFAULT NULL,
  `dpPort` varchar(10) DEFAULT NULL,
  `dpNpsn` varchar(100) DEFAULT NULL,
  `dpPengguna` varchar(100) DEFAULT NULL,
  `dpSekolah` varchar(100) DEFAULT NULL,
  `dpRombel` varchar(100) DEFAULT NULL,
  `dpGtk` varchar(100) DEFAULT NULL,
  `dpSiswa` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `dapodik`
--

INSERT INTO `dapodik` (`dpId`, `dpToken`, `dpUrl`, `dpPort`, `dpNpsn`, `dpPengguna`, `dpSekolah`, `dpRombel`, `dpGtk`, `dpSiswa`) VALUES
(1, 'Yxt92CPKPaIvJvm', 'localhost', '5774', '10814070', 'getPengguna', 'getSekolah', 'getRombelBelajar', 'getGtk', 'getPesertaDidik');

-- --------------------------------------------------------

--
-- Struktur dari tabel `file_pendukung`
--

CREATE TABLE `file_pendukung` (
  `id_file` int(11) NOT NULL,
  `id_mapel` int(11) DEFAULT 0,
  `nama_file` varchar(50) DEFAULT NULL,
  `status_file` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jam_skl`
--

CREATE TABLE `jam_skl` (
  `jmId` int(11) NOT NULL COMMENT 'id jam sekolah',
  `jamIn` time DEFAULT NULL COMMENT 'jam masuk',
  `jamOut` time DEFAULT NULL COMMENT 'jam pulang',
  `jamOutJumat` time DEFAULT NULL COMMENT 'jam pulang jumat',
  `jamAlpah` time DEFAULT NULL COMMENT 'jam alpha',
  `jamTerlambat` time DEFAULT NULL COMMENT 'jam terlambat'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `jam_skl`
--

INSERT INTO `jam_skl` (`jmId`, `jamIn`, `jamOut`, `jamOutJumat`, `jamAlpah`, `jamTerlambat`) VALUES
(1, '06:00:00', '10:00:00', '11:00:00', '00:00:00', '07:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jawaban`
--

CREATE TABLE `jawaban` (
  `id_jawaban` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `id_soal` int(11) NOT NULL,
  `id_ujian` int(11) NOT NULL,
  `jawaban` text CHARACTER SET latin1 DEFAULT NULL,
  `jawabx` text CHARACTER SET latin1 DEFAULT NULL,
  `jenis` int(1) NOT NULL,
  `esai` text CHARACTER SET latin1 DEFAULT NULL,
  `nilai_esai` int(5) NOT NULL DEFAULT 0,
  `ragu` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jawaban_copy`
--

CREATE TABLE `jawaban_copy` (
  `id_jawaban` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `id_soal` int(11) NOT NULL,
  `id_ujian` int(11) NOT NULL,
  `jawaban` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `jawabx` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `jenis` int(1) NOT NULL,
  `esai` text CHARACTER SET latin1 DEFAULT NULL,
  `nilai_esai` int(5) NOT NULL DEFAULT 0,
  `ragu` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `jawaban_copy`
--

INSERT INTO `jawaban_copy` (`id_jawaban`, `id_siswa`, `id_mapel`, `id_soal`, `id_ujian`, `jawaban`, `jawabx`, `jenis`, `esai`, `nilai_esai`, `ragu`) VALUES
(121, 11, 14, 33, 21, 'A', 'A', 1, NULL, 0, 0),
(122, 11, 14, 34, 21, 'A', 'A', 1, NULL, 0, 0),
(123, 11, 14, 30, 21, 'A', 'A', 1, NULL, 0, 0),
(124, 11, 14, 31, 21, 'A', 'A', 1, NULL, 0, 0),
(125, 11, 14, 32, 21, 'A', 'A', 1, NULL, 0, 0),
(132, 12, 14, 34, 21, 'A', 'A', 1, NULL, 0, 0),
(133, 12, 14, 33, 21, 'A', 'A', 1, NULL, 0, 0),
(144, 1, 19, 517, 27, 'A', 'A', 1, NULL, 0, 0),
(145, 1, 19, 504, 27, 'A', 'A', 1, NULL, 0, 0),
(146, 1, 19, 484, 27, 'A', 'A', 1, NULL, 0, 0),
(147, 1, 19, 510, 27, 'A', 'A', 1, NULL, 0, 0),
(148, 1, 19, 496, 27, 'A', 'A', 1, NULL, 0, 0),
(149, 1, 19, 514, 27, 'B', 'B', 1, NULL, 0, 0),
(150, 1, 19, 521, 27, 'A', 'A', 1, NULL, 0, 0),
(151, 1, 19, 483, 27, 'A', 'A', 1, NULL, 0, 0),
(152, 1, 19, 498, 27, 'A', 'A', 1, NULL, 0, 0),
(153, 1, 19, 505, 27, 'A', 'A', 1, NULL, 0, 0),
(154, 1, 19, 490, 27, 'A', 'A', 1, NULL, 0, 0),
(155, 1, 19, 516, 27, 'A', 'A', 1, NULL, 0, 0),
(156, 1, 19, 494, 27, 'A', 'A', 1, NULL, 0, 0),
(157, 1, 19, 511, 27, 'A', 'A', 1, NULL, 0, 0),
(158, 1, 19, 506, 27, 'A', 'A', 1, NULL, 0, 0),
(159, 1, 19, 508, 27, 'A', 'A', 1, NULL, 0, 0),
(160, 1, 19, 500, 27, 'A', 'A', 1, NULL, 0, 0),
(161, 1, 19, 518, 27, 'A', 'A', 1, NULL, 0, 0),
(162, 1, 19, 489, 27, 'A', 'A', 1, NULL, 0, 0),
(163, 1, 19, 515, 27, 'A', 'A', 1, NULL, 0, 0),
(164, 1, 19, 499, 27, 'A', 'A', 1, NULL, 0, 0),
(165, 1, 19, 519, 27, 'A', 'A', 1, NULL, 0, 0),
(166, 1, 19, 513, 27, 'A', 'A', 1, NULL, 0, 0),
(167, 1, 19, 501, 27, 'A', 'A', 1, NULL, 0, 0),
(168, 1, 19, 497, 27, 'A', 'A', 1, NULL, 0, 0),
(169, 1, 19, 491, 27, 'A', 'A', 1, NULL, 0, 0),
(170, 1, 19, 488, 27, 'A', 'A', 1, NULL, 0, 0),
(171, 1, 19, 495, 27, 'A', 'A', 1, NULL, 0, 0),
(172, 1, 19, 520, 27, 'A', 'A', 1, NULL, 0, 0),
(173, 1, 19, 522, 27, 'A', 'A', 1, NULL, 0, 0),
(174, 1, 19, 493, 27, 'A', 'A', 1, NULL, 0, 0),
(175, 1, 19, 509, 27, 'A', 'A', 1, NULL, 0, 0),
(176, 1, 19, 507, 27, 'A', 'A', 1, NULL, 0, 0),
(177, 1, 19, 503, 27, 'A', 'A', 1, NULL, 0, 0),
(178, 1, 19, 486, 27, 'A', 'A', 1, NULL, 0, 0),
(179, 1, 19, 512, 27, 'A', 'A', 1, NULL, 0, 0),
(180, 1, 19, 485, 27, 'A', 'A', 1, NULL, 0, 0),
(181, 1, 19, 487, 27, 'A', 'A', 1, NULL, 0, 0),
(182, 1, 19, 492, 27, 'A', 'A', 1, NULL, 0, 0),
(183, 1, 19, 502, 27, 'A', 'A', 1, NULL, 0, 0),
(184, 4, 14, 30, 21, 'A', 'A', 1, NULL, 0, 0),
(185, 4, 14, 31, 21, 'A', 'A', 1, NULL, 0, 0),
(186, 4, 14, 32, 21, 'B', 'B', 1, NULL, 0, 0),
(187, 4, 14, 33, 21, 'A', 'A', 1, NULL, 0, 0),
(188, 4, 14, 34, 21, 'A', 'A', 1, NULL, 0, 0),
(189, 7, 14, 33, 21, 'A', 'A', 1, NULL, 0, 0),
(190, 7, 14, 34, 21, 'A', 'A', 1, NULL, 0, 0),
(191, 7, 14, 30, 21, 'B', 'B', 1, NULL, 0, 0),
(192, 7, 14, 32, 21, 'C', 'C', 1, NULL, 0, 0),
(193, 7, 14, 31, 21, 'A', 'A', 1, NULL, 0, 0),
(194, 8, 14, 34, 21, 'A', 'A', 1, NULL, 0, 0),
(195, 8, 14, 33, 21, 'A', 'A', 1, NULL, 0, 0),
(196, 8, 14, 32, 21, 'A', 'A', 1, NULL, 0, 0),
(197, 8, 14, 31, 21, 'A', 'A', 1, NULL, 0, 0),
(198, 8, 14, 30, 21, 'A', 'A', 1, NULL, 0, 0),
(199, 9, 14, 32, 21, 'A', 'A', 1, NULL, 0, 0),
(200, 9, 14, 31, 21, 'A', 'A', 1, NULL, 0, 0),
(201, 9, 14, 33, 21, 'A', 'A', 1, NULL, 0, 0),
(202, 9, 14, 34, 21, 'A', 'A', 1, NULL, 0, 0),
(203, 9, 14, 30, 21, 'A', 'A', 1, NULL, 0, 0),
(204, 1, 14, 30, 21, 'A', 'A', 1, NULL, 0, 0),
(205, 1, 14, 34, 21, 'A', 'A', 1, NULL, 0, 0),
(206, 1, 14, 33, 21, 'A', 'A', 1, NULL, 0, 0),
(207, 1, 14, 31, 21, 'A', 'A', 1, NULL, 0, 0),
(208, 1, 14, 32, 21, 'A', 'A', 1, NULL, 0, 0),
(209, 5, 14, 33, 21, 'A', 'A', 1, NULL, 0, 0),
(210, 5, 14, 34, 21, 'A', 'A', 1, NULL, 0, 0),
(211, 5, 14, 32, 21, 'A', 'A', 1, NULL, 0, 0),
(212, 5, 14, 30, 21, 'A', 'A', 1, NULL, 0, 0),
(213, 5, 14, 31, 21, 'A', 'A', 1, NULL, 0, 0),
(214, 12, 14, 34, 21, 'B', 'B', 1, NULL, 0, 0),
(215, 12, 14, 33, 21, 'A', 'A', 1, NULL, 0, 0),
(216, 12, 14, 32, 21, 'C', 'C', 1, NULL, 0, 0),
(217, 12, 14, 31, 21, 'D', 'D', 1, NULL, 0, 0),
(218, 12, 14, 30, 21, 'B', 'B', 1, NULL, 0, 0),
(219, 13, 14, 33, 21, 'D', 'D', 1, NULL, 0, 0),
(220, 13, 14, 34, 21, 'D', 'D', 1, NULL, 0, 0),
(221, 13, 14, 32, 21, 'A', 'A', 1, NULL, 0, 0),
(222, 13, 14, 30, 21, 'B', 'B', 1, NULL, 0, 0),
(223, 13, 14, 31, 21, 'A', 'A', 1, NULL, 0, 0),
(224, 14, 14, 33, 21, 'C', 'C', 1, NULL, 0, 0),
(225, 14, 14, 34, 21, 'A', 'A', 1, NULL, 0, 0),
(226, 14, 14, 32, 21, 'B', 'B', 1, NULL, 0, 0),
(227, 14, 14, 30, 21, 'A', 'A', 1, NULL, 0, 0),
(228, 14, 14, 31, 21, 'B', 'B', 1, NULL, 0, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jawaban_tugas`
--

CREATE TABLE `jawaban_tugas` (
  `id_jawaban` int(11) NOT NULL,
  `id_siswa` int(11) DEFAULT NULL,
  `id_guru` int(11) DEFAULT NULL,
  `id_tugas` int(11) DEFAULT NULL,
  `jawaban` longblob DEFAULT NULL,
  `file` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `tgl_dikerjakan` datetime DEFAULT NULL,
  `tgl_update` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `nilai` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `catatanGuru` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis`
--

CREATE TABLE `jenis` (
  `id_jenis` varchar(30) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jenis`
--

INSERT INTO `jenis` (`id_jenis`, `nama`, `status`) VALUES
('MID', 'UJIAN TENGAH SEMESTER', 'tidak'),
('US', 'Ujian Sekolah', 'aktif'),
('USBK', 'UJIAN SEMESTER BERBASIS KOMPUTER', 'tidak');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurusan`
--

CREATE TABLE `jurusan` (
  `jurusan_id` varchar(25) NOT NULL,
  `nama_jurusan_sp` varchar(100) DEFAULT NULL,
  `kurikulum` varchar(120) DEFAULT NULL,
  `jurusan_sp_id` varchar(50) DEFAULT NULL,
  `kurikulum_id` varchar(20) DEFAULT NULL,
  `sekolah_id` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `idkls` int(11) NOT NULL,
  `id_kelas` varchar(11) CHARACTER SET latin1 DEFAULT NULL,
  `nama` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `id_level` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `id_pk` varchar(10) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`idkls`, `id_kelas`, `nama`, `id_level`, `id_pk`) VALUES
(1, 'XIITP', 'XIITP', 'XII', 'TP'),
(2, 'XIITKR', 'XIITKR', 'XII', 'TKR'),
(3, 'XIITKJ', 'XIITKJ', 'XII', 'TKJ');

-- --------------------------------------------------------

--
-- Struktur dari tabel `level`
--

CREATE TABLE `level` (
  `idlevel` int(11) NOT NULL,
  `kode_level` varchar(20) DEFAULT NULL,
  `keterangan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `level`
--

INSERT INTO `level` (`idlevel`, `kode_level`, `keterangan`) VALUES
(1, 'XII', 'XII');

-- --------------------------------------------------------

--
-- Struktur dari tabel `log`
--

CREATE TABLE `log` (
  `id_log` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `text` varchar(20) NOT NULL,
  `date` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `login`
--

CREATE TABLE `login` (
  `id_log` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `ipaddress` varchar(20) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `mapel`
--

CREATE TABLE `mapel` (
  `id_mapel` int(11) NOT NULL,
  `idpk` varchar(10) CHARACTER SET latin1 NOT NULL,
  `idguru` int(11) NOT NULL,
  `KodeMapel` varchar(100) CHARACTER SET latin1 DEFAULT NULL COMMENT 'Kode Mata Pelajaran',
  `nama` varchar(100) CHARACTER SET latin1 NOT NULL,
  `jml_soal` int(5) NOT NULL,
  `jml_esai` int(5) NOT NULL,
  `tampil_pg` int(5) NOT NULL,
  `tampil_esai` int(5) NOT NULL,
  `bobot_pg` int(5) NOT NULL,
  `bobot_esai` int(5) NOT NULL,
  `level` varchar(5) CHARACTER SET latin1 NOT NULL,
  `opsi` int(1) NOT NULL,
  `kelas` longtext CHARACTER SET latin1 NOT NULL,
  `siswa` longtext CHARACTER SET latin1 DEFAULT 'null',
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(2) CHARACTER SET latin1 NOT NULL,
  `statusujian` int(11) DEFAULT 0,
  `jenisSoalUjian` int(1) NOT NULL COMMENT '1 PG, 2 Esai, 3 PG Esai',
  `soalAgama` int(1) DEFAULT 0 COMMENT 'jenis soal agama',
  `soalAgamaList` varchar(100) DEFAULT 'umum' COMMENT 'list soal agama',
  `soalPaket` varchar(10) DEFAULT 'A' COMMENT 'jenis paket soal'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `mata_pelajaran`
--

CREATE TABLE `mata_pelajaran` (
  `idmapel` int(11) NOT NULL,
  `kode_mapel` varchar(100) NOT NULL,
  `nama_mapel` varchar(100) NOT NULL,
  `mata_pelajaran_id` varchar(100) DEFAULT NULL,
  `kode_level` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `mata_pelajaran`
--

INSERT INTO `mata_pelajaran` (`idmapel`, `kode_mapel`, `nama_mapel`, `mata_pelajaran_id`, `kode_level`) VALUES
(1, 'BINDO', 'BAHASA INDONESIA', NULL, 'XII'),
(2, 'MTK', 'MATEMATIKA', NULL, 'XII'),
(3, 'BING', 'BAHASA INGGRIS', NULL, 'XII'),
(4, 'KIMIA', 'KIMIA', NULL, 'XII'),
(5, 'SEJINDO', 'SEJARAH INDONESIA', NULL, 'XII'),
(6, 'PKN', 'PENDIDIKAN KEWARGANEGARAAN', NULL, 'XII'),
(7, 'PJOK', 'PENJASKES', NULL, 'XII'),
(8, 'FISIKA', 'FISIKA', NULL, 'XII'),
(9, 'PAI', 'PENDIDIKAN AGAMA ISLAM', NULL, 'XII'),
(10, 'PRODTKJ', 'PRODUKTIF TKJ', NULL, 'XII');

-- --------------------------------------------------------

--
-- Struktur dari tabel `materi2`
--

CREATE TABLE `materi2` (
  `materi2_id` int(5) NOT NULL,
  `materi2_mapel` varchar(255) DEFAULT '0',
  `materi2_judul` varchar(255) DEFAULT NULL,
  `materi2_isi` longblob DEFAULT NULL,
  `materi2_file` varchar(255) DEFAULT NULL,
  `materi2_tgl_rilis` datetime DEFAULT NULL,
  `id_guru` int(11) DEFAULT NULL,
  `kelas` varchar(255) NOT NULL,
  `materi2_tgl` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `url_youtube` longtext DEFAULT NULL,
  `url_gdrive` longtext DEFAULT NULL,
  `url_embed` varchar(255) DEFAULT NULL,
  `kode_level` varchar(20) DEFAULT NULL,
  `materi2_status` int(1) DEFAULT 1,
  `materi2_jenis` text DEFAULT NULL,
  `materi2_jenis2` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `materi_view`
--

CREATE TABLE `materi_view` (
  `mtrViewId` int(11) NOT NULL COMMENT 'id materi view',
  `mtrViewIdSiswa` int(11) DEFAULT NULL COMMENT 'id siswa',
  `mtrViewIdMateri` int(11) DEFAULT NULL COMMENT 'id materi',
  `mtrViewJenis` int(1) DEFAULT NULL COMMENT 'jenis view',
  `mtrViewDate` datetime DEFAULT NULL COMMENT 'date time view',
  `mtrViewStatus` int(1) DEFAULT NULL COMMENT 'status view'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai`
--

CREATE TABLE `nilai` (
  `id_nilai` int(11) NOT NULL,
  `id_ujian` int(11) NOT NULL COMMENT 'id ujian',
  `id_mapel` int(11) NOT NULL COMMENT 'kode bank soal',
  `id_siswa` int(11) NOT NULL,
  `kode_ujian` varchar(30) CHARACTER SET latin1 NOT NULL,
  `KodeMataPelajaran` varchar(100) DEFAULT NULL COMMENT 'kode mata pelajaran',
  `ujian_mulai` varchar(20) CHARACTER SET latin1 NOT NULL,
  `ujian_berlangsung` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `ujian_selesai` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `jml_benar` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `jml_salah` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `nilai_esai` varchar(10) CHARACTER SET latin1 DEFAULT '0',
  `skor` varchar(10) CHARACTER SET latin1 DEFAULT '0',
  `total` varchar(10) CHARACTER SET latin1 DEFAULT '0',
  `status` varchar(1) DEFAULT NULL,
  `ipaddress` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `hasil` int(2) NOT NULL,
  `jawaban` text DEFAULT NULL,
  `jawaban_esai` longtext CHARACTER SET latin1 DEFAULT NULL,
  `online` int(1) NOT NULL DEFAULT 0,
  `blok` int(2) DEFAULT 0,
  `blokirStatus` int(1) DEFAULT 1 COMMENT '1 aktifkan sistem blokir',
  `blokBukaAdmin` int(1) DEFAULT 0 COMMENT '1 admin membuka blokir siswa',
  `jmlPelanggaran` int(11) DEFAULT 0 COMMENT 'total jumlah pelanggaran',
  `id_soal` longtext CHARACTER SET latin1 DEFAULT NULL,
  `id_opsi` longtext CHARACTER SET latin1 DEFAULT NULL,
  `id_esai` text CHARACTER SET latin1 DEFAULT NULL,
  `nilai_esai2` longtext CHARACTER SET latin1 DEFAULT NULL,
  `selesai` int(2) DEFAULT 0,
  `cek_tombol_selesai` int(2) DEFAULT 0,
  `nilaiPaketSoal` varchar(10) DEFAULT NULL COMMENT 'Paket Soal Di Ambil Siswa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai_pindah`
--

CREATE TABLE `nilai_pindah` (
  `id_nilai` int(11) NOT NULL,
  `id_ujian` int(11) NOT NULL COMMENT 'id ujian',
  `id_mapel` int(11) NOT NULL COMMENT 'kode bank',
  `id_siswa` int(11) NOT NULL,
  `kode_ujian` varchar(30) CHARACTER SET latin1 NOT NULL,
  `KodeMataPelajaran` varchar(100) DEFAULT NULL COMMENT 'kode mata pelajaran',
  `ujian_mulai` varchar(20) CHARACTER SET latin1 NOT NULL,
  `ujian_berlangsung` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `ujian_selesai` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `jml_benar` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `jml_salah` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `nilai_esai` varchar(10) CHARACTER SET latin1 DEFAULT '0',
  `skor` varchar(10) CHARACTER SET latin1 DEFAULT '0',
  `total` varchar(10) CHARACTER SET latin1 DEFAULT '0',
  `status` varchar(1) DEFAULT NULL,
  `ipaddress` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `hasil` int(2) NOT NULL,
  `jawaban` text CHARACTER SET latin1 DEFAULT NULL,
  `jawaban_esai` longtext CHARACTER SET latin1 DEFAULT NULL,
  `online` int(1) NOT NULL DEFAULT 0,
  `blok` int(2) DEFAULT 0,
  `id_soal` longtext CHARACTER SET latin1 DEFAULT NULL,
  `id_opsi` longtext CHARACTER SET latin1 DEFAULT NULL,
  `id_esai` text CHARACTER SET latin1 DEFAULT NULL,
  `nilai_esai2` longtext CHARACTER SET latin1 DEFAULT NULL,
  `selesai` int(2) DEFAULT 0,
  `cek_tombol_selesai` int(2) DEFAULT 0,
  `nilaiPaketSoal` varchar(10) DEFAULT NULL COMMENT 'Paket Soal Di Ambil Siswa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengacak`
--

CREATE TABLE `pengacak` (
  `id_pengacak` int(11) NOT NULL,
  `id_ujian` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `id_soal` longtext NOT NULL,
  `id_opsi` longtext DEFAULT NULL,
  `id_esai` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengawas`
--

CREATE TABLE `pengawas` (
  `id_pengawas` int(11) NOT NULL,
  `nip` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `nama` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `jabatan` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `username` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `password` text CHARACTER SET utf8 DEFAULT NULL,
  `level` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `password2` text CHARACTER SET utf8 DEFAULT NULL,
  `id_kls` varchar(11) DEFAULT NULL,
  `id_jrs` varchar(11) DEFAULT NULL,
  `foto_pengawas` varchar(100) DEFAULT NULL,
  `pengawas_created` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data untuk tabel `pengawas`
--

INSERT INTO `pengawas` (`id_pengawas`, `nip`, `nama`, `jabatan`, `username`, `password`, `level`, `password2`, `id_kls`, `id_jrs`, `foto_pengawas`, `pengawas_created`) VALUES
(1, '-', 'administrator', '', 'admin', '$2a$12$ZupfbYZUEZ.CAp8tlX1x2Oi/CNW.EAJ1q9MEbcqYaGXTS9sUfG5L.', 'admin', NULL, NULL, NULL, NULL, NULL),
(263, '-', 'AKP GALANG', 'guru', 'guru', '$2y$10$IBPPSN2xo0NucoJGW1/qBe6DMKTYv4meEU14fu30.aeSHtNNqu5jm', 'guru', NULL, '', '', NULL, '2024-03-20 13:06:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengumuman`
--

CREATE TABLE `pengumuman` (
  `id_pengumuman` int(5) NOT NULL,
  `type` varchar(30) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `user` int(3) NOT NULL,
  `text` longtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `pnKelas` varchar(255) DEFAULT NULL,
  `pnLevel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pengumuman`
--

INSERT INTO `pengumuman` (`id_pengumuman`, `type`, `judul`, `user`, `text`, `date`, `pnKelas`, `pnLevel`) VALUES
(2, 'eksternal', 'tess', 1, '<p>tes</p>', '2026-03-10 04:00:02', 'N;', 'X');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pk`
--

CREATE TABLE `pk` (
  `idpk` int(11) NOT NULL,
  `id_pk` varchar(11) CHARACTER SET latin1 DEFAULT NULL,
  `program_keahlian` varchar(50) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pk`
--

INSERT INTO `pk` (`idpk`, `id_pk`, `program_keahlian`) VALUES
(1, 'TP', 'TP'),
(2, 'TKR', 'TKR'),
(3, 'TKJ', 'TKJ');

-- --------------------------------------------------------

--
-- Struktur dari tabel `referensi_jurusan`
--

CREATE TABLE `referensi_jurusan` (
  `jurusan_id` varchar(10) NOT NULL,
  `nama_jurusan` varchar(100) DEFAULT NULL,
  `untuk_sma` int(1) NOT NULL,
  `untuk_smk` int(1) NOT NULL,
  `jenjang_pendidikan_id` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `ruang`
--

CREATE TABLE `ruang` (
  `kode_ruang` varchar(10) NOT NULL,
  `keterangan` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `ruang`
--

INSERT INTO `ruang` (`kode_ruang`, `keterangan`) VALUES
('R1', 'R1'),
('R2', 'R2');

-- --------------------------------------------------------

--
-- Struktur dari tabel `savsoft_options`
--

CREATE TABLE `savsoft_options` (
  `oid` int(11) NOT NULL,
  `qid` int(11) NOT NULL,
  `q_option` text NOT NULL,
  `q_option_match` varchar(1000) DEFAULT NULL,
  `score` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `savsoft_qbank`
--

CREATE TABLE `savsoft_qbank` (
  `qid` int(11) NOT NULL,
  `question_type` varchar(100) NOT NULL DEFAULT 'Multiple Choice Single Answer',
  `question` text NOT NULL,
  `description` text NOT NULL,
  `cid` int(11) NOT NULL,
  `lid` int(11) NOT NULL,
  `no_time_served` int(11) NOT NULL DEFAULT 0,
  `no_time_corrected` int(11) NOT NULL DEFAULT 0,
  `no_time_incorrected` int(11) NOT NULL DEFAULT 0,
  `no_time_unattempted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `semester`
--

CREATE TABLE `semester` (
  `semester_id` varchar(5) NOT NULL,
  `tahun_ajaran_id` varchar(4) NOT NULL,
  `nama_semester` varchar(50) NOT NULL,
  `semester` int(1) NOT NULL,
  `periode_aktif` enum('1','0') NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `server`
--

CREATE TABLE `server` (
  `kode_server` varchar(20) NOT NULL,
  `nama_server` varchar(30) NOT NULL,
  `status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `server`
--

INSERT INTO `server` (`kode_server`, `nama_server`, `status`) VALUES
('SR01', 'SR01', 'aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sesi`
--

CREATE TABLE `sesi` (
  `kode_sesi` varchar(10) NOT NULL,
  `nama_sesi` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `sesi`
--

INSERT INTO `sesi` (`kode_sesi`, `nama_sesi`) VALUES
('1', '1'),
('2', '2'),
('3', '3');

-- --------------------------------------------------------

--
-- Struktur dari tabel `session`
--

CREATE TABLE `session` (
  `id` int(11) NOT NULL,
  `session_time` varchar(10) NOT NULL,
  `session_hash` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `setting`
--

CREATE TABLE `setting` (
  `id_setting` int(11) NOT NULL,
  `aplikasi` varchar(100) DEFAULT NULL,
  `kode_sekolah` varchar(10) DEFAULT NULL,
  `sekolah` varchar(50) DEFAULT NULL,
  `jenjang` varchar(5) DEFAULT NULL,
  `kepsek` varchar(50) DEFAULT NULL,
  `nip` varchar(30) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `kecamatan` varchar(50) DEFAULT NULL,
  `kota` varchar(30) DEFAULT NULL,
  `telp` varchar(20) DEFAULT NULL,
  `XProv` varchar(50) DEFAULT NULL,
  `XKab` varchar(50) DEFAULT NULL,
  `XKec` varchar(50) DEFAULT NULL,
  `fax` varchar(20) DEFAULT NULL,
  `web` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `logo` text DEFAULT NULL,
  `header` text DEFAULT NULL,
  `header_kartu` text DEFAULT NULL,
  `nama_ujian` text DEFAULT NULL,
  `versi` varchar(10) DEFAULT NULL,
  `ip_server` varchar(100) DEFAULT NULL,
  `waktu` varchar(50) DEFAULT NULL,
  `server` varchar(50) DEFAULT NULL,
  `id_server` varchar(50) DEFAULT NULL,
  `db_folder` varchar(50) DEFAULT NULL,
  `db_host` varchar(50) DEFAULT NULL,
  `db_user` varchar(50) DEFAULT NULL,
  `db_pass` varchar(50) DEFAULT NULL,
  `db_name` varchar(50) DEFAULT NULL,
  `db_token` varchar(100) DEFAULT NULL,
  `db_token1` varchar(100) DEFAULT NULL,
  `tokenApi` varchar(255) DEFAULT NULL,
  `sekolah_id` varchar(50) DEFAULT NULL,
  `npsn` varchar(10) DEFAULT NULL,
  `kartu_atas` int(11) DEFAULT NULL,
  `kartu_kiri` int(11) DEFAULT NULL,
  `url_host` varchar(100) DEFAULT NULL,
  `kartu_tinggi` int(11) DEFAULT NULL,
  `kartu_lebar` int(11) DEFAULT NULL,
  `protek` varchar(100) DEFAULT NULL,
  `nip_protek` varchar(30) DEFAULT NULL,
  `catat_login` int(1) DEFAULT 1,
  `izin_pass` int(1) DEFAULT 0,
  `izin_materi` int(1) DEFAULT 0,
  `izin_tugas` int(1) DEFAULT 0,
  `izin_info` int(1) DEFAULT 0,
  `izin_ujian` int(1) DEFAULT 0,
  `izin_status` tinyint(1) DEFAULT 0,
  `izin_sinkron` tinyint(1) DEFAULT 0 COMMENT 'fitur sinkron',
  `elerning` tinyint(1) DEFAULT 0 COMMENT 'aktif elerning',
  `folder_admin` varchar(100) DEFAULT NULL,
  `namapjj` varchar(255) DEFAULT NULL,
  `izin_absen` int(1) DEFAULT 0 COMMENT 'izin absen sekolah',
  `izin_absen_mapel` int(1) DEFAULT 0 COMMENT 'izin absen mapel',
  `izi_foto_absen` int(1) DEFAULT 0 COMMENT 'izin upload foto absen',
  `LoginSiswaMainten` int(1) DEFAULT 0 COMMENT 'Mainten Login Siswa',
  `IsiPesanSingkat` varchar(200) DEFAULT NULL COMMENT 'Isi Pesan Singkat Login Siswa',
  `JudulPesanSingkat` varchar(100) DEFAULT NULL COMMENT 'Judul Pesan Singkat Login Siswa',
  `mode_jawab` int(1) DEFAULT 0,
  `lisensiId` varchar(255) DEFAULT NULL,
  `namaSekolah` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `setting`
--

INSERT INTO `setting` (`id_setting`, `aplikasi`, `kode_sekolah`, `sekolah`, `jenjang`, `kepsek`, `nip`, `alamat`, `kecamatan`, `kota`, `telp`, `XProv`, `XKab`, `XKec`, `fax`, `web`, `email`, `logo`, `header`, `header_kartu`, `nama_ujian`, `versi`, `ip_server`, `waktu`, `server`, `id_server`, `db_folder`, `db_host`, `db_user`, `db_pass`, `db_name`, `db_token`, `db_token1`, `tokenApi`, `sekolah_id`, `npsn`, `kartu_atas`, `kartu_kiri`, `url_host`, `kartu_tinggi`, `kartu_lebar`, `protek`, `nip_protek`, `catat_login`, `izin_pass`, `izin_materi`, `izin_tugas`, `izin_info`, `izin_ujian`, `izin_status`, `izin_sinkron`, `elerning`, `folder_admin`, `namapjj`, `izin_absen`, `izin_absen_mapel`, `izi_foto_absen`, `LoginSiswaMainten`, `IsiPesanSingkat`, `JudulPesanSingkat`, `mode_jawab`, `lisensiId`, `namaSekolah`) VALUES
(1, 'REDIS', 'RUANG1', 'SMK', 'SMK', 'Hanung Bramantio, S.Pd', '-', 'JL. PERJUANGAN LK. VII KEL. GALANG KOTA ', 'Galang', 'Bogor', '', 'Pilih', '', '', '', 'xcoding.eu.org', 'cs.xcoding@gmail.com', 'dist/img/logo57.png', 'Laporan Ujian Sekolah', 'UJIAN SEKOLAH', 'Ujian Sekolah', '2.5', 'https://xcoding.eu,org', 'Asia/Jakarta', 'pusat', 'SR01', '', 'http://localhost:8082/candy_redis/', 'root', '', '', 'J8I7jEyNMIlbDdEKIEigagyyeFsyK1', 'J8I7jEyNMIlbDdEKIEigagyyeFsyK1', 'Ua4sVas2jHNLIHashyZigA2erXRPYT', '8cce47df-aae7-4274-83cb-5af3093eab56', '69787351', 12, 50, '', 40, 90, 'Entis', '-', 2, 0, 0, 0, 1, 1, 0, 0, 1, '0', ' ', 0, 0, 0, 0, 'Dengan Ilmu Kita Menuju Kemuliaan', 'Ki Hadjar Dewantara', 0, 'Admin Ganteng Sekali', 'bhh ');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sinkron`
--

CREATE TABLE `sinkron` (
  `id_singkron` int(11) NOT NULL,
  `nama_data` varchar(50) NOT NULL,
  `jumlah` varchar(50) DEFAULT NULL,
  `tanggal` varchar(50) DEFAULT NULL,
  `status_sinkron` int(11) DEFAULT NULL,
  `jumlah_server` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `sinkron`
--

INSERT INTO `sinkron` (`id_singkron`, `nama_data`, `jumlah`, `tanggal`, `status_sinkron`, `jumlah_server`) VALUES
(1, 'KELAS', '', '', 0, ''),
(2, 'DATA_MASTER', '', '', 0, ''),
(3, 'SISWA', '', '', 0, ''),
(4, 'MAPEL', '', '', 0, ''),
(5, 'BANK_SOAL', '', '', 0, ''),
(6, 'SOAL', '', '', 0, ''),
(7, 'JADWAL', NULL, NULL, 0, NULL),
(8, 'SETTING', NULL, NULL, 0, NULL),
(9, 'FILE_PENDUKUNG', NULL, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `id_siswa` int(11) NOT NULL,
  `id_kelas` varchar(11) CHARACTER SET latin1 DEFAULT NULL,
  `idpk` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `nis` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `no_peserta` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `firt_nama` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `nama` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `level` varchar(5) CHARACTER SET latin1 DEFAULT NULL,
  `ruang` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `sesi` int(2) DEFAULT NULL,
  `username` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `password` text CHARACTER SET latin1 DEFAULT NULL,
  `foto` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `server` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `jenis_kelamin` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `agama` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `status_siswa` int(1) DEFAULT 1,
  `soalPaket` varchar(10) DEFAULT 'A' COMMENT 'paket soal pada siswa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `id_kelas`, `idpk`, `nis`, `no_peserta`, `firt_nama`, `nama`, `level`, `ruang`, `sesi`, `username`, `password`, `foto`, `server`, `jenis_kelamin`, `agama`, `status_siswa`, `soalPaket`) VALUES
(1, 'XIITP', 'TP', '151610041', '12-248-001-8', 'Ade', 'Ade Saputra', 'XII', 'R1', 1, 'hs001', 'ps001', 'hs001.jpg', 'SR01', NULL, 'kristen', 1, 'A'),
(2, 'XIITP', 'TP', '151610043', '12-248-002-7', 'Ahmad', 'Ahmad Fauzi', 'XII', 'R1', 1, 'hs002', 'ps002', 'hs002.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(3, 'XIITP', 'TP', '151610044', '12-248-003-6', 'Ahmad', 'Ahmad Fauzi', 'XII', 'R1', 1, 'hs003', 'ps003', 'hs003.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(4, 'XIITP', 'TP', '151610045', '12-248-004-5', 'Ahmad', 'Ahmad Juliansyah', 'XII', 'R1', 1, 'hs004', 'ps004', 'hs004.jpg', 'SR01', NULL, 'kristen', 1, 'B'),
(5, 'XIITP', 'TP', '151610047', '12-248-005-4', 'Algi', 'Algi Julian', 'XII', 'R1', 1, 'hs005', 'ps005', 'hs005.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(6, 'XIITP', 'TP', '151610048', '12-248-006-3', 'Anas', 'Anas Aditya', 'XII', 'R1', 1, 'hs006', 'ps006', 'hs006.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(7, 'XIITP', 'TP', '151610049', '12-248-007-2', 'Andre', 'Andre Irawan', 'XII', 'R1', 1, 'hs007', 'ps007', 'hs007.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(8, 'XIITP', 'TP', '151610042', '12-248-008-9', 'Andrian', 'Andrian Al Viansyah', 'XII', 'R1', 1, 'hs008', 'ps008', 'hs008.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(9, 'XIITP', 'TP', '151610050', '12-248-009-8', 'Andrian', 'Andrian Maulana', 'XII', 'R1', 1, 'hs009', 'ps009', 'hs009.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(10, 'XIITP', 'TP', '151610051', '12-248-010-7', 'Bambang', 'Bambang Reza Umbara', 'XII', 'R1', 1, 'hs010', 'ps010', 'hs010.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(11, 'XIITP', 'TP', '151610052', '12-248-011-6', 'Ferdi', 'Ferdi Hasan', 'XII', 'R1', 1, 'hs011', 'ps011', 'hs011.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(12, 'XIITP', 'TP', '151610053', '12-248-012-5', 'Guntur', 'Guntur Adthia Bagaskara', 'XII', 'R1', 1, 'hs012', 'ps012', 'hs012.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(13, 'XIITP', 'TP', '151610055', '12-248-013-4', 'Harun', 'Harun Syahroji Iqmal', 'XII', 'R1', 2, 'hs013', 'ps013', 'hs013.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(14, 'XIITP', 'TP', '151610054', '12-248-014-3', 'Haryadi', 'Haryadi Sajali', 'XII', 'R1', 2, 'hs014', 'ps014', 'hs014.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(15, 'XIITP', 'TP', '151610057', '12-248-015-2', 'Ismail', 'Ismail', 'XII', 'R1', 2, 'hs015', 'ps015', 'hs015.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(16, 'XIITP', 'TP', '151610062', '12-248-016-9', 'Muchtar', 'Muchtar Gana', 'XII', 'R1', 2, 'hs016', 'ps016', 'hs016.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(17, 'XIITP', 'TP', '151610058', '12-248-017-8', 'Muhamad', 'Muhamad Abdul Rahman', 'XII', 'R1', 2, 'hs017', 'ps017', 'hs017.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(18, 'XIITP', 'TP', '151610063', '12-248-018-7', 'Muhamad', 'Muhamad Ali Hapijudin', 'XII', 'R1', 2, 'hs018', 'ps018', 'hs018.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(19, 'XIITP', 'TP', '151610065', '12-248-019-6', 'Muhamad', 'Muhamad Rizal', 'XII', 'R1', 2, 'hs019', 'ps019', 'hs019.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(20, 'XIITP', 'TP', '151610066', '12-248-020-5', 'Muhammad', 'Muhammad Niji Yuki Huda Sabillah', 'XII', 'R1', 2, 'hs020', 'ps020', 'hs020.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(21, 'XIITP', 'TP', '151610059', '12-248-021-4', 'Muhammad', 'Muhammad Ogi Prayoga S.', 'XII', 'R1', 2, 'hs021', 'ps021', 'hs021.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(22, 'XIITP', 'TP', '151610067', '12-248-022-3', 'Niko', 'Niko', 'XII', 'R1', 2, 'hs022', 'ps022', 'hs022.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(23, 'XIITP', 'TP', '151610068', '12-248-023-2', 'Rahma', 'Rahma Ahmada', 'XII', 'R1', 2, 'hs023', 'ps023', 'hs023.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(24, 'XIITP', 'TP', '151610070', '12-248-024-9', 'Renaldi', 'Renaldi', 'XII', 'R1', 2, 'hs024', 'ps024', 'hs024.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(25, 'XIITP', 'TP', '151610069', '12-248-025-8', 'Renaldi', 'Renaldi', 'XII', 'R1', 2, 'hs025', 'ps025', 'hs025.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(26, 'XIITP', 'TP', '151610072', '12-248-026-7', 'Rico', 'Rico Dwi Addrian Fattah', 'XII', 'R1', 2, 'hs026', 'ps026', 'hs026.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(27, 'XIITP', 'TP', '151610073', '12-248-027-6', 'Riki', 'Riki Riyanto', 'XII', 'R1', 2, 'hs027', 'ps027', 'hs027.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(28, 'XIITP', 'TP', '151610074', '12-248-028-5', 'Riki', 'Riki S', 'XII', 'R1', 2, 'hs028', 'ps028', 'hs028.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(29, 'XIITP', 'TP', '151610075', '12-248-029-4', 'Rudi', 'Rudi Hartono', 'XII', 'R1', 2, 'hs029', 'ps029', 'hs029.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(30, 'XIITP', 'TP', '151610076', '12-248-030-3', 'Saipul', 'Saipul Anwar', 'XII', 'R1', 3, 'hs030', 'ps030', 'hs030.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(31, 'XIITP', 'TP', '151610077', '12-248-031-2', 'Satya', 'Satya Pratama', 'XII', 'R1', 3, 'hs031', 'ps031', 'hs031.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(32, 'XIITP', 'TP', '151610078', '12-248-032-9', 'Sutrisno', 'Sutrisno', 'XII', 'R1', 3, 'hs032', 'ps032', 'hs032.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(33, 'XIITP', 'TP', '151610079', '12-248-033-8', 'Syarif', 'Syarif', 'XII', 'R1', 3, 'hs033', 'ps033', 'hs033.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(34, 'XIITP', 'TP', '151610081', '12-248-034-7', 'Yobi', 'Yobi Pratama', 'XII', 'R1', 3, 'hs034', 'ps034', 'hs034.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(35, 'XIITKR', 'TKR', '151610083', '12-248-035-6', 'Adittiya', 'Adittiya', 'XII', 'R1', 3, 'hs035', 'ps035', 'hs035.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(36, 'XIITKR', 'TKR', '151610084', '12-248-036-5', 'Aef', 'Aef saefullah EDK', 'XII', 'R1', 3, 'hs036', 'ps036', 'hs036.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(37, 'XIITKR', 'TKR', '151610085', '12-248-037-4', 'Ahmad', 'Ahmad', 'XII', 'R1', 3, 'hs037', 'ps037', 'hs037.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(38, 'XIITKR', 'TKR', '151610086', '12-248-038-3', 'Ahmad', 'Ahmad dani', 'XII', 'R1', 3, 'hs038', 'ps038', 'hs038.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(39, 'XIITKR', 'TKR', '151610089', '12-248-039-2', 'Amar', 'Amar', 'XII', 'R1', 3, 'hs039', 'ps039', 'hs039.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(40, 'XIITKR', 'TKR', '151610090', '12-248-040-9', 'Andi', 'Andi', 'XII', 'R1', 3, 'hs040', 'ps040', 'hs040.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(41, 'XIITKR', 'TKR', '151610091', '12-248-041-8', 'Anggi', 'Anggi Julian Purnama', 'XII', 'R1', 3, 'hs041', 'ps041', 'hs041.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(42, 'XIITKR', 'TKR', '151610092', '12-248-042-7', 'Ardiansyah', 'Ardiansyah', 'XII', 'R1', 3, 'hs042', 'ps042', 'hs042.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(43, 'XIITKR', 'TKR', '151610093', '12-248-043-6', 'Aryanto', 'Aryanto', 'XII', 'R1', 3, 'hs043', 'ps043', 'hs043.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(44, 'XIITKR', 'TKR', '151610094', '12-248-044-5', 'Awaludin', 'Awaludin', 'XII', 'R1', 3, 'hs044', 'ps044', 'hs044.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(45, 'XIITKR', 'TKR', '151610096', '12-248-045-4', 'Dede', 'Dede Ahmad Pauji', 'XII', 'R1', 3, 'hs045', 'ps045', 'hs045.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(46, 'XIITKR', 'TKR', '151610099', '12-248-046-3', 'Egi', 'Egi Ariansyah', 'XII', 'R1', 3, 'hs046', 'ps046', 'hs046.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(47, 'XIITKR', 'TKR', '151610100', '12-248-047-2', 'Erdin', 'Erdin', 'XII', 'R1', 3, 'hs047', 'ps047', 'hs047.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(48, 'XIITKR', 'TKR', '151610101', '12-248-048-9', 'Fajar', 'Fajar Ramadhan', 'XII', 'R1', 3, 'hs048', 'ps048', 'hs048.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(49, 'XIITKR', 'TKR', '151610102', '12-248-049-8', 'Fiky', 'Fiky Zulfikar', 'XII', 'R1', 3, 'hs049', 'ps049', 'hs049.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(50, 'XIITKR', 'TKR', '151610103', '12-248-050-7', 'Habibi', 'Habibi', 'XII', 'R1', 3, 'hs050', 'ps050', 'hs050.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(51, 'XIITKR', 'TKR', '151610104', '12-248-051-6', 'Handriyansyah', 'Handriyansyah Wijaya', 'XII', 'R1', 3, 'hs051', 'ps051', 'hs051.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(52, 'XIITKR', 'TKR', '151610128', '12-248-052-5', 'Herlangga', 'Herlangga Supardi', 'XII', 'R1', 3, 'hs052', 'ps052', 'hs052.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(53, 'XIITKR', 'TKR', '151610106', '12-248-053-4', 'Ibnu', 'Ibnu Mujahidin', 'XII', 'R1', 3, 'hs053', 'ps053', 'hs053.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(54, 'XIITKR', 'TKR', '151610107', '12-248-054-3', 'Kasan', 'Kasan Wijaya Kusuma', 'XII', 'R1', 3, 'hs054', 'ps054', 'hs054.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(55, 'XIITKR', 'TKR', '151610109', '12-248-055-2', 'Muhamad', 'Muhamad Aldi Ardiansyah', 'XII', 'R1', 3, 'hs055', 'ps055', 'hs055.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(56, 'XIITKR', 'TKR', '151610108', '12-248-056-9', 'Muhammad', 'Muhammad Sutrisno', 'XII', 'R1', 1, 'hs056', 'ps056', 'hs056.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(57, 'XIITKR', 'TKR', '151610110', '12-248-057-8', 'Muhammad', 'Muhammad Ramdan', 'XII', 'R1', 1, 'hs057', 'ps057', 'hs057.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(58, 'XIITKR', 'TKR', '151610111', '12-248-058-7', 'Nur', 'Nur Arifin', 'XII', 'R1', 1, 'hs058', 'ps058', 'hs058.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(59, 'XIITKR', 'TKR', '151610112', '12-248-059-6', 'Riyo', 'Riyo Wijaya', 'XII', 'R1', 1, 'hs059', 'ps059', 'hs059.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(60, 'XIITKR', 'TKR', '151610113', '12-248-060-5', 'Rizal', 'Rizal Maulana Aziz', 'XII', 'R1', 1, 'hs060', 'ps060', 'hs060.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(61, 'XIITKR', 'TKR', '151610114', '12-248-061-4', 'Robi', 'Robi Darwis', 'XII', 'R1', 1, 'hs061', 'ps061', 'hs061.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(62, 'XIITKR', 'TKR', '151610115', '12-248-062-3', 'Roni', 'Roni Sahroni', 'XII', 'R1', 1, 'hs062', 'ps062', 'hs062.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(63, 'XIITKR', 'TKR', '151610117', '12-248-063-2', 'Saemi', 'Saemi Al Rasyid', 'XII', 'R1', 1, 'hs063', 'ps063', 'hs063.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(64, 'XIITKR', 'TKR', '151610118', '12-248-064-9', 'Said', 'Said Abdullah', 'XII', 'R1', 1, 'hs064', 'ps064', 'hs064.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(65, 'XIITKR', 'TKR', '151610119', '12-248-065-8', 'Saripudin', 'Saripudin', 'XII', 'R1', 1, 'hs065', 'ps065', 'hs065.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(66, 'XIITKR', 'TKR', '151610123', '12-248-066-7', 'Ahmad', 'Ahmad Faisal', 'XII', 'R1', 1, 'hs066', 'ps066', 'hs066.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(67, 'XIITKR', 'TKR', '151610124', '12-248-067-6', 'Aksal', 'Aksal Sobari', 'XII', 'R1', 1, 'hs067', 'ps067', 'hs067.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(68, 'XIITKR', 'TKR', '151610125', '12-248-068-5', 'Alfian', 'Alfian', 'XII', 'R1', 1, 'hs068', 'ps068', 'hs068.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(69, 'XIITKR', 'TKR', '151610126', '12-248-069-4', 'Arsad', 'Arsad sopian', 'XII', 'R1', 1, 'hs069', 'ps069', 'hs069.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(70, 'XIITKR', 'TKR', '151610127', '12-248-070-3', 'Dede', 'Dede Maulana', 'XII', 'R1', 1, 'hs070', 'ps070', 'hs070.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(71, 'XIITKR', 'TKR', '151610129', '12-248-071-2', 'Junaedi', 'Junaedi', 'XII', 'R1', 1, 'hs071', 'ps071', 'hs071.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(72, 'XIITKR', 'TKR', '151610168', '12-248-072-9', 'Muhamad', 'Muhamad Fikri Fahmi Kurniadi', 'XII', 'R1', 1, 'hs072', 'ps072', 'hs072.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(73, 'XIITKR', 'TKR', '151610130', '12-248-073-8', 'Muhamad', 'Muhamad Kevin Fadli Fauzi', 'XII', 'R1', 2, 'hs073', 'ps073', 'hs073.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(74, 'XIITKR', 'TKR', '151610132', '12-248-074-7', 'Muhamad', 'Muhamad Rifki Saputra', 'XII', 'R1', 2, 'hs074', 'ps074', 'hs074.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(75, 'XIITKR', 'TKR', '151610133', '12-248-075-6', 'Padrul', 'Padrul Cahyadi', 'XII', 'R1', 2, 'hs075', 'ps075', 'hs075.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(76, 'XIITKR', 'TKR', '151610169', '12-248-076-5', 'Pentin', 'Pentin Alamsyah', 'XII', 'R1', 2, 'hs076', 'ps076', 'hs076.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(77, 'XIITKR', 'TKR', '151610134', '12-248-077-4', 'Sobri', 'Sobri Saputra', 'XII', 'R1', 2, 'hs077', 'ps077', 'hs077.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(78, 'XIITKR', 'TKR', '151610135', '12-248-078-3', 'Sukendar', 'Sukendar', 'XII', 'R1', 2, 'hs078', 'ps078', 'hs078.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(79, 'XIITKR', 'TKR', '151610120', '12-248-079-2', 'Teguh', 'Teguh Nur Sidik', 'XII', 'R1', 2, 'hs079', 'ps079', 'hs079.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(80, 'XIITKR', 'TKR', '151610136', '12-248-080-9', 'Tubagus', 'Tubagus M. Al-Fajri', 'XII', 'R1', 2, 'hs080', 'ps080', 'hs080.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(81, 'XIITKR', 'TKR', '151610166', '12-248-081-8', 'Wahyu', 'Wahyu Pratama', 'XII', 'R1', 2, 'hs081', 'ps081', 'hs081.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(82, 'XIITKR', 'TKR', '151610172', '12-248-082-7', 'Wahyudin', 'Wahyudin AZ.', 'XII', 'R1', 2, 'hs082', 'ps082', 'hs082.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(83, 'XIITKR', 'TKR', '151610138', '12-248-083-6', 'Wiro', 'Wiro Sugianto', 'XII', 'R1', 2, 'hs083', 'ps083', 'hs083.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(84, 'XIITKR', 'TKR', '151610121', '12-248-084-5', 'Yogi', 'Yogi Priyogo', 'XII', 'R1', 2, 'hs084', 'ps084', 'hs084.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(85, 'XIITKR', 'TKR', '151610139', '12-248-085-4', 'Yuda', 'Yuda Saputra', 'XII', 'R1', 2, 'hs085', 'ps085', 'hs085.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(86, 'XIITKR', 'TKR', '151610140', '12-248-086-3', 'Yuwanda', 'Yuwanda Musyaddir', 'XII', 'R1', 2, 'hs086', 'ps086', 'hs086.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(87, 'XIITKJ', 'TKJ', '151610001', '12-248-087-2', 'Anggi', 'Anggi Gian Sapitri', 'XII', 'R1', 2, 'hs087', 'ps087', 'hs087.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(88, 'XIITKJ', 'TKJ', '151610002', '12-248-088-9', 'Cindy', 'Cindy Apriana', 'XII', 'R1', 2, 'hs088', 'ps088', 'hs088.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(89, 'XIITKJ', 'TKJ', '151610003', '12-248-089-8', 'Dwi', 'Dwi Lestari', 'XII', 'R1', 2, 'hs089', 'ps089', 'hs089.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(90, 'XIITKJ', 'TKJ', '151610004', '12-248-090-7', 'Ebih', 'Ebih', 'XII', 'R1', 2, 'hs090', 'ps090', 'hs090.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(91, 'XIITKJ', 'TKJ', '151610005', '12-248-091-6', 'Elis', 'Elis Saeti Nuraeni', 'XII', 'R1', 3, 'hs091', 'ps091', 'hs091.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(92, 'XIITKJ', 'TKJ', '151610006', '12-248-092-5', 'Euis', 'Euis Susilawati', 'XII', 'R1', 3, 'hs092', 'ps092', 'hs092.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(93, 'XIITKJ', 'TKJ', '151610007', '12-248-093-4', 'Fahmi', 'Fahmi arni', 'XII', 'R1', 3, 'hs093', 'ps093', 'hs093.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(94, 'XIITKJ', 'TKJ', '151610008', '12-248-094-3', 'Fitri', 'Fitri Widiasari', 'XII', 'R1', 3, 'hs094', 'ps094', 'hs094.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(95, 'XIITKJ', 'TKJ', '151610009', '12-248-095-2', 'Gaby', 'Gaby Cantika Oktavia', 'XII', 'R1', 3, 'hs095', 'ps095', 'hs095.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(96, 'XIITKJ', 'TKJ', '151610010', '12-248-096-9', 'Haena', 'Haena Hermawati Yuningsih', 'XII', 'R1', 3, 'hs096', 'ps096', 'hs096.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(97, 'XIITKJ', 'TKJ', '151610011', '12-248-097-8', 'Karlina', 'Karlina', 'XII', 'R1', 3, 'hs097', 'ps097', 'hs097.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(98, 'XIITKJ', 'TKJ', '151610012', '12-248-098-7', 'Kurniawati', 'Kurniawati', 'XII', 'R1', 3, 'hs098', 'ps098', 'hs098.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(99, 'XIITKJ', 'TKJ', '151610013', '12-248-099-6', 'Ladina', 'Ladina al zannah chandra', 'XII', 'R1', 3, 'hs099', 'ps099', 'hs099.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(100, 'XIITKJ', 'TKJ', '151610014', '12-248-100-5', 'Laras', 'Laras Ayu Asmanih', 'XII', 'R1', 3, 'hs100', 'ps100', 'hs100.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(101, 'XIITKJ', 'TKJ', '151610015', '12-248-101-4', 'Lastri', 'Lastri Septriani', 'XII', 'R1', 3, 'hs101', 'ps101', 'hs101.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(102, 'XIITKJ', 'TKJ', '151610016', '12-248-102-3', 'Lisah', 'Lisah Fitri Kurnia', 'XII', 'R1', 3, 'hs102', 'ps102', 'hs102.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(103, 'XIITKJ', 'TKJ', '151610018', '12-248-103-2', 'Lutfi', 'Lutfi Wisti Nandasari', 'XII', 'R2', 3, 'hs103', 'ps103', 'hs103.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(104, 'XIITKJ', 'TKJ', '151610019', '12-248-104-9', 'Maya', 'Maya Karmanih', 'XII', 'R2', 3, 'hs104', 'ps104', 'hs104.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(105, 'XIITKJ', 'TKJ', '151610020', '12-248-105-8', 'Mayang', 'Mayang Sari', 'XII', 'R2', 3, 'hs105', 'ps105', 'hs105.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(106, 'XIITKJ', 'TKJ', '151610021', '12-248-106-7', 'Mayang', 'Mayang Sari Wati', 'XII', 'R2', 3, 'hs106', 'ps106', 'hs106.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(107, 'XIITKJ', 'TKJ', '151610022', '12-248-107-6', 'Megawati', 'Megawati', 'XII', 'R2', 1, 'hs107', 'ps107', 'hs107.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(108, 'XIITKJ', 'TKJ', '151610023', '12-248-108-5', 'Narsih', 'Narsih Agus Priyanti', 'XII', 'R2', 1, 'hs108', 'ps108', 'hs108.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(109, 'XIITKJ', 'TKJ', '151610024', '12-248-109-4', 'Nuraina', 'Nuraina', 'XII', 'R2', 1, 'hs109', 'ps109', 'hs109.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(110, 'XIITKJ', 'TKJ', '151610025', '12-248-110-3', 'Pita', 'Pita Kaputri', 'XII', 'R2', 1, 'hs110', 'ps110', 'hs110.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(111, 'XIITKJ', 'TKJ', '151610026', '12-248-111-2', 'Putri', 'Putri Ayu Lestari', 'XII', 'R2', 1, 'hs111', 'ps111', 'hs111.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(112, 'XIITKJ', 'TKJ', '151610027', '12-248-112-9', 'Putri', 'Putri Hagita', 'XII', 'R2', 1, 'hs112', 'ps112', 'hs112.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(113, 'XIITKJ', 'TKJ', '151610028', '12-248-113-8', 'Rasti', 'Rasti', 'XII', 'R2', 1, 'hs113', 'ps113', 'hs113.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(114, 'XIITKJ', 'TKJ', '151610029', '12-248-114-7', 'Rizky', 'Rizky Khofifah', 'XII', 'R2', 1, 'hs114', 'ps114', 'hs114.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(115, 'XIITKJ', 'TKJ', '151610030', '12-248-115-6', 'Sahroni', 'Sahroni', 'XII', 'R2', 1, 'hs115', 'ps115', 'hs115.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(116, 'XIITKJ', 'TKJ', '151610031', '12-248-116-5', 'Samah', 'Samah Maesaroh', 'XII', 'R2', 1, 'hs116', 'ps116', 'hs116.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(117, 'XIITKJ', 'TKJ', '151610032', '12-248-117-4', 'Sarmila', 'Sarmila Febyola Putri', 'XII', 'R2', 1, 'hs117', 'ps117', 'hs117.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(118, 'XIITKJ', 'TKJ', '151610033', '12-248-118-3', 'Silpi', 'Silpi Damayanti', 'XII', 'R2', 1, 'hs118', 'ps118', 'hs118.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(119, 'XIITKJ', 'TKJ', '151610034', '12-248-119-2', 'Siti', 'Siti Kartini', 'XII', 'R2', 1, 'hs119', 'ps119', 'hs119.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(120, 'XIITKJ', 'TKJ', '151610035', '12-248-120-9', 'Siti', 'Siti Masitoh', 'XII', 'R2', 1, 'hs120', 'ps120', 'hs120.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(121, 'XIITKJ', 'TKJ', '151610036', '12-248-121-8', 'Suci', 'Suci Selawati', 'XII', 'R2', 2, 'hs121', 'ps121', 'hs121.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(122, 'XIITKJ', 'TKJ', '151610037', '12-248-122-7', 'Tania', 'Tania Pratika', 'XII', 'R2', 2, 'hs122', 'ps122', 'hs122.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(123, 'XIITKJ', 'TKJ', '151610038', '12-248-123-6', 'Tarsimah', 'Tarsimah D.', 'XII', 'R2', 2, 'hs123', 'ps123', 'hs123.jpg', 'SR01', NULL, 'islam', 1, 'A'),
(124, 'XIITKJ', 'TKJ', '151610039', '12-248-124-5', 'Trisna', 'Trisna Shalamshah', 'XII', 'R2', 2, 'hs124', 'ps124', 'hs124.jpg', 'SR01', NULL, 'islam', 1, 'B'),
(125, 'XIITKJ', 'TKJ', '151610040', '12-248-125-4', 'Yoga', 'Yoga Maulana Atmaja', 'XII', 'R2', 2, 'hs125', 'ps125', 'hs125.jpg', 'SR01', NULL, 'islam', 1, 'A');

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa_susulan`
--

CREATE TABLE `siswa_susulan` (
  `suId` int(11) NOT NULL,
  `suIdSiswa` int(11) DEFAULT NULL COMMENT 'id siswa',
  `suKodeMapel` varchar(100) DEFAULT NULL COMMENT 'kode mata pelajaran',
  `suIdUjian` int(11) DEFAULT NULL COMMENT 'id ujian',
  `suNamaSiswa` varchar(255) DEFAULT NULL,
  `suNamaMapel` varchar(255) DEFAULT NULL,
  `suNamaUjian` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `soal`
--

CREATE TABLE `soal` (
  `id_soal` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `nomor` int(5) DEFAULT NULL,
  `soal` longblob DEFAULT NULL,
  `jenis` int(1) DEFAULT NULL,
  `pilA` longblob DEFAULT NULL,
  `pilB` longblob DEFAULT NULL,
  `pilC` longblob DEFAULT NULL,
  `pilD` longblob DEFAULT NULL,
  `pilE` longblob DEFAULT NULL,
  `jawaban` varchar(100) DEFAULT NULL,
  `file` longblob DEFAULT NULL,
  `file1` longblob DEFAULT NULL,
  `fileA` longblob DEFAULT NULL,
  `fileB` longblob DEFAULT NULL,
  `fileC` longblob DEFAULT NULL,
  `fileD` longblob DEFAULT NULL,
  `fileE` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tahun`
--

CREATE TABLE `tahun` (
  `thId` int(11) NOT NULL COMMENT 'id tahun',
  `thKode` varchar(50) DEFAULT NULL,
  `thNama` varchar(50) DEFAULT NULL,
  `thAktif` int(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tahun`
--

INSERT INTO `tahun` (`thId`, `thKode`, `thNama`, `thAktif`) VALUES
(1, '2020', '2020', 0),
(2, '2021', '2021', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_block`
--

CREATE TABLE `tb_block` (
  `id_block` int(11) NOT NULL,
  `judul_block` varchar(50) DEFAULT NULL,
  `isi_block` varchar(100) DEFAULT NULL,
  `footer_block` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `tb_block`
--

INSERT INTO `tb_block` (`id_block`, `judul_block`, `isi_block`, `footer_block`) VALUES
(1, 'Upssss !!!', 'Kamu di Block Karna Cantik @mryes', 'Segera Hubungi  @youngkq');

-- --------------------------------------------------------

--
-- Struktur dari tabel `telegram_bot`
--

CREATE TABLE `telegram_bot` (
  `tlId` int(11) NOT NULL COMMENT 'id telegram',
  `tlIdBotTelegram` int(11) DEFAULT NULL COMMENT 'ID Bot Telegram',
  `tlChatId` varchar(255) DEFAULT NULL COMMENT 'Id Chat Grub Telegram',
  `tlNama` varchar(100) DEFAULT NULL,
  `tlKode` varchar(10) DEFAULT NULL COMMENT 'kode telegram untuk tabel ini',
  `tlIdGuru` int(11) DEFAULT NULL COMMENT 'id guru',
  `tlCreat_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `tlKelas` varchar(255) DEFAULT NULL,
  `tlLevel` varchar(20) DEFAULT NULL,
  `tlActive` int(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `telegram_bot`
--

INSERT INTO `telegram_bot` (`tlId`, `tlIdBotTelegram`, `tlChatId`, `tlNama`, `tlKode`, `tlIdGuru`, `tlCreat_at`, `tlKelas`, `tlLevel`, `tlActive`) VALUES
(11, 1, '0', NULL, NULL, 1, '2021-03-27 07:33:54', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `token`
--

CREATE TABLE `token` (
  `id_token` int(11) NOT NULL,
  `token` varchar(6) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `masa_berlaku` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `token`
--

INSERT INTO `token` (`id_token`, `token`, `time`, `masa_berlaku`) VALUES
(1, 'XHEAON', '2023-01-02 04:27:28', '00:15:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `total_sekolah_sinkron`
--

CREATE TABLE `total_sekolah_sinkron` (
  `tssId` int(11) NOT NULL,
  `tssKode` varchar(20) DEFAULT NULL COMMENT 'kode sekolah',
  `tssNama` varchar(255) DEFAULT NULL COMMENT 'nama sekolah',
  `tssKepalaSekolah` varchar(255) DEFAULT NULL,
  `tssOpretator` varchar(255) DEFAULT NULL,
  `tssCreatedBy` timestamp NOT NULL DEFAULT current_timestamp(),
  `tssDateSinkron` datetime DEFAULT NULL COMMENT 'tanggal sinkron',
  `tssNamaSinkron` varchar(100) DEFAULT NULL COMMENT 'nama yg di sinkron',
  `tssJmlDataOk` varchar(50) DEFAULT NULL COMMENT 'jumlah data berhasil di snkron',
  `tssJmlDataNo` varchar(50) DEFAULT NULL COMMENT 'jumlah data gagal di sinkron'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `total_sekolah_sinkron`
--

INSERT INTO `total_sekolah_sinkron` (`tssId`, `tssKode`, `tssNama`, `tssKepalaSekolah`, `tssOpretator`, `tssCreatedBy`, `tssDateSinkron`, `tssNamaSinkron`, `tssJmlDataOk`, `tssJmlDataNo`) VALUES
(17, 'MKKSUS1', 'MKKS LAMPUNG TIMUR', 'NAMA KEPALA SEKOLAH', 'NAMA OPERATOR ', '2021-03-25 13:27:17', '2021-03-26 23:57:57', 'KELAS', '1', ''),
(18, 'MKKSUS1', 'MKKS LAMPUNG TIMUR', 'NAMA KEPALA SEKOLAH', 'NAMA OPERATOR ', '2021-03-25 13:27:35', '2021-03-26 23:57:55', 'DATA_MASTER', '1/3/3/2', ''),
(19, 'MKKSUS1', 'MKKS LAMPUNG TIMUR', 'NAMA KEPALA SEKOLAH', 'NAMA OPERATOR ', '2021-03-25 13:30:58', '2021-03-26 23:57:52', 'SISWA', '123', ''),
(20, 'MKKSUS1', 'MKKS LAMPUNG TIMUR', 'NAMA KEPALA SEKOLAH', 'NAMA OPERATOR ', '2021-03-25 13:31:00', '2021-03-26 23:57:50', 'MAPEL', '10', ''),
(21, 'MKKSUS1', 'MKKS LAMPUNG TIMUR', 'NAMA KEPALA SEKOLAH', 'NAMA OPERATOR ', '2021-03-25 13:31:03', '2021-03-26 23:57:48', 'BANK_SOAL', '3', ''),
(22, 'MKKSUS1', 'MKKS LAMPUNG TIMUR', 'NAMA KEPALA SEKOLAH', 'NAMA OPERATOR ', '2021-03-25 13:31:05', '2021-03-26 23:57:45', 'SOAL', '15', ''),
(23, 'MKKSUS1', 'MKKS LAMPUNG TIMUR', 'NAMA KEPALA SEKOLAH', 'NAMA OPERATOR ', '2021-03-25 15:35:28', '2021-03-26 23:57:43', 'JADWAL', '1', ''),
(24, 'MKKSUS1', 'MKKS LAMPUNG TIMUR', 'NAMA KEPALA SEKOLAH', 'NAMA OPERATOR ', '2021-03-27 04:08:16', '2021-03-27 11:08:30', 'FILE_PENDUKUNG', '5', ''),
(25, 'CANDY', 'CANDY REDIS', 'NAMA KEPALA SEKOLAH', 'NAMA OPERATOR ', '2021-07-15 03:52:40', '2021-07-15 10:52:40', 'KELAS', '1', ''),
(26, 'CANDY', 'CANDY REDIS', 'NAMA KEPALA SEKOLAH', 'NAMA OPERATOR ', '2021-07-15 03:52:43', '2021-07-15 10:52:43', 'DATA_MASTER', '1/3/3/2', ''),
(27, 'CANDY', 'CANDY REDIS', 'NAMA KEPALA SEKOLAH', 'NAMA OPERATOR ', '2021-07-15 03:52:47', '2021-07-15 10:52:47', 'SISWA', '123', ''),
(28, 'CANDY', 'CANDY REDIS', 'NAMA KEPALA SEKOLAH', 'NAMA OPERATOR ', '2021-07-15 03:53:36', '2021-07-15 10:53:36', 'MAPEL', '9', ''),
(29, 'CANDY', 'CANDY REDIS', 'NAMA KEPALA SEKOLAH', 'NAMA OPERATOR ', '2021-07-15 03:53:39', '2021-07-15 10:53:39', 'BANK_SOAL', '5', ''),
(30, 'CANDY', 'CANDY REDIS', 'NAMA KEPALA SEKOLAH', 'NAMA OPERATOR ', '2021-07-15 03:53:42', '2021-07-15 10:53:42', 'SOAL', '70', ''),
(31, 'CANDY', 'CANDY REDIS', 'NAMA KEPALA SEKOLAH', 'NAMA OPERATOR ', '2021-07-15 03:53:45', '2021-07-15 10:53:45', 'JADWAL', '1', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tugas`
--

CREATE TABLE `tugas` (
  `id_tugas` int(11) NOT NULL,
  `id_guru` int(11) DEFAULT NULL,
  `kelas` text DEFAULT NULL,
  `mapel` varchar(255) DEFAULT '0',
  `judul` varchar(50) DEFAULT '0',
  `tugas` longblob DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `tgl_mulai` datetime NOT NULL,
  `tgl_selesai` datetime NOT NULL,
  `tgl` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(11) DEFAULT 1,
  `kode_level` varchar(20) DEFAULT NULL,
  `tugas_siswa` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `ujian`
--

CREATE TABLE `ujian` (
  `id_ujian` int(11) NOT NULL COMMENT 'ID Ujian',
  `id_pk` varchar(10) NOT NULL COMMENT 'ID Jurusan',
  `id_guru` int(5) NOT NULL COMMENT 'ID Guru Mapel',
  `id_mapel` int(5) NOT NULL COMMENT 'ID Mata Pelajaran',
  `kode_ujian` varchar(100) DEFAULT NULL COMMENT 'Kode Ujian',
  `KodeMataPelajaran` varchar(100) DEFAULT NULL COMMENT 'kode mata pelajaran',
  `nama` varchar(100) NOT NULL COMMENT 'Kode Mapel / Bank Soal',
  `slagNama` varchar(100) DEFAULT NULL COMMENT 'Nama Mata Pelajaran',
  `jml_soal` int(5) NOT NULL,
  `jml_esai` int(5) NOT NULL,
  `bobot_pg` int(5) NOT NULL,
  `opsi` int(1) NOT NULL,
  `bobot_esai` int(5) NOT NULL,
  `tampil_pg` int(5) NOT NULL,
  `tampil_esai` int(5) NOT NULL,
  `lama_ujian` int(5) NOT NULL,
  `tgl_ujian` datetime NOT NULL,
  `tgl_selesai` datetime NOT NULL,
  `waktu_ujian` time DEFAULT NULL,
  `selesai_ujian` time DEFAULT NULL,
  `level` varchar(5) NOT NULL,
  `kelas` longtext NOT NULL,
  `siswa` longtext DEFAULT NULL,
  `sesi` varchar(10) DEFAULT NULL,
  `acak` int(1) NOT NULL,
  `token` int(1) NOT NULL,
  `status` int(1) DEFAULT 0,
  `hasil` int(1) DEFAULT NULL,
  `kkm` int(10) DEFAULT NULL,
  `ulang` int(2) DEFAULT NULL,
  `tombol_selsai` int(1) UNSIGNED ZEROFILL DEFAULT 0,
  `acak_opsi` int(1) DEFAULT NULL,
  `history` int(1) DEFAULT 0,
  `status_reset` int(1) DEFAULT 0,
  `jenisSoalUjian` int(1) NOT NULL COMMENT '1 PG, 2 EAI, 3 PG ESAI',
  `soalAgama` int(1) DEFAULT 0 COMMENT 'jenis soal agama',
  `soalAgamaList` varchar(100) DEFAULT 'umum' COMMENT 'list soal agama',
  `soalPaket` varchar(10) DEFAULT 'A' COMMENT 'paket soal',
  `blokir` int(1) DEFAULT 1 COMMENT '1 aktif 0 tidak'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`absId`),
  ADD KEY `absIdSiswa` (`absIdSiswa`),
  ADD KEY `absIdKelas` (`absIdKelas`);

--
-- Indeks untuk tabel `absensi_mapel`
--
ALTER TABLE `absensi_mapel`
  ADD PRIMARY KEY (`amId`),
  ADD KEY `absensi_mapel_ibfk_1` (`amIdGuru`),
  ADD KEY `absensi_mapel_ibfk_3` (`amKelas`),
  ADD KEY `amIdMapel` (`amIdMapel`);

--
-- Indeks untuk tabel `absensi_mapel_anggota`
--
ALTER TABLE `absensi_mapel_anggota`
  ADD PRIMARY KEY (`amaId`),
  ADD KEY `absensi_mapel_anggota_ibfk_1` (`amaIdAbsenMapel`),
  ADD KEY `absensi_mapel_anggota_ibfk_2` (`amaIdSiswa`),
  ADD KEY `absensi_mapel_anggota_ibfk_3` (`amaIdKelas`),
  ADD KEY `absensi_mapel_anggota_ibfk_4` (`amaIdMapel`);

--
-- Indeks untuk tabel `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id_berita`);

--
-- Indeks untuk tabel `bot_telegram`
--
ALTER TABLE `bot_telegram`
  ADD PRIMARY KEY (`botId`);

--
-- Indeks untuk tabel `dapodik`
--
ALTER TABLE `dapodik`
  ADD PRIMARY KEY (`dpId`);

--
-- Indeks untuk tabel `file_pendukung`
--
ALTER TABLE `file_pendukung`
  ADD PRIMARY KEY (`id_file`);

--
-- Indeks untuk tabel `jam_skl`
--
ALTER TABLE `jam_skl`
  ADD PRIMARY KEY (`jmId`);

--
-- Indeks untuk tabel `jawaban`
--
ALTER TABLE `jawaban`
  ADD PRIMARY KEY (`id_jawaban`),
  ADD KEY `id_siswa` (`id_siswa`,`id_mapel`,`id_soal`,`id_ujian`),
  ADD KEY `id_mapel` (`id_mapel`),
  ADD KEY `id_soal` (`id_soal`),
  ADD KEY `id_ujian` (`id_ujian`);

--
-- Indeks untuk tabel `jawaban_copy`
--
ALTER TABLE `jawaban_copy`
  ADD PRIMARY KEY (`id_jawaban`);

--
-- Indeks untuk tabel `jawaban_tugas`
--
ALTER TABLE `jawaban_tugas`
  ADD PRIMARY KEY (`id_jawaban`),
  ADD KEY `id_tugas` (`id_tugas`),
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `id_guru` (`id_guru`);

--
-- Indeks untuk tabel `jenis`
--
ALTER TABLE `jenis`
  ADD PRIMARY KEY (`id_jenis`);

--
-- Indeks untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`jurusan_id`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`idkls`),
  ADD UNIQUE KEY `id_kelas` (`id_kelas`),
  ADD KEY `id_level` (`id_level`),
  ADD KEY `id_pk` (`id_pk`);

--
-- Indeks untuk tabel `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`idlevel`),
  ADD UNIQUE KEY `kode_level` (`kode_level`);

--
-- Indeks untuk tabel `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id_log`);

--
-- Indeks untuk tabel `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id_log`);

--
-- Indeks untuk tabel `mapel`
--
ALTER TABLE `mapel`
  ADD PRIMARY KEY (`id_mapel`),
  ADD UNIQUE KEY `nama` (`nama`),
  ADD KEY `idguru` (`idguru`),
  ADD KEY `idguru_2` (`idguru`),
  ADD KEY `KodeMapel` (`KodeMapel`);

--
-- Indeks untuk tabel `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  ADD PRIMARY KEY (`idmapel`),
  ADD UNIQUE KEY `kode_mapel` (`kode_mapel`),
  ADD KEY `id_level` (`kode_level`);

--
-- Indeks untuk tabel `materi2`
--
ALTER TABLE `materi2`
  ADD PRIMARY KEY (`materi2_id`),
  ADD KEY `id_guru` (`id_guru`),
  ADD KEY `materi2_ibfk_2` (`materi2_mapel`);

--
-- Indeks untuk tabel `materi_view`
--
ALTER TABLE `materi_view`
  ADD PRIMARY KEY (`mtrViewId`),
  ADD KEY `mtrViewIdSiswa` (`mtrViewIdSiswa`),
  ADD KEY `mtrViewIdMateri` (`mtrViewIdMateri`);

--
-- Indeks untuk tabel `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`id_nilai`),
  ADD KEY `id_ujian` (`id_ujian`),
  ADD KEY `id_mapel` (`id_mapel`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indeks untuk tabel `nilai_pindah`
--
ALTER TABLE `nilai_pindah`
  ADD PRIMARY KEY (`id_nilai`),
  ADD KEY `id_ujian` (`id_ujian`),
  ADD KEY `id_mapel` (`id_mapel`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indeks untuk tabel `pengacak`
--
ALTER TABLE `pengacak`
  ADD PRIMARY KEY (`id_pengacak`);

--
-- Indeks untuk tabel `pengawas`
--
ALTER TABLE `pengawas`
  ADD PRIMARY KEY (`id_pengawas`),
  ADD KEY `id_kls` (`id_kls`),
  ADD KEY `id_jrs` (`id_jrs`);

--
-- Indeks untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`id_pengumuman`),
  ADD KEY `user` (`user`);

--
-- Indeks untuk tabel `pk`
--
ALTER TABLE `pk`
  ADD PRIMARY KEY (`idpk`),
  ADD UNIQUE KEY `id_pk` (`id_pk`);

--
-- Indeks untuk tabel `referensi_jurusan`
--
ALTER TABLE `referensi_jurusan`
  ADD PRIMARY KEY (`jurusan_id`);

--
-- Indeks untuk tabel `ruang`
--
ALTER TABLE `ruang`
  ADD PRIMARY KEY (`kode_ruang`);

--
-- Indeks untuk tabel `savsoft_options`
--
ALTER TABLE `savsoft_options`
  ADD PRIMARY KEY (`oid`);

--
-- Indeks untuk tabel `savsoft_qbank`
--
ALTER TABLE `savsoft_qbank`
  ADD PRIMARY KEY (`qid`);

--
-- Indeks untuk tabel `semester`
--
ALTER TABLE `semester`
  ADD PRIMARY KEY (`semester_id`);

--
-- Indeks untuk tabel `sesi`
--
ALTER TABLE `sesi`
  ADD PRIMARY KEY (`kode_sesi`);

--
-- Indeks untuk tabel `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id_setting`);

--
-- Indeks untuk tabel `sinkron`
--
ALTER TABLE `sinkron`
  ADD PRIMARY KEY (`id_singkron`,`nama_data`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD KEY `username` (`username`);

--
-- Indeks untuk tabel `siswa_susulan`
--
ALTER TABLE `siswa_susulan`
  ADD PRIMARY KEY (`suId`),
  ADD KEY `suIdSiswa` (`suIdSiswa`),
  ADD KEY `suIdUjian` (`suIdUjian`);

--
-- Indeks untuk tabel `soal`
--
ALTER TABLE `soal`
  ADD PRIMARY KEY (`id_soal`),
  ADD KEY `id_mapel` (`id_mapel`);

--
-- Indeks untuk tabel `tahun`
--
ALTER TABLE `tahun`
  ADD PRIMARY KEY (`thId`);

--
-- Indeks untuk tabel `tb_block`
--
ALTER TABLE `tb_block`
  ADD PRIMARY KEY (`id_block`);

--
-- Indeks untuk tabel `telegram_bot`
--
ALTER TABLE `telegram_bot`
  ADD PRIMARY KEY (`tlId`),
  ADD KEY `telegram_bot_ibfk_1` (`tlIdGuru`),
  ADD KEY `tlIdBotTelelgram` (`tlIdBotTelegram`);

--
-- Indeks untuk tabel `token`
--
ALTER TABLE `token`
  ADD PRIMARY KEY (`id_token`);

--
-- Indeks untuk tabel `total_sekolah_sinkron`
--
ALTER TABLE `total_sekolah_sinkron`
  ADD PRIMARY KEY (`tssId`);

--
-- Indeks untuk tabel `tugas`
--
ALTER TABLE `tugas`
  ADD PRIMARY KEY (`id_tugas`),
  ADD KEY `id_guru` (`id_guru`);

--
-- Indeks untuk tabel `ujian`
--
ALTER TABLE `ujian`
  ADD PRIMARY KEY (`id_ujian`),
  ADD KEY `nama` (`nama`),
  ADD KEY `id_mapel` (`id_mapel`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absensi`
--
ALTER TABLE `absensi`
  MODIFY `absId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id absen';

--
-- AUTO_INCREMENT untuk tabel `absensi_mapel`
--
ALTER TABLE `absensi_mapel`
  MODIFY `amId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id absen mapel';

--
-- AUTO_INCREMENT untuk tabel `absensi_mapel_anggota`
--
ALTER TABLE `absensi_mapel_anggota`
  MODIFY `amaId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id absen anggota mapel';

--
-- AUTO_INCREMENT untuk tabel `berita`
--
ALTER TABLE `berita`
  MODIFY `id_berita` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `bot_telegram`
--
ALTER TABLE `bot_telegram`
  MODIFY `botId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `dapodik`
--
ALTER TABLE `dapodik`
  MODIFY `dpId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `file_pendukung`
--
ALTER TABLE `file_pendukung`
  MODIFY `id_file` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jam_skl`
--
ALTER TABLE `jam_skl`
  MODIFY `jmId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id jam sekolah', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `jawaban`
--
ALTER TABLE `jawaban`
  MODIFY `id_jawaban` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jawaban_copy`
--
ALTER TABLE `jawaban_copy`
  MODIFY `id_jawaban` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=229;

--
-- AUTO_INCREMENT untuk tabel `jawaban_tugas`
--
ALTER TABLE `jawaban_tugas`
  MODIFY `id_jawaban` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `idkls` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `level`
--
ALTER TABLE `level`
  MODIFY `idlevel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `log`
--
ALTER TABLE `log`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `login`
--
ALTER TABLE `login`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `mapel`
--
ALTER TABLE `mapel`
  MODIFY `id_mapel` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  MODIFY `idmapel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `materi2`
--
ALTER TABLE `materi2`
  MODIFY `materi2_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `materi_view`
--
ALTER TABLE `materi_view`
  MODIFY `mtrViewId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id materi view';

--
-- AUTO_INCREMENT untuk tabel `nilai`
--
ALTER TABLE `nilai`
  MODIFY `id_nilai` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `nilai_pindah`
--
ALTER TABLE `nilai_pindah`
  MODIFY `id_nilai` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pengacak`
--
ALTER TABLE `pengacak`
  MODIFY `id_pengacak` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pengawas`
--
ALTER TABLE `pengawas`
  MODIFY `id_pengawas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=264;

--
-- AUTO_INCREMENT untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `id_pengumuman` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `pk`
--
ALTER TABLE `pk`
  MODIFY `idpk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `savsoft_options`
--
ALTER TABLE `savsoft_options`
  MODIFY `oid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `savsoft_qbank`
--
ALTER TABLE `savsoft_qbank`
  MODIFY `qid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `session`
--
ALTER TABLE `session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `setting`
--
ALTER TABLE `setting`
  MODIFY `id_setting` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `sinkron`
--
ALTER TABLE `sinkron`
  MODIFY `id_singkron` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT untuk tabel `siswa_susulan`
--
ALTER TABLE `siswa_susulan`
  MODIFY `suId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `soal`
--
ALTER TABLE `soal`
  MODIFY `id_soal` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tahun`
--
ALTER TABLE `tahun`
  MODIFY `thId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id tahun', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tb_block`
--
ALTER TABLE `tb_block`
  MODIFY `id_block` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `telegram_bot`
--
ALTER TABLE `telegram_bot`
  MODIFY `tlId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id telegram', AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `token`
--
ALTER TABLE `token`
  MODIFY `id_token` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `total_sekolah_sinkron`
--
ALTER TABLE `total_sekolah_sinkron`
  MODIFY `tssId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT untuk tabel `tugas`
--
ALTER TABLE `tugas`
  MODIFY `id_tugas` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `ujian`
--
ALTER TABLE `ujian`
  MODIFY `id_ujian` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID Ujian';

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_ibfk_1` FOREIGN KEY (`absIdSiswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `absensi_ibfk_2` FOREIGN KEY (`absIdKelas`) REFERENCES `kelas` (`idkls`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `absensi_mapel`
--
ALTER TABLE `absensi_mapel`
  ADD CONSTRAINT `absensi_mapel_ibfk_1` FOREIGN KEY (`amIdGuru`) REFERENCES `pengawas` (`id_pengawas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `absensi_mapel_ibfk_3` FOREIGN KEY (`amKelas`) REFERENCES `kelas` (`idkls`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `absensi_mapel_ibfk_4` FOREIGN KEY (`amIdMapel`) REFERENCES `mata_pelajaran` (`idmapel`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `absensi_mapel_anggota`
--
ALTER TABLE `absensi_mapel_anggota`
  ADD CONSTRAINT `absensi_mapel_anggota_ibfk_1` FOREIGN KEY (`amaIdAbsenMapel`) REFERENCES `absensi_mapel` (`amId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `absensi_mapel_anggota_ibfk_2` FOREIGN KEY (`amaIdSiswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `absensi_mapel_anggota_ibfk_3` FOREIGN KEY (`amaIdKelas`) REFERENCES `kelas` (`idkls`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `absensi_mapel_anggota_ibfk_4` FOREIGN KEY (`amaIdMapel`) REFERENCES `mata_pelajaran` (`idmapel`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `jawaban`
--
ALTER TABLE `jawaban`
  ADD CONSTRAINT `jawaban_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jawaban_ibfk_2` FOREIGN KEY (`id_mapel`) REFERENCES `mapel` (`id_mapel`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jawaban_ibfk_3` FOREIGN KEY (`id_soal`) REFERENCES `soal` (`id_soal`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jawaban_ibfk_4` FOREIGN KEY (`id_ujian`) REFERENCES `ujian` (`id_ujian`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `jawaban_tugas`
--
ALTER TABLE `jawaban_tugas`
  ADD CONSTRAINT `jawaban_tugas_ibfk_1` FOREIGN KEY (`id_tugas`) REFERENCES `tugas` (`id_tugas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jawaban_tugas_ibfk_2` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jawaban_tugas_ibfk_3` FOREIGN KEY (`id_guru`) REFERENCES `pengawas` (`id_pengawas`);

--
-- Ketidakleluasaan untuk tabel `mapel`
--
ALTER TABLE `mapel`
  ADD CONSTRAINT `mapel_ibfk_1` FOREIGN KEY (`idguru`) REFERENCES `pengawas` (`id_pengawas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mapel_ibfk_2` FOREIGN KEY (`KodeMapel`) REFERENCES `mata_pelajaran` (`kode_mapel`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `materi2`
--
ALTER TABLE `materi2`
  ADD CONSTRAINT `materi2_ibfk_1` FOREIGN KEY (`id_guru`) REFERENCES `pengawas` (`id_pengawas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `materi2_ibfk_2` FOREIGN KEY (`materi2_mapel`) REFERENCES `mata_pelajaran` (`kode_mapel`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `materi_view`
--
ALTER TABLE `materi_view`
  ADD CONSTRAINT `materi_view_ibfk_1` FOREIGN KEY (`mtrViewIdSiswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `materi_view_ibfk_2` FOREIGN KEY (`mtrViewIdMateri`) REFERENCES `materi2` (`materi2_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `nilai`
--
ALTER TABLE `nilai`
  ADD CONSTRAINT `nilai_ibfk_1` FOREIGN KEY (`id_ujian`) REFERENCES `ujian` (`id_ujian`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_ibfk_2` FOREIGN KEY (`id_mapel`) REFERENCES `mapel` (`id_mapel`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_ibfk_3` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `nilai_pindah`
--
ALTER TABLE `nilai_pindah`
  ADD CONSTRAINT `nilai_pindah_ibfk_1` FOREIGN KEY (`id_ujian`) REFERENCES `ujian` (`id_ujian`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_pindah_ibfk_2` FOREIGN KEY (`id_mapel`) REFERENCES `mapel` (`id_mapel`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_pindah_ibfk_3` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD CONSTRAINT `pengumuman_ibfk_1` FOREIGN KEY (`user`) REFERENCES `pengawas` (`id_pengawas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `siswa_susulan`
--
ALTER TABLE `siswa_susulan`
  ADD CONSTRAINT `siswa_susulan_ibfk_1` FOREIGN KEY (`suIdSiswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `siswa_susulan_ibfk_2` FOREIGN KEY (`suIdUjian`) REFERENCES `ujian` (`id_ujian`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `soal`
--
ALTER TABLE `soal`
  ADD CONSTRAINT `soal_ibfk_1` FOREIGN KEY (`id_mapel`) REFERENCES `mapel` (`id_mapel`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `telegram_bot`
--
ALTER TABLE `telegram_bot`
  ADD CONSTRAINT `telegram_bot_ibfk_1` FOREIGN KEY (`tlIdGuru`) REFERENCES `pengawas` (`id_pengawas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `telegram_bot_ibfk_2` FOREIGN KEY (`tlIdBotTelegram`) REFERENCES `bot_telegram` (`botId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tugas`
--
ALTER TABLE `tugas`
  ADD CONSTRAINT `tugas_ibfk_1` FOREIGN KEY (`id_guru`) REFERENCES `pengawas` (`id_pengawas`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `ujian`
--
ALTER TABLE `ujian`
  ADD CONSTRAINT `ujian_ibfk_2` FOREIGN KEY (`nama`) REFERENCES `mapel` (`nama`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
