-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Jun 2024 pada 09.15
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbperusahaan`
--

DELIMITER $$
--
-- Prosedur
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `Filter_Kehadiran_Karyawan` (IN `karyawan_id` INT)   BEGIN
    SELECT * FROM kehadiran WHERE Id_Karyawan = karyawan_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Filter_Penggajian_Karyawan` (IN `karyawan_id` INT)   BEGIN
    SELECT * FROM penggajian WHERE Id_Karyawan = karyawan_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `hapus_karyawan` (IN `p_Id_Karyawan` INT)   BEGIN
       DELETE FROM karyawan WHERE Id_Karyawan = p_Id_Karyawan;
   END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `hitung_gaji` (IN `p_Id_Karyawan` INT, IN `p_Bulan` INT, IN `p_Tahun` INT, OUT `p_Gaji_Bersih` DECIMAL(15,2))   BEGIN
    DECLARE v_Gaji_Pokok DECIMAL(15,2);
    DECLARE v_Tunjangan DECIMAL(15,2);
    DECLARE v_Potongan DECIMAL(15,2) DEFAULT 0;
    DECLARE v_Tanggal DATE;
    DECLARE v_Status_Kehadiran ENUM('Hadir', 'Ijin', 'Sakit', 'Tanpa Keterangan');
    DECLARE v_DaysInMonth INT;
    DECLARE v_CurrentDay INT DEFAULT 1;

    -- Get the basic salary for the employee
    SELECT Gaji INTO v_Gaji_Pokok FROM karyawan WHERE Id_Karyawan = p_Id_Karyawan;
    
    -- Calculate the allowance as 10% of the basic salary
    SET v_Tunjangan = 0.10 * v_Gaji_Pokok;
    
    -- Get the number of days in the specified month and year
    SET v_DaysInMonth = DAY(LAST_DAY(CONCAT(p_Tahun, '-', p_Bulan, '-01')));
    
    -- Loop through each day of the month
    WHILE v_CurrentDay <= v_DaysInMonth DO
        SET v_Tanggal = CONCAT(p_Tahun, '-', p_Bulan, '-', LPAD(v_CurrentDay, 2, '0'));
        
        -- Get the attendance status for the current day
        SELECT Status_Kehadiran INTO v_Status_Kehadiran
        FROM kehadiran 
        WHERE Id_Karyawan = p_Id_Karyawan 
          AND Tanggal = v_Tanggal
        LIMIT 1;
        
        -- Add deductions based on the attendance status
        IF v_Status_Kehadiran = 'Ijin' OR v_Status_Kehadiran = 'Sakit' THEN
            SET v_Potongan = v_Potongan + (0.015 * v_Gaji_Pokok);
        ELSEIF v_Status_Kehadiran = 'Tanpa Keterangan' THEN
            SET v_Potongan = v_Potongan + (0.02 * v_Gaji_Pokok);
        END IF;
        
        SET v_CurrentDay = v_CurrentDay + 1;
    END WHILE;
    
    -- Calculate the net salary
    SET p_Gaji_Bersih = v_Gaji_Pokok + v_Tunjangan - v_Potongan;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Jumlah_Penjualan` (IN `p_Bulan` INT, IN `p_Tahun` INT, OUT `p_JumlahPenjualan` DECIMAL(15,2))   BEGIN
    SELECT
        SUM(Total_Harga) INTO p_JumlahPenjualan
    FROM penjualan
    WHERE MONTH(Tanggal_Penjualan) = p_Bulan AND YEAR(Tanggal_Penjualan) = p_Tahun;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Jumlah_Proyek_Selesai` (IN `p_Bulan` INT, IN `p_Tahun` INT, OUT `p_JumlahProyekSelesai` INT)   BEGIN
    SELECT
        COUNT(*) INTO p_JumlahProyekSelesai
    FROM proyek
    WHERE MONTH(Tanggal_Selesai) = p_Bulan AND YEAR(Tanggal_Selesai) = p_Tahun;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `penjualan_6_bulan` ()   BEGIN
    SELECT 
        DATE_FORMAT(Tanggal_Penjualan, '%Y-%m') AS Bulan,
        SUM(Total_Harga) AS TotalPenjualan
    FROM 
        penjualan
    WHERE 
        Tanggal_Penjualan >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
    GROUP BY 
        DATE_FORMAT(Tanggal_Penjualan, '%Y-%m')
    ORDER BY 
        DATE_FORMAT(Tanggal_Penjualan, '%Y-%m');
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Persentase_Kehadiran` (IN `p_Bulan` INT, IN `p_Tahun` INT, OUT `p_Persentase` DECIMAL(5,2))   BEGIN
    SELECT
        (COUNT(CASE WHEN Status_Kehadiran = 'Hadir' THEN 1 END) / COUNT(*)) * 100 INTO p_Persentase
    FROM kehadiran
    WHERE MONTH(Tanggal) = p_Bulan AND YEAR(Tanggal) = p_Tahun;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proses_penggajian_otomatis` (IN `p_Id_Karyawan` INT, IN `p_Bulan` INT, IN `p_Tahun` INT)   BEGIN
    DECLARE v_Gaji_Pokok DECIMAL(15,2);
    DECLARE v_Tunjangan DECIMAL(15,2);
    DECLARE v_Potongan DECIMAL(15,2) DEFAULT 0;
    DECLARE v_Gaji_Bersih DECIMAL(15,2);
    DECLARE v_Tanggal DATE;
    DECLARE v_Status_Kehadiran ENUM('Hadir', 'Ijin', 'Sakit', 'Tanpa Keterangan');
    DECLARE v_HariperBulan INT;
    DECLARE v_HariSekarang INT DEFAULT 1;

    SELECT Gaji INTO v_Gaji_Pokok FROM karyawan WHERE Id_Karyawan = p_Id_Karyawan;
    
    SET v_Tunjangan = 0.10 * v_Gaji_Pokok;
    
    SET v_HariPerBulan = DAY(LAST_DAY(CONCAT(p_Tahun, '-', p_Bulan, '-01')));
    
    WHILE v_HariSekarang <= v_HariperBulan DO
        SET v_Tanggal = CONCAT(p_Tahun, '-', p_Bulan, '-', LPAD(v_HariSekarang, 2, '0'));
        
        SELECT Status_Kehadiran INTO v_Status_Kehadiran
        FROM kehadiran 
        WHERE Id_Karyawan = p_Id_Karyawan 
          AND Tanggal = v_Tanggal
        LIMIT 1;
        
        IF v_Status_Kehadiran = 'Ijin' OR v_Status_Kehadiran = 'Sakit' THEN
            SET v_Potongan = v_Potongan + (0.015 * v_Gaji_Pokok);
        ELSEIF v_Status_Kehadiran = 'Tanpa Keterangan' THEN
            SET v_Potongan = v_Potongan + (0.02 * v_Gaji_Pokok);
        END IF;
        
        SET v_HariSekarang = v_HariSekarang + 1;
    END WHILE;
    
    SET v_Gaji_Bersih = v_Gaji_Pokok + v_Tunjangan - v_Potongan;

    INSERT INTO penggajian (Id_Karyawan, Bulan, Tahun, Gaji_Pokok, Tunjangan, Potongan, Gaji_Bersih)
    VALUES (p_Id_Karyawan, p_Bulan, p_Tahun, v_Gaji_Pokok, v_Tunjangan, v_Potongan, v_Gaji_Bersih);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SearchKaryawan` (IN `pencarian` VARCHAR(50))   BEGIN
    SELECT *
    FROM karyawan
    WHERE 
        Nama LIKE CONCAT('%', pencarian, '%')
        OR Jabatan LIKE CONCAT('%', pencarian, '%')
        OR Id_Departemen LIKE CONCAT('%', pencarian, '%');
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tambah_karyawan` (IN `p_Id` INT, IN `p_Nama` VARCHAR(50), IN `p_Jabatan` VARCHAR(50), IN `p_Departemen` INT, IN `p_Tanggal_Bergabung` DATE, IN `p_Gaji` DECIMAL(50,0), IN `p_Kontak` VARCHAR(50))   BEGIN
       INSERT INTO karyawan (Id_Karyawan, Nama, Jabatan, Id_Departemen, Tanggal_Bergabung, Gaji, Kontak)
       VALUES (p_Id, p_Nama, p_Jabatan, p_Departemen, p_Tanggal_Bergabung, p_Gaji, p_Kontak);
   END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_karyawan` (IN `p_Id_Karyawan` INT, IN `p_Nama` VARCHAR(50), IN `p_Jabatan` VARCHAR(50), IN `p_Departemen` INT, IN `p_Tanggal_Bergabung` DATE, IN `p_Gaji` DECIMAL(50,0), IN `p_Kontak` VARCHAR(50))   BEGIN
       UPDATE karyawan
       SET Nama = p_Nama, Jabatan = p_Jabatan, Id_Departemen = p_Departemen, 
           Tanggal_Bergabung = p_Tanggal_Bergabung, Gaji = p_Gaji, Kontak = p_Kontak
       WHERE Id_Karyawan = p_Id_Karyawan;
   END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `departemen`
--

CREATE TABLE `departemen` (
  `Id_Departemen` int(50) NOT NULL,
  `Nama_Departemen` varchar(50) NOT NULL,
  `Deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `departemen`
