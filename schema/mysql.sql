create table if not exists `News`
(
	`id` int(10) not null auto_increment,
	`active` tinyint(1) default 1,
	`alias` varchar(100) default null,
	`date` datetime default null,
	`title` varchar(100) default null,
	`preview` text,
	`content` text,
	primary key (`id`),
	key `alias` (`alias`),
	key `date` (`active`,`date`)
) engine InnoDB;
