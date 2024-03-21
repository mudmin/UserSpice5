-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 23, 2022 at 01:18 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `546_full2`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit`
--

CREATE TABLE `audit` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `page` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ip` varchar(255) NOT NULL,
  `viewed` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `crons`
--

CREATE TABLE `crons` (
  `id` int(11) NOT NULL,
  `active` int(1) NOT NULL DEFAULT 1,
  `sort` int(3) NOT NULL,
  `name` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `createdby` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `crons`
--

INSERT INTO `crons` (`id`, `active`, `sort`, `name`, `file`, `createdby`, `created`, `modified`) VALUES
(1, 0, 100, 'Auto-Backup', 'backup.php', 1, '2017-09-16 07:49:22', '2017-11-11 20:15:36');

-- --------------------------------------------------------

--
-- Table structure for table `crons_logs`
--

CREATE TABLE `crons_logs` (
  `id` int(11) NOT NULL,
  `cron_id` int(11) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `email`
--

CREATE TABLE `email` (
  `id` int(11) NOT NULL,
  `website_name` varchar(100) NOT NULL,
  `smtp_server` varchar(100) NOT NULL,
  `smtp_port` int(10) NOT NULL,
  `email_login` varchar(150) NOT NULL,
  `email_pass` varchar(100) NOT NULL,
  `from_name` varchar(100) NOT NULL,
  `from_email` varchar(150) NOT NULL,
  `transport` varchar(255) NOT NULL,
  `verify_url` varchar(255) NOT NULL,
  `email_act` int(1) NOT NULL,
  `debug_level` int(1) NOT NULL DEFAULT 0,
  `isSMTP` int(1) NOT NULL DEFAULT 0,
  `isHTML` varchar(5) NOT NULL DEFAULT 'true',
  `useSMTPauth` varchar(6) NOT NULL DEFAULT 'true',
  `authtype` varchar(50) DEFAULT 'CRAM-MD5'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `email`
--

INSERT INTO `email` (`id`, `website_name`, `smtp_server`, `smtp_port`, `email_login`, `email_pass`, `from_name`, `from_email`, `transport`, `verify_url`, `email_act`, `debug_level`, `isSMTP`, `isHTML`, `useSMTPauth`, `authtype`) VALUES
(1, 'User Spice', 'smtp.gmail.com', 587, 'yourEmail@gmail.com', '1234', 'User Spice', 'yourEmail@gmail.com', 'tls', 'http://localhost/userspice', 0, 0, 0, 'true', 'true', 'CRAM-MD5');

-- --------------------------------------------------------

--
-- Table structure for table `groups_menus`
--

CREATE TABLE `groups_menus` (
  `id` int(11) UNSIGNED NOT NULL,
  `group_id` int(11) UNSIGNED NOT NULL,
  `menu_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `groups_menus`
--

INSERT INTO `groups_menus` (`id`, `group_id`, `menu_id`) VALUES
(5, 0, 3),
(6, 0, 1),
(7, 0, 2),
(8, 0, 51),
(9, 0, 52),
(10, 0, 37),
(11, 0, 38),
(12, 2, 39),
(13, 2, 40),
(14, 2, 41),
(15, 2, 42),
(16, 2, 43),
(17, 2, 44),
(18, 2, 45),
(19, 0, 46),
(20, 0, 47),
(21, 0, 49),
(25, 0, 18),
(26, 0, 20),
(27, 0, 21),
(28, 0, 7),
(29, 0, 8),
(30, 2, 9),
(31, 2, 10),
(32, 2, 11),
(33, 2, 12),
(34, 2, 13),
(35, 2, 14),
(36, 2, 15),
(37, 0, 16),
(38, 1, 15);

-- --------------------------------------------------------

--
-- Table structure for table `keys`
--

CREATE TABLE `keys` (
  `id` int(11) NOT NULL,
  `stripe_ts` varchar(255) NOT NULL,
  `stripe_tp` varchar(255) NOT NULL,
  `stripe_ls` varchar(255) NOT NULL,
  `stripe_lp` varchar(255) NOT NULL,
  `recap_pub` varchar(100) NOT NULL,
  `recap_pri` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `logdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `logtype` varchar(25) NOT NULL,
  `lognote` mediumtext NOT NULL,
  `ip` varchar(75) DEFAULT NULL,
  `metadata` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `logdate`, `logtype`, `lognote`, `ip`, `metadata`) VALUES
(1, 1, '2022-12-23 12:05:38', 'System Updates', 'Update 2022-05-04a successfully deployed.', '::1', NULL),
(2, 1, '2022-12-23 12:05:43', 'login', 'User logged in.', '::1', NULL),
(3, 1, '2022-12-23 12:06:38', 'System Updates', 'Update 2022-11-06a successfully deployed.', '::1', NULL),
(4, 1, '2022-12-23 12:06:38', 'System Updates', 'Update 2022-11-20a successfully deployed.', '::1', NULL),
(5, 1, '2022-12-23 12:06:38', 'System Updates', 'Update 2022-12-04a successfully deployed.', '::1', NULL),
(6, 1, '2022-12-23 12:06:38', 'System Updates', 'Update 2022-12-22a successfully deployed.', '::1', NULL),
(7, 1, '2022-12-23 12:06:38', 'System Updates', 'Update 2022-12-23a successfully deployed.', '::1', NULL),
(8, 1, '2022-12-23 12:16:27', 'login', 'User logged in.', '::1', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int(10) NOT NULL,
  `menu_title` varchar(255) NOT NULL,
  `parent` int(10) NOT NULL,
  `dropdown` int(1) NOT NULL,
  `logged_in` int(1) NOT NULL,
  `display_order` int(10) NOT NULL,
  `label` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `icon_class` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `menu_title`, `parent`, `dropdown`, `logged_in`, `display_order`, `label`, `link`, `icon_class`) VALUES
(1, 'main', 2, 0, 1, 1, '{{home}}', '', 'fa fa-fw fa-home'),
(2, 'main', -1, 1, 1, 14, '', '', 'fa fa-fw fa-cogs'),
(3, 'main', -1, 0, 1, 11, '{{username}}', 'users/account.php', 'fa fa-fw fa-user'),
(4, 'main', -1, 1, 0, 3, '{{help}}', '', 'fa fa-fw fa-life-ring'),
(5, 'main', -1, 0, 0, 2, '{{register}}', 'users/join.php', 'fa fa-fw fa-plus-square'),
(6, 'main', -1, 0, 0, 1, '{{login}}', 'users/login.php', 'fa fa-fw fa-sign-in'),
(7, 'main', 2, 0, 1, 2, '{{account}}', 'users/account.php', 'fa fa-fw fa-user'),
(8, 'main', 2, 0, 1, 3, '{{hr}}', '', ''),
(9, 'main', 2, 0, 1, 4, '{{dashboard}}', 'users/admin.php', 'fa fa-fw fa-cogs'),
(10, 'main', 2, 0, 1, 5, '{{users}}', 'users/admin.php?view=users', 'fa fa-fw fa-user'),
(11, 'main', 2, 0, 1, 6, '{{perms}}', 'users/admin.php?view=permissions', 'fa fa-fw fa-lock'),
(12, 'main', 2, 0, 1, 7, '{{pages}}', 'users/admin.php?view=pages', 'fa fa-fw fa-wrench'),
(13, 'main', 2, 0, 1, 9, '{{logs}}', 'users/admin.php?view=logs', 'fa fa-fw fa-search'),
(14, 'main', 2, 0, 1, 10, '{{hr}}', '', ''),
(15, 'main', 2, 0, 1, 11, '{{logout}}', 'users/logout.php', 'fa fa-fw fa-sign-out'),
(16, 'main', -1, 0, 0, 0, '{{home}}', '', 'fa fa-fw fa-home'),
(17, 'main', -1, 0, 1, 10, '{{home}}', '', 'fa fa-fw fa-home'),
(18, 'main', 4, 0, 0, 1, '{{forgot}}', 'users/forgot_password.php', 'fa fa-fw fa-wrench'),
(20, 'main', 4, 0, 0, 99999, '{{resend}}', 'users/verify_resend.php', 'fa fa-exclamation-triangle');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `msg_from` int(11) NOT NULL,
  `msg_to` int(11) NOT NULL,
  `msg_body` mediumtext NOT NULL,
  `msg_read` int(1) NOT NULL,
  `msg_thread` int(11) NOT NULL,
  `deleted` int(1) NOT NULL,
  `sent_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `message_threads`
--

CREATE TABLE `message_threads` (
  `id` int(11) NOT NULL,
  `msg_to` int(11) NOT NULL,
  `msg_from` int(11) NOT NULL,
  `msg_subject` varchar(255) NOT NULL,
  `last_update` datetime NOT NULL,
  `last_update_by` int(11) NOT NULL,
  `archive_from` int(1) NOT NULL DEFAULT 0,
  `archive_to` int(1) NOT NULL DEFAULT 0,
  `hidden_from` int(1) NOT NULL DEFAULT 0,
  `hidden_to` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` longtext NOT NULL,
  `is_read` tinyint(4) NOT NULL,
  `is_archived` tinyint(1) DEFAULT 0,
  `date_created` datetime DEFAULT NULL,
  `date_read` datetime DEFAULT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `class` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `page` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `private` int(11) NOT NULL DEFAULT 0,
  `re_auth` int(1) NOT NULL DEFAULT 0,
  `core` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `page`, `title`, `private`, `re_auth`, `core`) VALUES
(1, 'index.php', 'Home', 0, 0, 1),
(2, 'z_us_root.php', '', 0, 0, 1),
(3, 'users/account.php', 'Account Dashboard', 1, 0, 1),
(4, 'users/admin.php', 'Admin Dashboard', 1, 0, 1),
(14, 'users/forgot_password.php', 'Forgotten Password', 0, 0, 1),
(15, 'users/forgot_password_reset.php', 'Reset Forgotten Password', 0, 0, 1),
(16, 'users/index.php', 'Home', 0, 0, 1),
(17, 'users/init.php', '', 0, 0, 1),
(18, 'users/join.php', 'Join', 0, 0, 1),
(20, 'users/login.php', 'Login', 0, 0, 1),
(21, 'users/logout.php', 'Logout', 0, 0, 1),
(24, 'users/user_settings.php', 'User Settings', 1, 0, 1),
(25, 'users/verify.php', 'Account Verification', 0, 0, 1),
(26, 'users/verify_resend.php', 'Account Verification', 0, 0, 1),
(45, 'users/maintenance.php', 'Maintenance', 0, 0, 1),
(68, 'users/update.php', 'Update Manager', 1, 0, 1),
(81, 'users/admin_pin.php', 'Verification PIN Set', 1, 0, 1),
(90, 'users/complete.php', NULL, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`) VALUES
(1, 'User'),
(2, 'Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `permission_page_matches`
--

CREATE TABLE `permission_page_matches` (
  `id` int(11) NOT NULL,
  `permission_id` int(11) DEFAULT NULL,
  `page_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `permission_page_matches`
--

INSERT INTO `permission_page_matches` (`id`, `permission_id`, `page_id`) VALUES
(3, 1, 24),
(14, 2, 4),
(15, 1, 3),
(38, 2, 68),
(54, 1, 81);

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bio` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `user_id`, `bio`) VALUES
(1, 1, '&lt;h1&gt;This is the Admin&#039;s bio.&lt;/h1&gt;'),
(2, 2, 'This is your bio');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(50) NOT NULL,
  `recaptcha` int(1) NOT NULL DEFAULT 0,
  `force_ssl` int(1) NOT NULL,
  `css_sample` int(1) NOT NULL,
  `site_name` varchar(100) NOT NULL,
  `language` varchar(255) NOT NULL,
  `site_offline` int(1) NOT NULL,
  `force_pr` int(1) NOT NULL,
  `glogin` int(1) NOT NULL DEFAULT 0,
  `fblogin` int(1) NOT NULL,
  `gid` varchar(255) NOT NULL,
  `gsecret` varchar(255) NOT NULL,
  `gredirect` varchar(255) NOT NULL,
  `ghome` varchar(255) NOT NULL,
  `fbid` varchar(255) NOT NULL,
  `fbsecret` varchar(255) NOT NULL,
  `fbcallback` varchar(255) NOT NULL,
  `graph_ver` varchar(255) NOT NULL,
  `finalredir` varchar(255) NOT NULL,
  `req_cap` int(1) NOT NULL,
  `req_num` int(1) NOT NULL,
  `min_pw` int(2) NOT NULL,
  `max_pw` int(3) NOT NULL,
  `min_un` int(2) NOT NULL,
  `max_un` int(3) NOT NULL,
  `messaging` int(1) NOT NULL,
  `snooping` int(1) NOT NULL,
  `echouser` int(11) NOT NULL,
  `wys` int(1) NOT NULL,
  `change_un` int(1) NOT NULL,
  `backup_dest` varchar(255) NOT NULL,
  `backup_source` varchar(255) NOT NULL,
  `backup_table` varchar(255) NOT NULL,
  `msg_notification` int(1) NOT NULL,
  `permission_restriction` int(1) NOT NULL,
  `auto_assign_un` int(1) NOT NULL,
  `page_permission_restriction` int(1) NOT NULL,
  `msg_blocked_users` int(1) NOT NULL,
  `msg_default_to` int(1) NOT NULL,
  `notifications` int(1) NOT NULL,
  `notif_daylimit` int(3) NOT NULL,
  `recap_public` varchar(100) NOT NULL,
  `recap_private` varchar(100) NOT NULL,
  `page_default_private` int(1) NOT NULL,
  `navigation_type` tinyint(1) NOT NULL,
  `copyright` varchar(255) NOT NULL,
  `custom_settings` int(1) NOT NULL,
  `system_announcement` varchar(255) NOT NULL,
  `twofa` int(1) DEFAULT 0,
  `force_notif` tinyint(1) DEFAULT NULL,
  `cron_ip` varchar(255) DEFAULT NULL,
  `registration` tinyint(1) DEFAULT NULL,
  `join_vericode_expiry` int(9) UNSIGNED NOT NULL,
  `reset_vericode_expiry` int(9) UNSIGNED NOT NULL,
  `admin_verify` tinyint(1) NOT NULL,
  `admin_verify_timeout` int(9) NOT NULL,
  `session_manager` tinyint(1) NOT NULL,
  `template` varchar(255) DEFAULT 'standard',
  `saas` tinyint(1) DEFAULT NULL,
  `redirect_uri_after_login` mediumtext DEFAULT NULL,
  `show_tos` tinyint(1) DEFAULT 1,
  `default_language` varchar(11) DEFAULT NULL,
  `allow_language` tinyint(1) DEFAULT NULL,
  `spice_api` varchar(75) DEFAULT NULL,
  `announce` datetime DEFAULT NULL,
  `bleeding_edge` tinyint(1) DEFAULT 0,
  `err_time` int(11) DEFAULT 15,
  `container_open_class` varchar(255) DEFAULT 'container-fluid',
  `debug` tinyint(1) DEFAULT 0,
  `widgets` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `recaptcha`, `force_ssl`, `css_sample`, `site_name`, `language`, `site_offline`, `force_pr`, `glogin`, `fblogin`, `gid`, `gsecret`, `gredirect`, `ghome`, `fbid`, `fbsecret`, `fbcallback`, `graph_ver`, `finalredir`, `req_cap`, `req_num`, `min_pw`, `max_pw`, `min_un`, `max_un`, `messaging`, `snooping`, `echouser`, `wys`, `change_un`, `backup_dest`, `backup_source`, `backup_table`, `msg_notification`, `permission_restriction`, `auto_assign_un`, `page_permission_restriction`, `msg_blocked_users`, `msg_default_to`, `notifications`, `notif_daylimit`, `recap_public`, `recap_private`, `page_default_private`, `navigation_type`, `copyright`, `custom_settings`, `system_announcement`, `twofa`, `force_notif`, `cron_ip`, `registration`, `join_vericode_expiry`, `reset_vericode_expiry`, `admin_verify`, `admin_verify_timeout`, `session_manager`, `template`, `saas`, `redirect_uri_after_login`, `show_tos`, `default_language`, `allow_language`, `spice_api`, `announce`, `bleeding_edge`, `err_time`, `container_open_class`, `debug`, `widgets`) VALUES
(1, 0, 0, 0, 'UserSpice', 'en', 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', 0, 0, 6, 150, 4, 30, 0, 1, 0, 1, 0, '/', 'everything', '', 0, 0, 0, 0, 0, 1, 0, 7, '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI', '6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe', 1, 1, 'UserSpice', 1, '', 0, 0, 'off', 1, 24, 15, 1, 120, 0, 'bs5', NULL, NULL, 1, 'en-US', 0, NULL, '2022-12-23 07:05:43', 0, 15, 'container-fluid', 0, 'settings,misc,tools,plugins,snapshot,active_users,active-users');

-- --------------------------------------------------------

--
-- Table structure for table `updates`
--

CREATE TABLE `updates` (
  `id` int(11) NOT NULL,
  `migration` varchar(15) NOT NULL,
  `applied_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `update_skipped` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `updates`
--

INSERT INTO `updates` (`id`, `migration`, `applied_on`, `update_skipped`) VALUES
(15, '1XdrInkjV86F', '2018-02-18 22:33:24', NULL),
(16, '3GJYaKcqUtw7', '2018-04-25 16:51:08', NULL),
(17, '3GJYaKcqUtz8', '2018-04-25 16:51:08', NULL),
(18, '69qa8h6E1bzG', '2018-04-25 16:51:08', NULL),
(19, '2XQjsKYJAfn1', '2018-04-25 16:51:08', NULL),
(20, '549DLFeHMNw7', '2018-04-25 16:51:08', NULL),
(21, '4Dgt2XVjgz2x', '2018-04-25 16:51:08', NULL),
(22, 'VLBp32gTWvEo', '2018-04-25 16:51:08', NULL),
(23, 'Q3KlhjdtxE5X', '2018-04-25 16:51:08', NULL),
(24, 'ug5D3pVrNvfS', '2018-04-25 16:51:08', NULL),
(25, '69FbVbv4Jtrz', '2018-04-25 16:51:09', NULL),
(26, '4A6BdJHyvP4a', '2018-04-25 16:51:09', NULL),
(27, '37wvsb5BzymK', '2018-04-25 16:51:09', NULL),
(28, 'c7tZQf926zKq', '2018-04-25 16:51:09', NULL),
(29, 'ockrg4eU33GP', '2018-04-25 16:51:09', NULL),
(30, 'XX4zArPs4tor', '2018-04-25 16:51:09', NULL),
(31, 'pv7r2EHbVvhD', '2018-04-26 00:00:00', NULL),
(32, 'uNT7NpgcBDFD', '2018-04-26 00:00:00', NULL),
(33, 'mS5VtQCZjyJs', '2018-12-11 14:19:16', NULL),
(34, '23rqAv5elJ3G', '2018-12-11 14:19:51', NULL),
(35, 'qPEARSh49fob', '2019-01-01 12:01:01', NULL),
(36, 'FyMYJ2oeGCTX', '2019-01-01 12:01:01', NULL),
(37, 'iit5tHSLatiS', '2019-01-01 12:01:01', NULL),
(38, 'hcA5B3PLhq6E', '2020-07-16 11:27:53', NULL),
(39, 'VNEno3E4zaNz', '2020-07-16 11:27:53', NULL),
(40, '2ZB9mg1l0JXe', '2020-07-16 11:27:53', NULL),
(41, 'B9t6He7qmFXa', '2020-07-16 11:27:53', NULL),
(42, '86FkFVV4TGRg', '2020-07-16 11:27:53', NULL),
(43, 'y4A1Y0u9n2Rt', '2020-07-16 11:27:53', NULL),
(44, 'Tm5xY22MM8eC', '2020-07-16 11:27:53', NULL),
(45, '0YXdrInkjV86F', '2020-07-16 11:27:53', NULL),
(46, '99plgnkjV86', '2020-07-16 11:27:53', NULL),
(47, '0DaShInkjV86', '2020-07-16 11:27:53', NULL),
(48, '0DaShInkjVz1', '2020-07-16 11:27:53', NULL),
(49, 'y4A1Y0u9n2SS', '2020-07-16 11:27:53', NULL),
(50, '0DaShInkjV87', '2020-07-16 11:27:53', NULL),
(51, '0DaShInkjV88', '2020-07-16 11:27:53', NULL),
(52, '2019-09-04a', '2020-07-16 11:27:53', NULL),
(53, '2019-09-05a', '2020-07-16 11:27:53', NULL),
(54, '2019-09-26a', '2020-07-16 11:27:53', NULL),
(55, '2019-11-19a', '2020-07-16 11:27:53', NULL),
(56, '2019-12-28a', '2020-07-16 11:27:53', NULL),
(57, '2020-01-21a', '2020-07-16 11:27:54', NULL),
(58, '2020-03-26a', '2020-07-16 11:27:54', NULL),
(59, '2020-04-17a', '2020-07-16 11:27:54', NULL),
(60, '2020-06-06a', '2020-07-16 11:27:54', NULL),
(61, '2020-06-30a', '2020-07-16 11:27:54', NULL),
(62, '2020-07-01a', '2020-07-16 11:27:54', NULL),
(63, '2020-07-16a', '2020-10-08 01:26:22', NULL),
(64, '2020-07-30a', '2020-10-08 01:26:22', NULL),
(65, '2020-10-06a', '2022-04-15 17:37:11', NULL),
(66, '2020-11-03a', '2022-04-15 17:37:11', NULL),
(67, '2020-11-08a', '2022-04-15 17:37:11', NULL),
(68, '2020-11-10a', '2022-04-15 17:37:11', NULL),
(69, '2020-11-10b', '2022-04-15 17:37:11', NULL),
(70, '2020-12-17a', '2022-04-15 17:37:11', NULL),
(71, '2020-12-28a', '2022-04-15 17:37:11', NULL),
(72, '2021-01-20a', '2022-04-15 17:37:11', NULL),
(73, '2021-02-16a', '2022-04-15 17:37:11', NULL),
(74, '2021-04-14a', '2022-04-15 17:37:11', NULL),
(75, '2021-04-15a', '2022-04-15 17:37:11', NULL),
(76, '2021-05-20a', '2022-04-15 17:37:11', NULL),
(77, '2021-07-11a', '2022-04-15 17:37:11', NULL),
(78, '2021-08-22a', '2022-04-15 17:37:11', NULL),
(79, '2021-08-24a', '2022-04-15 17:37:11', NULL),
(80, '2021-09-25a', '2022-04-15 17:37:11', NULL),
(81, '2021-12-26a', '2022-04-15 17:37:11', NULL),
(82, '2022-05-04a', '2022-12-23 12:05:38', NULL),
(83, '2022-11-06a', '2022-12-23 12:06:38', NULL),
(84, '2022-11-20a', '2022-12-23 12:06:38', NULL),
(85, '2022-12-04a', '2022-12-23 12:06:38', NULL),
(86, '2022-12-22a', '2022-12-23 12:06:38', NULL),
(87, '2022-12-23a', '2022-12-23 12:06:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `permissions` tinyint(1) NOT NULL,
  `email` varchar(155) NOT NULL,
  `email_new` varchar(155) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `pin` varchar(255) DEFAULT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `language` varchar(255) DEFAULT 'en-US',
  `email_verified` tinyint(1) NOT NULL DEFAULT 0,
  `vericode` varchar(15) DEFAULT NULL,
  `vericode_expiry` datetime DEFAULT NULL,
  `oauth_provider` varchar(255) DEFAULT NULL,
  `oauth_uid` varchar(255) DEFAULT NULL,
  `gender` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `gpluslink` varchar(255) DEFAULT NULL,
  `account_owner` tinyint(4) NOT NULL DEFAULT 1,
  `account_id` int(11) NOT NULL DEFAULT 0,
  `account_mgr` int(11) NOT NULL DEFAULT 0,
  `fb_uid` varchar(255) DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL,
  `protected` tinyint(1) NOT NULL DEFAULT 0,
  `msg_exempt` tinyint(1) NOT NULL DEFAULT 0,
  `dev_user` tinyint(1) NOT NULL DEFAULT 0,
  `msg_notification` tinyint(1) NOT NULL DEFAULT 1,
  `cloak_allowed` tinyint(1) NOT NULL DEFAULT 0,
  `oauth_tos_accepted` tinyint(1) DEFAULT NULL,
  `un_changed` tinyint(1) NOT NULL DEFAULT 0,
  `force_pr` tinyint(1) NOT NULL DEFAULT 0,
  `logins` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `last_login` datetime DEFAULT NULL,
  `join_date` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `permissions`, `email`, `email_new`, `username`, `password`, `pin`, `fname`, `lname`, `language`, `email_verified`, `vericode`, `vericode_expiry`, `oauth_provider`, `oauth_uid`, `gender`, `locale`, `gpluslink`, `account_owner`, `account_id`, `account_mgr`, `fb_uid`, `picture`, `created`, `protected`, `msg_exempt`, `dev_user`, `msg_notification`, `cloak_allowed`, `oauth_tos_accepted`, `un_changed`, `force_pr`, `logins`, `last_login`, `join_date`, `modified`, `active`) VALUES
(1, 1, 'userspicephp@userspice.com', NULL, 'admin', '$2y$12$1v06jm2KMOXuuo3qP7erTuTIJFOnzhpds1Moa8BadnUUeX0RV3ex.', NULL, 'The', 'Admin', 'en-US', 1, 'nlPsJDtyeqFWsS', NULL, '', '', '', '', '', 1, 0, 0, '', '', '0000-00-00 00:00:00', 1, 1, 0, 1, 1, NULL, 0, 0, 0, '2022-12-23 07:16:27', '2022-12-25 00:00:00', '2016-01-01 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users_online`
--

CREATE TABLE `users_online` (
  `id` int(11) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `timestamp` varchar(15) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `session` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users_session`
--

CREATE TABLE `users_session` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `uagent` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_permission_matches`
--

CREATE TABLE `user_permission_matches` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_permission_matches`
--

INSERT INTO `user_permission_matches` (`id`, `user_id`, `permission_id`) VALUES
(100, 1, 1),
(101, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `us_announcements`
--

CREATE TABLE `us_announcements` (
  `id` int(11) NOT NULL,
  `dismissed` int(11) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `ignore` varchar(50) DEFAULT NULL,
  `class` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `us_fingerprints`
--

CREATE TABLE `us_fingerprints` (
  `kFingerprintID` int(11) UNSIGNED NOT NULL,
  `fkUserID` int(11) NOT NULL,
  `Fingerprint` varchar(32) NOT NULL,
  `Fingerprint_Expiry` datetime NOT NULL,
  `Fingerprint_Added` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `us_fingerprint_assets`
--

CREATE TABLE `us_fingerprint_assets` (
  `kFingerprintAssetID` int(11) UNSIGNED NOT NULL,
  `fkFingerprintID` int(11) NOT NULL,
  `IP_Address` varchar(255) NOT NULL,
  `User_Browser` varchar(255) NOT NULL,
  `User_OS` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `us_forms`
--

CREATE TABLE `us_forms` (
  `id` int(11) NOT NULL,
  `form` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `us_form_validation`
--

CREATE TABLE `us_form_validation` (
  `id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `params` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `us_form_validation`
--

INSERT INTO `us_form_validation` (`id`, `value`, `description`, `params`) VALUES
(1, 'min', 'Minimum # of Characters', 'number'),
(2, 'max', 'Maximum # of Characters', 'number'),
(3, 'is_numeric', 'Must be a number', 'true'),
(4, 'valid_email', 'Must be a valid email address', 'true'),
(5, '<', 'Must be a number less than', 'number'),
(6, '>', 'Must be a number greater than', 'number'),
(7, '<=', 'Must be a number less than or equal to', 'number'),
(8, '>=', 'Must be a number greater than or equal to', 'number'),
(9, '!=', 'Must not be equal to', 'text'),
(10, '==', 'Must be equal to', 'text'),
(11, 'is_integer', 'Must be an integer', 'true'),
(12, 'is_timezone', 'Must be a valid timezone name', 'true'),
(13, 'is_datetime', 'Must be a valid DateTime', 'true');

-- --------------------------------------------------------

--
-- Table structure for table `us_form_views`
--

CREATE TABLE `us_form_views` (
  `id` int(11) NOT NULL,
  `form_name` varchar(255) NOT NULL,
  `view_name` varchar(255) NOT NULL,
  `fields` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `us_ip_blacklist`
--

CREATE TABLE `us_ip_blacklist` (
  `id` int(11) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `last_user` int(11) NOT NULL DEFAULT 0,
  `reason` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `us_ip_list`
--

CREATE TABLE `us_ip_list` (
  `id` int(11) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `us_ip_list`
--

INSERT INTO `us_ip_list` (`id`, `ip`, `user_id`, `timestamp`) VALUES
(2, '::1', 1, '2022-12-23 12:05:43');

-- --------------------------------------------------------

--
-- Table structure for table `us_ip_whitelist`
--

CREATE TABLE `us_ip_whitelist` (
  `id` int(11) NOT NULL,
  `ip` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `us_management`
--

CREATE TABLE `us_management` (
  `id` int(11) NOT NULL,
  `page` varchar(255) NOT NULL,
  `view` varchar(255) NOT NULL,
  `feature` varchar(255) NOT NULL,
  `access` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `us_management`
--

INSERT INTO `us_management` (`id`, `page`, `view`, `feature`, `access`) VALUES
(1, '_admin_manage_ip.php', 'ip', 'IP Whitelist/Blacklist', ''),
(2, '_admin_nav.php', 'nav', 'Navigation [List/Add/Delete]', ''),
(3, '_admin_nav_item.php', 'nav_item', 'Navigation [View/Edit]', ''),
(4, '_admin_pages.php', 'pages', 'Page Management [List]', ''),
(5, '_admin_page.php', 'page', 'Page Management [View/Edit]', ''),
(6, '_admin_security_logs.php', 'security_logs', 'Security Logs', ''),
(7, '_admin_templates.php', 'templates', 'Templates', ''),
(8, '_admin_tools_check_updates.php', 'updates', 'Check Updates', ''),
(16, '_admin_menus.php', 'menus', 'Manage UltraMenu', ''),
(17, '_admin_logs.php', 'logs', 'System Logs', '');

-- --------------------------------------------------------

--
-- Table structure for table `us_menus`
--

CREATE TABLE `us_menus` (
  `id` int(11) UNSIGNED NOT NULL,
  `menu_name` varchar(255) DEFAULT NULL,
  `type` varchar(75) DEFAULT NULL,
  `nav_class` varchar(255) DEFAULT NULL,
  `theme` varchar(25) DEFAULT NULL,
  `z_index` int(11) DEFAULT NULL,
  `brand_html` text DEFAULT NULL,
  `disabled` tinyint(1) DEFAULT 0,
  `justify` varchar(10) DEFAULT 'right'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `us_menus`
--

INSERT INTO `us_menus` (`id`, `menu_name`, `type`, `nav_class`, `theme`, `z_index`, `brand_html`, `disabled`, `justify`) VALUES
(1, 'Main Menu', 'horizontal', '', 'dark', 50, '&lt;a href=&quot;{{root}}&quot; &gt;\r\n&lt;img src=&quot;{{root}}users/images/logo.png&quot; /&gt;', 0, 'right'),
(2, 'Dashboard Menu', 'horizontal', NULL, 'dark', 55, '&lt;a href=&quot;{{root}}&quot; title=&quot;Home Page&quot;&gt;\r\n&lt;img src=&quot;{{root}}users/images/logo.png&quot; alt=&quot;Main logo&quot; /&gt;&lt;/a&gt;', 0, 'right');

-- --------------------------------------------------------

--
-- Table structure for table `us_menu_items`
--

CREATE TABLE `us_menu_items` (
  `id` int(11) UNSIGNED NOT NULL,
  `menu` int(11) UNSIGNED NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `link` text DEFAULT NULL,
  `icon_class` varchar(255) DEFAULT NULL,
  `li_class` varchar(255) DEFAULT NULL,
  `a_class` varchar(255) DEFAULT NULL,
  `link_target` varchar(50) DEFAULT NULL,
  `parent` int(11) DEFAULT NULL,
  `display_order` int(11) DEFAULT NULL,
  `disabled` tinyint(1) DEFAULT 0,
  `permissions` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `us_menu_items`
--

INSERT INTO `us_menu_items` (`id`, `menu`, `type`, `label`, `link`, `icon_class`, `li_class`, `a_class`, `link_target`, `parent`, `display_order`, `disabled`, `permissions`) VALUES
(1, 1, 'dropdown', '', '', 'fa fa-cogs', NULL, NULL, '_self', 0, 14, 0, '[1]'),
(2, 1, 'link', '{{LOGGED_IN_USERNAME}}', 'users/account.php', 'fa fa-user', NULL, NULL, '_self', 0, 11, 0, '[1]'),
(3, 1, 'dropdown', '{{MENU_HELP}}', '', 'fa fa-life-ring', NULL, NULL, '_self', 0, 3, 0, '[0]'),
(4, 1, 'link', '{{SIGNUP_TEXT}}', 'users/join.php', 'fa fa-plus-square', NULL, NULL, '_self', 0, 2, 0, '[0]'),
(5, 1, 'link', '{{SIGNIN_BUTTONTEXT}}', 'users/login.php', 'fa fa-sign-in', NULL, NULL, '_self', 0, 1, 0, '[0]'),
(6, 1, 'link', '{{MENU_HOME}}', '', 'fa fa-home', NULL, NULL, '_self', 0, 0, 0, '[0]'),
(7, 1, 'link', '{{MENU_HOME}}', '', 'fa fa-home', NULL, NULL, '_self', 0, 10, 0, '[]'),
(8, 1, 'link', '{{MENU_HOME}}', '', 'fa fa-home', NULL, NULL, '_self', 1, 1, 0, '[1]'),
(9, 1, 'link', '{{MENU_ACCOUNT}}', 'users/account.php', 'fa fa-user', NULL, NULL, '_self', 1, 2, 0, '[1]'),
(10, 1, 'separator', '', '', '', NULL, NULL, '_self', 1, 3, 0, '[1]'),
(11, 1, 'link', '{{MENU_DASH}}', 'users/admin.php', 'fa fa-cogs', NULL, NULL, '_self', 1, 4, 0, '[2]'),
(12, 1, 'link', '{{MENU_USER_MGR}}', 'users/admin.php?view=users', 'fa fa-user', NULL, NULL, '_self', 1, 5, 0, '[2]'),
(13, 1, 'link', '{{MENU_PERM_MGR}}', 'users/admin.php?view=permissions', 'fa fa-lock', NULL, NULL, '_self', 1, 6, 0, '[2]'),
(14, 1, 'link', '{{MENU_PAGE_MGR}}', 'users/admin.php?view=pages', 'fa fa-wrench', NULL, NULL, '_self', 1, 7, 0, '[2]'),
(15, 1, 'link', '{{MENU_LOGS_MGR}}', 'users/admin.php?view=logs', 'fa fa-search', NULL, NULL, '_self', 1, 9, 0, '[2]'),
(16, 1, 'separator', '', '', '', NULL, NULL, '_self', 1, 10, 0, '[2]'),
(17, 1, 'link', '{{MENU_LOGOUT}}', 'users/logout.php', 'fa fa-sign-out', NULL, NULL, '_self', 1, 11, 0, '[2,1]'),
(18, 1, 'link', '{{SIGNIN_FORGOTPASS}}', 'users/forgot_password.php', 'fa fa-wrench', NULL, NULL, '_self', 3, 1, 0, '[0]'),
(19, 1, 'link', '{{VER_RESEND}}', 'users/verify_resend.php', 'fa fa-exclamation-triangle', NULL, NULL, '_self', 3, 99999, 0, '[0]'),
(20, 2, 'link', 'User Manager', 'users/admin.php?view=users', 'fa fa-user', '', '', '_self', 26, 1, 0, '[\"2\"]'),
(21, 2, 'link', 'Spice Shaker', 'users/admin.php?view=spice', 'fa fa-user-secret', '', '', '_self', 0, 2, 0, '[\"2\"]'),
(22, 2, 'dropdown', 'Tools', '', 'fa fa-wrench', '', '', '_self', 0, 3, 0, '[\"2\"]'),
(23, 2, 'link', 'Bug Report', 'users/admin.php?view=bugs', 'fa fa-bug', '', '', '_self', 26, 2, 0, '[\"2\"]'),
(24, 2, 'link', 'IP Manager', 'users/admin.php?view=ip', 'fa fa-warning', '', '', '_self', 26, 3, 0, '[\"0\"]'),
(25, 2, 'link', 'Cron Jobs', 'users/admin.php?view=cron', 'fa fa-terminal', '', '', '_self', 26, 4, 0, '[\"2\"]'),
(26, 2, 'link', 'Security Logs', 'users/admin.php?view=security_logs', 'fa fa-lock', '', '', '_self', 26, 5, 0, '[\"2\"]'),
(27, 2, 'link', 'System Logs', 'users/admin.php?view=logs', 'fa fa-list-ol', '', '', '_self', 26, 6, 0, '[\"2\"]'),
(28, 2, 'link', 'Templates', 'users/admin.php?view=templates', 'fa fa-eye', '', '', '_self', 26, 7, 0, '[\"2\"]'),
(29, 2, 'link', 'Updates', 'users/admin.php?view=updates', 'fa fa-arrow-circle-o-up', '', '', '_self', 26, 8, 0, '[\"2\"]'),
(30, 2, 'dropdown', 'Settings', '', 'fa fa-gear', '', '', '_self', 0, 4, 0, '[\"2\"]'),
(31, 2, 'link', 'General', 'users/admin.php?view=general', 'fa fa-check', '', '', '_self', 34, 2, 0, '[\"2\"]'),
(32, 2, 'link', 'Registration', 'admin.php?view=reg', 'fa fa-users', '', '', '_self', 34, 3, 0, '[\"2\"]'),
(33, 2, 'link', 'Email', 'users/admin.php?view=email', 'fa fa-envelope', '', '', '_self', 34, 4, 0, '[\"2\"]'),
(34, 2, 'link', 'Navigation (Classic)', 'users/admin.php?view=nav', 'fa fa-list-alt', '', '', '_self', 34, 5, 0, '[\"2\"]'),
(35, 2, 'link', 'UltraMenu', 'users/admin.php?view=menus', 'fa fa-rocket', '', '', '_self', 34, 6, 0, '[\"2\"]'),
(36, 2, 'link', 'Dashboard Access', 'users/admin.php?view=access', 'fa fa-file-code-o', '', '', '_self', 34, 7, 0, '[\"2\"]'),
(37, 2, 'link', 'Page Manager', 'users/admin.php?view=pages', 'fa fa-file', '', '', '_self', 26, 9, 0, '[\"2\"]'),
(38, 2, 'link', 'Permissions', 'users/admin.php?view=permissions', 'fa fa-unlock-alt', '', '', '_self', 26, 10, 0, '[\"2\"]'),
(39, 2, 'dropdown', 'Plugins', '#', 'fa fa-plug', '', '', '_self', 0, 5, 0, '[\"2\"]'),
(40, 2, 'snippet', 'All Plugins', 'users/includes/menu_hooks/plugins.php', '', '', '', '_self', 43, 2, 0, '[\"2\"]'),
(41, 2, 'link', 'Plugin Manager', 'users/admin.php?view=plugins', 'fa fa-puzzle-piece', '', '', '_self', 43, 1, 0, '[\"2\"]'),
(42, 2, 'link', 'Home', '#', 'fa fa-home', '', '', '_self', 0, 1, 0, '[\"2\"]'),
(43, 2, 'link', 'Admin Dashboard', 'users/admin.php', 'fa fa-cogs', '', '', '_self', 34, 1, 0, '[\"2\"]'),
(44, 2, 'link', 'Dashboard', 'users/admin.php', 'fa-solid fa-desktop', '', '', '_self', 0, 1, 0, '[\"2\"]');

-- --------------------------------------------------------

--
-- Table structure for table `us_plugins`
--

CREATE TABLE `us_plugins` (
  `id` int(11) NOT NULL,
  `plugin` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `updates` mediumtext DEFAULT NULL,
  `last_check` datetime DEFAULT '2020-01-01 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `us_plugin_hooks`
--

CREATE TABLE `us_plugin_hooks` (
  `id` int(11) UNSIGNED NOT NULL,
  `page` varchar(255) NOT NULL,
  `folder` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `hook` varchar(255) NOT NULL,
  `disabled` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `us_saas_levels`
--

CREATE TABLE `us_saas_levels` (
  `id` int(11) NOT NULL,
  `level` varchar(255) NOT NULL,
  `users` int(11) NOT NULL,
  `details` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `us_saas_orgs`
--

CREATE TABLE `us_saas_orgs` (
  `id` int(11) NOT NULL,
  `org` varchar(255) NOT NULL,
  `owner` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `active` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `us_user_sessions`
--

CREATE TABLE `us_user_sessions` (
  `kUserSessionID` int(11) UNSIGNED NOT NULL,
  `fkUserID` int(11) UNSIGNED NOT NULL,
  `UserFingerprint` varchar(255) NOT NULL,
  `UserSessionIP` varchar(255) NOT NULL,
  `UserSessionOS` varchar(255) NOT NULL,
  `UserSessionBrowser` varchar(255) NOT NULL,
  `UserSessionStarted` datetime NOT NULL,
  `UserSessionLastUsed` datetime DEFAULT NULL,
  `UserSessionLastPage` varchar(255) NOT NULL,
  `UserSessionEnded` tinyint(1) NOT NULL DEFAULT 0,
  `UserSessionEnded_Time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit`
--
ALTER TABLE `audit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crons`
--
ALTER TABLE `crons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crons_logs`
--
ALTER TABLE `crons_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email`
--
ALTER TABLE `email`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups_menus`
--
ALTER TABLE `groups_menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Indexes for table `keys`
--
ALTER TABLE `keys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message_threads`
--
ALTER TABLE `message_threads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission_page_matches`
--
ALTER TABLE `permission_page_matches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `updates`
--
ALTER TABLE `updates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `EMAIL` (`email`) USING BTREE;

--
-- Indexes for table `users_online`
--
ALTER TABLE `users_online`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_session`
--
ALTER TABLE `users_session`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_permission_matches`
--
ALTER TABLE `user_permission_matches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `us_announcements`
--
ALTER TABLE `us_announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `us_fingerprints`
--
ALTER TABLE `us_fingerprints`
  ADD PRIMARY KEY (`kFingerprintID`);

--
-- Indexes for table `us_fingerprint_assets`
--
ALTER TABLE `us_fingerprint_assets`
  ADD PRIMARY KEY (`kFingerprintAssetID`);

--
-- Indexes for table `us_forms`
--
ALTER TABLE `us_forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `us_form_validation`
--
ALTER TABLE `us_form_validation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `us_form_views`
--
ALTER TABLE `us_form_views`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `us_ip_blacklist`
--
ALTER TABLE `us_ip_blacklist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `us_ip_list`
--
ALTER TABLE `us_ip_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `us_ip_whitelist`
--
ALTER TABLE `us_ip_whitelist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `us_management`
--
ALTER TABLE `us_management`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `us_menus`
--
ALTER TABLE `us_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `us_menu_items`
--
ALTER TABLE `us_menu_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `us_plugins`
--
ALTER TABLE `us_plugins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `us_plugin_hooks`
--
ALTER TABLE `us_plugin_hooks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `us_saas_levels`
--
ALTER TABLE `us_saas_levels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `us_saas_orgs`
--
ALTER TABLE `us_saas_orgs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `us_user_sessions`
--
ALTER TABLE `us_user_sessions`
  ADD PRIMARY KEY (`kUserSessionID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit`
--
ALTER TABLE `audit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `crons`
--
ALTER TABLE `crons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `crons_logs`
--
ALTER TABLE `crons_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email`
--
ALTER TABLE `email`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `groups_menus`
--
ALTER TABLE `groups_menus`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `keys`
--
ALTER TABLE `keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `message_threads`
--
ALTER TABLE `message_threads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `permission_page_matches`
--
ALTER TABLE `permission_page_matches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `updates`
--
ALTER TABLE `updates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users_session`
--
ALTER TABLE `users_session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_permission_matches`
--
ALTER TABLE `user_permission_matches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `us_announcements`
--
ALTER TABLE `us_announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `us_fingerprints`
--
ALTER TABLE `us_fingerprints`
  MODIFY `kFingerprintID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `us_fingerprint_assets`
--
ALTER TABLE `us_fingerprint_assets`
  MODIFY `kFingerprintAssetID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `us_forms`
--
ALTER TABLE `us_forms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `us_form_validation`
--
ALTER TABLE `us_form_validation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `us_form_views`
--
ALTER TABLE `us_form_views`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `us_ip_blacklist`
--
ALTER TABLE `us_ip_blacklist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `us_ip_list`
--
ALTER TABLE `us_ip_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `us_ip_whitelist`
--
ALTER TABLE `us_ip_whitelist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `us_management`
--
ALTER TABLE `us_management`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `us_menus`
--
ALTER TABLE `us_menus`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `us_menu_items`
--
ALTER TABLE `us_menu_items`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `us_plugins`
--
ALTER TABLE `us_plugins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `us_plugin_hooks`
--
ALTER TABLE `us_plugin_hooks`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `us_saas_levels`
--
ALTER TABLE `us_saas_levels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `us_saas_orgs`
--
ALTER TABLE `us_saas_orgs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `us_user_sessions`
--
ALTER TABLE `us_user_sessions`
  MODIFY `kUserSessionID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
