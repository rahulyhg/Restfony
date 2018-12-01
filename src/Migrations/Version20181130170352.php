<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181130170352 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE bundle_elements (id INT AUTO_INCREMENT NOT NULL, bundle_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_6D65367CE41C2BFC (bundle_id), UNIQUE INDEX UNIQ_6D65367CDE18E50B (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bundles (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(150) NOT NULL, price DECIMAL(8,2)  NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discounts (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, discount_amount DECIMAL(8,2) NOT NULL, discount_type ENUM("FLAT", "PERCENT") NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_FC5702B8DE18E50B (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(150) NOT NULL, price DECIMAL(8,2) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sales (id INT AUTO_INCREMENT NOT NULL, sub_total DECIMAL(8,2) NOT NULL, discount DECIMAL(8,2) NOT NULL, total DECIMAL(8,2) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sales_items (id INT AUTO_INCREMENT NOT NULL, sales_id INT NOT NULL, item_id INT NOT NULL,item_type ENUM("PRODUCT","BUNDLE") NOT NULL,  item_quantity INT NOT NULL, item_price DECIMAL(8,2) NOT NULL, item_discount DECIMAL(8,2) NOT NULL, item_total DECIMAL(8,2) NOT NULL, INDEX IDX_175A58FB89002FE1 (sales_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bundle_elements ADD CONSTRAINT FK_6D65367CE41C2BFC FOREIGN KEY (bundle_id) REFERENCES bundles (id)');
        $this->addSql('ALTER TABLE bundle_elements ADD CONSTRAINT FK_6D65367CDE18E50B FOREIGN KEY (product_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE discounts ADD CONSTRAINT FK_FC5702B8DE18E50B FOREIGN KEY (product_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE sales_items ADD CONSTRAINT FK_175A58FB89002FE1 FOREIGN KEY (sales_id) REFERENCES sales (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bundle_elements DROP FOREIGN KEY FK_6D65367CE41C2BFC');
        $this->addSql('ALTER TABLE bundle_elements DROP FOREIGN KEY FK_6D65367CDE18E50B');
        $this->addSql('ALTER TABLE discounts DROP FOREIGN KEY FK_FC5702B8DE18E50B');
        $this->addSql('ALTER TABLE sales_items DROP FOREIGN KEY FK_175A58FB55E38587');
        $this->addSql('DROP TABLE bundle_elements');
        $this->addSql('DROP TABLE bundles');
        $this->addSql('DROP TABLE discounts');
        $this->addSql('DROP TABLE products');
        $this->addSql('DROP TABLE sales');
        $this->addSql('DROP TABLE sales_items');
    }
}
