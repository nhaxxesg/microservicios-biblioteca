## AUTH SERVICE Y USER SERVICE

Cuerpo json
```
{
  "name": "Juan Pérez",
  "email": "juan.perez26@example.com",
  "password": "secreto123",
  "role_id": 2
}
```

Respuesta json
```
{
  "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL2F1dGgvcmVnaXN0ZXIiLCJpYXQiOjE3NTAwODgzODgsImV4cCI6MTc1MDA5MTk4OCwibmJmIjoxNzUwMDg4Mzg4LCJqdGkiOiJoY29CY2paamFDV0Y5c1VTIiwic3ViIjoiNyIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.PjeZ9MzeSC5wzqBOBHnWkkRy46Lw2RlltmvtTZ2cNI0",
  "token_type": "bearer",
  "expires_in": 3600
}
```

El token tiene el id del usuario y no tiene expiracion esta con valor de 900000 en la expiracion


## AUTH SERVICE Y USER SERVICE

Cuerpo json
```
{
  "usuario_id": 1,
  "descripcion": "El libro fue devuelto con retraso",
  "estado": "devuelto",
  "book_id": 1
}

```

Respuesta json
```
{
  "data": {
    "usuario_id": 1,
    "descripcion": "El libro fue devuelto con retraso",
    "book_id": 1,
    "estado": "pendiente",
    "updated_at": "2025-06-16T16:28:33.000000Z",
    "created_at": "2025-06-16T16:28:33.000000Z",
    "id": 1
  },
  "message": "Solicitud creada exitosamente."
}
```