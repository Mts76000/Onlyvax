-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/

-- Hôte : 127.0.0.1
-- Généré le : sam. 11 nov. 2023 à 18:34
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `db_vaccin`
--

-- --------------------------------------------------------

--
-- Structure de la table `carnet`
--

CREATE TABLE `carnet` (
  `id` int(11) NOT NULL,
  `nom` varchar(120) DEFAULT NULL,
  `prenom` varchar(120) DEFAULT NULL,
  `date_de_nais` date DEFAULT NULL,
  `sexe` varchar(20) DEFAULT NULL,
  `etat_vaccin` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `carnet_vaccin` (
  `id` int(11) NOT NULL,
  `id_carnet` int(11) DEFAULT NULL,
  `id_vaccin` int(11) DEFAULT NULL,
  `vaccin_at` datetime DEFAULT NULL,
  `num_lot` int(11) DEFAULT NULL,
  `rappel` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nom` varchar(120) DEFAULT NULL,
  `prenom` varchar(120) DEFAULT NULL,
  `mail` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(25) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`id`, `nom`, `prenom`, `mail`, `password`, `role`, `token`, `created_at`)
VALUES (1, 'admin', 'admin', 'admin', '$2y$10$Rl52MxWySR/8VmX0Ct1exOK3qnUI1ovoPsd9C8n3SvQgroVvXuuPS', 'admin', '$2y$10$Rl52MxWySR/8VmX0Ct1exOK3qnUI1ovoPsd9C8n3SvQgroVvXuuPS', NOW());

CREATE TABLE `vaccin` (
  `id` int(11) NOT NULL,
  `nom` varchar(120) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `nb_utilisation` int(11) DEFAULT NULL,
  `rappel_vaccin` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `vaccin` (`id`, `nom`, `created_at`, `nb_utilisation`, `rappel_vaccin`, `description`) VALUES
(1, 'Act-Hib®', '2023-11-11 00:00:00', NULL, 30, 'Méningites à Haemophilus influenzae de type b'),
(2, 'Avaxim 160®', '2023-11-11 00:00:00', NULL, 60, 'Hépatite A'),
(3, 'Avaxim 80®', '2023-11-11 00:00:00', NULL, 60, 'Hépatite A'),
(4, 'Bexsero ®', '2023-11-11 00:00:00', NULL, 90, 'Méningites et septicémies à méningocoques'),
(5, 'Boostrixtetra®', '2023-11-11 00:00:00', NULL, 365, 'Diphtérie, Tétanos, Poliomyélite, Coqueluche'),
(6, 'Cervarix®', '2023-11-11 00:00:00', NULL, 365, 'Infections à Papillomavirus humains (HPV)'),
(7, 'Comirnaty Omicron XBB 1.5®', '2023-11-11 00:00:00', NULL, 30, 'Covid-19'),
(8, 'Comirnaty Omicron XBB 1.5 (pédiatrique)®', '2023-11-11 00:00:00', NULL, 30, 'Covid-19'),
(9, 'Comirnaty Omicron XBB 1.5 (pédiatrique)®', '2023-11-11 00:00:00', NULL, 30, 'Covid-19'),
(10, 'Dengvaxia®', '2023-11-11 00:00:00', NULL, 180, 'Dengue'),
(11, 'Efluelda®', '2023-11-11 00:00:00', NULL, 365, 'Grippe'),
(12, 'Encepur 0,5 ml®', '2023-11-11 00:00:00', NULL, 60, 'Encéphalite à tiques'),
(13, 'Engerix B 10®', '2023-11-11 00:00:00', NULL, 365, 'Hépatite B'),
(14, 'Engerix B 20®', '2023-11-11 00:00:00', NULL, 365, 'Hépatite B'),
(15, 'Fluarix Tetra ®', '2023-11-11 00:00:00', NULL, 365, 'Grippe'),
(16, 'Gardasil 9®', '2023-11-11 00:00:00', NULL, 365, 'Infections à Papillomavirus humains (HPV)'),
(17, 'HBVAXPRO 10®', '2023-11-11 00:00:00', NULL, 365, 'Hépatite B'),
(18, 'HBVAXPRO 5®', '2023-11-11 00:00:00', NULL, 365, 'Hépatite B'),
(19, 'Havrix 1440®', '2023-11-11 00:00:00', NULL, 60, 'Hépatite A'),
(20, 'Havrix 720®', '2023-11-11 00:00:00', NULL, 60, 'Hépatite A'),
(21, 'Hexyon®', '2023-11-11 00:00:00', NULL, 365, 'Diphtérie, Tétanos, Poliomyélite, Coqueluche, Méningites à Haemophilus influenzae de type b, Hépatite B'),
(22, 'Imovax Polio®', '2023-11-11 00:00:00', NULL, 365, 'Poliomyélite'),
(23, 'Imvanex®', '2023-11-11 00:00:00', NULL, 365, 'Mpox (Variole du singe)'),
(24, 'Infanrix Hexa®', '2023-11-11 00:00:00', NULL, 365, 'Diphtérie, Tétanos, Poliomyélite, Coqueluche, Méningites à Haemophilus influenzae de type b, Hépatite B'),
(25, 'Infanrix Quinta®', '2023-11-11 00:00:00', NULL, 365, 'Diphtérie, Tétanos, Poliomyélite, Coqueluche, Méningites à Haemophilus influenzae de type b'),
(26, 'Infanrix Tetra®', '2023-11-11 00:00:00', NULL, 365, 'Diphtérie, Tétanos, Poliomyélite, Coqueluche'),
(27, 'Influvac Tetra®', '2023-11-11 00:00:00', NULL, 365, 'Grippe'),
(28, 'Ixiaro®', '2023-11-11 00:00:00', NULL, 60, 'Encéphalite japonaise'),
(29, 'Jynneos®', '2023-11-11 00:00:00', NULL, 365, 'Mpox (Variole du singe)'),
(30, 'M-M-RVaxpro®', '2023-11-11 00:00:00', NULL, 365, 'Rougeole, Oreillons, Rubéole'),
(31, 'Menjugate 10®', '2023-11-11 00:00:00', NULL, 365, 'Méningites et septicémies à méningocoques'),
(32, 'Menquadfi®', '2023-11-11 00:00:00', NULL, 365, 'Méningites et septicémies à méningocoques'),
(33, 'Menveo®', '2023-11-11 00:00:00', NULL, 365, 'Méningites et septicémies à méningocoques'),
(34, 'Neisvac®', '2023-11-11 00:00:00', NULL, 365, 'Méningites et septicémies à méningocoques'),
(35, 'Nimenrix®', '2023-11-11 00:00:00', NULL, 365, 'Méningites et septicémies à méningocoques'),
(36, 'Nuvaxovid®', '2023-11-11 00:00:00', NULL, 30, 'Covid-19'),
(37, 'Pentavac®', '2023-11-11 00:00:00', NULL, 365, 'Diphtérie, Tétanos, Poliomyélite, Coqueluche, Méningites à Haemophilus influenzae de type b'),
(38, 'Pneumovax®', '2023-11-11 00:00:00', NULL, 365, 'Méningites, pneumonies et septicémies à pneumocoque'),
(39, 'Prevenar 13®', '2023-11-11 00:00:00', NULL, 365, 'Méningites, pneumonies et septicémies à pneumocoque'),
(40, 'Priorix®', '2023-11-11 00:00:00', NULL, 365, 'Rougeole, Oreillons, Rubéole'),
(41, 'Rabipur®', '2023-11-11 00:00:00', NULL, 365, 'Rage'),
(42, 'Repevax®', '2023-11-11 00:00:00', NULL, 365, 'Diphtérie, Tétanos, Poliomyélite, Coqueluche'),
(43, 'Revaxis®', '2023-11-11 00:00:00', NULL, 365, 'Diphtérie, Tétanos, Poliomyélite'),
(44, 'Rotarix®', '2023-11-11 00:00:00', NULL, 365, 'Gastro-entérite à rotavirus'),
(45, 'Rotateq®', '2023-11-11 00:00:00', NULL, 365, 'Gastro-entérite à rotavirus'),
(46, 'Spirolept®', '2023-11-11 00:00:00', NULL, 365, 'Leptospirose'),
(47, 'Stamaril®', '2023-11-11 00:00:00', NULL, 365, 'Fièvre jaune'),
(48, 'Tetravac-acellulaire®', '2023-11-11 00:00:00', NULL, 365, 'Diphtérie, Tétanos, Poliomyélite, Coqueluche'),
(49, 'Ticovac 0,25ml®', '2023-11-11 00:00:00', NULL, 60, 'Encéphalite à tiques'),
(50, 'Ticovac 0,5ml®', '2023-11-11 00:00:00', NULL, 60, 'Encéphalite à tiques'),
(51, 'Trumenba®', '2023-11-11 00:00:00', NULL, 365, 'Méningites et septicémies à méningocoques'),
(52, 'Twinrix Adulte®', '2023-11-11 00:00:00', NULL, 365, 'Hépatite A, Hépatite B'),
(53, 'Tyavax ®', '2023-11-11 00:00:00', NULL, 365, 'Fièvre typhoïde, Hépatite A'),
(54, 'Typhim Vi®', '2023-11-11 00:00:00', NULL, 365, 'Fièvre typhoïde'),
(55, 'Vaccin rabique Pasteur®', '2023-11-11 00:00:00', NULL, 365, 'Rage'),
(56, 'Vaqta 50®', '2023-11-11 00:00:00', NULL, 365, 'Hépatite A'),
(57, 'Varilrix®', '2023-11-11 00:00:00', NULL, 365, 'Varicelle'),
(58, 'Varivax®', '2023-11-11 00:00:00', NULL, 365, 'Varicelle'),
(59, 'Vaxelis®', '2023-11-11 00:00:00', NULL, 365, 'Diphtérie, Tétanos, Poliomyélite, Coqueluche, Méningites à Haemophilus influenzae de type b, Hépatite B'),
(60, 'Vaxigrip Tetra®', '2023-11-11 00:00:00', NULL, 365, 'Grippe'),
(61, 'VidPrevtyn Beta®', '2023-11-11 00:00:00', NULL, 30, 'Covid-19'),
(62, 'Vivotif®', '2023-11-11 00:00:00', NULL, 365, 'Fièvre typhoïde'),
(63, 'Zostavax®', '2023-11-11 00:00:00', NULL, 365, 'Zona');


ALTER TABLE `carnet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);


ALTER TABLE `carnet_vaccin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_carnet` (`id_carnet`),
  ADD KEY `id_vaccin` (`id_vaccin`);


ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `vaccin`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `carnet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;


ALTER TABLE `carnet_vaccin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


ALTER TABLE `vaccin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;


ALTER TABLE `carnet`
  ADD CONSTRAINT `carnet_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);


ALTER TABLE `carnet_vaccin`
  ADD CONSTRAINT `carnet_vaccin_ibfk_1` FOREIGN KEY (`id_carnet`) REFERENCES `carnet` (`id`),
  ADD CONSTRAINT `carnet_vaccin_ibfk_2` FOREIGN KEY (`id_vaccin`) REFERENCES `vaccin` (`id`);
COMMIT;

