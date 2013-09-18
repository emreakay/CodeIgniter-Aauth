-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Anamakine: localhost
-- Üretim Zamanı: 18 Eylül 2013 saat 10:18:09
-- Sunucu sürümü: 5.5.8
-- PHP Sürümü: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Veritabanı: `aauth2`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `aauth_groups`
--

CREATE TABLE IF NOT EXISTS `aauth_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Tablo döküm verisi `aauth_groups`
--

INSERT INTO `aauth_groups` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'public'),
(3, 'default');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `aauth_perms`
--

CREATE TABLE IF NOT EXISTS `aauth_perms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text,
  `definition` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Tablo döküm verisi `aauth_perms`
--


-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `aauth_perm_to_group`
--

CREATE TABLE IF NOT EXISTS `aauth_perm_to_group` (
  `perm_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `aauth_perm_to_group`
--


-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `aauth_pm`
--

CREATE TABLE IF NOT EXISTS `aauth_pm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text,
  `date` datetime DEFAULT NULL,
  `read` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Tablo döküm verisi `aauth_pm`
--


-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `aauth_users`
--

CREATE TABLE IF NOT EXISTS `aauth_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` text COLLATE utf8_turkish_ci NOT NULL,
  `pass` text COLLATE utf8_turkish_ci NOT NULL,
  `name` text COLLATE utf8_turkish_ci,
  `banned` int(11) DEFAULT '0',
  `last_login` datetime DEFAULT NULL,
  `last_activity` datetime DEFAULT NULL,
  `last_login_attempt` datetime DEFAULT NULL,
  `forgot_exp` text COLLATE utf8_turkish_ci,
  `remember_time` datetime DEFAULT NULL,
  `remember_exp` text COLLATE utf8_turkish_ci,
  `verification_code` text COLLATE utf8_turkish_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=2 ;

--
-- Tablo döküm verisi `aauth_users`
--

INSERT INTO `aauth_users` (`id`, `email`, `pass`, `name`, `banned`, `last_login`, `last_activity`, `last_login_attempt`, `forgot_exp`, `remember_time`, `remember_exp`, `verification_code`) VALUES
(1, 'admin@admin.com', 'admin pass', 'Admin', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `aauth_user_to_group`
--

CREATE TABLE IF NOT EXISTS `aauth_user_to_group` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `group_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `aauth_user_to_group`
--

INSERT INTO `aauth_user_to_group` (`user_id`, `group_id`) VALUES
(1, 1);
