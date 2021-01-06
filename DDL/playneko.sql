-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: 10.0.1.27
-- 생성 시간: 21-01-06 12:18
-- 서버 버전: 10.3.17-MariaDB-0+deb10u1
-- PHP 버전: 7.3.11-1~deb10u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 데이터베이스: `playneko`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `blog_admin`
--

CREATE TABLE `blog_admin` (
  `no` int(3) UNSIGNED NOT NULL,
  `project_id` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `member_id` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `member_pw` varchar(128) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `member_email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `admin_level` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `reg_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `blog_board`
--

CREATE TABLE `blog_board` (
  `no` int(11) UNSIGNED NOT NULL,
  `project_id` varchar(255) DEFAULT NULL,
  `board_title` varchar(255) NOT NULL DEFAULT '',
  `board_comment` text NOT NULL,
  `board_article` longtext NOT NULL,
  `board_thumnail` varchar(300) NOT NULL DEFAULT '',
  `board_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_del` tinyint(1) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `blog_cat`
--

CREATE TABLE `blog_cat` (
  `no` int(11) UNSIGNED NOT NULL,
  `project_id` varchar(255) DEFAULT NULL,
  `blog_no` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `cat_name` varchar(50) NOT NULL,
  `reg_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `blog_project`
--

CREATE TABLE `blog_project` (
  `no` int(11) UNSIGNED NOT NULL,
  `user_id` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `project_id` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `project_title` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `project_description` text CHARACTER SET utf8 NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `reg_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `blog_tag`
--

CREATE TABLE `blog_tag` (
  `no` int(11) UNSIGNED NOT NULL,
  `project_id` varchar(255) DEFAULT NULL,
  `blog_no` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `tag_name` varchar(50) NOT NULL,
  `reg_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `blog_admin`
--
ALTER TABLE `blog_admin`
  ADD PRIMARY KEY (`no`),
  ADD KEY `blog_id` (`project_id`);

--
-- 테이블의 인덱스 `blog_board`
--
ALTER TABLE `blog_board`
  ADD PRIMARY KEY (`no`),
  ADD KEY `board_title` (`board_title`),
  ADD KEY `board_date` (`board_date`),
  ADD KEY `blog_id` (`project_id`);

--
-- 테이블의 인덱스 `blog_cat`
--
ALTER TABLE `blog_cat`
  ADD PRIMARY KEY (`no`),
  ADD KEY `blog_no` (`blog_no`),
  ADD KEY `blog_id` (`project_id`);

--
-- 테이블의 인덱스 `blog_project`
--
ALTER TABLE `blog_project`
  ADD PRIMARY KEY (`no`);

--
-- 테이블의 인덱스 `blog_tag`
--
ALTER TABLE `blog_tag`
  ADD PRIMARY KEY (`no`),
  ADD KEY `blog_no` (`blog_no`),
  ADD KEY `blog_id` (`project_id`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `blog_admin`
--
ALTER TABLE `blog_admin`
  MODIFY `no` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- 테이블의 AUTO_INCREMENT `blog_board`
--
ALTER TABLE `blog_board`
  MODIFY `no` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- 테이블의 AUTO_INCREMENT `blog_cat`
--
ALTER TABLE `blog_cat`
  MODIFY `no` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- 테이블의 AUTO_INCREMENT `blog_project`
--
ALTER TABLE `blog_project`
  MODIFY `no` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- 테이블의 AUTO_INCREMENT `blog_tag`
--
ALTER TABLE `blog_tag`
  MODIFY `no` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
