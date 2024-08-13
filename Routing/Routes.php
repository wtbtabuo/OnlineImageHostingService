<?php

use Helpers\DatabaseHelper;
use Helpers\ValidationHelper;
use Response\HTTPRenderer;
use Response\Render\JSONRenderer;

return [
    'api/image' => function(){
        $uid = ValidationHelper::string($_POST['uid'] ?? null);
        $title = ValidationHelper::string($_POST['title'] ?? null);
        $image = $_FILES['image'] ?? null;

        if (!$uid) {
            return new JSONRenderer(['error' => 'UID is required'], 400);
        }
        if (!$title) {
            return new JSONRenderer(['error' => 'Title is required'], 400);
        }
        if (!$image || $image['error'] !== UPLOAD_ERR_OK) {
            return new JSONRenderer(['error' => 'Image is required and must be successfully uploaded'], 400);
        }

        $imageData = file_get_contents($image['tmp_name']);
        $res = DatabaseHelper::postImage($uid, $title, $imageData);

        return new JSONRenderer(['imageId' => $res]);
    },

    'api/images' => function(){
        $uid = ValidationHelper::string($_GET['uid'] ?? null);

        if (!$uid) {
            return new JSONRenderer(['error' => 'UID is required'], 400);
        }

        // データベースから画像とタイトルを取得
        $result = DatabaseHelper::getImageByUID($uid);
        if (!$result) {
            return new JSONRenderer(['error' => 'Image not found'], 404);
        }

        // 画像データとタイトルをJSONで返す
        return new JSONRenderer([
            'title' => $result['title'],
            'access_count' => $result['access_count'],
            'image' => base64_encode($result['image']) // 画像をbase64でエンコード
        ]);
    },
];
