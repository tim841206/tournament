-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- 主機: localhost
-- 產生時間： 2017 年 07 月 29 日 14:24
-- 伺服器版本: 10.1.13-MariaDB
-- PHP 版本： 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `tournament`
--

-- --------------------------------------------------------

--
-- 資料表結構 `GAMEMAIN`
--

CREATE TABLE `GAMEMAIN` (
  `USERNO` varchar(15) COLLATE utf8_bin NOT NULL,
  `GAMENO` varchar(15) COLLATE utf8_bin NOT NULL,
  `GAMENM` varchar(30) COLLATE utf8_bin NOT NULL,
  `GAMETYPE` varchar(1) COLLATE utf8_bin NOT NULL,
  `PLAYTYPE` varchar(1) COLLATE utf8_bin NOT NULL,
  `CREATEDATE` datetime NOT NULL,
  `UPDATEDATE` datetime NOT NULL,
  `AMOUNT` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 資料表結構 `GAMEPOSITION`
--

CREATE TABLE `GAMEPOSITION` (
  `USERNO` varchar(15) COLLATE utf8_bin NOT NULL,
  `GAMENO` varchar(15) COLLATE utf8_bin NOT NULL,
  `POSITION` int(11) NOT NULL,
  `PLAYERNO` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `UNIT` varchar(30) COLLATE utf8_bin NOT NULL,
  `NAME` varchar(30) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 資料表結構 `GAMESTATE`
--

CREATE TABLE `GAMESTATE` (
  `USERNO` varchar(15) COLLATE utf8_bin NOT NULL,
  `GAMENO` varchar(15) COLLATE utf8_bin NOT NULL,
  `PLAYNO` int(11) DEFAULT NULL,
  `SYSTEMPLAYNO` int(11) NOT NULL,
  `ABOVE` int(11) DEFAULT NULL,
  `ABOVESCORE` int(11) DEFAULT NULL,
  `BELOW` int(11) DEFAULT NULL,
  `BELOWSCORE` int(11) DEFAULT NULL,
  `PLAYTIME` varchar(5) DEFAULT NULL,
  `WINNER` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------


--
-- 資料表結構 `USERMAS`
--

CREATE TABLE `USERMAS` (
  `USERNO` varchar(15) COLLATE utf8_bin NOT NULL,
  `TOKEN` varchar(15) COLLATE utf8_bin DEFAULT NULL,
  `PASSWORD` varchar(30) COLLATE utf8_bin NOT NULL,
  `CREATEDATE` datetime NOT NULL,
  `LOGINDATE` datetime NOT NULL,
  `AUTHDATE` datetime NOT NULL,
  `OCCUPY` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 資料表的匯出資料 `USERMAS`
--

INSERT INTO `USERMAS` (`USERNO`, `PASSWORD`, `CREATEDATE`, `LOGINDATE`, `AUTHDATE`, `OCCUPY`) VALUES
('NTUcup', '0986036999', '2017-09-01 00:00:00', '2017-09-01 00:00:00', '2018-09-01 00:00:00', 0);

-- --------------------------------------------------------

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `GAMEMAIN`
--
ALTER TABLE `GAMEMAIN`
  ADD PRIMARY KEY (`USERNO`, `GAMENO`);

--
-- 資料表索引 `GAMEPOSITION`
--
ALTER TABLE `GAMEPOSITION`
  ADD PRIMARY KEY (`USERNO`, `GAMENO`, `POSITION`, `PLAYERNO`);

--
-- 資料表索引 `GAMESTATE`
--
ALTER TABLE `GAMESTATE`
  ADD PRIMARY KEY (`USERNO`, `GAMENO`, `SYSTEMPLAYNO`);

--
-- 資料表索引 `USERMAS`
--
ALTER TABLE `USERMAS`
  ADD PRIMARY KEY (`USERNO`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
