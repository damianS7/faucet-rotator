-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 30-06-2015 a las 00:04:09
-- Versión del servidor: 5.5.43-0ubuntu0.14.04.1
-- Versión de PHP: 5.5.9-1ubuntu4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `bitcoing_gator`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rotator_config`
--

CREATE TABLE IF NOT EXISTS `rotator_config` (
  `name` varchar(60) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`name`),
  UNIQUE KEY `key` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `rotator_config`
--

INSERT INTO `rotator_config` (`name`, `value`) VALUES
('ads-left', '%3Cdiv%20class%3D%22banner%22%3E%0A%3Cimg%20src%3D%22public/img/300x600.png%22/%3E%0A%3C/div%3E'),
('ads-top', '%3Cdiv%20class%3D%22banner%22%3E%0A%3Cimg%20src%3D%22public/img/728x90.png%22/%3E%0A%3C/div%3E%0A%3Cdiv%20class%3D%22banner%22%3E%0A%3Cimg%20src%3D%22public/img/728x90.png%22/%3E%0A%3C/div%3E'),
('custom_css', '.button%2C%20.order-button%20%7B%0A%20%20background%3A%20%20%231C7077%3B%0A%20%20color%3A%23fff%3B%0A%7D%20/*%20Colores%20de%20los%20botones%20*/%0A%0A.button%3Ahover%2C%20.order-button%3Ahover%20%7B%0Abackground-color%3A%20%23124F54%3Bcolor%3A%20%2357E4F0%3B%0A%7D%20/*%20Colores%20de%20los%20botones%20al%20pasar%20el%20raton%20por%20encima%20*/%0A%0A.button%3Aactive%2C%20.order-button%3Aactive%20%7B%0Abackground-color%3A%20%23333%3B%0A%7D%20/*%20Colores%20del%20boton%20al%20pulsarlo%20*/%0A%0A.order-button-selected%7B%0Acolor%3A%20%2357E4F0%3B%20background-color%3A%20%23124F54%3B%0A%7D%20/*%20Colores%20del%20boton%20despues%20de%20ser%20pulsado%20%28solo%20para%20botones%20de%20ordenar%29%20*/%0A%0A.control-text%7Bcolor%3A%20%2357E4F0%7D%20/*%20Colores%20del%20texto%20del%20rotador%20*/%0Abody%20%7Bbackground-color%3A%20%231C7077%3B%7D%20/*%20Colores%20de%20toda%20la%20pagina%20*/%0Abody%20%3E%20header%20%7Bbackground-color%3A%20%23293033%3Bcolor%3A%20%23fff%3B%7D%20%20/*%20Colores%20del%20panel%20del%20rotador%20*/%0A%0A%0A'),
('passw', '$1$/PXNHx15$wqBnr68K355BeM09oyh7H/');

--
-- Estructura de tabla para la tabla `rotator_faucets`
--

CREATE TABLE IF NOT EXISTS `rotator_faucets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `faucet` varchar(64) NOT NULL,
  `url` varchar(100) NOT NULL,
  `min_reward` int(11) NOT NULL,
  `max_reward` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `votes` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `url` (`url`),
  UNIQUE KEY `faucet` (`faucet`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=77 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rotator_reports`
--

CREATE TABLE IF NOT EXISTS `rotator_reports` (
  `id_report` int(11) NOT NULL AUTO_INCREMENT,
  `id_faucet` int(11) NOT NULL,
  `ip` varchar(20) NOT NULL,
  `title` varchar(250) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`id_report`),
  KEY `id_faucet` (`id_faucet`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rotator_votes`
--

CREATE TABLE IF NOT EXISTS `rotator_votes` (
  `ip` varchar(20) NOT NULL,
  `id_faucet` int(11) NOT NULL,
  PRIMARY KEY (`ip`,`id_faucet`),
  KEY `id_faucet` (`id_faucet`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `rotator_reports`
--
ALTER TABLE `rotator_reports`
  ADD CONSTRAINT `rotator_reports_ibfk_1` FOREIGN KEY (`id_faucet`) REFERENCES `rotator_faucets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `rotator_votes`
--
ALTER TABLE `rotator_votes`
  ADD CONSTRAINT `rotator_votes_ibfk_1` FOREIGN KEY (`id_faucet`) REFERENCES `rotator_faucets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
