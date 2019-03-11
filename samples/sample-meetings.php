<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Widactic\Client as ArtemusClient;
use Widactic\Meeting as ArtemusMeeting;
use Widactic\Participant as ArtemusParticipant;

$key = "ocCIXzd6N5Jj";
$secret = "eaTH4UAhrnKpncftkJPl61gLmFCKZGq9BsXkG2xLuvmubjoySe3BM8tHO30V81sr0qRxYoRwOZVS7fwPDTI7hgEd5v";


ArtemusClient::init($key, $secret, "http://artemus.lan/api/external/");

$meetings = ArtemusMeeting::collection();
$meetings->setQueryFilter("formation", "test_de_formation");
//$meetings->setQueryFilter("since", "");
$meetings->fetch();

foreach( $meetings->getEntries() as $meeting )
{
    /**
     * @var \Widactic\Meeting $meeting
     */
    foreach( $meeting->getParticipants() as $participant )
    {

        $user = $participant->getUser();

        // Participant non associé à un utilisateur
        if( !$user->exists() )
        {
            $user->setEntity("samsung");
            $user->setField("id_samsung", 100);

            $participant->save();
        }

        // Récupération des résultats
        if( $module = $participant->getLastResultAtIndex(1) )
        {
            print_r($module->getAnswers());
        }
    }
}