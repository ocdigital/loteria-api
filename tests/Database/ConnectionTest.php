<?php

namespace Tests\Database;

use PHPUnit\Framework\TestCase;
use App\Database\Connection;
use PDO;

class ConnectionTest extends TestCase
{
    public function testConnection()
    {
        $connection = Connection::getInstance();
        $this->assertInstanceOf(PDO::class, $connection);
    }
}