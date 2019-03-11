<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Widactic\Client as ArtemusClient;
use Widactic\User as ArtemusUser;

$key = "ocCIXzd6N5Jj";
$secret = "eaTH4UAhrnKpncftkJPl61gLmFCKZGq9BsXkG2xLuvmubjoySe3BM8tHO30V81sr0qRxYoRwOZVS7fwPDTI7hgEd5v";


ArtemusClient::init($key, $secret, "http://artemus.lan/api/external/");


$user = new ArtemusUser(16);
$user->setEmail("john.doe@arteums.com");

if( $user->save() )
{
    echo "User is updated\n";
    print_r($user->toArray());
}
else
{
    echo "An error has occured";
}
