create table if not exists `News`
(
	`id` int(10) not null auto_increment,
	`active` tinyint(1) default 1,
	`date` datetime default null,
	`title` varchar(100) default null,
	`text` text,
	`url` varchar(200) default null,
	primary key (`id`),
	key `date` (`active`,`date`)
) engine InnoDB;
