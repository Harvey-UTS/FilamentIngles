<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Importar Inscripciones</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Agregar el script para el cierre y redirección -->
    <script>
        window.onload = function () {
            @if (session('success'))
                // Mostrar el mensaje de éxito
                alert('{{ session('success') }}');
                // Redirigir a la página de inscripciones en Filament
                window.location.href = "{{ url('/admin/inscripciones') }}";
            @elseif(session('error'))
                alert('{{ session('error') }}');
            @endif
        }
    </script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white shadow-md rounded-lg p-8 max-w-lg w-full">
        <h1 class="text-2xl font-bold text-gray-700 text-center mb-6">Importar Inscripciones</h1>

        <form action="{{ route('importar.inscripciones') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <!-- Campo de archivo -->
            <div>
                <label for="file" class="block text-gray-600 font-medium">Archivo CSV</label>
                <input type="file" name="file" id="file"
                    class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('file')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botón de enviar -->
            <div>
                <button type="submit"
                    class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Subir Archivo
                </button>
            </div>
        </form>

        <!-- Mensaje de éxito -->
        @if (session('success'))
            <div class="mt-6 text-green-600 font-medium text-center">
                {{ session('success') }}
            </div>
        @endif

        <!-- Mensaje de error -->
        @if (session('error'))
            <div class="mt-6 text-red-600 font-medium text-center">
                {{ session('error') }}
            </div>
        @endif
    </div>

</body>
</html>
