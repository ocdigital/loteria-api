<?php

use PHPUnit\Framework\TestCase;
use App\Services\TripulanteService;
use App\Models\Tripulante;

class TripulanteServiceTest extends TestCase {
    private $tripulanteService;
    private $tripulanteMock;

    protected function setUp(): void {
        parent::setUp();

        $this->tripulanteMock = $this->createMock(Tripulante::class);

        $this->tripulanteMock->method('setNome')->willReturnSelf();
        $this->tripulanteMock->method('setEmail')->willReturnSelf();
        $this->tripulanteMock->method('getAll')->willReturn([
            ['nome' => 'Tripulante 1', 'email' => 'tripulante1@example.com'],
            ['nome' => 'Tripulante 2', 'email' => 'tripulante2@example.com']
        ]);

        $this->tripulanteService = new TripulanteService($this->tripulanteMock);
    }

    public function testCreateSuccess() {
        $this->tripulanteMock->expects($this->once())
            ->method('create')
            ->willReturn(true);

        $this->tripulanteMock->expects($this->once())
            ->method('setNome')
            ->with('Tripulante Test');
        $this->tripulanteMock->expects($this->once())
            ->method('setEmail')
            ->with('test@example.com');

        $result = $this->tripulanteService->create('Tripulante Test', 'test@example.com');
        $this->assertTrue($result);
    }

    public function testCreateFailure() {
        $this->tripulanteMock->expects($this->once())
            ->method('create')
            ->willReturn(false);

        $this->tripulanteMock->expects($this->once())
            ->method('setNome')
            ->with('Tripulante Test');
        $this->tripulanteMock->expects($this->once())
            ->method('setEmail')
            ->with('test@example.com');

        $result = $this->tripulanteService->create('Tripulante Test', 'test@example.com');
        $this->assertFalse($result);
    }

    public function testGetAll() {
        $result = $this->tripulanteService->getAll();
        $expected = [
            ['nome' => 'Tripulante 1', 'email' => 'tripulante1@example.com'],
            ['nome' => 'Tripulante 2', 'email' => 'tripulante2@example.com']
        ];
        $this->assertEquals($expected, $result);
    }
}
