<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $project->name }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 14px;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
        }

        /* 🔹 Asegurarse de que logo y la información de la empresa estén en la misma fila */
        .header {
            display: flex;
            align-items: center;
            /* Alinear verticalmente */
            justify-content: space-between;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }

        /* 🔹 El logo se redimensiona adecuadamente */
        .header img {
            max-width: 150px;
            /* Ajustamos el tamaño del logo */
            height: auto;
        }

        /* 🔹 La información de la empresa ocupa el espacio restante */
        .company-info {
            flex-grow: 1;
            text-align: right;
            font-size: 12px;
        }

        .title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin: 20px 0;
            color: #007bff;
        }

        .project-details,
        .concepts-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .concepts-table th,
        .concepts-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .concepts-table th {
            background-color: #007bff;
            color: white;
        }

        .total {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            margin-top: 10px;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #555;
            margin-top: 30px;
        }
    </style>
</head>

<body>

    <div class="container">
        <!-- 🔹 Encabezado con Logo y Datos de Empresa en la misma fila -->
        <div class="header">
            <img src="{{ public_path('img/logo.jpg') }}" alt="Logo Empresa" width="100px">
            <div class="company-info">
                <strong>Gessys S.A. de C.V.</strong><br>
                Dirección: Calle Ejemplo #123, CDMX<br>
                Tel: (55) 1234-5678<br>
                Email: contacto@gessys.com
            </div>
        </div>

        <!-- Título -->
        <div class="title">Cotización de Proyecto</div>

        <!-- Detalles del Proyecto -->
        <table class="project-details">
            <tr>
                <td><strong>Proyecto:</strong> {{ $project->name }}</td>
                <td><strong>Fecha:</strong> {{ now()->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td><strong>Descripción:</strong> {{ $project->description }}</td>
                <td><strong>Plazo:</strong> {{ $project->initial_date }} - {{ $project->final_date }}</td>
            </tr>
        </table>

        <!-- Tabla de Conceptos -->
        <table class="concepts-table">
            <thead>
                <tr>
                    <th>Concepto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($project->concepts as $concept)
                    <tr>
                        <td>{{ $concept->name }}</td>
                        <td>1</td>
                        <td>${{ number_format($concept->pivot->price, 2) }}</td>
                        <td>${{ number_format($concept->pivot->price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Total -->
        <div class="total">
            Total: <strong>${{ number_format($project->concepts->sum('pivot.price'), 2) }}</strong>
        </div>

        <!-- Pie de página -->
        <div class="footer">
            *Esta cotización es válida por 30 días a partir de la fecha de emisión.<br>
            Gracias por confiar en nuestros servicios.
        </div>
    </div>

</body>

</html>
