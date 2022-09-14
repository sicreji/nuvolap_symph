<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220914130126 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE training (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, duration INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE training_student (training_id INT NOT NULL, student_id INT NOT NULL, INDEX IDX_6A1D3F3DBEFD98D1 (training_id), INDEX IDX_6A1D3F3DCB944F1A (student_id), PRIMARY KEY(training_id, student_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE training_student ADD CONSTRAINT FK_6A1D3F3DBEFD98D1 FOREIGN KEY (training_id) REFERENCES training (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE training_student ADD CONSTRAINT FK_6A1D3F3DCB944F1A FOREIGN KEY (student_id) REFERENCES student (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE training_student DROP FOREIGN KEY FK_6A1D3F3DBEFD98D1');
        $this->addSql('ALTER TABLE training_student DROP FOREIGN KEY FK_6A1D3F3DCB944F1A');
        $this->addSql('DROP TABLE training');
        $this->addSql('DROP TABLE training_student');
    }
}
