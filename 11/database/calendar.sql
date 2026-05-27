CREATE TABLE `tasks` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(10) UNSIGNED NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `type_id` INT(10) NOT NULL,
  `location` VARCHAR(255) NULL,
  `date_time` DATETIME NOT NULL,
  `duration` VARCHAR(100) NULL,
  `comment` TEXT NULL,
  `status` VARCHAR(50) NOT NULL DEFAULT 'current',
  PRIMARY KEY (`id`)
);

CREATE TABLE `users` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(100) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
);
