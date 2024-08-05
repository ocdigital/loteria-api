<?php

use PHPUnit\Framework\TestCase;
use App\Services\SorteioService;
use App\Models\Sorteio;
use App\Helpers\NumberHelper;

class SorteioServiceTest extends TestCase {
    private $sorteioService;
    private $sorteioMock;
    private $numberHelperMock;

    protected function setUp(): void {
        parent::setUp();
    
        $this->sorteioMock = $this->createMock(Sorteio::class);
        $this->numberHelperMock = $this->createMock(NumberHelper::class);
    
        $this->numberHelperMock->method('gerarNumerosAleatorios')
            ->willReturn('1,2,3,4,5,6');
    
        $this->sorteioMock->method('create')->willReturn(true);
        $this->sorteioMock->method('getAll')->willReturn([
            ['id' => 1, 'bilhete_premiado' => 'Bilhete 1'],
            ['id' => 2, 'bilhete_premiado' => 'Bilhete 2']
        ]);
        $this->sorteioMock->method('getById')->willReturn(['id' => 1, 'bilhete_premiado' => 'Bilhete 1']);
    
        $this->sorteioService = new SorteioService($this->sorteioMock, $this->numberHelperMock);
    }

    public function testCreate() {
        $this->sorteioMock->expects($this->once())
            ->method('setBilhetePremiado')
            ->with('1,2,3,4,5,6');

        $this->sorteioMock->expects($this->once())
            ->method('create')
            ->willReturn(true);

        $result = $this->sorteioService->create();
        $this->assertTrue($result);
    }

    public function testGetAll() {
        $result = $this->sorteioService->getAll();
        $expected = [
            ['id' => 1, 'bilhete_premiado' => 'Bilhete 1'],
            ['id' => 2, 'bilhete_premiado' => 'Bilhete 2']
        ];
        $this->assertEquals($expected, $result);
    }

    public function testGetById() {
        $result = $this->sorteioService->getById(1);
        $expected = ['id' => 1, 'bilhete_premiado' => 'Bilhete 1'];
        $this->assertEquals($expected, $result);
    }
}
