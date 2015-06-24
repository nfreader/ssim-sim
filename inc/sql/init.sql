-- Create syntax for TABLE 'ssim_commod'
CREATE TABLE `ssim_commod` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) DEFAULT NULL,
  `techlevel` int(3) NOT NULL,
  `basecost` int(4) unsigned NOT NULL,
  `basesupply` int(5) unsigned NOT NULL,
  `type` enum('C','S','M') NOT NULL DEFAULT 'M',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4;

-- Create syntax for TABLE 'ssim_commodspob'
CREATE TABLE `ssim_commodspob` (
  `commod` int(11) unsigned NOT NULL,
  `spob` int(11) unsigned NOT NULL,
  `supply` int(4) unsigned NOT NULL DEFAULT '0',
  `lastchange` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `commod` (`commod`,`spob`),
  KEY `fk_commodspobspob` (`spob`),
  CONSTRAINT `fk_commodspobcommod` FOREIGN KEY (`commod`) REFERENCES `ssim_commod` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_commodspobspob` FOREIGN KEY (`spob`) REFERENCES `ssim_spob` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create syntax for TABLE 'ssim_govt'
CREATE TABLE `ssim_govt` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL,
  `color` varchar(6) DEFAULT NULL,
  `color2` varchar(6) DEFAULT NULL,
  `isoname` varchar(2) NOT NULL DEFAULT '',
  `govtseat` int(11) unsigned DEFAULT NULL,
  `type` enum('I','R','P') NOT NULL DEFAULT 'R' COMMENT 'Independent, Regular, Pirate',
  PRIMARY KEY (`id`),
  UNIQUE KEY `isoname` (`isoname`),
  UNIQUE KEY `color` (`color`,`color2`),
  KEY `fk_govtseat` (`govtseat`),
  CONSTRAINT `fk_govtseat` FOREIGN KEY (`govtseat`) REFERENCES `ssim_spob` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4;

-- Create syntax for TABLE 'ssim_jump'
CREATE TABLE `ssim_jump` (
  `dest` int(11) unsigned NOT NULL,
  `origin` int(10) unsigned NOT NULL,
  KEY `fk_jumporigin` (`origin`),
  KEY `fk_jumdest` (`dest`),
  CONSTRAINT `fk_jumdest` FOREIGN KEY (`dest`) REFERENCES `ssim_syst` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_jumporigin` FOREIGN KEY (`origin`) REFERENCES `ssim_syst` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create syntax for TABLE 'ssim_pilot'
CREATE TABLE `ssim_pilot` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL DEFAULT '',
  `govt` int(11) unsigned DEFAULT NULL,
  `balance` int(11) NOT NULL DEFAULT '0',
  `vessel` int(11) unsigned DEFAULT NULL,
  `status` enum('B','O','L') NOT NULL DEFAULT 'O',
  PRIMARY KEY (`id`),
  UNIQUE KEY `vessel` (`vessel`),
  KEY `fk_pilotgovt` (`govt`),
  CONSTRAINT `fk_pilotgovt` FOREIGN KEY (`govt`) REFERENCES `ssim_govt` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_pilotvessel` FOREIGN KEY (`vessel`) REFERENCES `ssim_vessel` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4;

-- Create syntax for TABLE 'ssim_relations'
CREATE TABLE `ssim_relations` (
  `subject` int(11) unsigned NOT NULL,
  `target` int(11) unsigned NOT NULL,
  `reciprical` tinyint(1) NOT NULL DEFAULT '0',
  `status` enum('N','A','W') NOT NULL DEFAULT 'N',
  KEY `fk_relationstarget` (`target`),
  KEY `fk_relationssubject` (`subject`),
  CONSTRAINT `fk_relationssubject` FOREIGN KEY (`subject`) REFERENCES `ssim_govt` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_relationstarget` FOREIGN KEY (`target`) REFERENCES `ssim_govt` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create syntax for TABLE 'ssim_ship'
CREATE TABLE `ssim_ship` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL,
  `cost` int(11) unsigned DEFAULT NULL,
  `shipwright` varchar(64) DEFAULT NULL,
  `class` enum('S','F') DEFAULT NULL,
  `fueltank` int(5) unsigned NOT NULL DEFAULT '1',
  `cargobay` int(5) unsigned NOT NULL DEFAULT '1',
  `armor` int(5) DEFAULT NULL,
  `shields` int(5) DEFAULT NULL,
  `starter` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4;

-- Create syntax for TABLE 'ssim_spob'
CREATE TABLE `ssim_spob` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL DEFAULT '',
  `parent` int(10) unsigned NOT NULL,
  `techlevel` int(11) DEFAULT NULL,
  `can_be_homeworld` tinyint(1) NOT NULL DEFAULT '0',
  `type` enum('P','M','S','N') NOT NULL DEFAULT 'P',
  PRIMARY KEY (`id`),
  KEY `fk_spobparent` (`parent`),
  CONSTRAINT `fk_spobparent` FOREIGN KEY (`parent`) REFERENCES `ssim_syst` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4;

-- Create syntax for TABLE 'ssim_syst'
CREATE TABLE `ssim_syst` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL DEFAULT '',
  `govt` int(11) unsigned DEFAULT NULL COMMENT 'NULL = uninhabited',
  `x` int(11) NOT NULL,
  `y` int(11) unsigned NOT NULL,
  `connections` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_systgovt` (`govt`),
  CONSTRAINT `fk_systgovt` FOREIGN KEY (`govt`) REFERENCES `ssim_govt` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4;

-- Create syntax for TABLE 'ssim_vessel'
CREATE TABLE `ssim_vessel` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL DEFAULT '',
  `registration` varchar(9) NOT NULL DEFAULT '',
  `ship` int(11) unsigned NOT NULL,
  `integrity` int(11) unsigned NOT NULL DEFAULT '100',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4;