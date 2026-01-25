-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 17, 2026 at 09:19 AM
-- Server version: 10.10.6-MariaDB
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chatgpt_simulation`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat_history`
--

DROP TABLE IF EXISTS `chat_history`;
CREATE TABLE IF NOT EXISTS `chat_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `chat_history`
--

INSERT INTO `chat_history` (`id`, `user_id`, `question`, `answer`, `created_at`) VALUES
(1, 1, 'kapan krs bisa diambil?', 'KRS biasanya dapat diambil pada awal semester sesuai dengan kalender akademik yang ditetapkan oleh universitas.', '2026-01-17 02:08:28'),
(4, 1, 'hello', 'Maaf, saya tidak tahu jawabannya. Coba tanyakan yang lain.', '2026-01-17 02:11:28'),
(5, 1, 'hello', 'Maaf, saya tidak tahu jawabannya. Coba tanyakan yang lain.', '2026-01-17 02:15:03'),
(6, 1, 'hay', 'Maaf, saya tidak tahu jawabannya. Coba tanyakan yang lain.', '2026-01-17 02:15:06'),
(7, 1, 'saya tidak bisa mengisi krs!', 'Mahasiswa yang tidak mengisi KRS tidak dapat mengikuti perkuliahan dan tidak terdaftar sebagai peserta mata kuliah.', '2026-01-17 02:15:31');

-- --------------------------------------------------------

--
-- Table structure for table `qa`
--

DROP TABLE IF EXISTS `qa`;
CREATE TABLE IF NOT EXISTS `qa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `question` (`question`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `qa`
--

INSERT INTO `qa` (`id`, `question`, `answer`) VALUES
(1, 'Apa itu Information Retrieval?', 'Information Retrieval adalah proses mencari informasi yang relevan dari kumpulan data yang besar.'),
(2, 'Apa manfaat Information Retrieval?', 'Manfaatnya adalah membantu menemukan informasi yang relevan dengan cepat dan efisien.'),
(3, 'Apa contoh penerapan Information Retrieval?', 'Contoh penerapan Information Retrieval adalah mesin pencari seperti Google, sistem pencarian jurnal, dan pencarian dokumen.'),
(4, 'Apa itu TF-IDF?', 'TF-IDF adalah metode pembobotan kata yang digunakan dalam Information Retrieval untuk mengukur pentingnya sebuah kata dalam dokumen.'),
(5, 'Apa itu Term Frequency?', 'Term Frequency adalah jumlah kemunculan suatu kata dalam sebuah dokumen.'),
(6, 'Apa itu Document Frequency?', 'Document Frequency adalah jumlah dokumen yang mengandung suatu kata tertentu.'),
(7, 'Apa itu Cosine Similarity?', 'Cosine Similarity adalah metode untuk mengukur tingkat kemiripan antara dua dokumen berdasarkan vektor kata.'),
(8, 'Apa itu KRS?', 'KRS adalah Kartu Rencana Studi yang digunakan mahasiswa untuk memilih mata kuliah setiap semester.'),
(9, 'Apa itu KHS?', 'KHS adalah Kartu Hasil Studi yang berisi nilai mata kuliah yang telah ditempuh mahasiswa.'),
(10, 'Apa itu IPK?', 'IPK adalah Indeks Prestasi Kumulatif yang menunjukkan rata-rata nilai mahasiswa selama masa studi.'),
(11, 'Apa itu SKS?', 'SKS adalah Satuan Kredit Semester yang menunjukkan beban studi suatu mata kuliah.'),
(12, 'Apa itu UTS?', 'UTS adalah Ujian Tengah Semester yang dilaksanakan di pertengahan masa perkuliahan.'),
(13, 'Apa itu UAS?', 'UAS adalah Ujian Akhir Semester yang dilaksanakan di akhir masa perkuliahan.'),
(14, 'Apa itu skripsi?', 'Skripsi adalah karya ilmiah mahasiswa sebagai salah satu syarat kelulusan program sarjana.'),
(15, 'Apa perbedaan skripsi dan tesis?', 'Skripsi adalah karya ilmiah untuk S1, sedangkan tesis adalah karya ilmiah untuk program S2.'),
(16, 'Apa itu jurnal ilmiah?', 'Jurnal ilmiah adalah publikasi akademik yang memuat hasil penelitian dan kajian ilmiah.'),
(17, 'Apa itu sitasi?', 'Sitasi adalah penyebutan sumber referensi yang digunakan dalam karya ilmiah.'),
(18, 'Apa itu plagiarism?', 'Plagiarism adalah tindakan mengambil karya orang lain tanpa menyebutkan sumber aslinya.'),
(19, 'Apa itu referensi?', 'Referensi adalah sumber rujukan yang digunakan dalam penulisan karya ilmiah.'),
(20, 'Apa itu proposal skripsi?', 'Proposal skripsi adalah rancangan penelitian yang diajukan sebelum pelaksanaan skripsi.'),
(21, 'Kapan KRS bisa diambil?', 'KRS biasanya dapat diambil pada awal semester sesuai dengan kalender akademik yang ditetapkan oleh universitas.'),
(22, 'Di mana mahasiswa mengisi KRS?', 'Mahasiswa mengisi KRS melalui sistem akademik online kampus seperti https://krsti.sar.ac.id atau portal akademik.'),
(23, 'Siapa yang berhak mengisi KRS?', 'Mahasiswa aktif yang telah melakukan registrasi dan memenuhi persyaratan akademik berhak mengisi KRS.'),
(24, 'Apa saja syarat pengisian KRS?', 'Syarat pengisian KRS meliputi status mahasiswa aktif, pembayaran UKT, dan persetujuan dosen pembimbing akademik.'),
(25, 'Berapa jumlah SKS yang dapat diambil dalam KRS?', 'Jumlah SKS yang dapat diambil mahasiswa dalam KRS ditentukan oleh IP atau IPK semester sebelumnya. Biasanya sekitar 19 hingga 24 SKS'),
(26, 'Apakah KRS bisa diubah setelah disubmit?', 'KRS masih dapat diubah selama masa revisi KRS sesuai dengan kebijakan akademik kampus.'),
(27, 'Apa yang terjadi jika tidak mengisi KRS?', 'Mahasiswa yang tidak mengisi KRS tidak dapat mengikuti perkuliahan dan tidak terdaftar sebagai peserta mata kuliah.'),
(28, 'Apakah KRS harus disetujui dosen?', 'Ya, KRS harus mendapatkan persetujuan dari dosen pembimbing akademik agar dinyatakan sah.'),
(29, 'Apa perbedaan KRS dan KHS?', 'KRS berisi rencana mata kuliah yang akan diambil, sedangkan KHS berisi hasil nilai mata kuliah yang telah ditempuh.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nim` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nim`, `nama`, `created_at`) VALUES
(1, '', '', '2026-01-17 09:08:28');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
