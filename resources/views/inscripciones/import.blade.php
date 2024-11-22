<!-- Modal de importación -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Importar Inscripciones</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulario para cargar el archivo -->
                <form id="importForm" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="file">Selecciona un archivo CSV</label>
                        <input type="file" name="file" id="file" class="form-control" accept=".csv">
                    </div>
                    <button type="submit" class="btn btn-primary">Subir archivo</button>
                </form>
                <div id="progressContainer" class="mt-3" style="display: none;">
                    <div class="progress">
                        <div id="progressBar" class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p id="progressText" class="text-center"></p>
                </div>
                <div id="statusMessage" class="mt-3"></div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Abrir el modal de importación
        $('#importModal').on('show.bs.modal', function() {
            $('#file').val(''); // Limpiar el archivo al abrir el modal
            $('#progressContainer').hide();
            $('#statusMessage').empty();
        });

        // Enviar el archivo
        $('#importForm').submit(function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            // Mostrar el contenedor de progreso
            $('#progressContainer').show();
            $('#statusMessage').html('<p>Subiendo archivo...</p>');
            $('#progressBar').width('0%');
            $('#progressText').text('0%');

            // Realizar la petición AJAX para subir el archivo
            $.ajax({
                url: '{{ route('inscripciones.import') }}', // Ruta para procesar el archivo
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                xhr: function() {
                    var xhr = new XMLHttpRequest();
                    xhr.upload.addEventListener('progress', function(e) {
                        if (e.lengthComputable) {
                            var percent = (e.loaded / e.total) * 100;
                            $('#progressBar').width(percent + '%');
                            $('#progressText').text(Math.round(percent) + '%');
                        }
                    });
                    return xhr;
                },
                success: function(response) {
                    $('#statusMessage').html('<p class="text-success">Archivo importado exitosamente.</p>');
                    $('#progressBar').width('100%');
                    $('#progressText').text('100%');
                },
                error: function(response) {
                    $('#statusMessage').html('<p class="text-danger">Error al importar el archivo.</p>');
                }
            });
        });
    });
</script>

