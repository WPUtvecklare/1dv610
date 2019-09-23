<?php

namespace login\model;

require_once('model/Exceptions.php');

class AuthenticationSystem {
    private $isLoggedIn;
    private $loggedInUser;
    private $storage;

    public function __construct (\login\model\UserStorage $storage) {
        // Ta in databasen
        $this->storage = $storage;
    }

    public function tryToLogin (\login\model\UserCredentials $userCredentials) : bool {
        $username = $userCredentials->getUsername()->getUsername();
        $password = $userCredentials->getPassword()->getPassword();

        if ($username == 'Admin' && $password == 'Password' ) {
            // Förändra session
            $this->setLoggedInUser($userCredentials->getUsername());
            // $this->isLoggedIn = true;
            return true;
        } else {
            throw new InvalidCredentialsException("Wrong name or password");
            return false;
        }

        // $db = new \login\model\Database();
        // $db-connect();

    }

    public function getIsUserLoggedIn () : bool {
        return $this->isLoggedIn;
    }

    public function getLoggedInUser () {
        return $this->loggedInUser;
    }

    public function setLoggedInUser ($username) {
        $savedUser = $this->storage->saveUser($username);
        $this->loggedInUser = $savedUser;
    }

}


// Try to login

// Isloggedin?

// Get logged in user

// Pratar med UserList som har en koppling till databasen?

// Kanske har en session handler som kan titta i sessionen på rätt plats

// Börja med session innan databasen

// Hårdkoda in Admin och Password
