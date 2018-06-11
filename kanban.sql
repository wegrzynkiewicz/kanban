-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE `tasks` (
  `task_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `creation_date` datetime NOT NULL,
  `type` int(11) NOT NULL,
  PRIMARY KEY (`task_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tasks` (`task_id`, `title`, `details`, `creation_date`, `type`) VALUES
(1,	'Postawić projekt na symfony',	'Trzeba pobrać paczki, composera, odświeżyć wiedzę na temat doctrina',	'2018-06-11 21:50:18',	1),
(2,	'Przeanalizować co trzeba było zrobić',	'Niezwykle trudne zadanie, gdyż nawet nie wiemy co mamy zrobić...',	'2018-06-11 21:55:56',	1),
(3,	'Pomysł to tablica kanbanowa',	'Zwykły crud, wiadomka, nic nieskomplikowanego',	'2018-06-11 21:56:45',	2),
(4,	'Piąteczka z zaliczenia',	'No ja myślę, że wykładowca, to rzuci jakąś czwóreczką chociaż',	'2018-06-11 21:57:23',	4),
(5,	'Trzeba jeszcze trochę info dodać, bo pusto',	'Wkleił bym lorem ipsum, ale zanim ja to znajdę to popiszę pierdół trochę',	'2018-06-11 21:58:01',	3),
(6,	'Ostatnie zadanie',	'Musi być asymetrycznie, fajnie to ma wyglądać',	'2018-06-11 21:58:28',	3),
(7,	'No i jeszcze filtrowanie',	'Dorobiłem filtrowanie, trzeba sprawdzić czy działa',	'2018-06-11 21:59:26',	1);

-- 2018-06-11 20:00:04
