USE ecoshare;

SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE publicite;
TRUNCATE TABLE sponsor_partenaire;
SET FOREIGN_KEY_CHECKS = 1;

INSERT INTO sponsor_partenaire (nom, type, logo, description, lien) VALUES
('GreenBank', 'sponsor',
 'https://via.placeholder.com/200x80?text=GreenBank',
 'Banque verte qui finance des projets écologiques.',
 'https://greenbank.example.com'),
('EcoCity', 'sponsor',
 'https://via.placeholder.com/200x80?text=EcoCity',
 'Collectivité engagée dans la réduction des déchets.',
 'https://ecocity.example.com'),
('SolarWorld', 'sponsor',
 'https://via.placeholder.com/200x80?text=SolarWorld',
 'Entreprise spécialisée dans les panneaux solaires.',
 'https://solarworld.example.com'),
('RecycleTech', 'partenaire',
 'https://via.placeholder.com/200x80?text=RecycleTech',
 'Startup qui propose des solutions de recyclage connectées.',
 'https://recycletech.example.com'),
('CleanWater', 'partenaire',
 'https://via.placeholder.com/200x80?text=CleanWater',
 'Association qui agit pour l\'accès à une eau propre.',
 'https://cleanwater.example.com');

-- Vérifie les IDs dans sponsor_partenaire si besoin, ici on suppose 1..5
INSERT INTO publicite (image, description, lien, sponsor_partenaire_id) VALUES
('https://via.placeholder.com/600x250?text=Compte+vert+GreenBank',
 'Ouvrez un compte vert et financez des projets éco-responsables.',
 'https://greenbank.example.com/compte-vert', 1),
('https://via.placeholder.com/600x250?text=Journee+nettoyage+EcoCity',
 'Participez à la journée de nettoyage organisée par EcoCity.',
 'https://ecocity.example.com/journee-nettoyage', 2),
('https://via.placeholder.com/600x250?text=Panneaux+solaires+SolarWorld',
 'Installez des panneaux solaires à prix réduit avec SolarWorld.',
 'https://solarworld.example.com/offres', 3),
('https://via.placeholder.com/600x250?text=Recyclage+intelligent+RecycleTech',
 'Découvrez nos bacs de recyclage intelligents connectés à EcoShare.',
 'https://recycletech.example.com/smart-bins', 4),
('https://via.placeholder.com/600x250?text=Campagne+EcoShare',
 'Campagne générale EcoShare pour réduire les déchets du quotidien.',
 NULL,
 NULL);
