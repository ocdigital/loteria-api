<?php

use PHPUnit\Framework\TestCase;
use App\Models\Bilhete;

class BilheteTest extends TestCase
{
    private $bilhete;
    private $dbMock;

    protected function setUp(): void
    {
        $this->dbMock = $this->createMock(\PDO::class);
        $this->bilhete = new Bilhete($this->dbMock);
    }

    public function testCreateSuccess()
    {
        $stmtMock = $this->createMock(\PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);

        $this->dbMock->expects($this->once())
            ->method('prepare')
            ->willReturn($stmtMock);

        $this->bilhete->setIdSorteio(1);
        $this->bilhete->setIdTripulante(1);
        $this->bilhete->setNumeros('1,2,3,4,5');

        $result = $this->bilhete->create();
        $this->assertTrue($result);
    }

    public function testCreateFailure()
    {
        $this->dbMock->expects($this->once())
            ->method('prepare')
            ->willThrowException(new \PDOException("Erro ao inserir bilhete."));

        $this->bilhete->setIdSorteio(1);
        $this->bilhete->setIdTripulante(1);
        $this->bilhete->setNumeros('1,2,3,4,5');

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Erro ao inserir bilhete.");

        $this->bilhete->create();
    }

    public function testGetAll()
    {
        $stmtMock = $this->createMock(\PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('fetchAll')->willReturn([
            ['id' => 1, 'sorteio_id' => 1, 'tripulante_id' => 1, 'numeros' => '1,2,3,4,5'],
            ['id' => 2, 'sorteio_id' => 1, 'tripulante_id' => 2, 'numeros' => '1,2,3,4,5'],
        ]);

        $this->dbMock->expects($this->once())
            ->method('prepare')
            ->willReturn($stmtMock);
           
            
        $result = $this->bilhete->getAll();
        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertEquals(1, $result[0]['sorteio_id']);
        $this->assertEquals(1, $result[0]['tripulante_id']);
        $this->assertEquals('1,2,3,4,5', $result[0]['numeros']);
        $this->assertEquals(1, $result[1]['sorteio_id']);
        $this->assertEquals(2, $result[1]['tripulante_id']);
        $this->assertEquals('1,2,3,4,5', $result[1]['numeros']);
    }
}

