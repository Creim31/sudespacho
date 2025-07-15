<?php
namespace App\Tests\Controller;

use App\Core\Application\ProductoService;
use App\Core\Ports\Persistence\ProductoRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
 
public function testListadoProductos(): void
    {
        $client = static::createClient();
        
        // 1. Crear mock del repositorio
        $repoMock = $this->createMock(ProductoRepositoryInterface::class);
        $repoMock->method('listarTodos')->willReturn([/* datos de prueba */]);
        $repoMock->method('contar')->willReturn(1);
        
        // 2. Crear instancia del servicio con el mock
        $productoService = new ProductoService($repoMock);
        
        // 3. Registrar el servicio en el contenedor usando el nombre de la clase como ID
        self::getContainer()->set(ProductoService::class, $productoService);
        
        // 4. Hacer la petición
        $client->request('GET', '/api/productos');
        
        // 5. Aserciones
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
        
        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('total', $data);
    }


}