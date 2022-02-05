<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220114141240 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `concert` (id INT AUTO_INCREMENT NOT NULL, band_id INT DEFAULT NULL, hall_id INT NOT NULL, date DATE NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_D57C02D249ABEB17 (band_id), INDEX IDX_D57C02D252AFCFD6 (hall_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `concert` ADD CONSTRAINT FK_D57C02D249ABEB17 FOREIGN KEY (band_id) REFERENCES band (id)');
        $this->addSql('ALTER TABLE `concert` ADD CONSTRAINT FK_D57C02D252AFCFD6 FOREIGN KEY (hall_id) REFERENCES hall (id)');
        $this->addSql('DROP TABLE `show`');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `show` (id INT AUTO_INCREMENT NOT NULL, band_id INT DEFAULT NULL, hall_id INT NOT NULL, date DATE NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_320ED90149ABEB17 (band_id), INDEX IDX_320ED90152AFCFD6 (hall_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE `show` ADD CONSTRAINT FK_320ED90149ABEB17 FOREIGN KEY (band_id) REFERENCES band (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE `show` ADD CONSTRAINT FK_320ED90152AFCFD6 FOREIGN KEY (hall_id) REFERENCES hall (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('DROP TABLE `concert`');
    }
}
