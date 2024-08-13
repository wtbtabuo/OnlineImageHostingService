<?php

namespace Helpers;

use Database\MySQLWrapper;
use Exception;

class DatabaseHelper
{
    public static function postImage(string $uid, string $title, string $imageData): int {
        $db = new MySQLWrapper();

        // データベースにインサートするSQL文
        $stmt = $db->prepare("INSERT INTO images (uid, title, access_count, image) VALUES (?, ?, ?, ?)");
        
        // プレースホルダに値をバインド
        $accessCount = 1;
        $stmt->bind_param("ssis", $uid, $title, $accessCount, $imageData);
        
        // クエリを実行
        if (!$stmt->execute()) {
            throw new Exception('Failed to insert data into images table: ' . $stmt->error);
        }
        // 挿入されたレコードのIDを取得して返す
        return $stmt->insert_id;
    }

    public static function getImageByUID(string $uid): ?array {
        $db = new MySQLWrapper();

        // UIDに基づいて画像データを取得するSQL文
        $stmt = $db->prepare("SELECT * FROM images WHERE uid = ?");
        $stmt->bind_param("s", $uid);
        $stmt->execute();

        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        if ($data) {
            // アクセスカウントを増やす
            $stmt = $db->prepare("UPDATE images SET access_count = access_count + 1 WHERE uid = ?");
            $stmt->bind_param("s", $uid);
            $stmt->execute();
        }

        // 画像データを返す、見つからない場合はnullを返す
        return $data ?? null;
    }
}