--

INSERT INTO `departemen` (`Id_Departemen`, `Nama_Departemen`, `Deskripsi`) VALUES
(1, 'Manajemen', 'Mengelola operasional'),
(2, 'Sumber Daya Manusia', 'Mengelola HR'),
(3, 'Teknologi Informasi', 'Mengelola IT'),
(4, 'Produksi', 'Mengelola produksi'),
(5, 'Pemasaran', 'Mengelola pemasaran'),
(6, 'Keuangan', 'Mengelola keuangan'),
(7, 'Penjualan', 'Mengelola penjualan'),
(8, 'Layanan Pelanggan', 'Mengelola layanan pelanggan'),
(9, 'Logistik', 'Mengelola logistik'),
(10, 'Pengembangan Produk', 'Mengelola pengembangan produk'),
(11, 'Tukang', 'Mengelola makanan');

--
-- Trigger `departemen`
--
DELIMITER $$
CREATE TRIGGER `cek_departement_karyawan` BEFORE DELETE ON `departemen` FOR EACH ROW BEGIN
    DECLARE employee_count INT;
    SELECT COUNT(*) INTO employee_count
    FROM karyawan
    WHERE Id_Departemen = OLD.Id_Departemen;

    IF employee_count > 0 THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Tidak dapat menghapus departemen yang masih memiliki karyawan.';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `jumlahkaryawanmasuk13hariterakhir`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `jumlahkaryawanmasuk13hariterakhir` (
`Tanggal` date
,`Jumlah_Karyawan_Masuk` bigint(21)
);

-- --------------------------------------------------------

--
-- Struktur dari tabel `karyawan`
--

