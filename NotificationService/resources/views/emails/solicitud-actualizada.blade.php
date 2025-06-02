<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .content {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            border: 1px solid #dee2e6;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 15px;
        }
        .status-update {
            background-color: #e9ecef;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        .footer {
            margin-top: 20px;
            font-size: 0.9em;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Actualización de Estado de Solicitud</h1>
    </div>
    
    <div class="content">
        <p>Hola {{ $nombre_usuario }},</p>
        
        <p>Te informamos que ha habido una actualización en tu solicitud:</p>
        
        <div class="status-update">
            <p><strong>Solicitud:</strong> {{ $id_solicitud_visible }}</p>
            <p><strong>Descripción:</strong> {{ $descripcion_solicitud }}</p>
            <p><strong>Nuevo Estado:</strong> {{ $nuevo_estado }}</p>
        </div>
        
        <p>Puedes ver los detalles completos de tu solicitud haciendo clic en el siguiente enlace:</p>
        
        <a href="{{ $link_detalle_solicitud }}" class="button">Ver detalles de la solicitud</a>
    </div>

    <div class="footer">
        <p>Este es un correo automático, por favor no responder.</p>
    </div>
</body>
</html>
