-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 29 Feb 2024 pada 07.02
-- Versi server: 10.4.21-MariaDB
-- Versi PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpustakaan_kevin`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `BukuID` int(11) NOT NULL,
  `Judul` varchar(255) NOT NULL,
  `Penulis` varchar(255) NOT NULL,
  `Penerbit` varchar(255) NOT NULL,
  `TahunTerbit` int(11) NOT NULL,
  `stok_buku` varchar(255) NOT NULL,
  `cover_buku` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`BukuID`, `Judul`, `Penulis`, `Penerbit`, `TahunTerbit`, `stok_buku`, `cover_buku`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Hope', 'Yustika M', 'Gramedia', 2018, '10', 'cover_1_1709094230.jpg', '2024-02-28 11:23:50', '2024-02-28 18:43:11', NULL),
(2, 'Ensiklopedia Sains Usborn', 'Regina S', 'Erlangga', 2017, '10', 'cover_1_1709140205.jpg', '2024-02-29 00:10:05', NULL, NULL),
(3, 'Sejarah Indonesia', 'Drs. Djakariah M. Pd', 'Penerbit Ombak', 2019, '10', 'cover_1_1709140441.jpg', '2024-02-29 00:14:01', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku_keluar`
--

CREATE TABLE `buku_keluar` (
  `id_buku_keluar` int(11) NOT NULL,
  `buku_id` int(11) NOT NULL,
  `stok_buku_keluar` varchar(255) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Trigger `buku_keluar`
--
DELIMITER $$
CREATE TRIGGER `hapus` AFTER DELETE ON `buku_keluar` FOR EACH ROW BEGIN
UPDATE buku SET stok_buku = stok_buku+old.stok_buku_keluar WHERE BukuID=old.buku_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `keluar` AFTER INSERT ON `buku_keluar` FOR EACH ROW BEGIN
UPDATE buku SET stok_buku = stok_buku-new.stok_buku_keluar WHERE BukuID=new.buku_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku_masuk`
--

CREATE TABLE `buku_masuk` (
  `id_buku_masuk` int(11) NOT NULL,
  `buku_id` int(11) NOT NULL,
  `stok_buku_masuk` varchar(255) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Trigger `buku_masuk`
--
DELIMITER $$
CREATE TRIGGER `masuk` AFTER INSERT ON `buku_masuk` FOR EACH ROW BEGIN
UPDATE buku SET stok_buku = stok_buku+new.stok_buku_masuk WHERE BukuID=new.buku_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tambah` AFTER DELETE ON `buku_masuk` FOR EACH ROW BEGIN
UPDATE buku SET stok_buku = stok_buku-old.stok_buku_masuk WHERE BukuID=old.buku_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `durasi_peminjaman`
--

CREATE TABLE `durasi_peminjaman` (
  `id_durasi` int(11) NOT NULL,
  `lama_durasi` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `durasi_peminjaman`
--

INSERT INTO `durasi_peminjaman` (`id_durasi`, `lama_durasi`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '30', '2024-02-29 08:42:39', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategoribuku`
--

CREATE TABLE `kategoribuku` (
  `KategoriID` int(11) NOT NULL,
  `NamaKategori` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kategoribuku`
--

INSERT INTO `kategoribuku` (`KategoriID`, `NamaKategori`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Novel', '2024-02-28 04:57:31', NULL, NULL),
(2, 'Ensiklopedia', '2024-02-28 04:57:31', NULL, NULL),
(3, 'Buku Ilmiah', '2024-02-28 11:05:25', '2024-02-28 11:06:01', NULL),
(4, 'Majalah', '2024-02-29 00:12:02', NULL, NULL),
(5, 'Kamus', '2024-02-29 00:12:26', '2024-02-29 10:14:41', NULL),
(6, 'Kamus', '2024-02-29 10:14:25', '2024-02-29 10:14:37', '2024-02-29 10:14:37');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategoribuku_relasi`
--

CREATE TABLE `kategoribuku_relasi` (
  `KategoriBukuID` int(11) NOT NULL,
  `BukuID` int(11) NOT NULL,
  `KategoriID` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kategoribuku_relasi`
--

INSERT INTO `kategoribuku_relasi` (`KategoriBukuID`, `BukuID`, `KategoriID`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, '2024-02-28 11:23:50', '2024-02-28 18:43:11', NULL),
(2, 2, 2, '2024-02-29 00:10:05', NULL, NULL),
(3, 3, 5, '2024-02-29 00:14:01', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `koleksipribadi`
--

CREATE TABLE `koleksipribadi` (
  `KoleksiID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `BukuID` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `koleksipribadi`
--

INSERT INTO `koleksipribadi` (`KoleksiID`, `UserID`, `BukuID`, `created_at`, `updated_at`, `deleted_at`) VALUES
(7, 3, 1, '2024-02-29 08:49:28', NULL, NULL),
(8, 3, 3, '2024-02-29 08:49:31', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `level`
--

CREATE TABLE `level` (
  `id_level` int(11) NOT NULL,
  `nama_level` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `level`
--

INSERT INTO `level` (`id_level`, `nama_level`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Administrator', '2024-02-28 10:20:26', NULL, NULL),
(2, 'Petugas', '2024-02-28 10:20:26', NULL, NULL),
(3, 'Peminjam', '2024-02-28 10:20:26', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_activity`
--

CREATE TABLE `log_activity` (
  `id_log` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `nama_log` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `log_activity`
--

INSERT INTO `log_activity` (`id_log`, `UserID`, `nama_log`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 1, 'Melakukan Login di website', '2024-02-29 12:39:28', NULL, NULL),
(4, 1, 'Melakukan Log Out dari website', '2024-02-29 12:39:51', NULL, NULL),
(5, 1, 'Melakukan Login di website', '2024-02-29 12:40:05', NULL, NULL),
(6, 1, 'Melakukan Log Out dari website', '2024-02-29 12:46:49', NULL, NULL),
(7, 3, 'Melakukan Login di website', '2024-02-29 12:47:10', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `PeminjamanID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `BukuID` int(11) NOT NULL,
  `stok_buku` varchar(255) NOT NULL,
  `TanggalPeminjaman` date NOT NULL,
  `TanggalPengembalian` date NOT NULL,
  `StatusPeminjaman` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Trigger `peminjaman`
--
DELIMITER $$
CREATE TRIGGER `update_book_stock` AFTER INSERT ON `peminjaman` FOR EACH ROW BEGIN
    DECLARE stock_difference INT;

    -- Jika StatusPeminjaman adalah 1, kurangi stok_buku
    IF NEW.StatusPeminjaman = 1 THEN
        SET stock_difference = -NEW.stok_buku;
    -- Jika StatusPeminjaman adalah 2, tambahkan kembali stok_buku
    ELSEIF NEW.StatusPeminjaman = 2 THEN
        SET stock_difference = NEW.stok_buku;
    -- Jika StatusPeminjaman adalah 0 atau 4, tidak perlu melakukan perubahan pada stok buku
    ELSE
        SET stock_difference = 0;
    END IF;

    -- Update stok_buku hanya jika StatusPeminjaman bukan 0 atau 4
    IF NEW.StatusPeminjaman <> 0 AND NEW.StatusPeminjaman <> 4 THEN
        UPDATE buku SET stok_buku = stok_buku + stock_difference WHERE BukuID = NEW.BukuID;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_book_stock2` AFTER UPDATE ON `peminjaman` FOR EACH ROW BEGIN
    DECLARE stock_difference INT;

    -- Jika StatusPeminjaman adalah 1, kurangi stok_buku
    IF NEW.StatusPeminjaman = 1 THEN
        SET stock_difference = -NEW.stok_buku;
    -- Jika StatusPeminjaman adalah 2, tambahkan kembali stok_buku
    ELSEIF NEW.StatusPeminjaman = 2 THEN
        SET stock_difference = NEW.stok_buku;
    -- Jika StatusPeminjaman adalah 0 atau 4, tidak perlu melakukan perubahan pada stok buku
    ELSE
        SET stock_difference = 0;
    END IF;

    -- Update stok_buku hanya jika StatusPeminjaman bukan 0 atau 4
    IF NEW.StatusPeminjaman <> 0 AND NEW.StatusPeminjaman <> 4 THEN
        UPDATE buku SET stok_buku = stok_buku + stock_difference WHERE BukuID = NEW.BukuID;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `rating`
--

CREATE TABLE `rating` (
  `id_rating` int(11) NOT NULL,
  `nama_rating` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `rating`
--

INSERT INTO `rating` (`id_rating`, `nama_rating`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '5/5 - Sangat Bagus', '2024-02-29 00:19:28', NULL, NULL),
(2, '4/5 - Bagus', '2024-02-29 00:19:28', NULL, NULL),
(3, '3/5 - Biasa saja', '2024-02-29 00:19:28', NULL, NULL),
(4, '2/5 - Tidak Bagus', '2024-02-29 00:19:28', NULL, NULL),
(5, '1/5 - Sangat Tidak Bagus', '2024-02-29 00:19:28', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ulasanbuku`
--

CREATE TABLE `ulasanbuku` (
  `UlasanID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `BukuID` int(11) NOT NULL,
  `Ulasan` text NOT NULL,
  `Rating` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `NamaLengkap` varchar(255) NOT NULL,
  `Alamat` text NOT NULL,
  `level` int(11) NOT NULL,
  `foto` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`UserID`, `Username`, `Password`, `Email`, `NamaLengkap`, `Alamat`, `level`, `foto`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', 'c4ca4238a0b923820dcc509a6f75849b', 'admin@gmail.com', 'Admin', 'Perumahan Admin', 1, 'default.png', '2024-02-28 09:54:08', NULL, NULL),
(2, 'Petugas', 'c4ca4238a0b923820dcc509a6f75849b', 'Ahmad@gmail.com', 'Ahmad', 'Perumahan Ahmad', 2, 'default.png', '2024-02-28 10:47:47', '2024-02-29 10:21:27', NULL),
(3, 'Whisper80', 'c4ca4238a0b923820dcc509a6f75849b', 'whisper80@gmail.com', 'Kevin Fernando', 'Perumahan Kevin', 3, 'default.png', '2024-02-28 10:49:46', '2024-02-29 10:19:52', NULL),
(4, 'Petugas 2', 'c4ca4238a0b923820dcc509a6f75849b', 'petugas2@gmail.com', 'Andrian', 'Perumahan Andrian', 2, 'default.png', '2024-02-29 10:16:54', NULL, NULL),
(5, 'Kelsey903', 'c4ca4238a0b923820dcc509a6f75849b', 'kelsey72@gmail.com', 'Kelsey M.C', 'Perumahan Kelsey', 3, 'default.png', '2024-02-29 10:23:09', '2024-02-29 10:44:56', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `website`
--

CREATE TABLE `website` (
  `id_website` int(11) NOT NULL,
  `nama_website` varchar(255) NOT NULL,
  `logo_website` text DEFAULT NULL,
  `logo_pdf` text DEFAULT NULL,
  `favicon_website` text DEFAULT NULL,
  `no_telepon_website` varchar(15) NOT NULL,
  `email_website` varchar(255) NOT NULL,
  `komplek` text DEFAULT NULL,
  `jalan` text DEFAULT NULL,
  `kelurahan` text DEFAULT NULL,
  `kecamatan` text DEFAULT NULL,
  `kota` text DEFAULT NULL,
  `kode_pos` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `website`
--

INSERT INTO `website` (`id_website`, `nama_website`, `logo_website`, `logo_pdf`, `favicon_website`, `no_telepon_website`, `email_website`, `komplek`, `jalan`, `kelurahan`, `kecamatan`, `kota`, `kode_pos`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Perpustakaan GT', 'logo_contoh.svg', 'logo_pdf_contoh.svg', 'favicon_contoh.svg', '087154628519', 'gtperpustakaan@gmail.com', 'Komp. Pahlawan Mas', 'Jl. Raya Pahlawan No. 123', 'Kel. Sukajadi', 'Kec. Sukasari', 'Kota Batam', '29424', '2023-05-01 16:33:53', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`BukuID`);

--
-- Indeks untuk tabel `buku_keluar`
--
ALTER TABLE `buku_keluar`
  ADD PRIMARY KEY (`id_buku_keluar`);

--
-- Indeks untuk tabel `buku_masuk`
--
ALTER TABLE `buku_masuk`
  ADD PRIMARY KEY (`id_buku_masuk`);

--
-- Indeks untuk tabel `durasi_peminjaman`
--
ALTER TABLE `durasi_peminjaman`
  ADD PRIMARY KEY (`id_durasi`);

--
-- Indeks untuk tabel `kategoribuku`
--
ALTER TABLE `kategoribuku`
  ADD PRIMARY KEY (`KategoriID`);

--
-- Indeks untuk tabel `kategoribuku_relasi`
--
ALTER TABLE `kategoribuku_relasi`
  ADD PRIMARY KEY (`KategoriBukuID`);

--
-- Indeks untuk tabel `koleksipribadi`
--
ALTER TABLE `koleksipribadi`
  ADD PRIMARY KEY (`KoleksiID`);

--
-- Indeks untuk tabel `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id_level`);

--
-- Indeks untuk tabel `log_activity`
--
ALTER TABLE `log_activity`
  ADD PRIMARY KEY (`id_log`);

--
-- Indeks untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`PeminjamanID`);

--
-- Indeks untuk tabel `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id_rating`);

--
-- Indeks untuk tabel `ulasanbuku`
--
ALTER TABLE `ulasanbuku`
  ADD PRIMARY KEY (`UlasanID`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`);

--
-- Indeks untuk tabel `website`
--
ALTER TABLE `website`
  ADD PRIMARY KEY (`id_website`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `buku`
--
ALTER TABLE `buku`
  MODIFY `BukuID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `buku_keluar`
--
ALTER TABLE `buku_keluar`
  MODIFY `id_buku_keluar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `buku_masuk`
--
ALTER TABLE `buku_masuk`
  MODIFY `id_buku_masuk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `durasi_peminjaman`
--
ALTER TABLE `durasi_peminjaman`
  MODIFY `id_durasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `kategoribuku`
--
ALTER TABLE `kategoribuku`
  MODIFY `KategoriID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `kategoribuku_relasi`
--
ALTER TABLE `kategoribuku_relasi`
  MODIFY `KategoriBukuID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `koleksipribadi`
--
ALTER TABLE `koleksipribadi`
  MODIFY `KoleksiID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `level`
--
ALTER TABLE `level`
  MODIFY `id_level` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `log_activity`
--
ALTER TABLE `log_activity`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `PeminjamanID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `rating`
--
ALTER TABLE `rating`
  MODIFY `id_rating` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `ulasanbuku`
--
ALTER TABLE `ulasanbuku`
  MODIFY `UlasanID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `website`
--
ALTER TABLE `website`
  MODIFY `id_website` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
