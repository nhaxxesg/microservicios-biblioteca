¡Claro! Aquí tienes una propuesta de Especificación de Requisitos de Software (SRS) para un microservicio de Préstamos de Libros en Laravel.

---

## Especificación de Requisitos de Software (SRS): Microservicio de Préstamos de Libros 📚➡️👤

**Versión:** 1.0
**Fecha:** 2025-05-28

### 1. Introducción

#### 1.1. Propósito

El propósito de este documento es describir los requisitos funcionales y no funcionales del **Microservicio de Préstamos de Libros**. Este microservicio se encargará de gestionar el ciclo de vida de los préstamos de libros, incluyendo su creación, actualización (ej. registro de devolución), listado y finalización o cancelación (eliminación lógica).

#### 1.2. Alcance

Este microservicio permitirá:
* Crear nuevos registros de préstamos de libros, asociando un libro (implícito, se necesitará un `libro_id`) y un usuario.
* Registrar la fecha de préstamo y la fecha prevista de devolución.
* Gestionar el estado del préstamo (ej. activo, devuelto, retrasado).
* Actualizar los detalles del préstamo, como la fecha real de devolución.
* Listar todos los préstamos o filtrar por usuario.
* Realizar una eliminación lógica de registros de préstamo (para casos de cancelación o para mantener el historial).
* Opcionalmente, vincular un préstamo a un registro de sanción (`sancion_id`), si un préstamo está relacionado con una sanción existente o si una sanción se genera debido a este préstamo (ej. por retraso).

**No está dentro del alcance de este microservicio:**
* La gestión del catálogo de libros (se asume un `libro_id` proveniente de otro servicio/sistema).
* La gestión detallada de usuarios (se asume un `user_id` proveniente de otro servicio/sistema).
* La gestión detallada de sanciones (se asume que `sancion_id` es una referencia a un servicio/sistema de sanciones). La lógica de *crear* una sanción por un préstamo retrasado podría estar en este servicio o en el de sanciones, dependiendo de la arquitectura.
* La lógica de negocio compleja sobre disponibilidad de libros o políticas de préstamo avanzadas (se enfoca en el registro del préstamo).

#### 1.3. Definiciones, Acrónimos y Abreviaturas

* **SRS:** Software Requirements Specification (Especificación de Requisitos de Software)
* **API:** Application Programming Interface (Interfaz de Programación de Aplicaciones)
* **CRUD:** Create, Read, Update, Delete
* **JSON:** JavaScript Object Notation

---

### 2. Descripción General

#### 2.1. Perspectiva del Producto

El Microservicio de Préstamos de Libros es un componente central en un sistema de gestión bibliotecaria. Se integra con servicios de usuarios, catálogo de libros y, potencialmente, un servicio de sanciones para registrar y rastrear qué libros están prestados, a quién y hasta cuándo.

#### 2.2. Funciones del Producto

Las funciones principales son:
* **Registro de Préstamos:** Crear y almacenar información detallada de cada préstamo.
* **Seguimiento de Préstamos:** Actualizar el estado y las fechas relevantes a medida que el préstamo progresa (ej. devolución).
* **Consulta de Préstamos:** Facilitar la visualización de préstamos activos o históricos, tanto de forma general como por usuario.
* **Gestión del Ciclo de Vida:** Manejar la finalización o cancelación de préstamos.

#### 2.3. Características de los Usuarios

* **Bibliotecarios/Administradores:** Tendrán permisos para crear, actualizar, listar todos y gestionar el ciclo de vida de los préstamos.
* **Usuarios del Sistema:** Podrán ver el listado de sus propios préstamos (activos e históricos).
* **Otros Microservicios:** Podrían consultar este servicio para verificar el estado de un libro o los préstamos de un usuario.

#### 2.4. Restricciones Generales

* El microservicio será desarrollado utilizando el framework **Laravel**.
* La comunicación se realizará preferentemente mediante APIs RESTful.
* Se utilizará el mecanismo de "Soft Deletes" de Laravel para la eliminación lógica.

#### 2.5. Suposiciones y Dependencias

* Existe un sistema/servicio de gestión de usuarios que proporciona un `user_id` único y válido.
* Existe un sistema/servicio de catálogo de libros que proporciona un `libro_id` único y válido.
* (Opcional pero recomendado) Existe un sistema/servicio de sanciones si se va a utilizar el campo `sancion_id` de manera activa para vincular préstamos con sanciones específicas.
* Las políticas de préstamo (ej. duración máxima, número máximo de libros por usuario) pueden ser validadas por este servicio o por un servicio de reglas de negocio superior. Este SRS se enfoca en el registro.



### 3. Requisitos Específicos

#### 3.1. Requisitos Funcionales

##### 3.1.1. RF-001: Crear Préstamo

