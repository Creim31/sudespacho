📦 Sudespacho - Proyecto Symfony
(Breve descripción de tu proyecto)

🚀 Requisitos
PHP 8.1 o superior

    Composer 2.x
    Symfony CLI (opcional)
    Base de datos (MySQL/MariaDB)


🛠 Instalación

    1. Clonar el repositorio

    ~~~
    git clone https://github.com/Creim31/sudespacho.git
    cd sudespacho
    ~~~
        
    2. Instalar dependencias

    composer install

    3. Configurar entorno
        Copia el archivo .env y ajusta las variables:

            cp .env .env.test

        Edita .env con tus datos:
            DATABASE_URL="mysql://usuario:contraseña@127.0.0.1:3306/dbsudespacho?serverVersion=mariadb-10.4.32&charset=utf8mb4"

        Edita .env.test con tus datos:
            DATABASE_URL="mysql://usuario:contraseña@127.0.0.1:3306/sudespacho_test?serverVersion=mariadb-10.4.32&charset=utf8mb4"
            (necesario para pruebas unitarias)

    4. Base de datos
        # Crear la base de datos
        php bin/console doctrine:database:create

        # Ejecutar migraciones
        php bin/console doctrine:migrations:migrate

        # En caso creaste mal la base de datos (OPCIONAL)
        php bin/console doctrine:database:drop --force

    5. Base de datos para testUnitarios
        # Crear la base de datos de pruebas
        php bin/console doctrine:database:create --env=test   
        
        # Ejecutar migraciones de pruebas
        php bin/console doctrine:migrations:migrate --env=test -n


    6. Puedes ejecutar Postman

        6.1 Creacion de producto

            POST http://localhost/sudespacho/public/api/productos       (host debes cambiarlo)
            Authorization: Bearer admintoken
            Content-Type: application/json

            {
                "nombre": "Producto prueba5",
                "descripcion": "Descripción5",
                "precio_sin_iva": 111,
                "tipo_iva": 21
            }
        
        6.2 Listar productos

            GET http://localhost/sudespacho/public/api/productos?pagina=1&limite=3      (host debes cambiarlo)
            Accept: application/json
    
    7. Ejecutar pruebas unitarias 

        cd sudespach
        ./vendor/bin/phpunit tests/Controller/ProductControllerTest.php

    Comandos útiles
        Comando	Descripción
        php bin/console cache:clear	Limpiar caché
   