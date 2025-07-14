<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sincronizador Wurth</title>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
    <link href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css" rel="stylesheet">
    
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

    <table id="example" class="display">
       <thead>
            <tr>
                <th>codigo_proveedor</th>
                <th>precio_final</th>
                <th>url</th>
            </tr>
        </thead>
        <tbody>
            <!-- Vacío, DataTables lo llenará -->
        </tbody>
    </table>

        <!-- Funciones Wurth -->
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="section-title">Acciones con Wurth</div>
                    <div class="display-flex">
                        <form action="{{ route('GET_wurth') }}" method="GET" class="mb-2">
                            @csrf
                            <button type="submit" class="btn btn-secondary ">Buscar URL en Wurth</button>
                        </form>
                        <form action="{{ route('GET_wurth_sinurl') }}" method="GET" class="mb-2">
                            @csrf
                            <button type="submit" class="btn btn-secondary ">Buscar en Wurth SIN URL</button>
                        </form>
                    </div>
                    <form action="{{ route('GET_actualizaprecio') }}" method="GET">
                        @csrf
                        <button type="submit" class="btn btn-warning w-25 d-block mx-auto">Actualizar Precios</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Exportar -->
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="section-title">Descargar archivo Excel</div>
                    <form action="{{ route('GET_exportarexcel') }}" method="GET">
                        @csrf
                        <button type="submit" class="btn btn-success w-25 d-block mx-auto">Exportar Excel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#example').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("GET_datatable") }}',
        columns: [
                { data: 'codigo_proveedor', name: 'codigo_proveedor' },
                { data: 'precio_final', name: 'precio_final' },
                { data: 'url', name: 'url' },
                {
                    data: 'codigo_proveedor',
                    render: function(data) {
                        return `<button class="btn btn-sm btn-primary actualizar-btn" data-codigo="${data}">Actualizar</button>`;
                    },
                    orderable: false,
                    searchable: false
                }
            ]
        });
        $(document).on('click', '.actualizar-btn', function () {
            
        const codigo = $(this).data('codigo');
        console.log('Actualizar producto con código:',codigo);

        if (!codigo) return;

            $.ajax({
                url: '{{ route("GET_actualizaprecio") }}',
                method: 'POST',
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}',
                    codigo: codigo
                },
                success: function (response) {
                    $('#example').DataTable().ajax.reload();
                },
                error: function (xhr) {
                    alert('Error al actualizar el producto');
                },
            });
        });
    });
</script>

</body>
</html>