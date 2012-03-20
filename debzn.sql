-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 20, 2012 at 11:30 AM
-- Server version: 5.6.4
-- PHP Version: 5.3.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `debzn`
--

-- --------------------------------------------------------

--
-- Table structure for table `allmusic_album`
--

CREATE TABLE IF NOT EXISTS `allmusic_album` (
  `albumID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `amgalbumID` varchar(255) NOT NULL DEFAULT '',
  `artist` varchar(255) NOT NULL DEFAULT '',
  `amgartistID` varchar(255) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `year` mediumint(9) NOT NULL DEFAULT '0',
  `genre` text NOT NULL,
  `url` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`albumID`),
  KEY `amgalbumID` (`amgalbumID`),
  KEY `amgartistID` (`amgartistID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1074 ;

-- --------------------------------------------------------

--
-- Table structure for table `allmusic_albumsearch`
--

CREATE TABLE IF NOT EXISTS `allmusic_albumsearch` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `amgartistID` varchar(255) NOT NULL DEFAULT '',
  `search` varchar(255) NOT NULL DEFAULT '',
  `amgalbumID` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`),
  KEY `search` (`search`),
  KEY `amgartistID` (`amgartistID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=79 ;

-- --------------------------------------------------------

--
-- Table structure for table `allmusic_artistsearch`
--

CREATE TABLE IF NOT EXISTS `allmusic_artistsearch` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `search` varchar(255) NOT NULL DEFAULT '',
  `amgartistID` varchar(255) NOT NULL DEFAULT '',
  `famgartistID` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`),
  KEY `search` (`search`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=954 ;

-- --------------------------------------------------------

--
-- Table structure for table `anidb_anime`
--

CREATE TABLE IF NOT EXISTS `anidb_anime` (
  `animeID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `anidbID` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fname` varchar(255) NOT NULL DEFAULT '',
  `type` varchar(255) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`animeID`),
  KEY `anidbID` (`anidbID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6564 ;

-- --------------------------------------------------------

--
-- Table structure for table `anidb_search`
--

CREATE TABLE IF NOT EXISTS `anidb_search` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `search` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `anidbID` varchar(255) NOT NULL DEFAULT '',
  `fanidbID` varchar(255) NOT NULL DEFAULT '',
  `unixtime` int(12) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `search` (`search`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32246 ;

-- --------------------------------------------------------

--
-- Table structure for table `gamespot_game`
--

CREATE TABLE IF NOT EXISTS `gamespot_game` (
  `gsID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `gsUrl` varchar(255) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `year` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `genre` varchar(255) NOT NULL DEFAULT '',
  `platform` varchar(255) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`gsID`),
  KEY `gsUrl` (`gsUrl`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=232 ;

-- --------------------------------------------------------

--
-- Table structure for table `gamespot_search`
--

CREATE TABLE IF NOT EXISTS `gamespot_search` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `search` varchar(255) NOT NULL DEFAULT '',
  `gsUrl` varchar(255) NOT NULL DEFAULT '',
  `fgsUrl` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=461 ;

-- --------------------------------------------------------

--
-- Table structure for table `googlemusic_album`
--

CREATE TABLE IF NOT EXISTS `googlemusic_album` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `gmalbumID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `artist` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `year` mediumint(9) NOT NULL,
  `genre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `googlemusic_albumsearch`
--

CREATE TABLE IF NOT EXISTS `googlemusic_albumsearch` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `search` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gmalbumID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fgmalbumID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `search` (`search`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Google music album search' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `imdb_film`
--

CREATE TABLE IF NOT EXISTS `imdb_film` (
  `filmID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `imdbID` varchar(255) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `aka` varchar(255) NOT NULL DEFAULT '',
  `year` mediumint(9) NOT NULL DEFAULT '0',
  `genre` varchar(255) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`filmID`),
  KEY `imdbID` (`imdbID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13323 ;

-- --------------------------------------------------------

--
-- Table structure for table `imdb_search`
--

CREATE TABLE IF NOT EXISTS `imdb_search` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `search` varchar(255) NOT NULL DEFAULT '',
  `imdbID` varchar(255) NOT NULL DEFAULT '',
  `fimdbID` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21529 ;

-- --------------------------------------------------------

--
-- Table structure for table `query_fail`
--

CREATE TABLE IF NOT EXISTS `query_fail` (
  `queryID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `query` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `IP` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `error` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date` int(10) unsigned NOT NULL,
  `status` enum('IGNORE','OPEN','FIXED') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'OPEN',
  PRIMARY KEY (`queryID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3933 ;

-- --------------------------------------------------------

--
-- Table structure for table `tvrage_episode`
--

CREATE TABLE IF NOT EXISTS `tvrage_episode` (
  `episodeID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tvrageEpisodeID` int(10) unsigned NOT NULL DEFAULT '0',
  `tvrageShowID` int(11) NOT NULL,
  `series` varchar(4) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `episode` int(4) NOT NULL DEFAULT '0',
  `date` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `type` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`episodeID`),
  KEY `tvrageEpisodeID` (`tvrageEpisodeID`),
  KEY `tvrageShowID` (`tvrageShowID`,`series`,`episode`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1074553 ;

-- --------------------------------------------------------

--
-- Table structure for table `tvrage_search`
--

CREATE TABLE IF NOT EXISTS `tvrage_search` (
  `searchID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `search` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tvrageShowID` int(11) NOT NULL,
  `ftvrageShowID` int(11) NOT NULL,
  PRIMARY KEY (`searchID`),
  KEY `search` (`search`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=39865 ;

-- --------------------------------------------------------

--
-- Table structure for table `tvrage_show`
--

CREATE TABLE IF NOT EXISTS `tvrage_show` (
  `showID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tvrageShowID` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `nzbName` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `genre` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `class` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nzbGenre` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `usenetToTvrage` text COLLATE utf8_unicode_ci NOT NULL,
  `tvrageToNewzbin` text COLLATE utf8_unicode_ci NOT NULL,
  `overrideLink` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`showID`),
  KEY `tvrageTextID` (`tvrageShowID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=32089 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
