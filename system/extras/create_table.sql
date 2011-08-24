CREATE TABLE `store_locations` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `name` varchar(60) collate utf8_bin NOT NULL,
  `address1` varchar(100) collate utf8_bin NOT NULL default '',
  `address2` varchar(100) character set utf8 default NULL,
  `city` varchar(100) collate utf8_bin NOT NULL default '',
  `state` varchar(3) collate utf8_bin default NULL,
  `postal_code` varchar(10) collate utf8_bin default NULL,
  `country` enum('US','AF','AL','DZ','AS','AD','AO','AI','AQ','AG','AR','AM','AW','AU','AT','AZ','BS','BH','BD','BB','BY','BE','BZ','BJ','BM','BT','BO','BA','BW','BR','BN','BG','BF','BI','KH','CM','CA','CV','KY','CF','TD','CL','CN','CX','CC','CO','KM','CG','CK','CR','HR','CU','CY','CZ','DK','DJ','DM','DO','TP','EC','EG','SV','GQ','ER','EE','ET','FK','FO','FJ','FI','FR','GF','PF','GA','GM','GE','DE','GH','GI','GR','GL','GD','GP','GU','GT','GN','GW','GY','HT','HN','HK','HU','IS','IN','ID','IR','IQ','IE','IL','IT','CI','JM','JP','JO','KZ','KE','KI','KW','KG','LA','LV','LB','LS','LR','LY','LI','LT','LU','MO','MK','MG','MW','MY','MV','ML','MT','MH','MQ','MR','MU','YT','MX','FM','MD','MC','MN','MS','MA','MZ','MM','NA','NR','NP','NL','AN','NC','NZ','NI','NE','NG','NU','NF','KP','MP','NO','OM','PK','PW','PA','PG','PY','PE','PH','PL','PT','PR','QA','RE','RO','RU','RW','SH','KN','LC','PM','VC','SM','ST','SA','SN','SC','SL','SG','SK','SI','SB','SO','ZA','KR','ES','LK','SD','SR','SZ','SE','CH','SY','TW','TJ','TZ','TH','TG','TK','TO','TT','TN','TR','TM','TC','TV','UG','UA','AE','UK','UY','UZ','VU','VA','VE','VN','VG','VI','WF','WS','YE','YU','ZR','ZM','ZW') character set latin1 NOT NULL,
  `phone_number` varchar(20) collate utf8_bin default NULL,
  `lat` float(12,6) default NULL,
  `lng` float(12,6) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM CHARSET=utf8 COLLATE=utf8_bin;