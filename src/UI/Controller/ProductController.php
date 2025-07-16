<?php
// src/UI/Controller/ProductController.php
namespace App\UI\Controller;

use App\Core\Application\UseCase\CreateProductUseCase;
use App\Core\Application\UseCase\ListarProductosUseCase;
use App\UI\Request\CreateProductRequest;
use App\UI\Response\ProductResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/productos')]
class ProductController extends AbstractController
{
    public function __construct(
        private CreateProductUseCase $useCase,
        private ListarProductosUseCase $useCaseList
    ) {}


    #[Route('/', name: 'listado_productos', methods: ['GET'])]
    public function listar(Request $request): JsonResponse
    {
        $pagina = (int)$request->query->get('pagina', 1);
        $limite = (int)$request->query->get('limite', 10);

        // Validación básica de parámetros
        if ($pagina < 1) $pagina = 1;
        if ($limite < 1 || $limite > 100) $limite = 10;

        $resultado = $this->useCaseList->executeList($pagina, $limite);
        // $resultado = $this->productoService->obtenerTodosProductos($pagina, $limite);

        return $this->json($resultado);
    }

    #[Route('', name: 'create_product', methods: ['POST'])]
    public function createProduct(Request $request): JsonResponse {
      // Validar autenticación
        if ($request->headers->get('Authorization') !== 'Bearer admintoken') {
            return new JsonResponse(['error' => 'No autorizado'], 401);
        }

        $data = json_decode($request->getContent(), true);
         // 3. Validar estructura básica del JSON
        if ($data === null) {
            return new JsonResponse(
                ['error' => 'Invalid JSON format'], 
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

       // 4. Validar campos obligatorios
        if (!isset($data['nombre'])) {
            return new JsonResponse(
                ['error' => 'El campo "nombre" es requerido'], 
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        if (!isset($data['precio_sin_iva'])) {
            return new JsonResponse(
                ['error' => 'El campo "precio_sin_iva" es requerido'], 
                JsonResponse::HTTP_BAD_REQUEST
            );
        }


        try {
            $product = $this->useCase->execute(
                $data['nombre'],
                $data['descripcion'] ?? '',
                (float) $data['precio_sin_iva'],
                (int) ($data['tipo_iva'] ?? 21)
            );
            
            return new JsonResponse([
                'id' => $product->getId(),
                'nombre' => $product->getNombre(),
                'precio_con_iva' => $product->getPrecioConIva()
            ], JsonResponse::HTTP_CREATED);

        }catch (\InvalidArgumentException $e) {
            return new JsonResponse(
                ['error' => $e->getMessage()], 
                JsonResponse::HTTP_BAD_REQUEST
            );
        }
        // catch (\Exception $e) {
        //     return new JsonResponse(
        //         ['error' => 'Server error'], 
        //         JsonResponse::HTTP_INTERNAL_SERVER_ERROR
        //     );
        // }







    }
}