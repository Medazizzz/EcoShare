<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251201120852 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, contenu VARCHAR(255) NOT NULL, date_creation DATETIME NOT NULL, evenement_id INT NOT NULL, INDEX IDX_67F068BCFD02F13 (evenement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, date_event DATETIME NOT NULL, lieu VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, organisateur_nom VARCHAR(255) DEFAULT NULL, organisateur_prenom VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE evenement_sponsor_partenaire (evenement_id INT NOT NULL, sponsor_partenaire_id INT NOT NULL, INDEX IDX_71473907FD02F13 (evenement_id), INDEX IDX_71473907C38A8E8C (sponsor_partenaire_id), PRIMARY KEY(evenement_id, sponsor_partenaire_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE publicite (id INT AUTO_INCREMENT NOT NULL, image VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, lien VARCHAR(255) DEFAULT NULL, sponsor_partenaire_id INT DEFAULT NULL, INDEX IDX_1D394E39C38A8E8C (sponsor_partenaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE sponsor_partenaire (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, logo VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, type VARCHAR(20) NOT NULL, lien VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCFD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id)');
        $this->addSql('ALTER TABLE evenement_sponsor_partenaire ADD CONSTRAINT FK_71473907FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evenement_sponsor_partenaire ADD CONSTRAINT FK_71473907C38A8E8C FOREIGN KEY (sponsor_partenaire_id) REFERENCES sponsor_partenaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE publicite ADD CONSTRAINT FK_1D394E39C38A8E8C FOREIGN KEY (sponsor_partenaire_id) REFERENCES sponsor_partenaire (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCFD02F13');
        $this->addSql('ALTER TABLE evenement_sponsor_partenaire DROP FOREIGN KEY FK_71473907FD02F13');
        $this->addSql('ALTER TABLE evenement_sponsor_partenaire DROP FOREIGN KEY FK_71473907C38A8E8C');
        $this->addSql('ALTER TABLE publicite DROP FOREIGN KEY FK_1D394E39C38A8E8C');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE evenement_sponsor_partenaire');
        $this->addSql('DROP TABLE publicite');
        $this->addSql('DROP TABLE sponsor_partenaire');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
