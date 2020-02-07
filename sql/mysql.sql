CREATE TABLE `xmsocial_social` (
  `social_id`               smallint(3) unsigned    NOT NULL AUTO_INCREMENT,
  `social_name`             varchar(50)             NOT NULL DEFAULT '',
  `social_type`             varchar(50)             NOT NULL DEFAULT '',
  `social_options`          varchar(255)            NOT NULL DEFAULT '',
  `social_weight`           smallint(3) unsigned    NOT NULL DEFAULT '0',
  `social_status`           tinyint(1)  unsigned    NOT NULL DEFAULT '1',
  
  PRIMARY KEY (`social_id`)
) ENGINE=MyISAM;

CREATE TABLE `xmsocial_rating` (
  `rating_id`               mediumint(8) unsigned   NOT NULL auto_increment,
  `rating_itemid`         	smallint(5)  unsigned   NOT NULL DEFAULT '0',
  `rating_modid`         	smallint(5)  unsigned   NOT NULL DEFAULT '0',
  `rating_value`            smallint(1)  unsigned   NOT NULL DEFAULT '0',
  `rating_uid`          	smallint(5)  unsigned   NOT NULL default '0',
  `rating_hostname`     	varchar(50)             NOT NULL DEFAULT '',
  `rating_date`           	int(10)      unsigned   NOT NULL DEFAULT '0',
  
  PRIMARY KEY (`rating_id`)
) ENGINE=MyISAM;