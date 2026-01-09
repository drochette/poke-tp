<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260109150026 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pokedex (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, pokemon_id INT NOT NULL, INDEX IDX_6336F6A7A76ED395 (user_id), INDEX IDX_6336F6A72FE71C3E (pokemon_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE pokedex ADD CONSTRAINT FK_6336F6A7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE pokedex ADD CONSTRAINT FK_6336F6A72FE71C3E FOREIGN KEY (pokemon_id) REFERENCES pokemon (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pokedex DROP FOREIGN KEY FK_6336F6A7A76ED395');
        $this->addSql('ALTER TABLE pokedex DROP FOREIGN KEY FK_6336F6A72FE71C3E');
        $this->addSql('DROP TABLE pokedex');
    }
}
