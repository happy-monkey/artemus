<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Artemus\Client as ArtemusClient;
use Artemus\User as ArtemusUser;

$key = "ocCIXzd6N5Jj";
$secret = "eaTH4UAhrnKpncftkJPl61gLmFCKZGq9BsXkG2xLuvmubjoySe3BM8tHO30V81sr0qRxYoRwOZVS7fwPDTI7hgEd5v";


ArtemusClient::init($key, $secret);

$users = ArtemusUser::collection();

if( $users->fetch() )
{
    print_r($users->toArray());
}
else
{
    echo "An error has occured";
}