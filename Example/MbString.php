<?php
use UfoCms\Helpers\Components\MbString;

require_once __DIR__ . '/../src/Components/MbString.php';
require_once __DIR__ . '/../src/Exceptions/HelperContextException.php';

$string = new MbString('Привет Мир');

echo $string->toLowerCase() . PHP_EOL;
echo $string->toUpperCase() . PHP_EOL;
echo $string->toTitleCase() . PHP_EOL;
echo $string->toCamelCase() . PHP_EOL;
echo $string->toSnakeCase() . PHP_EOL;

echo $string->biteSize() . PHP_EOL;
echo $string->mbStrLen() . PHP_EOL;
echo $string->getChar(2) . PHP_EOL;
echo $string->getEncoding() . PHP_EOL;

echo $string->lcFirst() . PHP_EOL;

echo $string->setChar(2, 'ю') . PHP_EOL;
echo $string->ucFirst() . PHP_EOL;

echo $string->removeChar(2) . PHP_EOL;
echo $string[2] . PHP_EOL;
$string[2] = 1;
echo $string[2] . PHP_EOL;
unset($string[2]);

echo $string[2] . PHP_EOL;


echo $string->toLowerCase() . PHP_EOL;
echo count($string) . PHP_EOL;
echo mb_strlen($string) . PHP_EOL;
