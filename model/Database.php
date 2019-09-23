<?php

namespace login\model;

class Database {
    private $connection;
    private $settings;
    private $userCheck;
    private $pwdCheck;

    public function __construct () {
        $serverName = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        if ($serverName == 'localhost') {
            $this->settings = new \login\LocalSettings();
        } else {
            $this->settings = new \login\ProductionSettings();
        }
    }
    
    public function connect () {
        $this->connection = mysqli_connect($this->settings->DB_HOST, $this->settings->DB_USERNAME, 
        $this->settings->DB_PASSWORD, $this->settings->DB_NAME);

        if (!$this->connection) {
            echo "Connection failed " . mysqli_connect_error();
        }

        return $this->connection;
    }

    public function isUserValid (string $username, string $password) {
        $query = "SELECT * FROM users WHERE username = ? and password = ?";

        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('ss', $username, $password);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row['username'] == $username && $row['password'] == $password) {
            return true;
        } else {
            return false;
        }
    }
}

