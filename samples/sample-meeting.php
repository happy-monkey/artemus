<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Widactic\Client as ArtemusClient;
use Widactic\Meeting as ArtemusMeeting;
use Widactic\Participant as ArtemusParticipant;

$key = "ocCIXzd6N5Jj";
$secret = "eaTH4UAhrnKpncftkJPl61gLmFCKZGq9BsXkG2xLuvmubjoySe3BM8tHO30V81sr0qRxYoRwOZVS7fwPDTI7hgEd5v";


ArtemusClient::init($key, $secret, "http://artemus.lan/api/external/");

$meeting = new ArtemusMeeting(75);

foreach( $meeting->getParticipants() as $participant )
{
    $user = $participant->getUser();

    // Participant non associé à un utilisateur
    if( !$user->exists() )
    {
        $user->setEntity("samsung");
        $user->setField("id_samsung", 100);

        //$participant->setUser($user);
        $participant->save();
    }

    /*
    if( $module = $participant->getLastResultAtIndex(1) )
    {
        print_r($module->getAnswers());
    }*/
}
