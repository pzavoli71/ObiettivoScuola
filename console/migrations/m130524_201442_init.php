<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'IdRuolo' => $this->integer()->notNull()->defaultValue(2),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
        
        $this->createTable('{{%ruolo}}', [
            'IdRuolo' => $this->primaryKey(),
            'DsRuolo' => $this->string(100)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%zgruppo}}', [
            'CdGruppo' => $this->primaryKey(),
            'DsGruppo' => $this->string(100)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%ztrans}}', [
            'CdPdc' => $this->primaryKey()->string(200)->notNull(),
            'DsPdc' => $this->string(200)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%zruoligruppo}}', [
            'IdRuolo' => $this->primaryKey(),
            'CdGruppo' => $this->primaryKey(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->addForeignKey('fix_ruoligruppo_ruolo', '{{%zruoligruppo}}', 'IdRuolo', '{{%ruolo}}' , 'IdRuolo');
        $this->addForeignKey('fix_ruoligruppo_gruppo', '{{%zruoligruppo}}', 'CdGruppo', '{{%zgruppo}}' , 'CdGruppo');
        
        $this->createTable('{{%zpermessi}}', [
            'CdGruppo' => $this->primaryKey(),
            'CdPdc' => $this->primaryKey()->string(200)->notNull(),
            'Permesso' => $this->string(50)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->addForeignKey('fix_zpermessi_ztrans', '{{%zpermessi}}', 'CdPdc', '{{%ztrans}}' , 'CdPdc');
        
        $this->createTable('session', [
            'id' => $this->char(40)->notNull(),
            'expire' => $this->integer(),
            'data' => $this->binary(),
            'user_id' => $this->integer(),
            'browser_platform' => $this->char(200)->notNull(),
        ]);

        $this->addPrimaryKey('session_pk', 'session', 'id');        
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
