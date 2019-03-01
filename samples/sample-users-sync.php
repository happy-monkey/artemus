<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Artemus\Client as ArtemusClient;
use Artemus\User as ArtemusUser;

$key = "ocCIXzd6N5Jj";
$secret = "eaTH4UAhrnKpncftkJPl61gLmFCKZGq9BsXkG2xLuvmubjoySe3BM8tHO30V81sr0qRxYoRwOZVS7fwPDTI7hgEd5v";


ArtemusClient::init($key, $secret);


// Get users from your database or another source
$users = json_decode(file_get_contents(__DIR__."/users.json"));

// Init a new collection of user
$collection = ArtemusUser::collection();

// Walk through your users to create object with your data.
// You need to create at least one field that will be used for sync
foreach( $users as $user )
{
    $entry = new ArtemusUser();
    $entry->setFirstname($user->firstname);
    $entry->setLastname($user->lastname);
    $entry->setEmail($user->email);
    $entry->setEntity("samsung");
    $entry->setField("id_samsung", $user->id);

    $collection->add($entry);
}

// Sync your data using a field
if( $collection->sync("id_samsung") )
{
    echo "Synchronization ended\n";
    print_r($collection->toArray());
}
else
{
    echo "An error has occured";
}
