<?php

namespace App\Database;

require_once 'vendor/autoload.php';

use App\Database\Connection;
use App\Database\Migration;

$pdo = Connection::getInstance();

$migration = new Migration($pdo);
$migration->migrate();