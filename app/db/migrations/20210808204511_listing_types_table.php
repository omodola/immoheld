<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class ListingTypesTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $table = $this->table("listing_types");
        $table
            ->addColumn("type", "string")
            ->addColumn("created_at", "datetime", ["default" => "CURRENT_TIMESTAMP"])
            ->addColumn("updated_at", "timestamp", ["default" => "CURRENT_TIMESTAMP", 'update' => 'CURRENT_TIMESTAMP'])
            ->addColumn("deleted_at", "datetime", ["null" => true])
            ->create();

        // insert default data
        $builder = $this->getQueryBuilder();
        $builder
            ->insert(["type"])
            ->into("listing_types")
            ->values(["type" => "apartment"])
            ->values(["type" => "bungalow"])
            ->values(["type" => "castle"])
            ->values(["type" => "duplex"])
            ->values(["type" => "cabin"])
            ->values(["type" => "mansion"])
            ->values(["type" => "villa"])
            ->values(["type" => "cottage"])
            ->execute();
    }
}
