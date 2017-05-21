INSERT INTO `Forfait` (`id`, `libelle`, `montant`) VALUES
('ETP', 'Forfait Etape', 110.00),
('KM', 'Frais Kilométrique', 0.62),
('NUI', 'Nuitée Hôtel', 40.00),
('REP', 'Repas Restaurant', 25.00);

INSERT INTO `Etat` (`id`, `libelle`) VALUES
('RB', 'Remboursée'),
('CL', 'Saisie clôturée'),
('CR', 'Fiche créée, saisie en cours'),
('VA', 'Validée et mise en paiement');

INSERT INTO `Visiteur` (`id`,`nom`,`prenom`,`adresse`,`cp`,`ville`,`dateEmbauche`,`login`,`pwd`) VALUES
('FM','FLOCH',"Marie","32 rue de Siam","29200","BREST","2002-01-05","Mfloch","exemple");