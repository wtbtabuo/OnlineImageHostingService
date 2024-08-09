<?php

namespace Database\Migrations;

use Database\SchemaMigration;

class CreateTextSnapTable implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return [
            "CREATE TABLE text_snap (
                id INT PRIMARY KEY AUTO_INCREMENT,
                uid VARCHAR(255) NOT NULL,
                code TEXT NOT NULL,
                code_language VARCHAR(255) NOT NULL,
                title VARCHAR(255),
                expired_at DATETIME,
                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
            )"
        ];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [
            "DROP TABLE text_snap"
        ];
    }
}