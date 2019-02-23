CREATE TABLE `xmsocial_social` (
  `social_id`               smallint(3) unsigned    NOT NULL AUTO_INCREMENT,
  `social_name`             varchar(50)             NOT NULL DEFAULT '',
  `social_type`             varchar(50)             NOT NULL DEFAULT '',
  `social_options`          varchar(255)            NOT NULL DEFAULT '',
  `social_weight`           smallint(3) unsigned    NOT NULL DEFAULT '0',
  `social_status`           tinyint(1)  unsigned    NOT NULL DEFAULT '1',
  
  PRIMARY KEY (`social_id`)
) ENGINE=MyISAM;