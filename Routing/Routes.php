<?php

use Helpers\DatabaseHelper;
use Helpers\ValidationHelper;
use Response\HTTPRenderer;
use Response\Render\HTMLRenderer;
use Response\Render\JSONRenderer;

return [
    'api/image'=>function(){
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

];