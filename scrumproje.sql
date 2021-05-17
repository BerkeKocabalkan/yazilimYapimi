-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1:3306
-- Üretim Zamanı: 17 May 2021, 19:03:17
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
  `bakiyeOnay` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`bakiyeId`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  `kullaniciYetki` enum('0','1') COLLATE utf8_unicode_ci DEFAULT '0',
  `kullaniciPara` decimal(50,2) DEFAULT '0.00',
  PRIMARY KEY (`kullaniciId`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `kullanici`
--

INSERT INTO `kullanici` (`kullaniciId`, `kullaniciAd`, `kullaniciSoyad`, `kullaniciTakmaAd`, `kullaniciSifre`, `kullaniciTC`, `kullaniciTelefon`, `kullaniciMail`, `kullaniciAdres`, `kullaniciYetki`, `kullaniciPara`) VALUES
(1, 'Berke', 'Kocabalkan', 'Berke Kocabalkan', 'adcd7048512e64b48da55b027577886e', '43039502220', '05514073232', 'berke.kocabalkan@gmail.com', 'adres', '1', '228.00');

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urun`
--

DROP TABLE IF EXISTS `urun`;
CREATE TABLE IF NOT EXISTS `urun` (
  `urunId` int(11) NOT NULL AUTO_INCREMENT,
  `urunAd` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`urunId`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
