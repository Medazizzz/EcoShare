Plateforme de partage d’objets éco-solidaires
Une plateforme web permettant aux utilisateurs :
•	de proposer des objets qu’ils n’utilisent plus (don ou prêt),
•	de réserver ou emprunter des objets mis à disposition par d’autres,
•	de favoriser la réutilisation locale via un système de recherche par ville.
Exemples d’objets : livres, vêtements, outils, plantes, jouets, matériel de cuisine…

Tâche 1 : Gestion des utilisateurs (Authentification et profils) Aziz Thabet
Objectif : gérer l’inscription, la connexion et le profil utilisateur.
Détails :
•	CRUD User : ajout, modification, suppression, affichage profil
•	Contrôle de saisie : email valide, mot de passe sécurisé, ville obligatoire
•	Bundle Symfony : Security, Validator, Form
•	Templates : pages inscription/login avec Twig et Bootstrap/Tailwind
•	Métier : gestion des rôles et affichage du badge “Éco-utilisateur”




Tache 2 :Gestion et réservation des objets Sarra Omrani 
Objectif : permettre aux utilisateurs de publier, modifier, supprimer et réserver des objets disponibles sur la plateforme.
Détails :
•	CRUD Objet et Reservation : création, modification, suppression des objets et création, annulation, consultation de l’historique des réservations.
•	Contrôle de saisie : champs obligatoires pour les objets, image obligatoire, état choisi, et empêcher la réservation d’un objet déjà réservé.
•	Templates : formulaires Twig pour ajouter/modifier les objets, affichage en liste ou galerie, bouton “Réserver” et suivi des réservations.
•	Bundles Symfony : Form pour les formulaires, Doctrine pour la gestion des entités, Validator pour la validation.
•	Extensions : VichUploaderBundle pour la gestion des images et Notifier pour envoyer emails ou notifications.
•	Métier : associer automatiquement chaque objet à son propriétaire et mettre à jour le statut de l’objet (“disponible” → “réservé”) lors d’une réservation.

tâche 3 : Avis, réclamations et recommandations 
Objectif : permettre aux utilisateurs de donner des avis, noter les objets, signaler des problèmes et recevoir des recommandations personnalisées.
Détails :
•	CRUD Avis/Commentaire : création, modification, suppression
•	CRUD Réclamation : signalement de problème ou objet non conforme
•	Recommandations : proposer des objets similaires ou pertinents en fonction des avis et de l’historique de l’utilisateur
•	Contrôle de saisie : texte obligatoire, notation valide (1 à 5 étoiles)
•	Templates : formulaires Twig pour avis, réclamations et recommandations, page de suivi
•	Bundle Symfony : Form, Doctrine, Twig
•	Extension : Notifier pour envoyer une alerte au propriétaire ou à l’admin
•	Métier : calcul de la note moyenne des objets et utilisateurs, suivi des réclamations, génération automatique de suggestions/recommandations
Tâche 4 : Gestion des événements écologiques Rania Ben Salem 
Objectif : permettre aux utilisateurs et à l’admin de créer, modifier, supprimer et consulter des événements liés à l’écologie et à la réutilisation.
Détails :
•	CRUD Événement :
o	Création : titre, description, date, lieu, image, type d’événement (atelier, nettoyage, échange, don…).
o	Modification et suppression par l’admin ou l’organisateur.
o	Affichage : liste des événements à venir, détails, filtrage par ville ou type.
•	Contrôle de saisie :
o	Titre, date et lieu obligatoires.
o	Vérifier que la date est future.
o	Image obligatoire pour l’affichage sur la plateforme.
•	Templates :
o	Formulaires Twig pour ajouter ou modifier un événement.
o	Page de liste et fiche détaillée de l’événement.
o	Bouton “Participer” ou “S’inscrire”.
•	Bundles Symfony :
o	Form pour les formulaires.
o	Doctrine pour la persistance.
o	Validator pour la validation.
o	VichUploaderBundle pour gérer les images si nécessaire.
•	Métier :
o	Suivi des participants par événement.
o	Envoi automatique de notifications (via Notifier) pour rappel de participation ou changements d’événement.
Tâche 5 : Gestion des sponsors, partenariats et publicités
Objectif : permettre à l’admin de gérer les partenaires, sponsors et contenus publicitaires sur la plateforme afin de soutenir le projet et promouvoir des initiatives éco-responsables.
Détails :
•	CRUD Sponsor / Partenaire / Publicité :
o	Ajout : nom du sponsor/partenaire, logo ou image, description, type (sponsor, partenaire, publicité), lien externe (site web ou page d’inscription).
o	Modification : possibilité de mettre à jour l’image, description ou lien.
o	Suppression : retirer un sponsor, partenaire ou publicité obsolète.
o	Affichage : liste des sponsors/partenaires/publicités sur une page dédiée et/ou sur la page d’accueil.
•	Contrôle de saisie :
o	Nom obligatoire, image obligatoire pour logo/publicité, lien valide.
o	Vérification du type (sponsor / partenaire / publicité).
•	Templates :
o	Formulaire Twig pour ajouter/modifier un sponsor ou une publicité.
o	Tableau ou galerie pour afficher tous les sponsors/partenaires/publicités avec options “modifier” / “supprimer”.
•	Bundles Symfony :
o	Form pour les formulaires.
o	Doctrine pour la gestion des entités.
o	Validator pour la validation.
o	VichUploaderBundle pour la gestion des images.
•	Métier :
o	Associer automatiquement un sponsor ou partenaire à un événement ou à un objet si besoin.
o	Permettre à l’admin de programmer la visibilité des publicités ou des partenaires sur la plateforme.
