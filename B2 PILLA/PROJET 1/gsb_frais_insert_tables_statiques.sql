--
-- Contenu de la table `FraisForfait`
--

INSERT INTO `FraisForfait` (`id`, `libelle`, `montant`) VALUES
('ETP', 'Forfait Etape', 110.00),
('KM', 'Frais Kilométrique', 0.62),
('NUI', 'Nuitée Hôtel', 80.00),
('REP', 'Repas Restaurant', 25.00);


-- --------------------------------------------------------

--
-- Contenu de la table `LigneFraisForfait`
--


-- --------------------------------------------------------

--
-- Contenu de la table `Etat`
--

INSERT INTO `Etat` (`id`, `libelle`) VALUES
('RB', 'Remboursée'),
('CL', 'Saisie clôturée'),
('CR', 'Fiche créée, saisie en cours'),
('VA', 'Validée et mise en paiement');


-- --------------------------------------------------------

--
-- Fonction d'insertion `Employe`
--

DELIMITER $$

CREATE PROCEDURE InsertEmploye(
    IN p_id VARCHAR(4),
    IN p_nom VARCHAR(50),
    IN p_prenom VARCHAR(50),
    IN p_login VARCHAR(50),
    IN p_hash VARCHAR(255),
    IN p_salt VARCHAR (255),
    IN p_adresse VARCHAR(100),
    IN p_cp VARCHAR(10),
    IN p_ville VARCHAR(50),
    IN p_dateEmbauche DATE,
    IN p_role ENUM('v', 'd', 'c')
)
BEGIN
    -- Insertion dans la table Employe
    INSERT INTO Employe (idVisiteur, nom, prenom, login, hash, salt, adresse, cp, ville, dateEmbauche)
    VALUES (p_id, p_nom, p_prenom, p_login, p_hash, p_salt, p_adresse, p_cp, p_ville, p_dateEmbauche);

    -- Insertion dans la table Visiteur avec l'ID employé
    IF p_role = 'v' THEN
        INSERT INTO Visiteur (idVisiteur) VALUES (p_id);
    ELSEIF p_role = 'd' THEN
        INSERT INTO Directeur (idDirecteur) VALUES (p_id);
    ELSEIF p_role = 'c' THEN
        INSERT INTO Comptable (idComptable) VALUES (p_id);
    END IF;
END $$

DELIMITER ;


-- --------------------------------------------------------

--
-- Contenu de la table `Visiteur`
--

