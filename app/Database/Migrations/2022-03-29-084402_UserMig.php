<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserMig extends Migration
{
    public function up()
    {
        $table = "users";
        $this->forge->addField([
            'id'                        => [
                'type'                  => 'int',
                'constraint'            => 11,
                'auto_increment'        => true,
            ],
            'created_at'                => [
                'type'                  => 'int',
                'constraint'            => 11,
            ],
            'updated_at'                => [
                'type'                  => 'int',
                'constraint'            => 11,
            ],
            'deleted_at'                => [
                'type'                  => 'int',
                'constraint'            => 11,
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable($table);

        $this->forge->addField([
            'id'                        => [
                'type'                  => 'int',
                'constraint'            => 11,
                'auto_increment'        => true,
            ],
            'object_id' => [
                'type' => 'int',
                'constraint'            => 11,
            ],
            'meta_key'                => [
                'type'                  => 'text',
                'constraint'            => '',
            ],
            'meta_value'                => [
                'type'                  => 'text',
                'constraint'            => '',
            ],
            'created_at'                => [
                'type'                  => 'int',
                'constraint'            => 11,
            ],
            'updated_at'                => [
                'type'                  => 'int',
                'constraint'            => 11,
            ],
            'deleted_at'                => [
                'type'                  => 'int',
                'constraint'            => 11,
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable("users_meta");
    }

    public function down()
    {
        //
    }
}