CREATE TABLE `karyawan` (
  `Id_Karyawan` int(50) NOT NULL,
  `Nama` varchar(50) NOT NULL,
  `Jabatan` varchar(50) NOT NULL,
  `Id_Departemen` int(50) NOT NULL,
  `Tanggal_Bergabung` date NOT NULL,
  `Gaji` decimal(50,0) NOT NULL,
  `Kontak` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `karyawan`
--

INSERT INTO `karyawan` (`Id_Karyawan`, `Nama`, `Jabatan`, `Id_Departemen`, `Tanggal_Bergabung`, `Gaji`, `Kontak`) VALUES
(1, 'Erik Ten Hag', 'Manager', 1, '2020-01-15', '15000000', '88888888888'),
(2, 'Bruno', 'Admin', 4, '2020-02-17', '6000000', '81888888888'),
(3, 'Agus Prasetyo', 'Staff IT', 3, '2021-06-10', '9000000', '2147483647'),
(4, 'Rina Kurniawati', 'Supervisor', 4, '2018-11-05', '12000000', '6282390187'),
(5, 'Dewi Lestari', 'Admin', 2, '2022-02-20', '7000000', '2147483647'),
(6, 'Fajar Setiawan', 'Marketing', 4, '2020-12-10', '8500000', '2147483647'),
(7, 'Lutfi Ramadhan', 'Finance', 3, '2019-07-15', '9500000', '2147483647'),
(8, 'Megawati', 'Customer Service', 2, '2021-09-25', '7500000', '2147483647'),
(9, 'Ahmad Fauzi', 'Sales', 4, '2019-05-05', '9000000', '2147483647'),
(10, 'Ratna Sari', 'HR Manager', 2, '2018-03-30', '13000000', '888888'),
(17, 'Bung Towel', 'Staff HR', 11, '0000-00-00', '8500000', '6282390187'),
(19, 'Braithwhite', 'HR Manager', 6, '2024-06-12', '8500000', '6282390187'),
(20, 'Onana', 'Staff IT', 1, '2024-06-14', '8500000', '62823901'),
(25, 'Mudryk', 'HR Manager', 2, '2024-06-14', '10000000', '088888888888'),
(33, 'Goat Lingard', 'Staff HR', 7, '2024-06-14', '12000000', '088888888888'),
(40, 'Anthony ', 'Staff HR', 7, '2024-06-14', '7000000', '088888888888'),
(50, 'Camavinga', 'HR Manager', 5, '2024-06-14', '12000000', '088888888888');

--
-- Trigger `karyawan`
--
DELIMITER $$
CREATE TRIGGER `cek_karyawan_proyek_aktif` BEFORE DELETE ON `karyawan` FOR EACH ROW BEGIN
    DECLARE project_count INT;
    SELECT COUNT(*) INTO project_count
    FROM proyek
    WHERE Id_Karyawan = OLD.Id_Karyawan
        AND Tanggal_Selesai >= CURDATE();

    IF project_count > 0 THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Tidak dapat menghapus karyawan yang memiliki proyek aktif.';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `cek_mingaji_update` BEFORE UPDATE ON `karyawan` FOR EACH ROW BEGIN
    DECLARE minimum_wage DECIMAL(50, 0) DEFAULT 5000000;
    IF NEW.Gaji < minimum_wage THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Gaji tidak boleh dikurangi menjadi di bawah gaji minimum.';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `cek_minimal_gaji` BEFORE INSERT ON `karyawan` FOR EACH ROW BEGIN
    DECLARE minimum_wage DECIMAL(50, 0) DEFAULT 1000000;
    IF NEW.Gaji < minimum_wage THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Gaji tidak boleh kurang dari gaji minimum.';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `cek_tglgabung_kar_update` BEFORE UPDATE ON `karyawan` FOR EACH ROW BEGIN
    IF NEW.Tanggal_Bergabung > CURDATE() THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Tanggal bergabung tidak boleh diubah menjadi tanggal di masa depan.';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `cek_tglgabung_karyawan` BEFORE INSERT ON `karyawan` FOR EACH ROW BEGIN
    IF NEW.Tanggal_Bergabung > CURDATE() THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Tanggal bergabung tidak boleh di masa depan.';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `check_karyawan_data` BEFORE DELETE ON `karyawan` FOR EACH ROW BEGIN
    DECLARE count_kehadiran INT;
    DECLARE count_penggajian INT;
    DECLARE count_proyek INT;
    DECLARE count_penjualan INT;
    

    SELECT COUNT(*) INTO count_kehadiran FROM kehadiran WHERE Id_Karyawan = OLD.Id_Karyawan;
    SELECT COUNT(*) INTO count_penggajian FROM penggajian WHERE Id_Karyawan = OLD.Id_Karyawan;
    SELECT COUNT(*) INTO count_proyek FROM proyek WHERE Id_Karyawan = OLD.Id_Karyawan;
    SELECT COUNT(*) INTO count_penjualan FROM penjualan WHERE Id_Karyawan = OLD.Id_Karyawan;
    
    IF count_kehadiran > 0 OR count_penggajian > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Karyawan ini masih terdapat data di tabel lain. Hapus data terkait terlebih dahulu.';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kehadiran`
--

CREATE TABLE `kehadiran` (
  `Id_Kehadiran` int(50) NOT NULL,
  `Id_Karyawan` int(50) NOT NULL,
  `Tanggal` date NOT NULL,
  `Jam_Masuk` time NOT NULL,
  `Jam_Keluar` time NOT NULL,
  `Status_Kehadiran` enum('Hadir','Ijin','Sakit','Tanpa Keterangan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kehadiran`
--

INSERT INTO `kehadiran` (`Id_Kehadiran`, `Id_Karyawan`, `Tanggal`, `Jam_Masuk`, `Jam_Keluar`, `Status_Kehadiran`) VALUES
(1, 1, '2024-06-01', '08:00:00', '17:00:00', 'Hadir'),
(2, 2, '2024-06-01', '08:15:00', '17:10:00', 'Hadir'),
(3, 3, '2024-06-01', '08:05:00', '17:00:00', 'Hadir'),
(4, 4, '2024-06-01', '08:00:00', '17:00:00', 'Hadir'),
(5, 5, '2024-06-01', '08:10:00', '17:00:00', 'Hadir'),
(6, 6, '2024-06-01', '08:00:00', '17:15:00', 'Hadir'),
(7, 7, '2024-06-01', '08:20:00', '17:10:00', 'Hadir'),
(8, 8, '2024-06-01', '08:05:00', '17:05:00', 'Hadir'),
(9, 9, '2024-06-01', '08:15:00', '17:00:00', 'Hadir'),
(10, 10, '2024-06-01', '08:00:00', '17:00:00', 'Hadir'),
(11, 8, '2024-06-05', '08:00:00', '17:00:00', 'Hadir'),
(12, 3, '2024-06-06', '08:00:00', '17:00:00', 'Hadir'),
(13, 1, '2024-05-26', '08:00:00', '17:00:00', 'Hadir'),
(14, 2, '2024-05-26', '08:00:00', '17:00:00', 'Ijin'),
(15, 3, '2024-05-26', '08:00:00', '17:00:00', 'Sakit'),
(16, 4, '2024-05-26', '08:00:00', '17:00:00', 'Tanpa Keterangan'),
(17, 5, '2024-05-26', '08:00:00', '17:00:00', 'Hadir'),
(18, 6, '2024-05-26', '08:00:00', '17:00:00', 'Ijin'),
(19, 7, '2024-05-26', '08:00:00', '17:00:00', 'Sakit'),
(20, 8, '2024-05-26', '08:00:00', '17:00:00', 'Tanpa Keterangan'),
(21, 9, '2024-05-26', '08:00:00', '17:00:00', 'Hadir'),
(22, 10, '2024-05-26', '08:00:00', '17:00:00', 'Ijin'),
(23, 1, '2024-05-27', '08:00:00', '17:00:00', 'Sakit'),
(24, 2, '2024-05-27', '08:00:00', '17:00:00', 'Tanpa Keterangan'),
(25, 3, '2024-05-27', '08:00:00', '17:00:00', 'Hadir'),
(26, 4, '2024-05-27', '08:00:00', '17:00:00', 'Ijin'),
(27, 5, '2024-05-27', '08:00:00', '17:00:00', 'Sakit'),
(28, 6, '2024-05-27', '08:00:00', '17:00:00', 'Tanpa Keterangan'),
(29, 7, '2024-05-27', '08:00:00', '17:00:00', 'Hadir'),
(30, 8, '2024-05-27', '08:00:00', '17:00:00', 'Ijin'),
(31, 9, '2024-05-27', '08:00:00', '17:00:00', 'Sakit'),
(32, 10, '2024-05-27', '08:00:00', '17:00:00', 'Tanpa Keterangan'),
(33, 1, '2024-05-28', '08:00:00', '17:00:00', 'Hadir'),
(34, 2, '2024-05-28', '08:00:00', '17:00:00', 'Ijin'),
(35, 3, '2024-05-28', '08:00:00', '17:00:00', 'Sakit'),
(36, 4, '2024-05-28', '08:00:00', '17:00:00', 'Tanpa Keterangan'),
(37, 5, '2024-05-28', '08:00:00', '17:00:00', 'Hadir'),
(38, 6, '2024-05-28', '08:00:00', '17:00:00', 'Ijin'),
(39, 7, '2024-05-28', '08:00:00', '17:00:00', 'Sakit'),
(40, 8, '2024-05-28', '08:00:00', '17:00:00', 'Tanpa Keterangan'),
(41, 9, '2024-05-28', '08:00:00', '17:00:00', 'Hadir'),
(42, 10, '2024-05-28', '08:00:00', '17:00:00', 'Ijin'),
(43, 1, '2024-05-29', '08:00:00', '17:00:00', 'Sakit'),
(44, 2, '2024-05-29', '08:00:00', '17:00:00', 'Tanpa Keterangan'),
(45, 3, '2024-05-29', '08:00:00', '17:00:00', 'Hadir'),
(46, 4, '2024-05-29', '08:00:00', '17:00:00', 'Ijin'),
(47, 5, '2024-05-29', '08:00:00', '17:00:00', 'Sakit'),
(48, 6, '2024-05-29', '08:00:00', '17:00:00', 'Tanpa Keterangan'),
(49, 7, '2024-05-29', '08:00:00', '17:00:00', 'Hadir'),
(50, 8, '2024-05-29', '08:00:00', '17:00:00', 'Ijin'),
(51, 9, '2024-05-29', '08:00:00', '17:00:00', 'Sakit'),
(52, 10, '2024-05-29', '08:00:00', '17:00:00', 'Tanpa Keterangan'),
(53, 1, '2024-05-30', '08:00:00', '17:00:00', 'Hadir'),
(54, 2, '2024-05-30', '08:00:00', '17:00:00', 'Ijin'),
(55, 3, '2024-05-30', '08:00:00', '17:00:00', 'Sakit'),
(56, 4, '2024-05-30', '08:00:00', '17:00:00', 'Tanpa Keterangan'),
(57, 5, '2024-05-30', '08:00:00', '17:00:00', 'Hadir'),
(58, 6, '2024-05-30', '08:00:00', '17:00:00', 'Ijin'),
(59, 7, '2024-05-30', '08:00:00', '17:00:00', 'Sakit'),
(60, 8, '2024-05-30', '08:00:00', '17:00:00', 'Tanpa Keterangan'),
(61, 9, '2024-05-30', '08:00:00', '17:00:00', 'Hadir'),
(62, 10, '2024-05-30', '08:00:00', '17:00:00', 'Ijin'),
(63, 1, '2024-05-31', '08:00:00', '17:00:00', 'Sakit'),
(64, 2, '2024-05-31', '08:00:00', '17:00:00', 'Tanpa Keterangan'),
(65, 3, '2024-05-31', '08:00:00', '17:00:00', 'Hadir'),
(66, 4, '2024-05-31', '08:00:00', '17:00:00', 'Ijin'),
(67, 5, '2024-05-31', '08:00:00', '17:00:00', 'Sakit'),
(68, 6, '2024-05-31', '08:00:00', '17:00:00', 'Tanpa Keterangan'),
(69, 7, '2024-05-31', '08:00:00', '17:00:00', 'Hadir'),
(70, 8, '2024-05-31', '08:00:00', '17:00:00', 'Ijin'),
(71, 9, '2024-05-31', '08:00:00', '17:00:00', 'Sakit'),
(72, 10, '2024-05-31', '08:00:00', '17:00:00', 'Tanpa Keterangan'),
(73, 1, '2024-06-01', '08:00:00', '17:00:00', 'Hadir'),
(74, 2, '2024-06-01', '08:00:00', '17:00:00', 'Ijin'),
(75, 3, '2024-06-01', '08:00:00', '17:00:00', 'Sakit'),
(76, 4, '2024-06-01', '08:00:00', '17:00:00', 'Tanpa Keterangan'),
(77, 5, '2024-06-01', '08:00:00', '17:00:00', 'Hadir'),
(78, 6, '2024-06-01', '08:00:00', '17:00:00', 'Ijin'),
(79, 7, '2024-06-01', '08:00:00', '17:00:00', 'Sakit'),
(80, 8, '2024-06-01', '08:00:00', '17:00:00', 'Tanpa Keterangan'),
(81, 9, '2024-06-01', '08:00:00', '17:00:00', 'Hadir'),
(82, 10, '2024-06-01', '08:00:00', '17:00:00', 'Ijin'),
(83, 1, '2024-06-02', '08:00:00', '17:00:00', 'Sakit'),
(84, 2, '2024-06-02', '08:00:00', '17:00:00', 'Tanpa Keterangan'),
(85, 3, '2024-06-02', '08:00:00', '17:00:00', 'Hadir'),
(86, 4, '2024-06-02', '08:00:00', '17:00:00', 'Ijin'),
(87, 5, '2024-06-02', '08:00:00', '17:00:00', 'Sakit'),
(88, 6, '2024-06-02', '08:00:00', '17:00:00', 'Tanpa Keterangan'),
(89, 7, '2024-06-02', '08:00:00', '17:00:00', 'Hadir'),
(90, 8, '2024-06-02', '08:00:00', '17:00:00', 'Ijin'),
(91, 9, '2024-06-02', '08:00:00', '17:00:00', 'Sakit'),
(92, 10, '2024-06-02', '08:00:00', '17:00:00', 'Tanpa Keterangan'),
(93, 1, '2024-06-03', '08:00:00', '17:00:00', 'Hadir'),
(94, 2, '2024-06-03', '08:00:00', '17:00:00', 'Ijin'),
(95, 3, '2024-06-03', '08:00:00', '17:00:00', 'Sakit'),
(96, 4, '2024-06-03', '08:00:00', '17:00:00', 'Tanpa Keterangan'),
(97, 5, '2024-06-03', '08:00:00', '17:00:00', 'Hadir'),
(98, 6, '2024-06-03', '08:00:00', '17:00:00', 'Ijin'),
(99, 7, '2024-06-03', '08:00:00', '17:00:00', 'Sakit'),
(100, 8, '2024-06-03', '08:00:00', '17:00:00', 'Tanpa Keterangan'),
(101, 9, '2024-06-03', '08:00:00', '17:00:00', 'Hadir'),
(102, 10, '2024-06-03', '08:00:00', '17:00:00', 'Ijin'),
(103, 1, '2024-06-04', '08:00:00', '17:00:00', 'Sakit'),
(104, 2, '2024-06-04', '08:00:00', '17:00:00', 'Tanpa Keterangan'),
(105, 3, '2024-06-04', '08:00:00', '17:00:00', 'Hadir'),
(106, 4, '2024-06-04', '08:00:00', '17:00:00', 'Ijin'),
(107, 5, '2024-06-04', '08:00:00', '17:00:00', 'Sakit'),
(108, 6, '2024-06-04', '08:00:00', '17:00:00', 'Tanpa Keterangan'),
(109, 7, '2024-06-04', '08:00:00', '17:00:00', 'Hadir'),
(110, 8, '2024-06-04', '08:00:00', '17:00:00', 'Ijin'),
(111, 9, '2024-06-04', '08:00:00', '17:00:00', 'Sakit'),
(112, 10, '2024-06-04', '08:00:00', '17:00:00', 'Tanpa Keterangan'),
(113, 1, '2024-06-05', '08:00:00', '17:00:00', 'Hadir'),
(114, 2, '2024-06-05', '08:00:00', '17:00:00', 'Ijin'),
(115, 3, '2024-06-05', '08:00:00', '17:00:00', 'Sakit'),
(116, 4, '2024-06-05', '08:00:00', '17:00:00', 'Tanpa Keterangan'),
(117, 5, '2024-06-05', '08:00:00', '17:00:00', 'Hadir'),
(118, 6, '2024-06-05', '08:00:00', '17:00:00', 'Ijin'),
(119, 7, '2024-06-05', '08:00:00', '17:00:00', 'Sakit'),
(120, 8, '2024-06-05', '08:00:00', '17:00:00', 'Tanpa Keterangan'),
(121, 9, '2024-06-05', '08:00:00', '17:00:00', 'Hadir'),
(122, 10, '2024-06-05', '08:00:00', '17:00:00', 'Ijin'),
(123, 1, '2024-06-06', '08:00:00', '17:00:00', 'Sakit'),
(124, 2, '2024-06-06', '08:00:00', '17:00:00', 'Tanpa Keterangan'),
(125, 3, '2024-06-06', '08:00:00', '17:00:00', 'Hadir'),
(126, 4, '2024-06-06', '08:00:00', '17:00:00', 'Ijin'),
(127, 5, '2024-06-06', '08:00:00', '17:00:00', 'Sakit'),
(128, 6, '2024-06-06', '08:00:00', '17:00:00', 'Tanpa Keterangan'),
(129, 7, '2024-06-06', '08:00:00', '17:00:00', 'Hadir'),
(130, 8, '2024-06-06', '08:00:00', '17:00:00', 'Ijin'),
(131, 9, '2024-06-06', '08:00:00', '17:00:00', 'Sakit'),
(132, 10, '2024-06-06', '08:00:00', '17:00:00', 'Tanpa Keterangan'),
(133, 1, '2024-06-07', '08:00:00', '17:00:00', 'Hadir'),
(134, 2, '2024-06-07', '08:00:00', '17:00:00', 'Ijin'),
(135, 3, '2024-06-07', '08:00:00', '17:00:00', 'Sakit'),
(136, 4, '2024-06-07', '08:00:00', '17:00:00', 'Tanpa Keterangan'),
(137, 5, '2024-06-07', '08:00:00', '17:00:00', 'Hadir'),
(138, 6, '2024-06-07', '08:00:00', '17:00:00', 'Ijin'),
(139, 7, '2024-06-07', '08:00:00', '17:00:00', 'Sakit'),
(140, 8, '2024-06-07', '08:00:00', '17:00:00', 'Tanpa Keterangan'),
(141, 9, '2024-06-07', '08:00:00', '17:00:00', 'Hadir'),
(142, 10, '2024-06-07', '08:00:00', '17:00:00', 'Ijin'),
(143, 1, '2024-06-14', '00:00:00', '00:00:00', 'Hadir');

-- --------------------------------------------------------

--
-- Struktur dari tabel `login`
--

CREATE TABLE `login` (
  `id` int(10) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `login`
--

INSERT INTO `login` (`id`, `username`, `password`) VALUES
(1, 'admin', '1234'),
(2, 'admin123@gmail.com', '123'),
(3, 'admin123@gmail.com', '123'),
(4, 'admin111@gmail.com', '1234'),
(5, 'admin111@gmail.com', '1234'),
(6, 'admin111@gmail.com', '1234');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penggajian`
--

CREATE TABLE `penggajian` (
  `Id_Penggajian` int(11) NOT NULL,
  `Id_Karyawan` int(11) NOT NULL,
  `Bulan` int(2) NOT NULL,
  `Tahun` int(11) NOT NULL,
  `Gaji_Pokok` decimal(15,2) NOT NULL,
  `Tunjangan` decimal(15,2) NOT NULL,
  `Potongan` decimal(15,2) NOT NULL,
  `Gaji_Bersih` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `penggajian`
--

INSERT INTO `penggajian` (`Id_Penggajian`, `Id_Karyawan`, `Bulan`, `Tahun`, `Gaji_Pokok`, `Tunjangan`, `Potongan`, `Gaji_Bersih`) VALUES
(1, 1, 5, 2024, '15000000.00', '2000000.00', '500000.00', '16500000.00'),
(2, 2, 5, 2024, '8000000.00', '1000000.00', '200000.00', '8800000.00'),
(3, 3, 5, 2024, '9000000.00', '1500000.00', '300000.00', '10200000.00'),
(4, 4, 5, 2024, '12000000.00', '2500000.00', '400000.00', '14100000.00'),
(5, 5, 5, 2024, '7000000.00', '500000.00', '100000.00', '7400000.00'),
(6, 6, 5, 2024, '8500000.00', '600000.00', '200000.00', '8900000.00'),
(7, 7, 5, 2024, '9500000.00', '700000.00', '300000.00', '9900000.00'),
(8, 8, 5, 2024, '7500000.00', '400000.00', '100000.00', '7800000.00'),
(9, 9, 5, 2024, '9000000.00', '600000.00', '200000.00', '9400000.00'),
(10, 10, 5, 2024, '13000000.00', '2500000.00', '500000.00', '15000000.00'),
(11, 1, 6, 2024, '15000000.00', '1500000.00', '675000.00', '15825000.00'),
(12, 2, 6, 2024, '6000000.00', '600000.00', '2700000.00', '3900000.00'),
(13, 1, 6, 2024, '15000000.00', '1500000.00', '675000.00', '15825000.00'),
(14, 1, 6, 2024, '15000000.00', '1500000.00', '675000.00', '15825000.00'),
(15, 1, 6, 2024, '15000000.00', '1500000.00', '675000.00', '15825000.00'),
(16, 1, 6, 2024, '15000000.00', '1500000.00', '675000.00', '15825000.00'),
(17, 1, 6, 2024, '15000000.00', '1500000.00', '675000.00', '15825000.00'),
(18, 1, 6, 2024, '15000000.00', '1500000.00', '675000.00', '15825000.00'),
(19, 1, 6, 2024, '15000000.00', '1500000.00', '675000.00', '15825000.00'),
(20, 7, 6, 2024, '9500000.00', '950000.00', '3705000.00', '6745000.00'),
(21, 7, 6, 2024, '9500000.00', '950000.00', '3705000.00', '6745000.00'),
(22, 7, 6, 2024, '9500000.00', '950000.00', '3705000.00', '6745000.00'),
(23, 9, 6, 2024, '9000000.00', '900000.00', '405000.00', '9495000.00'),
(24, 9, 6, 2024, '9000000.00', '900000.00', '405000.00', '9495000.00'),
(25, 10, 6, 2024, '13000000.00', '1300000.00', '5850000.00', '8450000.00'),
(26, 10, 6, 2024, '13000000.00', '1300000.00', '5850000.00', '8450000.00'),
(27, 10, 6, 2024, '13000000.00', '1300000.00', '5850000.00', '8450000.00'),
(28, 10, 6, 2024, '13000000.00', '1300000.00', '5850000.00', '8450000.00'),
(29, 10, 6, 2024, '13000000.00', '1300000.00', '5850000.00', '8450000.00'),
(30, 9, 6, 2024, '9000000.00', '900000.00', '405000.00', '9495000.00'),
(31, 9, 6, 2024, '9000000.00', '900000.00', '405000.00', '9495000.00'),
(32, 9, 6, 2024, '9000000.00', '900000.00', '405000.00', '9495000.00'),
(33, 9, 6, 2024, '9000000.00', '900000.00', '405000.00', '9495000.00'),
(34, 3, 6, 2024, '9000000.00', '900000.00', '3510000.00', '6390000.00'),
(35, 3, 6, 2024, '9000000.00', '900000.00', '3510000.00', '6390000.00'),
(36, 7, 6, 2024, '9500000.00', '950000.00', '3705000.00', '6745000.00'),
(37, 4, 6, 2024, '12000000.00', '1200000.00', '6780000.00', '6420000.00'),
(38, 4, 6, 2024, '12000000.00', '1200000.00', '6780000.00', '6420000.00'),
(39, 9, 6, 2024, '9000000.00', '900000.00', '405000.00', '9495000.00'),
(40, 9, 5, 2024, '9000000.00', '900000.00', '405000.00', '9495000.00'),
(41, 2, 5, 2024, '6000000.00', '600000.00', '630000.00', '5970000.00'),
(42, 2, 5, 2024, '6000000.00', '600000.00', '630000.00', '5970000.00'),
(43, 7, 5, 2024, '9500000.00', '950000.00', '427500.00', '10022500.00'),
(44, 25, 5, 2024, '10000000.00', '1000000.00', '0.00', '11000000.00'),
(45, 7, 5, 2024, '9500000.00', '950000.00', '427500.00', '10022500.00'),
(46, 2, 5, 2024, '6000000.00', '600000.00', '630000.00', '5970000.00');

--
-- Trigger `penggajian`
--
DELIMITER $$
CREATE TRIGGER `cek_gaji_bersih` BEFORE INSERT ON `penggajian` FOR EACH ROW BEGIN
    DECLARE gaji_pokok DECIMAL(15, 2);
    DECLARE tunjangan DECIMAL(15, 2);
    DECLARE potongan DECIMAL(15, 2);

    SELECT Gaji INTO gaji_pokok
    FROM karyawan
    WHERE Id_Karyawan = NEW.Id_Karyawan;

    SET NEW.Gaji_Bersih = gaji_pokok + NEW.Tunjangan - NEW.Potongan;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan`
--

CREATE TABLE `penjualan` (
  `Id_Penjualan` int(11) NOT NULL,
  `Id_Karyawan` int(50) NOT NULL,
  `Produk_Penjualan` varchar(50) NOT NULL,
  `Tanggal_Penjualan` date NOT NULL,
  `Jumlah` int(11) NOT NULL,
  `Total_Harga` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `penjualan`
--

INSERT INTO `penjualan` (`Id_Penjualan`, `Id_Karyawan`, `Produk_Penjualan`, `Tanggal_Penjualan`, `Jumlah`, `Total_Harga`) VALUES
(1, 7, 'Laptop', '2024-06-01', 5, '75000000.00'),
(2, 7, 'Mouse', '2024-06-02', 20, '5000000.00'),
(3, 7, 'Keyboard', '2024-06-03', 10, '3000000.00'),
(4, 7, 'Monitor', '2024-06-04', 8, '24000000.00'),
(5, 7, 'Printer', '2024-06-05', 3, '9000000.00'),
(7, 7, 'Harddisk', '2024-06-07', 15, '4500000.00'),
(11, 7, 'Laptop', '2024-01-01', 5, '75000000.00'),
(12, 7, 'Mouse', '2024-01-02', 20, '5000000.00'),
(13, 7, 'Keyboard', '2024-01-03', 10, '3000000.00'),
(14, 7, 'Monitor', '2024-01-04', 8, '24000000.00'),
(15, 7, 'Printer', '2024-01-05', 3, '9000000.00'),
(16, 7, 'Laptop', '2024-02-01', 7, '105000000.00'),
(17, 7, 'Mouse', '2024-02-02', 25, '6250000.00'),
(18, 7, 'Keyboard', '2024-02-03', 15, '4500000.00'),
(19, 7, 'Monitor', '2024-02-04', 10, '30000000.00'),
(20, 7, 'Printer', '2024-02-05', 5, '15000000.00'),
(21, 7, 'Laptop', '2024-03-01', 6, '90000000.00'),
(22, 7, 'Mouse', '2024-03-02', 22, '5500000.00'),
(23, 7, 'Keyboard', '2024-03-03', 12, '3600000.00'),
(24, 7, 'Monitor', '2024-03-04', 9, '27000000.00'),
(25, 7, 'Printer', '2024-03-05', 4, '12000000.00'),
(26, 7, 'Laptop', '2024-04-01', 8, '120000000.00'),
(27, 7, 'Mouse', '2024-04-02', 30, '7500000.00'),
(28, 7, 'Keyboard', '2024-04-03', 20, '6000000.00'),
(29, 7, 'Monitor', '2024-04-04', 12, '36000000.00'),
(30, 7, 'Printer', '2024-04-05', 6, '18000000.00'),
(31, 7, 'Laptop', '2024-05-01', 10, '150000000.00'),
(32, 7, 'Mouse', '2024-05-02', 35, '8750000.00'),
(33, 7, 'Keyboard', '2024-05-03', 25, '7500000.00'),
(34, 7, 'Monitor', '2024-05-04', 15, '45000000.00'),
(35, 7, 'Printer', '2024-05-05', 7, '21000000.00'),
(36, 7, 'Laptop', '2024-06-01', 12, '180000000.00'),
(37, 7, 'Mouse', '2024-06-02', 40, '10000000.00'),
(38, 7, 'Keyboard', '2024-06-03', 30, '9000000.00'),
(39, 7, 'Monitor', '2024-06-04', 18, '54000000.00'),
(40, 7, 'Printer', '2024-06-05', 9, '27000000.00'),
(41, 40, 'Harddisk', '2024-06-13', 9, '12500000.00'),
(43, 40, 'USV', '2024-06-14', 10, '12500000.00'),
(44, 33, 'USV', '2024-06-14', 18, '12500000.00'),
(45, 40, 'USB', '2024-06-14', 50, '12800000.00');

--
-- Trigger `penjualan`
--
DELIMITER $$
CREATE TRIGGER `departemen_penjualan_karyawan` BEFORE INSERT ON `penjualan` FOR EACH ROW BEGIN
    DECLARE departemen_id INT;
    SELECT Id_Departemen INTO departemen_id
    FROM karyawan
    WHERE Id_Karyawan = NEW.Id_Karyawan;

    IF departemen_id <> 7 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Hanya karyawan dari departemen penjualan yang dapat dimasukkan ke tabel penjualan.';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `proyek`
--

CREATE TABLE `proyek` (
  `Id_Proyek` int(11) NOT NULL,
  `Id_Departemen` int(11) NOT NULL,
  `Id_Karyawan` int(11) NOT NULL,
  `Nama_Proyek` varchar(50) NOT NULL,
  `Deskripsi` text NOT NULL,
  `Tanggal_Mulai` date NOT NULL,
  `Tanggal_Selesai` date NOT NULL,
  `Anggaran` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `proyek`
--

INSERT INTO `proyek` (`Id_Proyek`, `Id_Departemen`, `Id_Karyawan`, `Nama_Proyek`, `Deskripsi`, `Tanggal_Mulai`, `Tanggal_Selesai`, `Anggaran`) VALUES
(1, 1, 1, 'Sistem ERP', 'Implementasi sistem ERP', '2024-01-01', '2024-12-31', 500000000),
(2, 3, 1, 'Website Perusahaan', 'Pengembangan website', '2024-03-01', '2024-08-31', 100000000),
(3, 2, 1, 'Pelatihan Karyawan', 'Program pelatihan HR', '2024-04-15', '2024-10-15', 200000000),
(4, 3, 1, 'Upgrade Sistem IT', 'Upgrade infrastruktur IT', '2024-05-01', '2024-11-30', 300000000),
(5, 6, 1, 'Digital Marketing', 'Strategi pemasaran digital', '2024-02-01', '2024-07-01', 150000000),
(6, 7, 1, 'Pengembangan Produk Baru', 'Riset dan pengembangan produk baru', '2024-04-01', '2024-12-01', 250000000),
(8, 3, 1, 'Sistem Keamanan Jaringan', 'Penguatan keamanan jaringan IT', '2024-05-01', '2024-10-01', 200000000),
(9, 5, 1, 'Pengembangan CRM', 'Implementasi sistem CRM baru', '2024-06-01', '2024-11-01', 300000000),
(10, 10, 1, 'Pelatihan Manajemen Proyek', 'Pelatihan untuk manajer proyek', '2024-01-01', '2024-06-01', 100000000),
(11, 4, 7, 'Menjual', 'isda', '2024-06-11', '2024-06-30', 30000000),
(12, 6, 2, 'Jual Beli Belut', 'Memancing Belut dan menangkap belut', '2024-06-11', '2024-06-20', 70000),
(13, 11, 1, 'Membuat gedung', 'membangun', '2024-06-05', '2024-06-05', 4000000),
(14, 4, 1, 'Membuat gedung', 'pp', '2024-06-14', '2024-06-14', 4000000),
(15, 5, 17, 'Membuat gedung', 'pp', '2024-06-14', '2024-06-14', 4000000),
(16, 2, 3, 'Seminar', 'seminar', '2024-06-14', '2024-06-29', 40000000),
(17, 1, 1, 'Seminar', 'ppppppp', '2024-06-14', '2024-06-30', 90000000);

--
-- Trigger `proyek`
--
DELIMITER $$
CREATE TRIGGER `cek_tgl_proyek` BEFORE INSERT ON `proyek` FOR EACH ROW BEGIN
    IF NEW.Tanggal_Selesai < NEW.Tanggal_Mulai THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Tanggal selesai proyek tidak boleh lebih awal dari tanggal mulai.';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `view_detail_proyek`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `view_detail_proyek` (
`Id_Proyek` int(11)
,`Nama_Proyek` varchar(50)
,`Department` varchar(50)
,`Manager` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `view_jumlahkaryawan`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `view_jumlahkaryawan` (
`Jumlah_Karyawan` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `view_jumlah_departemen`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `view_jumlah_departemen` (
`Jumlah_Departemen` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `view_jumlah_penjualan_bulan_ini`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `view_jumlah_penjualan_bulan_ini` (
`Total_Penjualan_Bulan_Ini` decimal(37,2)
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `view_jumlah_proyek_aktif`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `view_jumlah_proyek_aktif` (
`Jumlah_Proyek_Aktif` bigint(21)
);

-- --------------------------------------------------------

--
-- Struktur untuk view `jumlahkaryawanmasuk13hariterakhir`
--
DROP TABLE IF EXISTS `jumlahkaryawanmasuk13hariterakhir`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `jumlahkaryawanmasuk13hariterakhir`  AS SELECT `kehadiran`.`Tanggal` AS `Tanggal`, count(distinct `kehadiran`.`Id_Karyawan`) AS `Jumlah_Karyawan_Masuk` FROM `kehadiran` WHERE `kehadiran`.`Tanggal` between curdate() - interval 13 day and curdate() AND `kehadiran`.`Status_Kehadiran` = 'Hadir' GROUP BY `kehadiran`.`Tanggal` ORDER BY `kehadiran`.`Tanggal` AS `DESCdesc` ASC  ;

-- --------------------------------------------------------

--
-- Struktur untuk view `view_detail_proyek`
--
DROP TABLE IF EXISTS `view_detail_proyek`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_detail_proyek`  AS SELECT `p`.`Id_Proyek` AS `Id_Proyek`, `p`.`Nama_Proyek` AS `Nama_Proyek`, `d`.`Nama_Departemen` AS `Department`, `k`.`Nama` AS `Manager` FROM ((`proyek` `p` join `departemen` `d` on(`p`.`Id_Departemen` = `d`.`Id_Departemen`)) join `karyawan` `k` on(`p`.`Id_Karyawan` = `k`.`Id_Karyawan`))  ;

-- --------------------------------------------------------

--
-- Struktur untuk view `view_jumlahkaryawan`
--
DROP TABLE IF EXISTS `view_jumlahkaryawan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_jumlahkaryawan`  AS SELECT count(`karyawan`.`Id_Karyawan`) AS `Jumlah_Karyawan` FROM `karyawan``karyawan`  ;

-- --------------------------------------------------------

--
-- Struktur untuk view `view_jumlah_departemen`
--
DROP TABLE IF EXISTS `view_jumlah_departemen`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_jumlah_departemen`  AS SELECT count(`departemen`.`Id_Departemen`) AS `Jumlah_Departemen` FROM `departemen``departemen`  ;

-- --------------------------------------------------------

--
-- Struktur untuk view `view_jumlah_penjualan_bulan_ini`
--
DROP TABLE IF EXISTS `view_jumlah_penjualan_bulan_ini`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_jumlah_penjualan_bulan_ini`  AS SELECT sum(`penjualan`.`Total_Harga`) AS `Total_Penjualan_Bulan_Ini` FROM `penjualan` WHERE month(`penjualan`.`Tanggal_Penjualan`) = month(curdate()) AND year(`penjualan`.`Tanggal_Penjualan`) = year(curdate())  ;

-- --------------------------------------------------------

--
-- Struktur untuk view `view_jumlah_proyek_aktif`
--
DROP TABLE IF EXISTS `view_jumlah_proyek_aktif`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_jumlah_proyek_aktif`  AS SELECT count(0) AS `Jumlah_Proyek_Aktif` FROM `proyek` WHERE `proyek`.`Tanggal_Selesai` >= curdate()  ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `departemen`
--
ALTER TABLE `departemen`
  ADD PRIMARY KEY (`Id_Departemen`);

--
-- Indeks untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`Id_Karyawan`),
  ADD KEY `karyawan_departemen` (`Id_Departemen`);

--
-- Indeks untuk tabel `kehadiran`
--
ALTER TABLE `kehadiran`
  ADD PRIMARY KEY (`Id_Kehadiran`),
  ADD KEY `kehadiran_karyawan` (`Id_Karyawan`);

--
-- Indeks untuk tabel `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `penggajian`
--
ALTER TABLE `penggajian`
  ADD PRIMARY KEY (`Id_Penggajian`),
  ADD KEY `penggajian` (`Id_Karyawan`);

--
-- Indeks untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`Id_Penjualan`),
  ADD KEY `penjualan_karyawan` (`Id_Karyawan`);

--
-- Indeks untuk tabel `proyek`
--
ALTER TABLE `proyek`
  ADD PRIMARY KEY (`Id_Proyek`),
  ADD KEY `proyek_karyawan` (`Id_Departemen`),
  ADD KEY `proyek_karyawann` (`Id_Karyawan`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kehadiran`
--
ALTER TABLE `kehadiran`
  MODIFY `Id_Kehadiran` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT untuk tabel `login`
--
ALTER TABLE `login`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `penggajian`
--
ALTER TABLE `penggajian`
  MODIFY `Id_Penggajian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `Id_Penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT untuk tabel `proyek`
--
ALTER TABLE `proyek`
  MODIFY `Id_Proyek` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  ADD CONSTRAINT `karyawan_departemen` FOREIGN KEY (`Id_Departemen`) REFERENCES `departemen` (`Id_Departemen`);

--
-- Ketidakleluasaan untuk tabel `kehadiran`
--
ALTER TABLE `kehadiran`
  ADD CONSTRAINT `kehadiran_karyawan` FOREIGN KEY (`Id_Karyawan`) REFERENCES `karyawan` (`Id_Karyawan`);

--
-- Ketidakleluasaan untuk tabel `penggajian`
--
ALTER TABLE `penggajian`
  ADD CONSTRAINT `penggajian` FOREIGN KEY (`Id_Karyawan`) REFERENCES `karyawan` (`Id_Karyawan`);

--
-- Ketidakleluasaan untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `penjualan_karyawan` FOREIGN KEY (`Id_Karyawan`) REFERENCES `karyawan` (`Id_Karyawan`);

--
-- Ketidakleluasaan untuk tabel `proyek`
--
ALTER TABLE `proyek`
  ADD CONSTRAINT `proyek_departemen` FOREIGN KEY (`Id_Departemen`) REFERENCES `departemen` (`Id_Departemen`),
  ADD CONSTRAINT `proyek_karyawann` FOREIGN KEY (`Id_Karyawan`) REFERENCES `karyawan` (`Id_Karyawan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
