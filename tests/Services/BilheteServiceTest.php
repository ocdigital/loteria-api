<?php 

use PHPUnit\Framework\TestCase;
use App\Services\BilheteService;
use App\Models\Bilhete;
use App\Models\Sorteio;
use App\Helpers\NumberHelper;

class BilheteServiceTest extends TestCase
{
    private $bilheteService;
    private $bilheteMock;
    private $sorteioMock;
    private $numberHelperMock;

    protected function setUp(): void
    {
        parent::setUp();
    
        $this->bilheteMock = $this->createMock(Bilhete::class);
        $this->sorteioMock = $this->createMock(Sorteio::class);
        $this->numberHelperMock = $this->createMock(NumberHelper::class);
    
        $this->sorteioMock->method('getById')->willReturn([
            'bilhete_premiado' => '1,2,3,4,5,6'
        ]);
    
        $this->bilheteMock->method('create')->willReturn(true);
        $this->bilheteMock->method('setIdSorteio')->willReturnSelf();
        $this->bilheteMock->method('setIdTripulante')->willReturnSelf();
        $this->bilheteMock->method('setNumeros')->willReturnSelf();
    
        $this->numberHelperMock->method('gerarNumerosAleatorios')->willReturn('1,2,3,4,5,6');

        $this->bilheteService = new BilheteService($this->bilheteMock, $this->sorteioMock, $this->numberHelperMock);
    }

    public function testGetAll()
    {
        $this->sorteioMock->method('getAll')->willReturn([
            ['id' => 1, 'bilhete_premiado' => 'Bilhete 1'],
            ['id' => 2, 'bilhete_premiado' => 'Bilhete 2']
        ]);

        $result = $this->bilheteService->getAll();
        $expected = [
            ['id' => 1, 'bilhete_premiado' => 'Bilhete 1'],
            ['id' => 2, 'bilhete_premiado' => 'Bilhete 2']
        ];

        $this->assertEquals($expected, $result);
    }

    public function testCreate()
    {   
        $this->numberHelperMock->expects($this->once())
            ->method('gerarNumerosAleatorios')
            ->with(true, 6)
            ->willReturn('1,2,3,4,5,6');

        $this->bilheteMock->expects($this->once())
            ->method('setIdSorteio')
            ->with(1)
            ->willReturnSelf();
        $this->bilheteMock->expects($this->once())
            ->method('setIdTripulante')
            ->with(2)
            ->willReturnSelf();
        $this->bilheteMock->expects($this->once())
            ->method('setNumeros')
            ->with('1,2,3,4,5,6')
            ->willReturnSelf();

        $this->bilheteMock->expects($this->exactly(1))
            ->method('create')
            ->willReturn(true);

        $expectedHtml = "<table><th>Números</th></tr><tr><td><span style='color: red; font-weight: bold;'>01</span> <span style='color: red; font-weight: bold;'>02</span> <span style='color: red; font-weight: bold;'>03</span> <span style='color: red; font-weight: bold;'>04</span> <span style='color: red; font-weight: bold;'>05</span> <span style='color: red; font-weight: bold;'>06</span> </td></tr></table>";

        $result = $this->bilheteService->create(1, 2, 6, 1, true);
        $this->assertEquals($expectedHtml, $result);
    }
}
