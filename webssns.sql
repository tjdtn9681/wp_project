-- phpMyAdmin SQL Dump
-- version 3.2.3
-- http://www.phpmyadmin.net
--
-- 호스트: localhost
-- 처리한 시간: 14-12-01 22:55 
-- 서버 버전: 5.1.41
-- PHP 버전: 5.2.12

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- 데이터베이스: `webssns`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `member`
--

CREATE TABLE IF NOT EXISTS `member` (
  `id` char(16) CHARACTER SET latin1 NOT NULL,
  `pass` char(41) CHARACTER SET latin1 NOT NULL,
  `mail` char(40) NOT NULL,
  `regdate` date NOT NULL,
  `permit` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `member`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `newfeed_rep`
--

CREATE TABLE IF NOT EXISTS `newfeed_rep` (
  `no` int(10) NOT NULL AUTO_INCREMENT,
  `board_no` int(10) NOT NULL,
  `id` varchar(16) NOT NULL,
  `pass` varchar(41) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 테이블의 덤프 데이터 `newfeed_rep`
--


-- --------------------------------------------------------

--
-- 테이블 구조 `newsfeed`
--

CREATE TABLE IF NOT EXISTS `newsfeed` (
  `no` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id` char(16) NOT NULL,
  `pass` char(41) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `content` text CHARACTER SET utf8 NOT NULL,
  `image` varchar(100) NOT NULL,
  PRIMARY KEY (`no`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- 테이블의 덤프 데이터 `newsfeed`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `programs`
--

CREATE TABLE IF NOT EXISTS `programs` (
  `no` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id` char(16) NOT NULL,
  `pass` char(41) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `content` text CHARACTER SET utf8 NOT NULL,
  `image` varchar(100) NOT NULL,
  PRIMARY KEY (`no`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- 테이블의 덤프 데이터 `programs`
--

INSERT INTO `programs` (`no`, `id`, `pass`, `date`, `time`, `content`, `image`) VALUES
(1, 'a', '*667F407DE7C6AD07358FA38DAED7828A72014B4E', '2014-11-30', '02:46:07', 'sdafsafasdfsadf', './images/Chrysanthemum.jpg'),
(2, 'a', '*667F407DE7C6AD07358FA38DAED7828A72014B4E', '2014-11-30', '02:51:29', 'a', './images/Chrysanthemum.jpg');
