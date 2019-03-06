<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Artemus\Client as ArtemusClient;
use Artemus\Field as ArtemusField;

$key = "ocCIXzd6N5Jj";
$secret = "eaTH4UAhrnKpncftkJPl61gLmFCKZGq9BsXkG2xLuvmubjoySe3BM8tHO30V81sr0qRxYoRwOZVS7fwPDTI7hgEd5v";


ArtemusClient::init($key, $secret, "http://artemus.lan/api/external/");

$field = new ArtemusField();
$field->setApiName("magasin");

$field->addValue("Darty", 1);
$field->addValue("FNAC", 2);
$field->addValue("Boulanger", 3);
$field->save();
