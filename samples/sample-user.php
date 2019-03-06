<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Artemus\Client as ArtemusClient;
use Artemus\User as ArtemusUser;

$key = "ocCIXzd6N5Jj";
$secret = "eaTH4UAhrnKpncftkJPl61gLmFCKZGq9BsXkG2xLuvmubjoySe3BM8tHO30V81sr0qRxYoRwOZVS7fwPDTI7hgEd5v";


ArtemusClient::init($key, $secret, "http://artemus.lan/api/external/");



$entry = new ArtemusUser();
$entry->setFirstname("Alexandre");
$entry->setLastname("Chastan");
$entry->setEmail("alex_chastan@artemus.fr");
$entry->setEntity("samsung");
$entry->setField("id_samsung", 1);
$entry->setField("magasin_samsung", "Darty Odysseum", 10);

if( $entry->sync("id_samsung") )
{
    echo "Utilisateur sauvegardé !";
}