* **Descripción:** El sistema permitirá registrar un nuevo préstamo de libro.
* **Entradas:**
    * `libro_id` (obligatorio, ID del libro a prestar).
    * `user_id` (obligatorio, ID del usuario que recibe el préstamo).
    * `fecha_prestamo` (obligatorio, DATE o TIMESTAMP, fecha en que se realiza el préstamo, por defecto puede ser la actual).
    * `fecha_devolucion_prevista` (obligatorio, DATE o TIMESTAMP, fecha esperada para la devolución).
    * `estado` (obligatorio, VARCHAR, estado inicial, ej. "activo").
    * `sancion_id` (opcional, ID de una sanción relacionada si aplica).
* **Proceso:**
    1.  Validar los datos de entrada (ej. `user_id` y `libro_id` existen y son válidos, `libro_id` está disponible para préstamo - esta última podría ser una consulta a otro servicio o una lógica interna si este servicio gestiona inventario).
    2.  (Opcional) Verificar si el usuario tiene sanciones activas que impidan el préstamo (consultando el servicio de sanciones).
    3.  Registrar el nuevo préstamo en la base de datos.
* **Salidas:**
    * Confirmación de la creación con los datos del préstamo creado (incluyendo su ID).
    * Mensaje de error si la validación falla o si el préstamo no puede realizarse.

##### 3.1.2. RF-002: Actualizar Préstamo

* **Descripción:** El sistema permitirá modificar los detalles de un préstamo existente, principalmente para registrar una devolución o cambiar su estado.
* **Entradas:**
    * ID del préstamo a actualizar (obligatorio).
    * Campos opcionales a actualizar:
        * `fecha_devolucion_real` (DATE o TIMESTAMP, cuando el libro es devuelto).
        * `estado` (ej. "devuelto", "retrasado", "renovado", "cancelado").
        * `fecha_devolucion_prevista` (si se permite renovación).
        * `sancion_id` (si se genera una sanción por retraso y se quiere vincular).
* **Proceso:**
    1.  Buscar el préstamo por su ID.
    2.  Validar los nuevos datos.
    3.  Actualizar los campos proporcionados. Si se registra `fecha_devolucion_real`, el `estado` típicamente cambiará a "devuelto".
    4.  (Opcional) Si el préstamo se devuelve tarde, se podría disparar un evento o lógica para crear/registrar una sanción.
* **Salidas:**
    * Confirmación de la actualización con los datos del préstamo modificado.
    * Mensaje de error si el préstamo no se encuentra o la validación falla.

##### 3.1.3. RF-003: Listar Préstamos por Usuario

* **Descripción:** El sistema permitirá listar todos los préstamos (no eliminados lógicamente) asociados a un `user_id` específico.
* **Entradas:**
    * `user_id` (obligatorio).
    * Parámetros opcionales de paginación y filtro (ej. por `estado`, activos, históricos).
* **Proceso:**
    1.  Consultar la base de datos para obtener los préstamos que coincidan con el `user_id` y otros filtros.
* **Salidas:**
    * Lista de préstamos con sus detalles.
    * Información de paginación si aplica.

##### 3.1.4. RF-004: Eliminar Lógicamente un Préstamo (Finalizar/Cancelar)

* **Descripción:** El sistema permitirá marcar un préstamo como eliminado lógicamente. Esto puede usarse para cancelar un préstamo antes de que se efectúe o para archivar préstamos muy antiguos si no se desea que aparezcan en listados activos. No es el flujo normal de "devolución".
* **Entradas:**
    * ID del préstamo a eliminar (obligatorio).
* **Proceso:**
    1.  Buscar el préstamo por su ID.
    2.  Establecer el campo `deleted_at` con la fecha y hora actual (manejado por SoftDeletes de Laravel). El `estado` también podría cambiarse a "cancelado".
* **Salidas:**
    * Confirmación de la eliminación lógica.
    * Mensaje de error si el préstamo no se encuentra.

##### 3.1.5. RF-005: Listar Todos los Préstamos (Admin)

* **Descripción:** El sistema permitirá a un administrador listar todos los préstamos, con opciones de filtrado y paginación.
* **Entradas (Opcionales para filtrado/paginación):**
    * `user_id`
    * `libro_id`
    * `estado`
    * Rango de `fecha_prestamo` / `fecha_devolucion_prevista`
    * `incluir_eliminados` (booleano)
    * Parámetros de paginación.
* **Proceso:**
    1.  Recuperar los préstamos de la base de datos aplicando los filtros.
* **Salidas:**
    * Lista de préstamos que coincidan con los criterios.
    * Información de paginación.

##### 3.1.6. RF-006: Ver Detalle de Préstamo

* **Descripción:** El sistema permitirá ver los detalles completos de un préstamo específico.
* **Entradas:**
    * ID del préstamo.
* **Proceso:**
    1.  Buscar el préstamo por su ID.
* **Salidas:**
    * Detalles completos del préstamo.
    * Mensaje de error si no se encuentra.

#### 3.2. Modelo de Datos

