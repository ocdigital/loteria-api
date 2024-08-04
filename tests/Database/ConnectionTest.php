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

    public function testConnectionFail()
    {
        // Resetando a instância usando Reflection
        $reflection = new \ReflectionClass(Connection::class);
        $property = $reflection->getProperty('instance');
        $property->setAccessible(true);
        $property->setValue(null);

        // Capturando a saída do erro
        ob_start();
        $connection = Connection::getInstance();
        $output = ob_get_clean();

        // Verificando se a mensagem de erro foi impressa
        $this->assertStringContainsString('Connection failed', $output);
    }
}