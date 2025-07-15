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

//    #[Route('/api/productos', name: 'productos_crear', methods: ['POST'])]
//     public function create(Request $request,ProductService $productService): JsonResponse {
//         // Verificar autenticación
//         $authHeader = $request->headers->get('Authorization');
//         if ($authHeader !== 'Bearer admintoken') {
//             return $this->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
//         }
        
//         $data = json_decode($request->getContent(), true);
        
//         try {
//             $producto = $productService->createProduct(
//                 $data['nombre'],
//                 $data['descripcion'],
//                 (float) $data['precio_sin_iva'],
//                 $data['tipo_iva']
//             );
            
//             return $this->json([
//                 'id' => $producto->getId(),
//                 'nombre' => $producto->getNombre(),
//                 'precio_con_iva' => $producto->getPrecioConIva()
//             ], Response::HTTP_CREATED);
//         } catch (\InvalidArgumentException $e) {
//             return $this->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
//         }
//     }

}
