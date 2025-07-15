📦 Sudespacho - Proyecto Symfony
(Breve descripción de tu proyecto)

🚀 Requisitos
PHP 8.1 o superior

    Composer 2.x
    Symfony CLI (opcional)
    Base de datos (MySQL/MariaDB, PostgreSQL, etc.)
    Node.js (si usas Webpack/Encore)

🛠 Instalación

    1. Clonar el repositorio

    ~~~
    git clone https://github.com/Creim31/sudespacho.git
    cd sudespacho
    ~~~
        
    2. Instalar dependencias

    composer install
    npm install  # Solo si usas JavaScript/Webpack

    3. Configurar entorno
        Copia el archivo .env y ajusta las variables:

            cp .env .env.local

        Edita .env.local con tus datos:
            DATABASE_URL="mysql://usuario:contraseña@127.0.0.1:3306/nombre_bd"
            APP_ENV=dev
            APP_SECRET=tu_clave_secreta

    4. Base de datos
        # Crear la base de datos
        php bin/console doctrine:database:create

        # Ejecutar migraciones
        php bin/console doctrine:migrations:migrate

        # Opcional: Cargar datos de prueba
        php bin/console doctrine:fixtures:load

    5. Iniciar servidor
        symfony server:start  # Usando Symfony CLI

        php -S 127.0.0.1:8000 -t public