INSERT INTO `character` (`id_character_race`, `id_character_elem`, `name`, `picture`) VALUES
(1, 1, 'Nain', NULL),
(2, 1, 'Ranger', NULL),
(2, 1, 'Voleur', NULL),
(2, 1, 'Barbare', NULL),
(3, 1, 'Elfe', NULL),
(4, 1, 'Ogre', NULL),
(5, 1, 'Orque', NULL),
(6, 1, 'Gobelin', NULL),
(7, 1, 'Troll', NULL),
(8, 1, 'Mort-vivant', NULL),
(9, 1, 'Squelette', NULL),
(2, 1, 'Sorcier', NULL);

INSERT INTO `element` (`id_element`, `name`, `description`) VALUES
(1, 'Feu', 'Le feu ça brûle'),
(2, 'Eau', 'L\'eau ça mouille'),
(3, 'Air', 'L\'air ça vente'),
(4, 'Terre', 'La terre s\'atterre');

INSERT INTO `hero` (`id_character`, `firstname`) VALUES
(1, 'Nano Le'),
(2, 'Roger Le'),
(3, 'Val Le '),
(4, 'Borbert Le '),
(5, 'Elfora L\''),
(6, 'Augro L\'');

INSERT INTO `isstrongerelem` (`id_isStronger`, `id_elem_stronger`, `id_elem_weaker`) VALUES
(1, 2, 1),
(2, 1, 4),
(3, 4, 3),
(4, 3, 2);

INSERT INTO `monster` (`id_character`) VALUES
(7),
(8),
(9),
(10),
(11),
(12);


INSERT INTO `race` (`id_race`, `name`, `description`, `attack`, `defense`, `agility`, `hp`) VALUES
(1, 'Nain', 'Les nains sont des créatures robustes de petite taille, qui se distinguent par leurs talents de forgerons, de mineurs et de bâtisseurs. Ils adorent la bière et détestent les elfes', 20, 25, 5, 70),
(2, 'Humain', 'Race qui a inventé la bière et la raclette. Peut aussi réussir les captcha', 15, 15, 20, 50),
(3, 'Elfe', 'Les elfes sont une race ancienne, et sont en communion avec la nature. Ils aiment se balader en forêt, insulter des nains et faire des tresses aux poneys. Ah, et ils mangent de la salade aussi', 15, 10, 25, 40),
(4, 'Ogre', 'Les ogres sont des créatures massives connues pour leur appétit insasiable et leur intelligence limité. Malgré cela ils sont d\'une loyauté indefectible envers ceux qui arrivent à parler leur étrange language (du moins tant qu\'il y a assez à manger)', 20, 10, 5, 100),
(5, 'Orque', 'Les orques sont des créatures redoutables pour des aventuriers mal prépaprés. Ils servent d\'armée de base aux seigneurs maléfiques et sorciers pour leurs donjons, du fait de leur robustesse et violence au combat (mais ils sont un peu débiles quand même)', 15, 15, 10, 60),
(6, 'Gobelin', 'Les gobelins sont une race petite et espiègle, qui peuvent parraître inoffensifs à première vue, mais faites attention à ne jamais sous-estimer une bande de gobelins enragés!', 15, 5, 30, 30),
(7, 'Troll', 'Les trolls ressemblent beaucoup aux ogres de part leur silhouette imposante, mais contrairement à leurs cousins pacifistes, ils ne vivent que pour la guerre', 25, 5, 5, 100),
(8, 'Mort-vivant', 'Les Mort-vivants sont des cadavres ramenés à la vie par des sorciers nécromanciens. Ils ont la vitesse et l\'intelligence d\'un escargot alcoolisé mais il ne faut pas sous-estimer le danger qu\'ils représentent quand ils sont nombreux', 15, 20, 5, 70),
(9, 'Squelette', 'Plus intelligents et plus que les morts-vivants, les squelettes sont nimbés de mystères: comment se nourissent-ils? Comment font-ils en cas de fracture? Prennent-ils des bains de lait pour fortifier leurs os?', 20, 5, 20, 40);

-- REQUETE COMPTE ADMIN --
-- ID: root
-- MDP: root

INSERT INTO `user` (`id_user`, `username`, `password`) VALUES (NULL, 'root', '$2y$12$4HA9hcr.5goGibfINlVUQuVSYeduIlBfSymEmJ1vuxzd70ycnz7cK');
