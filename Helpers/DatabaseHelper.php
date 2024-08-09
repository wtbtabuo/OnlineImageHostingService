<?php

namespace Helpers;

use Database\MySQLWrapper;
use Exception;

class DatabaseHelper
{
    public static function postTextSnippet(string $uid, string $code, string $code_language, $expired_at, string $title): array {
        $db = new MySQLWrapper();

        // データベースにインサートするSQL文
        $stmt = $db->prepare("INSERT INTO text_snap (uid, code, code_language, title, expired_at) VALUES (?, ?, ?, ?, ?)");
        
        // プレースホルダに値をバインド
        $stmt->bind_param("sssss", $uid, $code, $code_language, $title, $expired_at);
        
        // クエリを実行
        if (!$stmt->execute()) {
            throw new Exception('Failed to insert data into text_snap table: ' . $stmt->error);
        }
        
        // 挿入されたレコードのIDを取得
        $insertedId = $stmt->insert_id;
        
        // インサートされたデータを再取得して返す（例として）
        $stmt = $db->prepare("SELECT * FROM text_snap WHERE id = ?");
        $stmt->bind_param("i", $insertedId);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        
        if (!$data) {
            throw new Exception('Could not retrieve the inserted record from database');
        }
        
        return $data;
    }

    public static function getTextSnippetByUid(string $uid): array {
        $db = new MySQLWrapper();

        $stmt = $db->prepare("SELECT * FROM text_snap WHERE uid = ?");

        if (!$stmt) {
            throw new Exception('Failed to prepare statement: ' . $db->error);
        }

        $stmt->bind_param("s", $uid);
        
        // クエリを実行
        if (!$stmt->execute()) {
            throw new Exception('Failed to get data from text_snap table: ' . $stmt->error);
        }

        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        
        if (!$data) {
            throw new Exception('Could not retrieve the inserted record from database');
        }
        
        return $data;
    }
}
