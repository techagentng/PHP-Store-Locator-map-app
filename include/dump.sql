CREATE TABLE IF NOT EXISTS `store_locator` (
  `id` int(11) AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `post_id` int(11) NOT NULL DEFAULT 0,
  `category_id` int(11) NULL DEFAULT 0,
  `name` char(160) NOT NULL DEFAULT '',
  `logo` char(255) NOT NULL DEFAULT '',
  `address` char(160) NOT NULL DEFAULT '',
  `lat` char(20) NOT NULL DEFAULT '',
  `lng` char(20) NOT NULL DEFAULT '',
  `url` char(200) NOT NULL DEFAULT '',
  `description` text,
  `tel` varchar(30) NOT NULL DEFAULT '',
  `email` varchar(60) NOT NULL DEFAULT '',
  `city` char(60) NOT NULL DEFAULT '',
  `country` char(60) NOT NULL DEFAULT '',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=INNODB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `store_locator_category` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(120) NOT NULL DEFAULT '',
  `marker_icon` varchar(255) NOT NULL DEFAULT '',
  `image` varchar(255) NOT NULL DEFAULT ''
) ENGINE=INNODB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;