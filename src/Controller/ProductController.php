<?php

namespace App\Controller;

use App\Core\Application\ProductoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{

    private const ALLOWED_IVA_TYPES = ['SUPERREDUCED' => 4, 'REDUCED' => 10, 'GENERAL' => 21];
    private const AUTH_TOKEN = 'admintoken';


    public function __construct(private ProductoService $productoService) {}
    
    #[Route('/api/productos', name: 'productos_listado', methods: ['GET'])]
    public function listado(Request $request): JsonResponse
    {
        $resultado = $this->productoService->listarProductos(
            $request->query->getInt('pagina', 1),
            $request->query->getInt('limite', 10),
            $request->query->get('filtro')
        );
        
        return $this->json($resultado);
    }

    #[Route('/api/productos', name: 'productos_crear', methods: ['POST'])]
    public function create(Request $request): JsonResponse
     {
        // 1. Verificar autenticación
        $authHeader = $request->headers->get('Authorization');
        
        if ($authHeader !== 'Bearer '.self::AUTH_TOKEN) {
            return $this->json(
                ['error' => 'Acceso no autorizado. Token requerido.'],
                Response::HTTP_UNAUTHORIZED
            );
        }

        // 2. Verificar conexión básica
        try {
            return $this->json(
                ['message' => 'Conexión exitosa. Autenticación válida.'],
                Response::HTTP_OK
            );
            
        } catch (\Exception $e) {
            return $this->json(
                ['error' => 'Error de conexión: '.$e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
   
}
