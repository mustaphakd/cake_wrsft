CREATE TABLE `woroarchweb`.`articles` ( `id` BINARY(36) NOT NULL , `title` VARCHAR(50) NOT NULL , `content` LONGTEXT NOT NULL , `created` DATETIME NOT NULL , `modified` DATETIME NOT NULL , `enabled` BOOLEAN NOT NULL DEFAULT FALSE , `user_id` VARBINARY(36) NOT NULL , PRIMARY KEY (`id`(36)));


ALTER TABLE woroarchweb.articles ADD image_path VARCHAR(250) NULL;