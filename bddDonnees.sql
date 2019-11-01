INSERT INTO `character` (`id_character_race`, `id_character_elem`, `name`, `picture`) VALUES
(1, 1, 'Nain', 1),
(1, 4, 'Nanino', 13),
(2, 3, 'Ranger', 2),
(2, 1, 'Barbare', 3),
(2, 1, 'Paladin', 14),
(2, 4, 'Guerrier', 15),
(3, 2, 'Elfe', 4),
(3, 3, 'Guerriere', 16),
(4, 1, 'Ogre', 5),
(4, 2, 'Ogrito', 17),
(5, 4, 'Orque', 6),
(5, 2, 'Orque marin', 19),
(6, 1, 'Gobelin', 7),
(6, 2, 'Armored Gobelin', 22),
(7, 2, 'Troll', 8),
(8, 1, 'Mort-vivant', 9),
(8, 4, 'Zombie', 21),
(9, 1, 'Squelette', 10),
(9, 3, 'Armored skeleton', 20),
(2, 1, 'Sorcier', 11),
(2, 4, 'Dark warrior', 18);

INSERT INTO `element` (`id_element`, `name`, `description`) VALUES
(1, 'Feu', 'Le feu ça brûle'),
(2, 'Eau', 'L\'eau ça mouille'),
(3, 'Air', 'L\'air ça vente'),
(4, 'Terre', 'La terre s\'atterre');

INSERT INTO `hero` (`id_character`, `firstname`) VALUES
(1, 'Nano'),
(2, 'El'),
(3, 'Roger'),
(4, 'Borbert'),
(5, 'Palau'),
(6, 'Guerric'),
(7, 'Elfora'),
(8, 'Audrey'),
(9, 'Augro'),
(10, 'Greg');

INSERT INTO `isstrongerelem` (`id_isStronger`, `id_elem_stronger`, `id_elem_weaker`) VALUES
(1, 2, 1),
(2, 1, 4),
(3, 4, 3),
(4, 3, 2);

INSERT INTO `monster` (`id_character`) VALUES
(11),
(12),
(13),
(14),
(15),
(16),
(17),
(18),
(19),
(20),
(21);


INSERT INTO `pictures` (`name`, `path`) values
("nain", "../../public/assets/img/characters/nain.png"),
("ranger", "../../public/assets/img/characters/ranger.jpg"),
("barbare", "../../public/assets/img/characters/barbare.jpg"),
("elfe","../../public/assets/img/characters/elfe.jpg"),
("ogre","../../public/assets/img/characters/ogre.jpg"),
("orque","../../public/assets/img/characters/orque.jpg"),
("gobelin","../../public/assets/img/characters/gobelin.jpg"),
("troll","../../public/assets/img/characters/troll.jpg"),
("mort","../../public/assets/img/characters/mort.jpg"),
("squelette","../../public/assets/img/characters/squelette.jpg"),
("sorcier", "../../public/assets/img/characters/sorcier.jpg"),
("humain", "../../public/assets/img/characters/humain.jpg"),
("Nanino", "../../public/assets/img/characters/Nanino.png"),
("Paladin", "../../public/assets/img/characters/Paladin.png"),
("Guerrier", "../../public/assets/img/characters/Guerrier.jpeg"),
("Guerrière", "../../public/assets/img/characters/Guerrière.jpeg"),
("Ogrito", "../../public/assets/img/characters/Ogrito.jpeg"),
("Dark warrior", "../../public/assets/img/characters/Dark warrior.jpeg"),
("Orque marin", "../../public/assets/img/characters/Orque marin.jpeg"),
("Armored Skeleton", "../../public/assets/img/characters/Armored Skeleton.jpeg"),
("Zombie", "../../public/assets/img/characters/Zombie.jpeg"),
("Armored Gobelin", "../../public/assets/img/characters/Armored Gobelin.png");


INSERT INTO `race` (`id_race`, `name`, `description`, `attack`, `defense`, `agility`, `hp`, `id_picture`) VALUES
(1, 'Nain', 'Les nains sont des créatures robustes de petite taille, qui se distinguent par leurs talents de forgerons, de mineurs et de bâtisseurs. Ils adorent la bière et détestent les elfes', 25, 25, 5, 70,1),
(2, 'Humain', 'Race qui a inventé la bière et la raclette. Peut aussi réussir les captcha', 15, 15, 20, 50,13),
(3, 'Elfe', 'Les elfes sont une race ancienne, et sont en communion avec la nature. Ils aiment se balader en forêt, insulter des nains et faire des tresses aux poneys. Ah, et ils mangent de la salade aussi', 15, 10, 25, 40,5),
(4, 'Ogre', 'Les ogres sont des créatures massives connues pour leur appétit insasiable et leur intelligence limité. Malgré cela ils sont d\'une loyauté indefectible envers ceux qui arrivent à parler leur étrange language (du moins tant qu\'il y a assez à manger)', 20, 10, 5, 100, 6),
(5, 'Orque', 'Les orques sont des créatures redoutables pour des aventuriers mal prépaprés. Ils servent d\'armée de base aux seigneurs maléfiques et sorciers pour leurs donjons, du fait de leur robustesse et violence au combat (mais ils sont un peu débiles quand même)', 15, 15, 10, 60, 7),
(6, 'Gobelin', 'Les gobelins sont une race petite et espiègle, qui peuvent parraître inoffensifs à première vue, mais faites attention à ne jamais sous-estimer une bande de gobelins enragés!', 15, 5, 50, 30, 8),
(7, 'Troll', 'Les trolls ressemblent beaucoup aux ogres de part leur silhouette imposante, mais contrairement à leurs cousins pacifistes, ils ne vivent que pour la guerre', 15, 5, 5, 100, 9),
(8, 'Mort-vivant', 'Les Mort-vivants sont des cadavres ramenés à la vie par des sorciers nécromanciens. Ils ont la vitesse et l\'intelligence d\'un escargot alcoolisé mais il ne faut pas sous-estimer le danger qu\'ils représentent quand ils sont nombreux', 25, 20, 10, 70, 10),
(9, 'Squelette', 'Plus intelligents et plus que les morts-vivants, les squelettes sont nimbés de mystères: comment se nourissent-ils? Comment font-ils en cas de fracture? Prennent-ils des bains de lait pour fortifier leurs os?', 20, 5, 15, 40, 11);


-- REQUETE COMPTE ADMIN --
-- ID: root
-- MDP: root

INSERT INTO `user` (`id_user`, `username`, `password`) VALUES (NULL, 'root', '$2y$12$4HA9hcr.5goGibfINlVUQuVSYeduIlBfSymEmJ1vuxzd70ycnz7cK');
