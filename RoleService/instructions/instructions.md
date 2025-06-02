# Documento de Especificación de Requisitos de Software (SRS) - Microservicio de Gestión de Roles y Autenticación

**Tu Nombre/Equipo de Desarrollo**
**Fecha:** 28 de mayo de 2025

## Tabla de Contenidos
1. [Introducción](#introducción)
   1.1. [Propósito](#propósito)
   1.2. [Alcance](#alcance)
   1.3. [Audiencia](#audiencia)
   1.4. [Definiciones y Acrónimos](#definiciones-y-acrónimos)
   1.5. [Referencias](#referencias)
2. [Requisitos Funcionales](#requisitos-funcionales)
   2.1. [Gestión de Roles](#gestión-de-roles)
      2.1.1. [RF.1: Creación de Roles](#rf1-creación-de-roles)
      2.1.2. [RF.2: Lectura de Roles](#rf2-lectura-de-roles)
      2.1.3. [RF.3: Actualización de Roles](#rf3-actualización-de-roles)
      2.1.4. [RF.4: Eliminación de Roles](#rf4-eliminación-de-roles)
   2.2. [Asignación de Roles a Usuarios](#asignación-de-roles-a-usuarios)
      2.2.1. [RF.5: Asignación de Rol](#rf5-asignación-de-rol)
      2.2.2. [RF.6: Lectura de Roles de un Usuario](#rf6-lectura-de-roles-de-un-usuario)
      2.2.3. [RF.7: Desasignación de Rol](#rf7-desasignación-de-rol)
   2.3. [Autenticación con JWT](#autenticación-con-jwt)
      2.3.1. [RF.8: Generación de Token JWT](#rf8-generación-de-token-jwt)
      2.3.2. [RF.9: Verificación de Token JWT](#rf9-verificación-de-token-jwt)
      2.3.3. [RF.10: Protección de Endpoints](#rf10-protección-de-endpoints)
3. [Requisitos No Funcionales](#requisitos-no-funcionales)
   3.1. [Rendimiento](#rendimiento)
      3.1.1. [RNF.1: Tiempo de Respuesta](#rnf1-tiempo-de-respuesta)
      3.1.2. [RNF.2: Latencia de Autenticación](#rnf2-latencia-de-autenticación)
   3.2. [Seguridad](#seguridad)
      3.2.1. [RNF.3: Seguridad de Tokens](#rnf3-seguridad-de-tokens)
      3.2.2. [RNF.4: Protección de Claves Secretas](#rnf4-protección-de-claves-secretas)
      3.2.3. [RNF.5: Autorización (Implícita)](#rnf5-autorización-implícita)
   3.3. [Escalabilidad](#escalabilidad)
      3.3.1. [RNF.6: Escalabilidad Horizontal](#rnf6-escalabilidad-horizontal)
      3.3.2. [RNF.7: Diseño Stateless](#rnf7-diseño-stateless)
   3.4. [Mantenibilidad](#mantenibilidad)
      3.4.1. [RNF.8: Claridad del Código](#rnf8-claridad-del-código)
      3.4.2. [RNF.9: Pruebas Unitarias e Integración](#rnf9-pruebas-unitarias-e-integración)
      3.4.3. [RNF.10: Registro (Logging)](#rnf10-registro-logging)
   3.5. [Usabilidad](#usabilidad)
      3.5.1. [RNF.11: API Intuitiva](#rnf11-api-intuitiva)
4. [Interfaces Externas](#interfaces-externas)
   4.1. [Interfaces de Usuario](#interfaces-de-usuario)
   4.2. [Interfaces de Hardware](#interfaces-de-hardware)
   4.3. [Interfaces de Software](#interfaces-de-software)
   4.4. [Interfaces de Comunicación](#interfaces-de-comunicación)
5. [Restricciones](#restricciones)
   5.1. [RES.1: Lenguaje de Programación](#res1-lenguaje-de-programación)
   5.2. [RES.2: Autenticación JWT](#res2-autenticación-jwt)
   5.3. [RES.3: Cumplimiento de Estándares](#res3-cumplimiento-de-estándares)
6. [Criterios de Aceptación](#criterios-de-aceptación)
7. [Apéndices (Opcional)](#apéndices-opcional)

## 1. Introducción

### 1.1. Propósito
Este documento especifica los requisitos funcionales y no funcionales para un microservicio desarrollado en Laravel que gestionará roles de usuario, asignará roles a usuarios y proporcionará autenticación segura mediante JWT (JSON Web Tokens). Este microservicio será un componente fundamental para la gestión de acceso y permisos dentro de un sistema más amplio.

### 1.2. Alcance
Este documento cubre las funcionalidades relacionadas con la creación, lectura, actualización y eliminación de roles, la asignación de estos roles a usuarios existentes y la implementación de un sistema de autenticación basado en JWT para asegurar el acceso a los recursos del microservicio.

### 1.3. Audiencia
Este documento está dirigido a las siguientes partes interesadas:
* Ingenieros de software responsables del desarrollo e implementación del microservicio.
* Arquitectos de software responsables del diseño e integración del microservicio en el sistema general.
* Analistas de negocio y Product Owners responsables de la definición y priorización de los requisitos.
* Equipos de pruebas responsables de la verificación y validación del microservicio.

### 1.4. Definiciones y Acrónimos
* **API:** Interfaz de Programación de Aplicaciones.
* **CRUD:** (Create, Read, Update, Delete) - Operaciones básicas de gestión de datos.
* **JWT:** (JSON Web Token) - Estándar de la industria para la creación de tokens de acceso seguros.
* **Microservicio:** Arquitectura de software donde una aplicación se estructura como una colección de servicios pequeños, independientes y débilmente acoplados.
* **SRS:** (Software Requirements Specification) - Documento de Especificación de Requisitos de Software.
* **URL:** (Uniform Resource Locator) - Dirección web específica.

### 1.5. Referencias
* Documentación oficial de Laravel ([https://laravel.com/docs/](https://laravel.com/docs/))
* Especificación JWT (RFC 7519) ([https://datatracker.ietf.org/doc/html/rfc7519](https://datatracker.ietf.org/doc/html/rfc7519))

## 2. Requisitos Funcionales

### 2.1. Gestión de Roles

#### 2.1.1. RF.1: Creación de Roles
* El sistema permitirá la creación de nuevos roles con un nombre único y una descripción opcional.
* La API expondrá un endpoint para crear roles.
* Se validará que el nombre del rol no esté duplicado.
* Se registrará la fecha y hora de creación del rol.

#### 2.1.2. RF.2: Lectura de Roles
* El sistema permitirá la lectura de uno o varios roles.
* La API expondrá endpoints para:
    * Obtener la lista de todos los roles.
    * Obtener los detalles de un rol específico mediante su ID.

#### 2.1.3. RF.3: Actualización de Roles
* El sistema permitirá la modificación del nombre y la descripción de un rol existente.
* La API expondrá un endpoint para actualizar la información de un rol mediante su ID.
* Se validará que el nuevo nombre del rol no esté duplicado (excepto para el rol que se está actualizando).
* Se registrará la fecha y hora de la última actualización del rol.

#### 2.1.4. RF.4: Eliminación de Roles
* El sistema permitirá la eliminación de roles existentes.
* La API expondrá un endpoint para eliminar un rol mediante su ID.
* Se deberá considerar la implicación de eliminar un rol que esté actualmente asignado a usuarios (posibles estrategias: prohibir la eliminación, desasignar el rol automáticamente, etc. Esto debe especificarse más adelante).

### 2.2. Asignación de Roles a Usuarios

#### 2.2.1. RF.5: Asignación de Rol
* El sistema permitirá asignar uno o varios roles a un usuario específico.
* La API expondrá un endpoint para asignar roles a un usuario, requiriendo el ID del usuario y el ID del rol que se asignará (Un usuario solo puede tener 1 rol).
* Se validará que los IDs de los roles proporcionados existan en el sistema.
* Los usuarios se gestionaran en otro microservicio mediante el ID.

#### 2.2.2. RF.6: Lectura de Roles de un Usuario
* El sistema permitirá obtener la lista de roles asignados a un usuario específico.
* La API expondrá un endpoint para obtener los roles de un usuario, requiriendo el ID del usuario.

#### 2.2.3. RF.7: Desasignación de Rol
* El sistema permitirá desasignar el rol de un usuario específico.
* La API expondrá un endpoint para desasignar roles de un usuario, requiriendo el ID del usuario.
* Se validará que los IDs de los roles proporcionados estén actualmente asignados al usuario.

### 2.3. Autenticación con JWT

#### 2.3.1. RF.8: Generación de Token JWT
* El sistema permitirá generar un token JWT después de una autenticación exitosa del usuario.
* La API expondrá un endpoint para la autenticación (por ejemplo, `/api/login`) que recibirá credenciales de usuario (email y contraseña).
* Tras la validación exitosa de las credenciales (se busca en un microservicio de usuarios), se generará un token JWT que contendrá información relevante del usuario y su rol.
* El token JWT generado tendrá una fecha de expiración configurable.

#### 2.3.2. RF.9: Verificación de Token JWT
* El sistema permitirá verificar la validez de un token JWT recibido en las peticiones a los endpoints protegidos.
* Se utilizará una clave secreta para firmar y verificar los tokens JWT. Esta clave deberá ser configurable y gestionada de forma segura.
* Si el token es válido y no ha expirado, la petición al endpoint protegido será procesada.
* Si el token no es válido o ha expirado, la API devolverá un error de autenticación (por ejemplo, código de estado HTTP 401 Unauthorized).

#### 2.3.3. RF.10: Protección de Endpoints
* El sistema permitirá proteger ciertos endpoints de la API, requiriendo un token JWT válido en el encabezado de la petición (por ejemplo, `Authorization: Bearer <token>`).
* Se deberá especificar qué endpoints requerirán autenticación. Inicialmente, se podría requerir autenticación para todos los endpoints de gestión de roles y asignación de roles.

## 3. Requisitos No Funcionales

### 3.1. Rendimiento

#### 3.1.1. RNF.1: Tiempo de Respuesta
Los tiempos de respuesta para las operaciones CRUD de roles y asignación de roles deben ser inferiores a 200 ms en condiciones de carga normal.

#### 3.1.2. RNF.2: Latencia de Autenticación
El tiempo para generar y verificar un token JWT debe ser inferior a 100 ms en condiciones de carga normal.

### 3.2. Seguridad

#### 3.2.1. RNF.3: Seguridad de Tokens
Los tokens JWT deben generarse utilizando un algoritmo de firma seguro (por ejemplo, HS256).

#### 3.2.2. RNF.4: Protección de Claves Secretas
La clave secreta utilizada para firmar los tokens JWT debe almacenarse de forma segura y no debe estar expuesta en el código fuente. Se recomienda el uso de variables de entorno o sistemas de gestión de secretos.

#### 3.2.3. RNF.5: Autorización (Implícita)
Aunque este microservicio se centra en la autenticación y gestión de roles, se asume que otro componente del sistema utilizará la información de los roles asignados a los usuarios (incluida en el JWT o consultada a este microservicio) para realizar la autorización (control de acceso a recursos).

### 3.3. Escalabilidad

#### 3.3.1. RNF.6: Escalabilidad Horizontal
El microservicio debe ser diseñado para poder escalarse horizontalmente para manejar un aumento en la carga de peticiones.

#### 3.3.2. RNF.7: Diseño Stateless
El microservicio debe ser diseñado como stateless (sin estado) para facilitar la escalabilidad horizontal. La información de la sesión debe residir en el token JWT.

### 3.4. Mantenibilidad

#### 3.4.1. RNF.8: Claridad del Código
El código debe ser limpio, bien comentado y seguir las mejores prácticas de desarrollo de Laravel.

#### 3.4.2. RNF.9: Pruebas Unitarias e Integración
Se deben implementar pruebas unitarias e de integración para garantizar la correcta funcionalidad y la estabilidad del microservicio.

#### 3.4.3. RNF.10: Registro (Logging)
El microservicio debe implementar un sistema de registro robusto para rastrear eventos, errores y el uso de la API.

### 3.5. Usabilidad

#### 3.5.1. RNF.11: API Intuitiva
La API debe ser fácil de entender y utilizar por otros desarrolladores. Se deben seguir convenciones de nomenclatura claras y proporcionar mensajes de error informativos.

## 4. Interfaces Externas

### 4.1. Interfaces de Usuario
Este microservicio no proporcionará una interfaz de usuario directa. Será consumido por otros servicios o aplicaciones a través de su API.

### 4.2. Interfaces de Hardware
No se especifican requisitos de hardware particulares para este microservicio más allá de los necesarios para ejecutar una aplicación Laravel.

### 4.3. Interfaces de Software
* **Laravel Framework:** El microservicio se desarrollará utilizando el framework Laravel.
* **Base de Datos:** Se requerirá una base de datos para persistir la información de los roles y las asignaciones de roles. La elección específica de la base de datos (MySQL) se definirá en la fase de diseño.
* **Librería JWT para Laravel:** Se utilizará una librería de Laravel para la generación y verificación de tokens JWT (por ejemplo, `tymon/jwt-auth`).
* **Otro Microservicio de Usuarios (Asumido):** Se asume la existencia de otro microservicio responsable de la gestión de usuarios, con el cual este microservicio interactuará (posiblemente a través de su API) para validar las credenciales durante el proceso de autenticación y para obtener información de los usuarios al asignarles roles.

### 4.4. Interfaces de Comunicación
El microservicio expondrá una API RESTful a través de HTTP. Las peticiones y respuestas se realizarán en formato JSON.

## 5. Restricciones

### 5.1. RES.1: Lenguaje de Programación
El microservicio debe desarrollarse utilizando el lenguaje de programación PHP y el framework Laravel.

### 5.2. RES.2: Autenticación JWT
La autenticación debe implementarse utilizando JWT.

### 5.3. RES.3: Cumplimiento de Estándares
El desarrollo debe seguir los estándares de codificación y las mejores prácticas de Laravel.

## 6. Criterios de Aceptación
Los siguientes criterios de aceptación deberán cumplirse para considerar que el microservicio ha sido desarrollado satisfactoriamente:
* Todas las funcionalidades descritas en los requisitos funcionales (Sección 2) deben estar implementadas y funcionando correctamente.
* El microservicio debe cumplir con todos los requisitos no funcionales especificados (Sección 3).
* La API debe estar documentada de forma clara y precisa (por ejemplo, utilizando Swagger/OpenAPI).
* Se deben haber implementado pruebas unitarias e de integración con una cobertura adecuada.
* El código fuente debe estar versionado utilizando un sistema de control de versiones (por ejemplo, Git).
* El microservicio debe poder desplegarse en el entorno de destino especificado.