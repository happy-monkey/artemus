<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Artemus\Client as ArtemusClient;
use Artemus\Meeting as ArtemusMeeting;
use Artemus\Participant as ArtemusParticipant;

$key = "ocCIXzd6N5Jj";
$secret = "eaTH4UAhrnKpncftkJPl61gLmFCKZGq9BsXkG2xLuvmubjoySe3BM8tHO30V81sr0qRxYoRwOZVS7fwPDTI7hgEd5v";


ArtemusClient::init($key, $secret, "http://artemus.lan/api/external/");

$meeting = new ArtemusMeeting(25);

foreach( $meeting->getUsers() as $participant )
{
    $user = $participant->getUser();

    // Participant non associé à un utilisateur
    if( !$user->exists() )
    {
        $user->setEntity("samsung");
        $user->setField("id_samsung", 100);

        $participant->save();
    }
}

$participants = ArtemusParticipant::collection($meeting->getUsers());
print_r($participants->toArray());