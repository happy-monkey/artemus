<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Artemus\Client;
use Artemus\User;

$key = "roW8nBTiJwzb";
$secret = "hbXr6M827c5eRJgSKlY0AuqxYsKEydDHjWO8sCQ3LhatIyJlixpv1ZNaVwtzipBo2nQonTFdgz7kmZLfXEUq9jbWrR";


Client::init($key, $secret);

// ===== GET ALL USERS ===== //
//*
$users = User::collection();
$users->fetch("samsung");

print_r($users->toArray());
//*/


// ===== GET AN USER AND UPDATE FIRSTNAME ===== //
//*
if( $user = new User(10) )
{
    $user->setFirstname("John");
    $user->setLastname("Doe");
    $user->setField("code_user", 21);
    $user->save();

    print_r($user->toArray());
}
//*/


// ===== CREATE A NEW USER ===== //
//*
$user = new User();
$user->setFirstname("Test API Composer");
$user->setLastname("Nom de famille");
$user->setEmail("test@artemus.fr");
$user->save();
echo $user->getId();
//*/


// ===== SYNC AN USER FROM A FIELD ===== //
//*
$user = new User();
$user->setFirstname("John");
$user->setLastname("Doe");
$user->setField("code_user", 20);
$user->setEmail("john.doe@gmail.com");
$user->sync("code_user");

print_r($user->toArray());
//*/





// ===== BULK SYNC ===== //
//*
// Get db users
$dbUsers = [
    [
        "id" => 10000,
        "firstname" => "John",
        "lastname" => "Doe",
        "email" => "john.doe@gmail.com"
    ],
    [
        "id" => 10001,
        "firstname" => "Marcel",
        "lastname" => "Vincent",
        "email" => "marcel.vincent@gmail.com"
    ]
];

// Create collection
$users = User::collection();

foreach( $dbUsers as $dbUser )
{
    $user = new User();
    $user->setFirstname($dbUser["firstname"]);
    $user->setLastname($dbUser["lastname"]);
    $user->setEmail($dbUser["email"]);
    $user->setGroups(["samsung"]);
    $user->setField("code_user", $dbUser["id"]);
    $users->add($user);
}

// Sync collection with db using field code_user
$users->sync("code_user");

// Print result
print_r($users->toArray());
//*/