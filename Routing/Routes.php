<?php

use Helpers\DatabaseHelper;
use Helpers\ValidationHelper;
use Response\HTTPRenderer;
use Response\Render\HTMLRenderer;
use Response\Render\JSONRenderer;

return [
    'api/image'=>function(){
        $inputData = json_decode(file_get_contents('php://input'), true);
        $uid = ValidationHelper::string($inputData['uid']??null);
        $text = ValidationHelper::string($inputData['text']??null);
        $language = ValidationHelper::string($inputData['language']??null);
        $retention = $inputData['retention'];
        $title = ValidationHelper::string($inputData['title']??null);
        $textSnippet = DatabaseHelper::postTextSnippet($uid, $text, $language, $retention, $title);
        return new JSONRenderer(['textSnippet'=>$textSnippet]);
    },

    'api/textSnippet/text' => function() {
        $uid = ValidationHelper::string($_GET['uid'] ?? null);

        $textSnippet = DatabaseHelper::getTextSnippetByUid($uid);
        if ($textSnippet) {
            return new JSONRenderer(['textSnippet' => $textSnippet]);
        } else {
            // データが見つからなかった場合の処理
            return new JSONRenderer(['error' => 'Text snippet not found'], 404);
        }
    }
];