<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class PhotosTable extends AbstractMigration
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
        $table = $this->table("photos");
        $table
            ->addColumn("url", "text", [ "null" => false ])
            ->addColumn("created_at", "datetime", ["default" => "CURRENT_TIMESTAMP"])
            ->addColumn("updated_at", "timestamp", ["default" => "CURRENT_TIMESTAMP", 'update' => 'CURRENT_TIMESTAMP'])
            ->addColumn("deleted_at", "datetime", ["null" => true])
            ->create();
    }
}
