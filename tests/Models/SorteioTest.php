<?php

use PHPUnit\Framework\TestCase;
use App\Models\Sorteio;

class SorteioTest extends TestCase
{
    private $sorteio;
    private $dbMock;

    protected function setUp(): void
    {
        $this->dbMock = $this->createMock(\PDO::class);
        $this->sorteio = new Sorteio($this->dbMock);
    }

    public function testCreateSuccess()
    {
        $stmtMock = $this->createMock(\PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);

        $this->dbMock->expects($this->once())
            ->method('prepare')
            ->willReturn($stmtMock);

        $this->sorteio->setBilhetePremiado(1);
        
        $result = $this->sorteio->create();
        $this->assertTrue($result);
    }

    public function testCreateFailure()
    {
        $this->dbMock->expects($this->once())
            ->method('prepare')
            ->willThrowException(new \PDOException("Erro ao inserir sorteio."));

        $this->sorteio->setBilhetePremiado(1);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Erro ao inserir sorteio.");

        $this->sorteio->create();
    }

    public function testGetAll()
    {
        $stmtMock = $this->createMock(\PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('fetchAll')->willReturn([
            ['id' => 1, 'bilhete_premiado' => 1],
            ['id' => 2, 'bilhete_premiado' => 2],
        ]);

        $this->dbMock->expects($this->once())
            ->method('prepare')
            ->willReturn($stmtMock);

        $result = $this->sorteio->getAll();
        $this->assertIsArray($result);
        $this->assertCount(2, $result);
    }

    public function testGetById()
    {
        $stmtMock = $this->createMock(\PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('fetch')->willReturn(['id' => 1, 'bilhete_premiado' => 1]);

        $this->dbMock->expects($this->once())
            ->method('prepare')
            ->willReturn($stmtMock);

        $result = $this->sorteio->getById(1);
        $this->assertIsArray($result);
        $this->assertEquals(1, $result['id']);
        $this->assertEquals(1, $result['bilhete_premiado']);
    }

    

}
