<?php 
require_once 'functions.php'; 

$testFile1 = 'music.mp3';
$testFile2 = 'document.zip';

$testHtml = '
<html>
<head>
    <title>Тестовая страница</title>
</head>
<body>
    <a href="https://yandex.ru">Яндекс</a>
    <a href="/about.php">О нас</a>
    <img src="photo1.jpg" alt="Фото">
    <img src="logo.png">
</body>
</html>
';

$testText = 'Регулярные выражения в PHP очень мощные. Учим PHP вместе!';
$testEmoji = 'Привет :) Вот это да ;) Погода плохая :(';
$testSpaces = 'Пробелы              мешают  читать     этот       текст';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Проверка функций</title>
</head>
<body>

    <h1>Проверка регулярных выражений</h1>

    <h2>1. Расширение файла и 2. Тип файла</h2>
    <p>Файл: <b><?= $testFile1 ?></b></p>
    <ul>
        <li>Расширение: <?= getFileExtension($testFile1) ?></li>
        <li>Тип: <?= checkFileType($testFile1) ?></li>
    </ul>

    <p>Файл: <b><?= $testFile2 ?></b></p>
    <ul>
        <li>Расширение: <?= getFileExtension($testFile2) ?></li>
        <li>Тип: <?= checkFileType($testFile2) ?></li>
    </ul>

    <hr>

    <h2>Задания 3, 4 и 5: Работа с HTML</h2>
    <p><b>Исходный HTML-код:</b></p>
    <pre><?= htmlspecialchars($testHtml) ?></pre>

    <h3>3. Поиск тега &lt;title&gt;</h3>
    <p>Результат: <b><?= getTitleText($testHtml) ?></b></p>

    <h3>4. Поиск ссылок (href)</h3>
    <pre><?php print_r(getHtmlLinks($testHtml)); ?></pre>

    <h3>5. Поиск картинок (src)</h3>
    <pre><?php print_r(getHtmlImages($testHtml)); ?></pre>

    <hr>

    <h2>6. Подсветка строки (слово "PHP")</h2>
    <p>Исходный текст: <?= $testText ?></p>
    <p>Результат: <?= highlightstring("PHP", $testText) ?></p>

    <hr>

    <h2>7. Замена смайликов</h2>
    <p>Исходный текст: <?= $testEmoji ?></p>
    <p>Результат: <?= replaceEmoji($testEmoji) ?></p>

    <hr>

    <h2>8. Удаление лишних пробелов</h2>
    <p>Исходный текст:</p>
    <pre><?= $testSpaces ?></pre>
    <p>Результат:</p>
    <pre><?= clearSpaces($testSpaces) ?></pre>

</body>
</html>