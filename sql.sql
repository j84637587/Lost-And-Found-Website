-- --------------------------------------------------------
-- 主機:                           127.0.0.1
-- 伺服器版本:                        5.7.33 - MySQL Community Server (GPL)
-- 伺服器作業系統:                      Win64
-- HeidiSQL 版本:                  11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- 傾印 lf 的資料庫結構
CREATE DATABASE IF NOT EXISTS `lf` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `lf`;

-- 傾印  資料表 lf.item 結構
CREATE TABLE IF NOT EXISTS `item` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '物品id',
  `type` varchar(50) NOT NULL COMMENT '刊登類型',
  `name` varchar(40) NOT NULL DEFAULT '' COMMENT '物品名稱',
  `description` varchar(400) NOT NULL DEFAULT '' COMMENT '物品說明',
  `img_path` varchar(50) DEFAULT NULL COMMENT '圖片路徑',
  `date` datetime NOT NULL COMMENT '遺失時間',
  `user_id` bigint(20) NOT NULL COMMENT '刊登者',
  `post_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '刊登時間',
  `enable` varchar(1) NOT NULL DEFAULT 'N' COMMENT '是否已審核',
  `del_reason` varchar(100) DEFAULT NULL COMMENT '刪除原因',
  `del_date` datetime DEFAULT NULL COMMENT '刪除時間',
  PRIMARY KEY (`id`),
  KEY `FK_lost_item_user` (`user_id`),
  CONSTRAINT `FK_lost_item_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

-- 正在傾印表格  lf.item 的資料：~8 rows (近似值)
/*!40000 ALTER TABLE `item` DISABLE KEYS */;
REPLACE INTO `item` (`id`, `type`, `name`, `description`, `img_path`, `date`, `user_id`, `post_date`, `enable`, `del_reason`, `del_date`) VALUES
	(1, 'found', '鑰匙', '一個有星星貼紙在上方的鑰匙', '', '2022-06-21 09:18:00', 1, '2022-06-21 06:19:20', 'N', '5', '2022-06-21 21:56:34'),
	(2, 'lost', '學生證', '學號 4xxxxxx 的學生證，遺失在體育館。', NULL, '2022-06-21 21:36:41', 1, '2022-06-21 21:36:42', 'N', '56', '2022-06-21 22:01:09'),
	(7, 'found', '鑰匙', '一個有星星貼紙在上方的鑰匙', NULL, '2022-06-22 06:11:14', 3, '2022-06-22 06:11:15', 'Y', NULL, NULL),
	(8, 'found', '微積分考卷2', '學號:4xxxx 微積分考卷  上面分數是66', '', '2022-06-22 17:31:00', 1, '2022-06-22 17:31:50', 'N', NULL, NULL),
	(10, 'lost', '手機', '紅色', '', '2022-06-16 22:21:00', 5, '2022-06-22 22:22:57', 'N', NULL, NULL);
/*!40000 ALTER TABLE `item` ENABLE KEYS */;

-- 傾印  資料表 lf.user 結構
CREATE TABLE IF NOT EXISTS `user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '使用者ID',
  `name` varchar(50) NOT NULL COMMENT '使用者名稱',
  `account` varchar(50) NOT NULL COMMENT '帳號',
  `password` varchar(50) NOT NULL COMMENT '密碼',
  `email` varchar(50) NOT NULL COMMENT '信箱',
  `admin` varchar(1) NOT NULL DEFAULT 'N' COMMENT '是否為管理員',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- 正在傾印表格  lf.user 的資料：~4 rows (近似值)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
REPLACE INTO `user` (`id`, `name`, `account`, `password`, `email`, `admin`) VALUES
	(1, '測試', 'test', 'test', 'test@email.com', 'N'),
	(2, '管理員', 'admin', 'admin', 'admin@email.com', 'Y');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