CALL InsertEmploye('a131', 'Villechalane', 'Louis', 'lvillachane', '1262df02c29b7e38508e8ea150c1cac671aeb742d69c861076ead94f0ef2d3eae4c343840b126110b40d80f3e9a2a6e9a28fe30e3a57b24f8e662ecc14b06cb1', '42910b8ee228717c79226eec1c0bdbc1', '8 rue des Charmes', '46000', 'Cahors', '2005-12-21', 'v');
CALL InsertEmploye('a17', 'Andre', 'David', 'dandre', 'f878de4e829ce97a4d5daac9fc8ba032a3a593dd12aaaf0217ad458ae0c4e70382e2356e4b61776e85cc3a28eae733655e7d2d9ed776f62e676c7b6da3e7e197', 'ed012c9c0e60aeea4bc9c9eeeb674f8d', '1 rue Petit', '46200', 'Lalbenque', '1998-11-23', 'v');
CALL InsertEmploye('a55', 'Bedos', 'Christian', 'cbedos', '723d11fb7c62dd94a21bcf9f313c488d18e5995168c0ce9a77f7ab88cf292a76235fca81d8b848d6a0e575b81ae53d0caaa0e5c9abecd9aa25bb6dae49637d26', '7f47ec5680886e072d824345477e484c', '1 rue Peranud', '46250', 'Montcuq', '1995-01-12', 'v');
CALL InsertEmploye('a93', 'Tusseau', 'Louis', 'ltusseau', '39ba95f7cb31421f7d71057074c70ce34008553934d7647df493fbb549fed34827ff0d251faaf484aa04560f28f95664a52c41ea31167323a0315036e2ca2a64', 'f4c620a92d30c4348e530c056343c14a', '22 rue des Ternes', '46123', 'Gramat', '2000-05-01', 'v');
CALL InsertEmploye('b13', 'Bentot', 'Pascal', 'pbentot', 'e094c44474dfe63def41e286a8d8f9a5ddc5ceaad94251337df1c57d7d26b7b32438d5c4d02c39f0c8554179652f840756747282f0488e6f0ef3414abef9ca84', '8f744a665068c2fe1dedcf1181f0fe93', '11 allée des Cerises', '46512', 'Bessines', '1992-07-09', 'v');
CALL InsertEmploye('b16', 'Bioret', 'Luc', 'lbioret', 'a1bc2d31d30432a7bb6a8f553c488c434fcc6a19e07a6d56095a7611d8bcec9fa87a99f5a27f35bd3fb72432a768eb382fce87075e70ca320d57a24541523018', '33bc49b9acf216b87855b39e81872f5c', '1 Avenue gambetta', '46000', 'Cahors', '1998-05-11', 'v');
CALL InsertEmploye('b19', 'Bunisset', 'Francis', 'fbunisset', 'd9c9a57833f0f6063a5f20cc713781e40e0bdcef238625c58d18e535ba155ad9e4cadbda6325f6edc2f9ad813a0f342761015bf26ffff2492c0546aa90940970', '90607898cfc1f996e1aa81a49bc83117', '10 rue des Perles', '93100', 'Montreuil', '1987-10-21', 'v');
CALL InsertEmploye('b25', 'Bunisset', 'Denise', 'dbunisset', '6ed11bd4b0d3d6bf8eb5072c2520b8aa3305410517e4e69c6c8ac83740b99f86fb36343e4fcb6e4a73c93df322c1aedb2b15cf626eac0ba739d53b30f9d72ca5', '8f87815d864709c8fc43e3734a9aa818', '23 rue Manin', '75019', 'paris', '2010-12-05', 'v');
CALL InsertEmploye('b28', 'Cacheux', 'Bernard', 'bcacheux', '701191511c0ed232a213b277a70ac1378eaac933ea14b1c71467e169626bf9efaca7011add0a24a576bd4dab7e113db932dc37b16c7cb85aefc1d9326e0b61e6', 'e7a6513c1e98718dbaa9dd435296f49c', '114 rue Blanche', '75017', 'Paris', '2009-11-12', 'v');
CALL InsertEmploye('b34', 'Cadic', 'Eric', 'ecadic', 'b2681ba4790e060e46581c18afc29dc6e857922e79c984c71ee0a9365ea30009f64f34069036de04eb73af8f6a0dbfae284eed85c85fcd3d6ead4d530bccd7a1', '0dc7825b6b2255d1cda1fe7220994f8f', '123 avenue de la République', '75011', 'Paris', '2008-09-23', 'v');
CALL InsertEmploye('b4', 'Charoze', 'Catherine', 'ccharoze', '5272a06827dcb02a6e3689ff26b9fa08909edffad2b1150c68892c32a5bdcf0a44fdb056a30cd52cf568d41e644e9944853bffcd9d86fa4f062adbff0d024f0f', '37eb758f99dd287040e689a1a42db1b4', '100 rue Petit', '75019', 'Paris', '2005-11-12', 'v');
CALL InsertEmploye('b50', 'Clepkens', 'Christophe', 'cclepkens', 'f27fc3cd696e9363ee963a34e3607797410126416805e46f29bd93b78965247057f533180c8fa1d8e9d8f5fff31d86920c38dd4d7ef83659bb4b05ba360b0064', '2a0d6289f80b7f134445981d2948bfb4', '12 allée des Anges', '93230', 'Romainville', '2003-08-11', 'v');
CALL InsertEmploye('b59', 'Cottin', 'Vincenne', 'vcottin', 'f02ac923c43fbb1e1586a092bf9d2491e7377bd6cbdee56a94910dcb9836ec97dcf8f92b57cee146dc7a1d9ada44e3e16f81a707c8c96bbac124fcabb220a92f', 'a2aa8b482274bdbe51ac781952cbe3a4', '36 rue Des Roches', '93100', 'Monteuil', '2001-11-18', 'v');
CALL InsertEmploye('c14', 'Daburon', 'François', 'fdaburon', '1b273a4aff5a88079efb97b71034a154f29414c6ae8bfa4b52f01cd00b691963af46f26298c39bbc0d4cffe7885e278414e3f0f02889ac9483fa87d479671424', '63b970ab025db8b803ad80fd2ff9e7c6', '13 rue de Chanzy', '94000', 'Créteil', '2002-02-11', 'v');
CALL InsertEmploye('c3', 'De', 'Philippe', 'pde', '8baff0ab07fcc2d2d7bc006c87f0217a0106bcb0bda1c8704fe0161e2e8ac12b9709fcd6e85dea23d7b993f31cd6e40a5f0b6869f25cc088d09fa79fafec194f', '92394627db359e70617544617b8e219c', '13 rue Barthes', '94000', 'Créteil', '2010-12-14', 'v');
CALL InsertEmploye('c54', 'Debelle', 'Michel', 'mdebelle', '47daadc5b0b41d7d20756bf23b8d3005f74473be8048eeaa72150cec0b0714a3cbe05de84b7e5def522be4965bd25e5ad8ba2eae23c4bb665abbb1e485ae0754', 'c8462d0eace47443a174c451013d903e', '181 avenue Barbusse', '93210', 'Rosny', '2006-11-23', 'v');
CALL InsertEmploye('d13', 'Debelle', 'Jeanne', 'jdebelle', '785007cfe1597cc43149b4062e3ddb65915b94cb7a6a2110a110dd6749d5fe273bae502ef99fed2efad0cf33f5fd3c29ca851e0faef36359c57f87847ca54193', '537dce1efc0d03b6f79aefd35b2d2f61', '134 allée des Joncs', '44000', 'Nantes', '2000-05-11', 'v');
CALL InsertEmploye('d51', 'Debroise', 'Michel', 'mdebroise', '8b46440d6c1affa72a6f104acc8e0277de205b4b836f15093b1ccad82cb4976a5f038b57c935686949413c3fb6e7473f3898f83603bf0cd0194af9c36436a7be', '655298304a6939dc22ade50df7f7d323', '2 Bld Jourdain', '44000', 'Nantes', '2001-04-17', 'v');
CALL InsertEmploye('e22', 'Desmarquest', 'Nathalie', 'ndesmarquest', '0e502c9f2b632ae03c91926dccf22cb1e4cdaebe5f72c8b478fa0d6b24fd82c0b9e947c4bdbd14743ba289fe89c6c792439e20a02fe34c5c38912b99885a5236', 'baba9306d3172dee9aa90839d2624fa6', '14 Place d Arc', '45000', 'Orléans', '2005-11-12', 'v');
CALL InsertEmploye('e24', 'Desnost', 'Pierre', 'pdesnost', 'f1a26fa5b576d26c669a6b364ed39eed9ab7cadc0ef0d2eaaef86971a8c7bb271cb3ba64a94072d12eebb6a08b09386bea8c84c41faf7c5911387b037534248c', '4a4db2bc44e8ce83dcb3ff023e2c9bba', '16 avenue des Cèdres', '23200', 'Guéret', '2001-02-05', 'v');
CALL InsertEmploye('e39', 'Dudouit', 'Frédéric', 'fdudouit', 'b9a487a9e70dccd4e1a63250e0e60c4a225277724bd99419be93432074d5c0a1481e0867479df351c7f4df4ac8c87efc521379bcd3b3fba2430538cffd4f53fd', 'be3ed62b809f907939f77c3628a47a7d', '18 rue de l église', '23120', 'GrandBourg', '2000-08-01', 'v');
CALL InsertEmploye('e49', 'Duncombe', 'Claude', 'cduncombe', 'e44301b64ccb6240a9f6fd886267d724549af3607a7e6f35d444f4639e6585ba14ac8690d26b0b8618b41d601e9ced82ec4abeac052316868f701fe9e6e941e5', 'b652654f92d672b8726d017130e4c9b5', '19 rue de la tour', '23100', 'La souteraine', '1987-10-10', 'v');
CALL InsertEmploye('e5', 'Enault-Pascreau', 'Céline', 'cenault', '3808d893eef5830c434f4de3a5b03acba514348605309405027e96d8a0de637cec31ede67556cb4fd1ad118f2095be4a1581b4a64bc29c84da13999e3595dafb', 'fad0cc790d27d3769f6dfa7cdf81cff5', '25 place de la gare', '23200', 'Gueret', '1995-09-01', 'v');
CALL InsertEmploye('e52', 'Eynde', 'Valérie', 'veynde', '75a7920735784cf5d8bce492a7cffa05c35e5d31e0fbd45439f20455693699ebe44b5f21352feb78e36353e5fbd9544270b7f87efb60f02cd7309b26f61b76a2', 'f97f2b0ca3c30ec75adecebf23d2677c', '3 Grand Place', '13015', 'Marseille', '1999-11-01', 'v');
CALL InsertEmploye('f21', 'Finck', 'Jacques', 'jfinck', 'd82c886bdb09e4372727a976504ca1a235554746d3de182ac3f28ce74796812ac2d810da6f845779d599221eedbb08b5ddfb3e4a64e9e7491a93e2ac9487d45d', '6be6f2cc063723ac1aa4169d1c54bd6a', '10 avenue du Prado', '13002', 'Marseille', '2001-11-10', 'v');
CALL InsertEmploye('f39', 'Frémont', 'Fernande', 'ffremont', 'e4b7b4ededfd32baf471fbefa6d2195e74ff2403f87c5fb280ea00261157939791a341ffa811205838acc863880d661c8145fd4dbdabc7623c7dc8d5996f40d9', '4c1747ac4aa26883be28f98d5a11bff3', '4 route de la mer', '13012', 'Allauh', '1998-10-01', 'v');
CALL InsertEmploye('f4', 'Gest', 'Alain', 'agest', '3753f3dc031c2dd1deef247072e18ddd026555568ebfde19f5c312e7d0ccc0c303cbdfbaf0bbd4a8ebcc573e8ecee4c244eb394205b35c986b9e6b70ae2a3831', 'ea9ac7729a5dbf8f38c54d1b77007375', '30 avenue de la mer', '13025', 'Berre', '1985-11-01', 'v');


