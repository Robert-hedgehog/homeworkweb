<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart home</title>
</head>
<body>
    <?php

    require_once 'oop.php';
    $basicDevice = new Device("Яндекс", "Станция миди", "YS-23234");

    echo "Производитель: " . $basicDevice->getBrand() . "<br>";
    echo "Модель: " . $basicDevice->getModel() . "<br>";
    echo "Полное название: " . $basicDevice->getFullDeviceName() . "<br>";
    echo "Текущий серийный номер: " . $basicDevice->getSerialNumber() . "<br>";
    $basicDevice->setSerialNumber("YAI-564476");
    echo "Измененный серийный номер: " . $basicDevice->getSerialNumber() . "<br>";

    $lamp = new SmartLamp("Яндекс", "Е27_RGB", "987879", "Гостиная");
    echo $lamp->getInfo() . "<br>";
    $lamp->checkStatus(true);
    $lamp->checkStatus(false);

    $scene = new Automation();
    $scene->create();

    ?>
</body>
</html>