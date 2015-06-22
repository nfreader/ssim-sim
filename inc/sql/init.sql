-- Create syntax for TABLE 'tbl_govt'
CREATE TABLE `tbl_govt` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL,
  `color` varchar(6) DEFAULT NULL,
  `color2` varchar(6) DEFAULT NULL,
  `isoname` varchar(2) NOT NULL DEFAULT '',
  `homesyst` int(11) unsigned DEFAULT NULL,
  `type` enum('I','R','P') NOT NULL DEFAULT 'R' COMMENT 'Independent, Regular, Pirate',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4;

-- Create syntax for TABLE 'tbl_jump'
CREATE TABLE `tbl_jump` (
  `dest` int(11) unsigned NOT NULL,
  `origin` int(10) unsigned NOT NULL,
  KEY `fk_jumporigin` (`origin`),
  KEY `fk_jumdest` (`dest`),
  CONSTRAINT `fk_jumdest` FOREIGN KEY (`dest`) REFERENCES `tbl_syst` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_jumporigin` FOREIGN KEY (`origin`) REFERENCES `tbl_syst` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create syntax for TABLE 'tbl_pilot'
CREATE TABLE `tbl_pilot` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL DEFAULT '',
  `govt` int(11) unsigned DEFAULT NULL,
  `balance` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_pilotgovt` (`govt`),
  CONSTRAINT `fk_pilotgovt` FOREIGN KEY (`govt`) REFERENCES `tbl_govt` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create syntax for TABLE 'tbl_relations'
CREATE TABLE `tbl_relations` (
  `subject` int(11) unsigned NOT NULL,
  `target` int(11) unsigned NOT NULL,
  `reciprical` tinyint(1) NOT NULL DEFAULT '0',
  `status` enum('N','A','W') NOT NULL DEFAULT 'N',
  KEY `fk_relationstarget` (`target`),
  KEY `fk_relationssubject` (`subject`),
  CONSTRAINT `fk_relationssubject` FOREIGN KEY (`subject`) REFERENCES `tbl_govt` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_relationstarget` FOREIGN KEY (`target`) REFERENCES `tbl_govt` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create syntax for TABLE 'tbl_spob'
CREATE TABLE `tbl_spob` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL DEFAULT '',
  `parent` int(10) unsigned NOT NULL,
  `techlevel` int(11) DEFAULT NULL,
  `can_be_homeworld` tinyint(1) NOT NULL DEFAULT '0',
  `type` enum('P','M','S','N') NOT NULL DEFAULT 'P',
  PRIMARY KEY (`id`),
  KEY `fk_spobparent` (`parent`),
  CONSTRAINT `fk_spobparent` FOREIGN KEY (`parent`) REFERENCES `tbl_syst` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4;

-- Create syntax for TABLE 'tbl_syst'
CREATE TABLE `tbl_syst` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL DEFAULT '',
  `govt` int(11) unsigned DEFAULT NULL COMMENT 'NULL = uninhabited',
  `x` int(11) NOT NULL,
  `y` int(11) unsigned NOT NULL,
  `connections` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_systgovt` (`govt`),
  CONSTRAINT `fk_systgovt` FOREIGN KEY (`govt`) REFERENCES `tbl_govt` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4;