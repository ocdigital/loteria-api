<?php

namespace App\Database;

use PDO;
use PDOException;

class Connection
{
    private static $instance = null;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            try {
                self::$instance = new PDO('mysql:host=mysql;dbname=loteria', 'loteria', 'password');
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
            }
        }

        return self::$instance;
    }
}