-- --------------------------------------------------------

--
-- Contenu de la table `Directeur`
--


CALL InsertEmploye('d001', 'Cartman', 'Eric', 'ecartman', '6bfcc4026b5f162799a6dc8305c09db9c1674ac616bd5c7422a45fbb6d0816ac163047c47a1f426f4f4c6b5b5042c671eabc4fdc7310fd5b183eef59dc274604', '8077b4b1c4ca18bcbfd6b64a9f59a54ac1837fec89ca06d7edf95b636885cf06', '30 avenue du gros sac', '15129', 'South Park', '1997-08-13', 'd');
CALL InsertEmploye('d002', 'Broflovski', 'Kyle', 'kbroflovski', '6bfcc4026b5f162799a6dc8305c09db9c1674ac616bd5c7422a45fbb6d0816ac163047c47a1f426f4f4c6b5b5042c671eabc4fdc7310fd5b183eef59dc274604', '2734d62ac8e15c14c510e42b12fd015d8ef52661448216546762acdb71f6e273', '14 route du juif', '15129', 'South Park', '1997-08-13', 'd');
CALL InsertEmploye('d003', 'Marsh', 'Stan', 'smarsh', '6bfcc4026b5f162799a6dc8305c09db9c1674ac616bd5c7422a45fbb6d0816ac163047c47a1f426f4f4c6b5b5042c671eabc4fdc7310fd5b183eef59dc274604', 'a2d2362a25d86f0bc887a805b3428e2f256aa0feee8165d7f2fb0e6094f38f1a', '867 chemin du chapeau bleu', '15129', 'South Park', '1997-08-13', 'd');
CALL InsertEmploye('d004', 'McCormick', 'Kenny', 'kmccormick', '6bfcc4026b5f162799a6dc8305c09db9c1674ac616bd5c7422a45fbb6d0816ac163047c47a1f426f4f4c6b5b5042c671eabc4fdc7310fd5b183eef59dc274604', '2c173202a4dd3b3ff342ec15b2222c721e82cd755cb13084b3c3eb4fba9c52e2', '1 boulevard du pauvre', '15129', 'South Park', '1997-08-13', 'd');
CALL InsertEmploye('d005', 'Stotch', 'Butters', 'bstotch', '6bfcc4026b5f162799a6dc8305c09db9c1674ac616bd5c7422a45fbb6d0816ac163047c47a1f426f4f4c6b5b5042c671eabc4fdc7310fd5b183eef59dc274604', '519723845859ed160cd05f2268d4855ec2465ae926c67d403a3156a8aa6f6166', '2 route de l idiot', '15129', 'South Park', '1997-08-13', 'd');
CALL InsertEmploye('d006', 'Valmer', 'Jimmy', 'jvalmer', '6bfcc4026b5f162799a6dc8305c09db9c1674ac616bd5c7422a45fbb6d0816ac163047c47a1f426f4f4c6b5b5042c671eabc4fdc7310fd5b183eef59dc274604', 'c39ae667ee240e483e5670211fbc931b5d5432d2883e0045dce53a3bdb67784c', '24 rout de l handicape', '15129', 'South Park', '1997-08-13', 'd');


-- --------------------------------------------------------

--
-- Contenu de la table `Comptable`
--

CALL InsertEmploye('ac1', 'Dumoulin', 'Alphonse', 'adumoulin', '2fd88d6d1411135f9bc0206ff4702f0138732379cc08a01ffa026907286df9646d71adf94bdf8b5d0247b903d7b2cd3416694e6fdae2f5619eccbd0c1b02074b', '5a937d4ebd98ce63340eb1452391f3168fb713540f711e0d16f19bf35848975b', '12 rue des martyrs de la résistance', '93100', 'Montreuil', '1995-12-21', 'c');