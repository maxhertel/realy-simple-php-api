-- `php-test`.accounts definition

CREATE TABLE `accounts` (
  `balance` decimal(10,0) DEFAULT NULL,
  `id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;