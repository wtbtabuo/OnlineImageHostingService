<?php

namespace Helpers;

use Database\MySQLWrapper;
use Exception;

class DatabaseHelper
{
    public static function postImage(string $uid, string $title, string $imageData): int {
        $db = new MySQLWrapper();

        // データベースにインサートするSQL文
        $stmt = $db->prepare("INSERT INTO images (uid, title, image) VALUES (?, ?, ?)");
        
        // プレースホルダに値をバインド
        $stmt->bind_param("sss", $uid, $title, $imageData);
        
        // クエリを実行
        if (!$stmt->execute()) {
            throw new Exception('Failed to insert data into images table: ' . $stmt->error);
        }
        // 挿入されたレコードのIDを取得して返す
        return $stmt->insert_id;
    }
}
