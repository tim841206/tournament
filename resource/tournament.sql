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

--
-- 資料庫： `tournament`
--

-- --------------------------------------------------------

--
-- 資料表結構 `GAMEMAIN`
--

CREATE TABLE `GAMEMAIN` (
  `GAMENO` varchar(6) COLLATE utf8_bin NOT NULL,
  `AMOUNT` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 資料表結構 `GAMEPOSITION`
--

CREATE TABLE `GAMEPOSITION` (
  `GAMENO` varchar(6) COLLATE utf8_bin NOT NULL,
  `POSITION` int(11) NOT NULL,
  `UNIT` varchar(30) COLLATE utf8_bin NOT NULL,
  `NAME` varchar(30) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 資料表結構 `GAMESTATE`
--

CREATE TABLE `GAMESTATE` (
  `GAMENO` varchar(6) COLLATE utf8_bin NOT NULL,
  `PLAYNO` int(11) DEFAULT NULL,
  `SYSTEMPLAYNO` int(11) NOT NULL,
  `ABOVE` int(11) DEFAULT NULL,
  `ABOVESCORE` int(11) DEFAULT NULL,
  `BELOW` int(11) DEFAULT NULL,
  `BELOWSCORE` int(11) DEFAULT NULL,
  `WINNER` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