* **Tabla:** `prestamos`
    * `id`: BIGINT, UNSIGNED, Primary Key, Auto-increment.
    * `libro_id`: BIGINT, UNSIGNED (o el tipo de dato correspondiente al ID del libro). No nulo. Indexado.
    * `user_id`: BIGINT, UNSIGNED (o el tipo de dato correspondiente al ID de usuario). No nulo. Indexado.
    * `sancion_id`: BIGINT, UNSIGNED. Nulo. Indexado. (FK a tabla/servicio de sanciones).
    * `fecha_prestamo`: TIMESTAMP. No nulo.
    * `fecha_devolucion_prevista`: TIMESTAMP. No nulo.
    * `fecha_devolucion_real`: TIMESTAMP. Nulo. (Se llena al devolver el libro).
    * `estado`: VARCHAR(50). No nulo. (Ej: "activo", "devuelto", "retrasado", "renovado", "cancelado"). Indexado.
    * `created_at`: TIMESTAMP. Gestionado por Laravel.
    * `updated_at`: TIMESTAMP. Gestionado por Laravel.
    * `deleted_at`: TIMESTAMP. Nulo por defecto. Gestionado por Laravel (SoftDeletes).

#### 3.3. Requisitos de Interfaz Externa (API Endpoints)

* **`POST /api/prestamos`**
    * **Descripción:** Crea un nuevo préstamo (RF-001).
    * **Autenticación:** Requerida (permisos de bibliotecario/administrador).
    * **Request Body (JSON):** `{ "libro_id": 1, "user_id": 1, "fecha_prestamo": "YYYY-MM-DD HH:MM:SS", "fecha_devolucion_prevista": "YYYY-MM-DD HH:MM:SS", "estado": "activo", "sancion_id": null }`
    * **Success Response (201 Created):** Datos del préstamo creado.

* **`PUT /api/prestamos/{id}`**
    * **Descripción:** Actualiza un préstamo existente (RF-002).
    * **Autenticación:** Requerida (permisos de bibliotecario/administrador).
    * **Path Parameter:** `id` (ID del préstamo).
    * **Request Body (JSON):** `{ "fecha_devolucion_real": "...", "estado": "devuelto", "sancion_id": 2 }` (campos opcionales)
    * **Success Response (200 OK):** Datos del préstamo actualizado.

* **`GET /api/prestamos/usuario/{user_id}`**
    * **Descripción:** Lista los préstamos para un usuario específico (RF-003).
    * **Autenticación:** Requerida (permisos de administrador o el propio usuario).
    * **Path Parameter:** `user_id`.
    * **Query Parameters:** `page`, `per_page`, `estado`.
    * **Success Response (200 OK):** Lista paginada de préstamos.

* **`GET /api/prestamos`**
    * **Descripción:** Lista todos los préstamos (RF-005).
    * **Autenticación:** Requerida (permisos de administrador).
    * **Query Parameters:** `page`, `per_page`, `estado`, `user_id`, `libro_id`, `incluir_eliminados`.
    * **Success Response (200 OK):** Lista paginada de préstamos.

* **`GET /api/prestamos/{id}`**
    * **Descripción:** Obtiene el detalle de un préstamo específico (RF-006).
    * **Autenticación:** Requerida.
    * **Path Parameter:** `id`.
    * **Success Response (200 OK):** Datos del préstamo.

* **`DELETE /api/prestamos/{id}`**
    * **Descripción:** Realiza una eliminación lógica del préstamo (RF-004).
    * **Autenticación:** Requerida (permisos de administrador).
    * **Path Parameter:** `id`.
    * **Success Response (204 No Content o 200 OK con mensaje).**

#### 3.4. Requisitos No Funcionales

* **RNF-001: Rendimiento:** Las consultas de listado deben ser eficientes. Las operaciones CUD deben ser rápidas.
* **RNF-002: Escalabilidad:** El servicio debe poder escalar para manejar un gran volumen de préstamos y usuarios.
* **RNF-003: Disponibilidad:** El servicio debe tener alta disponibilidad.
* **RNF-004: Seguridad:**
    * HTTPS para todas las comunicaciones API.
    * Autenticación y autorización adecuadas para proteger los endpoints.
    * Prevención de vulnerabilidades comunes.
* **RNF-005: Mantenibilidad:** Código claro, bien documentado, siguiendo estándares de Laravel, y con pruebas.
* **RNF-006: Logging:** Registrar eventos críticos, errores y accesos para auditoría y depuración.
* **RNF-007: Integridad de Datos:** Asegurar la consistencia de los datos referenciales (`user_id`, `libro_id`, `sancion_id`) y las fechas.

#### 3.5. Integración con Otros Servicios

* **Servicio de Gestión de Usuarios:** Para validar `user_id`.
* **Servicio de Catálogo de Libros:** Para validar `libro_id` y obtener información del libro (ej. título para mostrar en listados, verificar disponibilidad).
* **Servicio de Sanciones:**
    * Para consultar si un usuario tiene sanciones activas que impidan nuevos préstamos (antes de llamar a RF-001).
    * Para registrar una nueva sanción si un préstamo se retrasa (este microservicio podría emitir un evento que el servicio de sanciones consuma, o llamar directamente a una API del servicio de sanciones).
    * Para referenciar una sanción existente en el campo `sancion_id` del préstamo.