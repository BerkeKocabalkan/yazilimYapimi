-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1:3306
-- Üretim Zamanı: 20 Haz 2021, 13:53:47
-- Sunucu sürümü: 5.7.31
-- PHP Sürümü: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `scrumproje`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `bakiye`
--

DROP TABLE IF EXISTS `bakiye`;
CREATE TABLE IF NOT EXISTS `bakiye` (
  `bakiyeId` int(11) NOT NULL AUTO_INCREMENT,
  `kullaniciId` int(11) NOT NULL,
  `bakiyePara` decimal(11,2) NOT NULL,
  `bakiyeKur` enum('0','1','2','3') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `bakiyeOnay` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`bakiyeId`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `bakiye`
--

INSERT INTO `bakiye` (`bakiyeId`, `kullaniciId`, `bakiyePara`, `bakiyeKur`, `bakiyeOnay`) VALUES
(6, 1, '10.00', '0', '1'),
(5, 6, '100.00', '0', '1'),
(4, 5, '200.00', '0', '1'),
(7, 1, '5.00', '0', '1'),
(8, 1, '5.00', '1', '1'),
(9, 1, '5.00', '0', '1'),
(10, 1, '5.00', '0', '1'),
(11, 1, '5.00', '1', '1'),
(12, 1, '5.00', '2', '1'),
(13, 1, '5.00', '3', '1'),
(14, 1, '5.00', '2', '1');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanici`
--

DROP TABLE IF EXISTS `kullanici`;
CREATE TABLE IF NOT EXISTS `kullanici` (
  `kullaniciId` int(11) NOT NULL AUTO_INCREMENT,
  `kullaniciAd` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `kullaniciSoyad` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `kullaniciTakmaAd` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `kullaniciSifre` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `kullaniciTC` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `kullaniciTelefon` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `kullaniciMail` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `kullaniciAdres` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `kullaniciYetki` enum('0','1','2') COLLATE utf8_unicode_ci DEFAULT '0',
  `kullaniciPara` decimal(50,2) DEFAULT '0.00',
  PRIMARY KEY (`kullaniciId`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `kullanici`
--

INSERT INTO `kullanici` (`kullaniciId`, `kullaniciAd`, `kullaniciSoyad`, `kullaniciTakmaAd`, `kullaniciSifre`, `kullaniciTC`, `kullaniciTelefon`, `kullaniciMail`, `kullaniciAdres`, `kullaniciYetki`, `kullaniciPara`) VALUES
(1, 'Berke', 'Kocabalkan', 'Berke Kocabalkan', 'adcd7048512e64b48da55b027577886e', '43039502220', '05514073232', 'berke.kocabalkan@gmail.com', 'adres', '1', '411.43'),
(6, 'ad', 'Soyadddd', 'takadddd', 'adcd7048512e64b48da55b027577886e', '43039502255', '05514073224', 'satici@gmail.com', 'adres', '0', '280.00'),
(5, 'ad', 'Soyad', 'takad', 'adcd7048512e64b48da55b027577886e', '334244452252', '05514073533', 'deneme@gmail.com', 'adres', '0', '240.00'),
(7, 'Muhasebe', 'Hesabı', 'Muhasebe', 'adcd7048512e64b48da55b027577886e', '43039522222', '05514073232', 'muhasebe@gmail.com', 'adres', '2', '0.25');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullaniciurun`
--

DROP TABLE IF EXISTS `kullaniciurun`;
CREATE TABLE IF NOT EXISTS `kullaniciurun` (
  `kullaniciurunId` int(11) NOT NULL AUTO_INCREMENT,
  `kullaniciId` int(11) NOT NULL,
  `urunId` int(11) NOT NULL,
  `kullaniciurunMiktar` int(11) NOT NULL,
  `kullaniciurunFiyat` decimal(11,2) NOT NULL,
  `kullaniciurunOnay` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`kullaniciurunId`)
) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `kullaniciurun`
--

INSERT INTO `kullaniciurun` (`kullaniciurunId`, `kullaniciId`, `urunId`, `kullaniciurunMiktar`, `kullaniciurunFiyat`, `kullaniciurunOnay`) VALUES
(4, 6, 22, 0, '4.00', '1'),
(3, 5, 22, 0, '2.00', '1'),
(66, 6, 29, 0, '5.00', '1'),
(65, 6, 25, 0, '5.00', '1'),
(64, 6, 25, 0, '5.00', '1'),
(63, 6, 28, 0, '5.00', '1'),
(62, 6, 28, 0, '5.00', '1'),
(61, 1, 22, 0, '5.00', '1'),
(60, 1, 27, 0, '10.00', '1');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `siparis`
--

DROP TABLE IF EXISTS `siparis`;
CREATE TABLE IF NOT EXISTS `siparis` (
  `siparisId` int(11) NOT NULL AUTO_INCREMENT,
  `kullaniciId` int(11) NOT NULL,
  `urunId` int(11) NOT NULL,
  `kullaniciurunMiktar` int(11) NOT NULL,
  `kullaniciurunFiyat` decimal(11,2) NOT NULL,
  `siparisTarih` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `siparisDurum` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`siparisId`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `siparis`
--

INSERT INTO `siparis` (`siparisId`, `kullaniciId`, `urunId`, `kullaniciurunMiktar`, `kullaniciurunFiyat`, `siparisTarih`, `siparisDurum`) VALUES
(10, 1, 25, 5, '5.00', '2021-06-20 13:38:15', '1'),
(9, 1, 25, 5, '5.00', '2021-06-20 09:53:10', '1'),
(8, 1, 29, 5, '5.00', '2021-06-20 09:52:53', '1'),
(7, 6, 22, 5, '5.00', '2021-06-20 09:52:02', '1');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urun`
--

DROP TABLE IF EXISTS `urun`;
CREATE TABLE IF NOT EXISTS `urun` (
  `urunId` int(11) NOT NULL AUTO_INCREMENT,
  `urunAd` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`urunId`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `urun`
--

INSERT INTO `urun` (`urunId`, `urunAd`) VALUES
(29, 'deneme ürün'),
(28, 'muz'),
(27, 'avakado'),
(26, 'armut'),
(25, 'kivi'),
(24, 'muz'),
(23, 'elma'),
(22, 'ayva');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
