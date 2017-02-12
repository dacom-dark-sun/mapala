<?php

use yii\db\Migration;

/**
 * Handles the creation of table `raiting`.
 * Has foreign keys to the tables:
 *
 * - `calendar`
 * - `user`
 */
class m170210_203552_create_raiting_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('raiting', [
            'id' => $this->primaryKey(),
            'calend_id' => $this->integer(),
            'user_id' => $this->integer(),
            'raiting' => $this->integer(),
            'username' => $this->string(),
        ]);

        // creates index for column `calend_id`
        $this->createIndex(
            'idx-raiting-calend_id',
            'raiting',
            'calend_id'
        );

        // add foreign key for table `calendar`
        $this->addForeignKey(
            'fk-raiting-calend_id',
            'raiting',
            'calend_id',
            'calendar',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            'idx-raiting-user_id',
            'raiting',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-raiting-user_id',
            'raiting',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `calendar`
        $this->dropForeignKey(
            'fk-raiting-calend_id',
            'raiting'
        );

        // drops index for column `calend_id`
        $this->dropIndex(
            'idx-raiting-calend_id',
            'raiting'
        );

        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-raiting-user_id',
            'raiting'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-raiting-user_id',
            'raiting'
        );

        $this->dropTable('raiting');
    }
}
