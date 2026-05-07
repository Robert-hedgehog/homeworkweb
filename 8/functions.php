<?php

function getFileExtension($fileName) {
    if (preg_match('/\.([a-z0-9]+)$/i', $fileName, $match)) {
        return $match[1];
    }
    return false;
}

function checkFileType($fileName) {
    if (preg_match('/\.(zip|rar|7z|tar|gz)$/i', $fileName)) {
        return 'Архив (Archive)';
    }
    elseif (preg_match('/\.(mp3|aac|alac|wav|ogg|flac)$/i', $fileName)) {
        return 'Аудио (Audio)';
    } 
    elseif (preg_match('/\.(mp4|avi|mkv|mov|webm)$/i', $fileName)) {
        return 'Видео (Video)';
    }
    elseif (preg_match('/\.(png|jpg|jpeg|gif|bmp|webp)$/i', $fileName)) {
        return 'Изображение (Image)';
    }
    return 'Неизвестный формат';
}

function getTitleText($htmlText) {
    if (preg_match('#<title>([^<]+)</title>#iu', $htmlText, $match)) {
        return $match[1];
    }
    return 'Тег <title> отсутствует';
}

function getHtmlLinks($htmlText) {
    preg_match_all('/<a[^>]+href=["\']([^"\']+)["\']/iu', $htmlText, $matches);
    return $matches[1];
}

function getHtmlImages($htmlText) {
    preg_match_all('#<img[^>]+src=["\']([^"\']+)["\']#iu', $htmlText, $matches);
    return $matches[1];
}

function highlightstring($keyword, $text) {
    $pattern = '/' . preg_quote($keyword, '/') . '/iu';
    return preg_replace($pattern, '<strong>$0</strong>', $text);
}

function replaceEmoji($text) {
    $search = ['/:\)/', '/;\)/', '/:\(/'];
    $replace = [
        '<img src="smile.png" alt=":)">',
        '<img src="wink.png" alt=";)">',
        '<img src="sad.png" alt=":(">'
    ];
    return preg_replace($search, $replace, $text);

}
function clearSpaces($text) {
    return preg_replace('/\s{2,}/u', ' ', $text);
}
