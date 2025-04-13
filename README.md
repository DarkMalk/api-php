# API con PHP

Proyecto con la finalidad de aprender y practicar PHP, en el cual se crea una API de notas sencilla con el framework Flight, en el cual se incluye autenticación, rutas protegidas y CRUD para las notas, este se encuentra disponible para conectar con una base de datos MySQL.

# preview

![api-php-preview](./preview/api-php.webp)

# Como instalar y probar

## requisitos:

- PHP
- Composer
- MySQL

# Como instalar PHP y Composer (mac)

Instalar PHP

```bash
brew install php
```

Instalar Composer

```bash
brew install composer
```

# Configurar variables de entorno

Debes configurar los datos requeridos en el archivo `.env`, para esto puedes utilizar el archivo que se encuentra en el proyecto `.env.example` y luego debes renombrarlo con el nombre correspondiente `.env`.

```bash
DB_NAME=""
DB_USER=""
DB_PASSWORD=""
DB_HOST=""
DB_PORT=""

SECRET_KEY=""
```

# Preparar base de datos MySQL

```sql
create table user (
  id int primary key not null auto_increment,
  username varchar(40) not null unique,
  password varchar(255) not null,
  created_at timestamp not null default current_timestamp
);

create table note (
  id int primary key not null auto_increment,
  text varchar(255) not null,
  id_user int not null,
  foreign key (id_user) references user (id)
);
```

# Iniciar servidor de desarrollo

Instalar dependencias con `composer`.
```bash
composer install
```

Puedes utilizar el comando de `php`, indicándole `IP:PUERTO`.

```bash
php -S localhost:8000
```

También podemos utilizar el comando de `composer`

```bash
composer run dev
```

# Rutas y métodos de la API

### Autenticación

- **POST /api/auth/login**

  - Descripción: Inicia sesión y obtiene un token.
  - Códigos de estado: 200 (OK), 401 (Unauthorized)
  - Request Body: `username, password`

- **POST /api/auth/register**
  - Descripción: Crea un usuario en el sistema.
  - Códigos de estado: 201 (Created), 400 (Bad Request)
  - Request Body: `username, password`

### Notas

- **GET /api/notes**

  - Descripción: Obtiene todas las notas del usuario autenticado.
  - Códigos de estado: 200 (OK), 401 (Unauthorized)

- **POST /api/notes**

  - Descripción: Crea una nueva nota.
  - Códigos de estado: 201 (Created), 400 (Bad Request), 401 (Unauthorized)
  - Request Body: `text`

- **GET /api/notes/{id}**

  - Descripción: Obtiene una nota específica del usuario autenticado.
  - Códigos de estado: 200 (OK), 404 (Not Found), 401 (Unauthorized)

- **PUT /api/notes/{id}**

  - Descripción: Actualiza una nota específica del usuario autenticado.
  - Códigos de estado: 200 (OK), 400 (Bad Request), 304 (Not Modified), 401 (Unauthorized)
  - Request Body: `text`

- **DELETE /api/notes/{id}**
  - Descripción: Elimina una nota específica del usuario autenticado.
  - Códigos de estado: 200 (OK), 304 (Not Modified), 401 (Unauthorized)
