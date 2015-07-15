-- ----------------------------
-- Table structure for `whos_online`
-- ----------------------------
DROP TABLE IF EXISTS `whos_online`;
CREATE TABLE `whos_online` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `session_id` varchar(64) CHARACTER SET utf8 NOT NULL,
  `first_click` datetime NOT NULL,
  `last_click` datetime DEFAULT NULL,
  `ip` varchar(128) CHARACTER SET utf8 NOT NULL,
  `route` varchar(1024) CHARACTER SET utf8 DEFAULT NULL,
  `agent` varchar(1024) CHARACTER SET utf8 DEFAULT NULL,
  `referer` varchar(1024) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
