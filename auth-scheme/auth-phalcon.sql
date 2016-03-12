SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `auth_credentials` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(128) NOT NULL,
  `password` varchar(36) NOT NULL,
  `status` enum('active','locked') NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `auth_sessions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `auth_id` int(10) unsigned NOT NULL,
  `adapter` varchar(16) NOT NULL,
  `auth_hash` varchar(36) NOT NULL,
  `user_hash` varchar(36) NOT NULL,
  `user_ip` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `last_visit` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
