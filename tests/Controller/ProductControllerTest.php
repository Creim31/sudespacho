<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    public function testListadoProductos(): void
    {
        $client = static::createClient();
        
        // Usa la URL EXACTA como aparece en debug:router (con barra final)
        $client->request(
            'GET',
            '/api/productos/?pagina=1&limite=5'  // <- ¡Barra final!
        );

        $this->assertResponseIsSuccessful();
        $this->assertJson($client->getResponse()->getContent());
        
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertIsArray($data);
        $this->assertCount(5, $data); 
    }
}