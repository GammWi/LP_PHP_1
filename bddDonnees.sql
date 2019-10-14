INSERT INTO `character` (`id_character`, `id_character_race`, `id_character_elem`, `name`, `picture`) VALUES
(3, 1, 1, 'Nain', NULL),
(4, 2, 1, 'Ranger', NULL),
(5, 2, 1, 'Voleur', NULL),
(6, 2, 1, 'Barbare', NULL),
(7, 3, 1, 'Elfe', NULL),
(8, 4, 1, 'Ogre', NULL),
(9, 5, 1, 'Orque', NULL),
(10, 6, 1, 'Gobelin', NULL),
(11, 7, 1, 'Troll', NULL),
(12, 8, 1, 'Mort-vivant', NULL),
(13, 9, 1, 'Squelette', NULL),
(14, 2, 1, 'Sorcier', NULL);


INSERT INTO `hero` (`id_hero`, `id_character`, `firstname`) VALUES
(1, 3, 'Nano Le'),
(2, 4, 'Roger Le'),
(3, 5, 'Val Le '),
(4, 6, 'Borbert Le '),
(5, 7, 'Elfora L\''),
(6, 8, 'Augro L\'');

INSERT INTO `monster` (`id_monster`, `id_character`) VALUES
(1, 9),
(2, 10),
(3, 11),
(4, 12),
(5, 13),
(6, 14);

INSERT INTO `race` (`id_race`, `name`, `description`, `boostAttack`, `boostDefense`, `boostAgility`, `boostHp`) VALUES
(1, 'Nain', NULL, NULL, NULL, NULL, NULL),
(2, 'Humain', NULL, NULL, NULL, NULL, NULL),
(3, 'Elfe', NULL, NULL, NULL, NULL, NULL),
(4, 'Ogre', NULL, NULL, NULL, NULL, NULL),
(5, 'Orque', NULL, NULL, NULL, NULL, NULL),
(6, 'Gobelin', NULL, NULL, NULL, NULL, NULL),
(7, 'Troll', NULL, NULL, NULL, NULL, NULL),
(8, 'Mort-vivant', NULL, NULL, NULL, NULL, NULL),
(9, 'Squelette', NULL, NULL, NULL, NULL, NULL);

-- REQUETE COMPTE ADMIN --
-- ID: root
-- MDP: root

INSERT INTO `user` (`id_user`, `username`, `password`) VALUES (NULL, 'root', '$2y$12$4HA9hcr.5goGibfINlVUQuVSYeduIlBfSymEmJ1vuxzd70ycnz7cK');