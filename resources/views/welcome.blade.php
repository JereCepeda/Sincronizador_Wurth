<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sincronizador Wurth</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            background-color: #f8f9fa;
            font-size: 14px;
        }
        .card {
            margin-bottom: 20px;
        }
        .section-title {
            font-weight: bold;
            font-size: 1.1rem;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <h2 class="text-center mb-4">Panel de Sincronización Wurth</h2>

    <div class="row justify-content-center">

        <!-- Subida de Excel -->
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="section-title">Subir archivo Excel</div>
                    <form action="{{ route('POST_cargarexcel') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <input type="file" name="subida" class="form-control" accept=".xlsx">
                        </div>
                        <button type="submit" class="btn btn-primary w-25 d-block mx-auto">Cargar Excel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>