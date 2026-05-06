<?php
$regex1 = '/^-?\d+$/';

$regex2 = '/^[a-zA-Z0-9]+$/';

$regex3 = '/^[a-zа-яё0-9]+$/iu';

$regex4 = '/^[a-z0-9.-]+\.[a-z]{2,}$/i';

$regex5 = '/^[a-zA-Z][a-zA-Z0-9]{2,24}$/';

$regex6 = '/^[a-zA-Z0-9]+$/';

$regex7 = '/^[a-zA-Z0-9\W]{8,}$/';

$regex8 = '/^\d{4}-\d{2}-\d{2}$/';

$regex9 = '#^\d{2}/\d{2}/\d{4}$#';

$regex10 = '/^\d{2}\.\d{2}\.\d{4}$/';

$regex11 = '/^([01]\d|2[0-3])(:[0-5]\d){2}$/';

$regex12 = '/^([01]\d|2[0-3]):[0-5]\d$/';

$regex13 = '#^https?://[a-z0-9.-]+\.[a-zA-Z]{2,}(/.*)?$#i';

$regex14 = '/^[a-zA-Z0-9._-]+@[a-z0-9.-]+\.[a-z]{2,}$/i';

$regex15 = '/^\d{1,3}(\.\d{1,3}){3}$/';

$regex16 = '/^([0-9a-f]{1,4}:){7}[0-9a-f]{1,4}$/i';

$regex17 = '/^([0-9a-f]{2}:){5}[0-9a-f]{2}$/i';

$regex18 = '/^\+7\d{10}$/';

$regex19 = '/^\d{4}\s\d{4}\s\d{4}\s\d{4}$/';

$regex20 = '/^(\d{10}|\d{12})$/';

$regex21 = '/^\d{6}$/';

$regex22 = '/^\d+,\d{2}\sруб\.$/iu';

$regex23 = '/^\$\d+\.\d{2}$/';

$link = 'https://bki.forlabs.ru/app/learning/205/studies/10826/tasks/6852';
echo $link . '<br>';

if (preg_match($regex13, $link)) {
    echo "Working link";
} else {
    echo "Not working link";
}
?>
