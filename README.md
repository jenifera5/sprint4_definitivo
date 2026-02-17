# 📚Aplicación web Full-Stack con Laravel y Vite

Sistema web completo para la gestión de una biblioteca virtual, desarrollado con **Laravel 10**, **Laravel Breeze** y arquitectura con **Git Flow**.  
Permite administrar libros, usuarios, préstamos y categorías de manera eficiente e intuitiva.

---

## 🚀 Estado del Proyecto

✅ CRUD completo funcional  
✅ Sistema de autenticación con Laravel Breeze  
✅ Arquitectura Git Flow implementada  
✅ Relaciones Eloquent correctamente configuradas  
✅ Seeders con datos de prueba  
✅ Control automático de disponibilidad de libros  

---

## 🌿 Metodología de Trabajo – Git Flow

Este proyecto utiliza **Git Flow** como estrategia de ramificación:

- `main` → versión estable lista para producción
- `dev` → rama de desarrollo principal
- `feature/*` → nuevas funcionalidades
- `hotfix/*` → correcciones urgentes

Ejemplo de flujo utilizado:

```bash
git checkout -b feature/import-legacy
git add .
git commit -m "feat: implementación completa biblioteca"
git checkout dev
git merge feature/import-legacy
git push origin dev
```

Esto garantiza:
- Desarrollo ordenado
- Historial limpio
- Separación entre versión estable y desarrollo

---

## 🔐 Autenticación – Laravel Breeze

El sistema incluye:

- Registro de usuarios
- Inicio de sesión
- Recordar sesión
- Recuperación de contraseña
- Cierre de sesión
- Protección de rutas con middleware `auth`

Breeze se integró y se adaptó el diseño visual para mantener coherencia con el layout del proyecto.

---

## 🌟 Características Principales

### 📚 Gestión Completa de Libros (CRUD)
- Crear, editar, visualizar y eliminar libros
- Asociar libros a múltiples categorías (relación N:M)
- Control de copias disponibles

### 👥 Administración de Usuarios
- Registro con validación
- Historial completo de préstamos
- Visualización de préstamos activos y devueltos

### 🧾 Sistema de Préstamos
- Crear y gestionar préstamos
- Control automático de disponibilidad
- Marcar préstamos como devueltos
- Incremento automático de copias al devolver

### 🏷️ Organización por Categorías
- Relación N:M libros-categorías
- Filtrado por género
- Asociación múltiple

### 🎨 Interfaz Moderna
- Blade templating
- Tailwind CSS
- Layout reutilizable
- Diseño responsive

---

## 🛠️ Tecnologías Utilizadas

| Tecnología | Uso |
|------------|------|
| Laravel 10 | Framework backend |
| Laravel Breeze | Autenticación |
| Eloquent ORM | Base de datos |
| Blade | Motor de plantillas |
| Tailwind CSS | Estilos |
| MySQL / SQLite | Base de datos |
| Git Flow | Control de versiones |
| PHP 8.1+ | Backend |

---

## 🗂️ Modelo de Datos

### 🧍 usuarios
- id
- nombre
- email
- password

### 📚 libros
- id
- titulo
- autor
- isbn
- disponibles

### 🏷️ categorias
- id
- nombre
- descripcion

### 🔗 libro_categorias (pivot)
- id_libro
- id_categoria

### 🧾 prestamos
- id
- id_usuario
- id_libro
- fecha_prestamo
- fecha_devolucion
- devuelto (boolean)

---

## ⚙️ Instalación

```bash
git clone https://github.com/jenifera5/sprint4.git
cd bibliotecaweb

composer install
cp .env.example .env
php artisan key:generate
```

Configurar base de datos en `.env`

```bash
php artisan migrate:fresh --seed
php artisan serve
```

Abrir:

```
http://127.0.0.1:8000
```

---

## 📌 Comandos Útiles

### Migraciones
```bash
php artisan migrate
php artisan migrate:fresh --seed
```

### Seeders
```bash
php artisan db:seed
```

### Rutas
```bash
php artisan route:list
```

### Limpieza de caché
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

---

## 🔒 Seguridad Implementada

- Protección CSRF
- Hashing de contraseñas (bcrypt)
- Middleware `auth`
- Validación en formularios
- Prevención de SQL Injection (Eloquent)

---

## 📈 Próximas Mejoras

- API REST
- Panel administrador con roles
- Búsqueda avanzada
- Sistema de reservas
- Notificaciones por email
- Tests automatizados

---

## 👩‍💻 Autora

**Jenifer Álvarez**  
Backend Developer (PHP / Laravel)  
GitHub: https://github.com/jenifera5  
Email: jeniferalvarez12@gmail.com

---

## 📄 Licencia

Proyecto académico desarrollado como parte del Sprint 4.
