-- phpMyAdmin SQL Dump
-- version 4.4.15.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 29, 2016 at 07:40 AM
-- Server version: 5.6.25
-- PHP Version: 5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ppsaas`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2016_04_28_115621_create_customer_table', 1),
('2016_04_28_133448_create_service_table', 2),
('2016_04_28_133512_create_account_table', 2),
('2016_04_28_133621_create_vmis_project_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `saas_account`
--

CREATE TABLE IF NOT EXISTS `saas_account` (
  `id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `saas_contents`
--

CREATE TABLE IF NOT EXISTS `saas_contents` (
  `id` int(10) unsigned NOT NULL COMMENT 'id',
  `flag` varchar(15) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '推荐位',
  `title` varchar(80) COLLATE utf8_unicode_ci NOT NULL COMMENT '文章/单页/碎片/备忘标题',
  `thumb` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '文章/单页缩略图',
  `content` text COLLATE utf8_unicode_ci NOT NULL COMMENT '文章/单页/碎片/备忘正文',
  `slug` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '网址缩略名，文章、单页与碎片模型有缩略名，其它模型暂无',
  `type` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'article' COMMENT '内容类型：article文章模型 page单页模型 fragment碎片模型 memo备忘模型',
  `user_id` int(12) NOT NULL DEFAULT '0' COMMENT '文章编辑用户id',
  `is_top` tinyint(3) NOT NULL DEFAULT '0' COMMENT '是否置顶：1置顶，0不置顶',
  `owner_id` int(12) unsigned DEFAULT '0' COMMENT '归属用户id:一般备忘有归属用户id，0表示无任何归属',
  `outer_link` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '外链地址',
  `category_id` int(10) NOT NULL COMMENT '文章分类id',
  `deleted_at` datetime DEFAULT NULL COMMENT '被软删除时间',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改更新时间'
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='内容数据（文章/单页/碎片/备忘）表';

-- --------------------------------------------------------

--
-- Table structure for table `saas_customer`
--

CREATE TABLE IF NOT EXISTS `saas_customer` (
  `id` int(10) unsigned NOT NULL,
  `full_name` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `short_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `contact_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `introduction` text COLLATE utf8_unicode_ci NOT NULL,
  `logo` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `saas_dict`
--

CREATE TABLE IF NOT EXISTS `saas_dict` (
  `id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `code` varchar(10) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `saas_dict`
--

INSERT INTO `saas_dict` (`id`, `pid`, `code`, `name`, `description`) VALUES
(20, 0, '3', '4', '5'),
(11, 0, '6', '6', '6'),
(21, 0, '4', '4', '4'),
(16, 0, '1', '多大的1', 'fff单独1'),
(17, 16, '放放', '单独s', '搜索');

-- --------------------------------------------------------

--
-- Table structure for table `saas_flags`
--

CREATE TABLE IF NOT EXISTS `saas_flags` (
  `id` int(10) NOT NULL COMMENT 'id',
  `attr` varchar(5) COLLATE utf8_unicode_ci NOT NULL COMMENT '属性名',
  `attr_full_name` varchar(15) COLLATE utf8_unicode_ci NOT NULL COMMENT '属性全称名',
  `display_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '展示名',
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `saas_flags`
--

INSERT INTO `saas_flags` (`id`, `attr`, `attr_full_name`, `display_name`, `description`) VALUES
(1, 'l', 'link', '链接', '可用于友情链接'),
(2, 'f', 'flash', '幻灯', '可用于页面幻灯片模型'),
(3, 's', 'scrolling', '滚动', '可用于页面滚动效果的文章'),
(4, 'h', 'hot', '热门', '可用于页面推荐性文章');

-- --------------------------------------------------------

--
-- Table structure for table `saas_metas`
--

CREATE TABLE IF NOT EXISTS `saas_metas` (
  `id` int(10) unsigned NOT NULL COMMENT 'id',
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT 'meta名',
  `thumb` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'meta缩略图',
  `slug` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'meta缩略名',
  `type` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'category' COMMENT 'meta类型: [category]-分类，[tag]-标签',
  `description` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'meta描述',
  `count` int(10) unsigned DEFAULT '0' COMMENT 'meta被使用的次数',
  `sort` int(6) unsigned DEFAULT '0' COMMENT 'meta排序，数字越大排序越靠前'
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='META元数据（分类|标签） 表';

--
-- Dumping data for table `saas_metas`
--

INSERT INTO `saas_metas` (`id`, `name`, `thumb`, `slug`, `type`, `description`, `count`, `sort`) VALUES
(1, '默认', NULL, 'default', 'category', '默认', 0, 0),
(2, '软件', NULL, 'soft', 'category', '收录个人开发的软件或脚本', 0, 0),
(3, '文档', NULL, 'docs', 'category', '这里收录自己开发过程中所撰写的文档', 0, 0),
(4, 'Laravel', NULL, 'laravel', 'category', '分享一些Laravel相关文章', 0, 0),
(5, 'Javascript', NULL, 'javascript', 'category', '前端Javascript相关知识', 0, 0),
(6, '测试', NULL, NULL, 'category', '测试内容', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `saas_password_resets`
--

CREATE TABLE IF NOT EXISTS `saas_password_resets` (
  `email` varchar(120) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '邮箱',
  `token` varchar(60) COLLATE utf8_unicode_ci NOT NULL COMMENT '会话token',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `saas_permissions`
--

CREATE TABLE IF NOT EXISTS `saas_permissions` (
  `id` int(10) unsigned NOT NULL COMMENT 'id',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '权限名',
  `display_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '权限展示名',
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改更新时间'
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='权限信息表';

--
-- Dumping data for table `saas_permissions`
--

INSERT INTO `saas_permissions` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'manage_contents', '管理内容', NULL, '2014-12-22 02:30:59', '2014-12-22 02:30:59'),
(2, 'manage_users', '管理用户', NULL, '2014-12-22 02:30:59', '2014-12-22 02:30:59'),
(3, 'manage_system', '管理系统', NULL, '2015-02-04 09:40:56', '2015-02-04 09:40:59');

-- --------------------------------------------------------

--
-- Table structure for table `saas_permission_role`
--

CREATE TABLE IF NOT EXISTS `saas_permission_role` (
  `permission_id` int(10) unsigned NOT NULL COMMENT '权限id',
  `role_id` int(10) unsigned NOT NULL COMMENT '角色id'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='权限与用户组角色对应关系表';

--
-- Dumping data for table `saas_permission_role`
--

INSERT INTO `saas_permission_role` (`permission_id`, `role_id`) VALUES
(1, 2),
(1, 3),
(2, 1),
(2, 2),
(3, 1),
(3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `saas_relationships`
--

CREATE TABLE IF NOT EXISTS `saas_relationships` (
  `cid` int(10) unsigned NOT NULL COMMENT '内容数据id',
  `mid` int(10) unsigned NOT NULL COMMENT 'meta元数据id'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='内容与元数据关系联系表[考虑查询复杂度，目前只存储文章单页跟标签的关系]';

-- --------------------------------------------------------

--
-- Table structure for table `saas_roles`
--

CREATE TABLE IF NOT EXISTS `saas_roles` (
  `id` int(10) unsigned NOT NULL COMMENT 'id',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '角色名',
  `display_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '角色展示名',
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '角色描述',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改更新时间'
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户组角色表';

--
-- Dumping data for table `saas_roles`
--

INSERT INTO `saas_roles` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Founder', '创始人', NULL, '2014-12-22 02:30:59', '2014-12-22 02:30:59'),
(2, 'Admin', '超级管理员', NULL, '2014-12-22 02:30:59', '2014-12-22 02:30:59'),
(3, 'Editor', '编辑', NULL, '2015-02-04 17:12:22', '2015-02-04 17:12:22'),
(4, 'Demo', '演示', NULL, '2015-02-04 17:13:03', '2015-02-04 17:13:03');

-- --------------------------------------------------------

--
-- Table structure for table `saas_role_user`
--

CREATE TABLE IF NOT EXISTS `saas_role_user` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `saas_role_user`
--

INSERT INTO `saas_role_user` (`user_id`, `role_id`) VALUES
(1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `saas_service`
--

CREATE TABLE IF NOT EXISTS `saas_service` (
  `id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `saas_settings`
--

CREATE TABLE IF NOT EXISTS `saas_settings` (
  `id` int(10) unsigned NOT NULL COMMENT 'id',
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '设置项名',
  `value` text COLLATE utf8_unicode_ci COMMENT '设置项值',
  `status` tinyint(3) DEFAULT '1' COMMENT '状态 0未启用 1启用 其它数字表示异常',
  `type_id` int(12) DEFAULT '0' COMMENT '设置所属类型id 0表示无任何归属类型',
  `sort` int(6) unsigned DEFAULT '0' COMMENT '设置排序，数字越大排序越靠前'
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='动态设置表';

--
-- Dumping data for table `saas_settings`
--

INSERT INTO `saas_settings` (`id`, `name`, `value`, `status`, `type_id`, `sort`) VALUES
(1, 'default_setting', '默认设置', 1, 1, 999),
(2, 'system', '系统', 1, 2, 0),
(3, 'manager', '管理员', 1, 2, 0),
(4, 'content', '内容', 1, 2, 0),
(5, 'upload', '上传', 1, 2, 0),
(6, 'article', '文章', 1, 3, 0),
(7, 'page', '单页', 1, 3, 0),
(8, 'fragment', '碎片', 1, 3, 0),
(9, 'memo', '备忘', 1, 3, 0),
(10, 'Founder', '创始人', 1, 4, 0),
(11, 'Admin', '超级管理员', 1, 4, 0),
(12, 'Editor', '编辑', 1, 4, 0),
(13, 'Demo', '演示', 1, 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `saas_setting_type`
--

CREATE TABLE IF NOT EXISTS `saas_setting_type` (
  `id` int(10) unsigned NOT NULL COMMENT 'id',
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '设置类型项名',
  `value` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '设置类型项值',
  `sort` int(6) unsigned DEFAULT '0' COMMENT '设置类型排序，数字越大排序越靠前'
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='动态设置类型表';

--
-- Dumping data for table `saas_setting_type`
--

INSERT INTO `saas_setting_type` (`id`, `name`, `value`, `sort`) VALUES
(1, 'default', '默认', 0),
(2, 'system_operation', '系统操作类型', 0),
(3, 'content_type', '内容类型', 0),
(4, 'role_type', '角色类型', 0);

-- --------------------------------------------------------

--
-- Table structure for table `saas_system_log`
--

CREATE TABLE IF NOT EXISTS `saas_system_log` (
  `id` int(12) NOT NULL COMMENT '系统日志id',
  `user_id` int(12) DEFAULT '0' COMMENT '用户id（为0表示系统级操作，其它一般为管理型用户操作）',
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'system' COMMENT '操作类型',
  `url` varchar(200) COLLATE utf8_unicode_ci DEFAULT '-' COMMENT '操作发起的url',
  `content` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '操作内容',
  `operator_ip` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '操作者ip',
  `deleted_at` datetime DEFAULT NULL COMMENT '被软删除时间',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改更新时间'
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='系统日志表';

--
-- Dumping data for table `saas_system_log`
--

INSERT INTO `saas_system_log` (`id`, `user_id`, `type`, `url`, `content`, `operator_ip`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'manager', 'http://yascmf.local/auth/login', '管理员：Admin[admin@example.com] 登录系统。', '127.0.0.1', NULL, '2016-03-31 17:29:24', '2016-03-31 17:29:24'),
(2, 1, 'manager', 'http://ppsaas.local/auth/login', '管理员：Admin[admin@example.com] 登录系统。', '127.0.0.1', NULL, '2016-04-28 15:42:43', '2016-04-28 15:42:43');

-- --------------------------------------------------------

--
-- Table structure for table `saas_system_options`
--

CREATE TABLE IF NOT EXISTS `saas_system_options` (
  `id` int(10) unsigned NOT NULL COMMENT 'id',
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '配置选项名',
  `value` text COLLATE utf8_unicode_ci COMMENT '配置选项值'
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='系统配置选项表';

--
-- Dumping data for table `saas_system_options`
--

INSERT INTO `saas_system_options` (`id`, `name`, `value`) VALUES
(1, 'website_keywords', 'saas'),
(2, 'company_address', ''),
(3, 'website_title', 'saas'),
(4, 'company_telephone', 'saas'),
(5, 'company_full_name', 'saas'),
(6, 'website_icp', ''),
(7, 'system_version', ''),
(8, 'page_size', '10'),
(9, 'system_logo', 'http://cmf.yas.so/assets/img/yas_logo.png'),
(10, 'picture_watermark', 'http://cmf.yas.so/assets/img/yas_logo.png'),
(11, 'company_short_name', 'saas'),
(12, 'system_author', ''),
(13, 'system_author_website', ''),
(14, 'is_watermark', '0');

-- --------------------------------------------------------

--
-- Table structure for table `saas_users`
--

CREATE TABLE IF NOT EXISTS `saas_users` (
  `id` int(12) unsigned NOT NULL COMMENT 'id',
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '用户登录名',
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL COMMENT '用户密码',
  `nickname` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '用户屏显昵称，可以不同用户登录名',
  `email` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '用户邮箱',
  `realname` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '用户真实姓名',
  `pid` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '用户身份证号',
  `pid_card_thumb1` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '身份证证件正面（印有国徽图案、签发机关和有效期限）照片',
  `pid_card_thumb2` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '身份证证件反面（印有个人基本信息和照片）照片',
  `avatar` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '用户个人图像',
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '固定/移动电话',
  `address` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '联系地址',
  `emergency_contact` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '紧急联系人信息',
  `servicer_id` int(12) DEFAULT '0' COMMENT '专属客服id，（为0表示其为无专属客服的管理用户）',
  `deleted_at` datetime DEFAULT NULL COMMENT '被软删除时间',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改更新时间',
  `is_lock` tinyint(3) NOT NULL DEFAULT '0' COMMENT '是否锁定限制用户登录，1锁定,0正常',
  `user_type` enum('visitor','customer','manager') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'visitor' COMMENT '用户类型：visitor 游客, customer 投资客户, manager 管理型用户',
  `confirmation_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '确认码',
  `confirmed` tinyint(1) DEFAULT '0' COMMENT '是否已通过验证 0：未通过 1：通过',
  `remember_token` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Laravel 追加的记住令牌'
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户表';

--
-- Dumping data for table `saas_users`
--

INSERT INTO `saas_users` (`id`, `username`, `password`, `nickname`, `email`, `realname`, `pid`, `pid_card_thumb1`, `pid_card_thumb2`, `avatar`, `phone`, `address`, `emergency_contact`, `servicer_id`, `deleted_at`, `created_at`, `updated_at`, `is_lock`, `user_type`, `confirmation_code`, `confirmed`, `remember_token`) VALUES
(1, 'admin', '$2y$10$J7LHukU1OvdKS0HjHyP67OckaKXwci9vV6iqOCpN65x8X7MDgMNlu', 'Admin', 'admin@example.com', '管理员', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-12-22 02:30:59', '2015-04-26 19:26:04', 0, 'manager', '161590b511f23a7aca43e785ba037d4f', 1, 'GFdBArEXF5jmURqJwsiVfNjZg2AmmR4kBX0Wtgw9djGZgsO6D3G8XZGMTxg9');

-- --------------------------------------------------------

--
-- Table structure for table `vmis_article`
--

CREATE TABLE IF NOT EXISTS `vmis_article` (
  `id` int(11) NOT NULL,
  `sid` int(11) NOT NULL COMMENT 'saas id',
  `uid` int(11) NOT NULL,
  `ctime` int(11) NOT NULL,
  `utime` int(11) NOT NULL,
  `status` smallint(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vmis_fund`
--

CREATE TABLE IF NOT EXISTS `vmis_fund` (
  `id` int(11) NOT NULL,
  `sid` int(11) NOT NULL COMMENT 'saas id',
  `uid` int(11) NOT NULL,
  `ctime` int(11) NOT NULL,
  `utime` int(11) NOT NULL,
  `status` smallint(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vmis_project`
--

CREATE TABLE IF NOT EXISTS `vmis_project` (
  `id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vmis_project_follow`
--

CREATE TABLE IF NOT EXISTS `vmis_project_follow` (
  `id` int(11) NOT NULL,
  `sid` int(11) NOT NULL COMMENT 'saas id',
  `uid` int(11) NOT NULL,
  `ctime` int(11) NOT NULL,
  `utime` int(11) NOT NULL,
  `status` smallint(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vmis_project_invest`
--

CREATE TABLE IF NOT EXISTS `vmis_project_invest` (
  `id` int(11) NOT NULL,
  `sid` int(11) NOT NULL COMMENT 'saas id',
  `uid` int(11) NOT NULL,
  `ctime` int(11) NOT NULL,
  `utime` int(11) NOT NULL,
  `status` smallint(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vmis_project_quit`
--

CREATE TABLE IF NOT EXISTS `vmis_project_quit` (
  `id` int(11) NOT NULL,
  `sid` int(11) NOT NULL COMMENT 'saas id',
  `uid` int(11) NOT NULL,
  `ctime` int(11) NOT NULL,
  `utime` int(11) NOT NULL,
  `status` smallint(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vmis_role`
--

CREATE TABLE IF NOT EXISTS `vmis_role` (
  `id` int(11) NOT NULL,
  `sid` int(11) NOT NULL COMMENT 'saas id',
  `uid` int(11) NOT NULL,
  `ctime` int(11) NOT NULL,
  `utime` int(11) NOT NULL,
  `status` smallint(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vmis_user`
--

CREATE TABLE IF NOT EXISTS `vmis_user` (
  `id` int(11) NOT NULL,
  `sid` int(11) NOT NULL COMMENT 'saas id',
  `uid` int(11) NOT NULL,
  `ctime` int(11) NOT NULL,
  `utime` int(11) NOT NULL,
  `status` smallint(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vmis_user_role`
--

CREATE TABLE IF NOT EXISTS `vmis_user_role` (
  `id` int(11) NOT NULL,
  `sid` int(11) NOT NULL COMMENT 'saas id',
  `uid` int(11) NOT NULL,
  `ctime` int(11) NOT NULL,
  `utime` int(11) NOT NULL,
  `status` smallint(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `saas_account`
--
ALTER TABLE `saas_account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `saas_contents`
--
ALTER TABLE `saas_contents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `content_slug_unique` (`slug`),
  ADD KEY `content_title_index` (`title`);

--
-- Indexes for table `saas_customer`
--
ALTER TABLE `saas_customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `saas_dict`
--
ALTER TABLE `saas_dict`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `saas_flags`
--
ALTER TABLE `saas_flags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `saas_metas`
--
ALTER TABLE `saas_metas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name_index` (`name`),
  ADD KEY `slug_index` (`slug`);

--
-- Indexes for table `saas_permissions`
--
ALTER TABLE `saas_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `saas_permission_role`
--
ALTER TABLE `saas_permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_id_foreign` (`role_id`);

--
-- Indexes for table `saas_relationships`
--
ALTER TABLE `saas_relationships`
  ADD PRIMARY KEY (`cid`,`mid`);

--
-- Indexes for table `saas_roles`
--
ALTER TABLE `saas_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_name_unique` (`name`);

--
-- Indexes for table `saas_role_user`
--
ALTER TABLE `saas_role_user`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_id_foreign` (`role_id`) USING BTREE;

--
-- Indexes for table `saas_service`
--
ALTER TABLE `saas_service`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `saas_settings`
--
ALTER TABLE `saas_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `setting_name_index` (`name`);

--
-- Indexes for table `saas_setting_type`
--
ALTER TABLE `saas_setting_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_type_name_unique` (`name`);

--
-- Indexes for table `saas_system_log`
--
ALTER TABLE `saas_system_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `saas_system_options`
--
ALTER TABLE `saas_system_options`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `system_option_name_unique` (`name`);

--
-- Indexes for table `saas_users`
--
ALTER TABLE `saas_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_username_unique` (`username`),
  ADD UNIQUE KEY `user_email_unique` (`email`),
  ADD UNIQUE KEY `user_pid_unique` (`pid`),
  ADD KEY `user_nickname_index` (`nickname`),
  ADD KEY `user_realname_index` (`realname`),
  ADD KEY `user_phone_index` (`phone`);

--
-- Indexes for table `vmis_article`
--
ALTER TABLE `vmis_article`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vmis_fund`
--
ALTER TABLE `vmis_fund`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vmis_project`
--
ALTER TABLE `vmis_project`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vmis_project_follow`
--
ALTER TABLE `vmis_project_follow`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vmis_project_invest`
--
ALTER TABLE `vmis_project_invest`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vmis_project_quit`
--
ALTER TABLE `vmis_project_quit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vmis_role`
--
ALTER TABLE `vmis_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vmis_user`
--
ALTER TABLE `vmis_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vmis_user_role`
--
ALTER TABLE `vmis_user_role`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `saas_account`
--
ALTER TABLE `saas_account`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `saas_contents`
--
ALTER TABLE `saas_contents`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `saas_customer`
--
ALTER TABLE `saas_customer`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `saas_dict`
--
ALTER TABLE `saas_dict`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `saas_flags`
--
ALTER TABLE `saas_flags`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'id',AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `saas_metas`
--
ALTER TABLE `saas_metas`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `saas_permissions`
--
ALTER TABLE `saas_permissions`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `saas_roles`
--
ALTER TABLE `saas_roles`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `saas_service`
--
ALTER TABLE `saas_service`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `saas_settings`
--
ALTER TABLE `saas_settings`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `saas_setting_type`
--
ALTER TABLE `saas_setting_type`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `saas_system_log`
--
ALTER TABLE `saas_system_log`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT COMMENT '系统日志id',AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `saas_system_options`
--
ALTER TABLE `saas_system_options`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `saas_users`
--
ALTER TABLE `saas_users`
  MODIFY `id` int(12) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `vmis_article`
--
ALTER TABLE `vmis_article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `vmis_fund`
--
ALTER TABLE `vmis_fund`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `vmis_project`
--
ALTER TABLE `vmis_project`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `vmis_project_follow`
--
ALTER TABLE `vmis_project_follow`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `vmis_project_invest`
--
ALTER TABLE `vmis_project_invest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `vmis_project_quit`
--
ALTER TABLE `vmis_project_quit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `vmis_role`
--
ALTER TABLE `vmis_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `vmis_user`
--
ALTER TABLE `vmis_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `vmis_user_role`
--
ALTER TABLE `vmis_user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
