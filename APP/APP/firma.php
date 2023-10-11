<!DOCTYPE html>
<html>

<head>
    <title>Formulario con Captura de Firma</title>
    <!-- Incluye la librería SignaturePad.js -->
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
</head>

<body>
    <h1>Formulario con Captura de Firma</h1>
    <form action="" method="post">
        <!-- Otros campos del formulario -->
        <div>
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>
        </div>

        <!-- Espacio para la firma -->
        <div>
            <label>FIRME AQUI</label>
            <!-- Elemento Canvas para capturar la firma -->
            <canvas id="firmaCanvas" width="600" height="300"></canvas>
        </div>

        <!-- Botón de envío del formulario -->
        <div>
            <input type="submit" value="Enviar">
        </div>
        </br>
        <!-- Botón para descargar la firma -->
        <div>
            <button type="button" id="descargarFirma">Descargar Firma</button>
        </div>
        <!-- boton para limpiar la firma en caso de ser necesario -->
        <div>
            <button type="button" id="limpiarFirma">Limpiar Firma</button>
        </div>
    </form>

    <script>
        // Inicializa SignaturePad en el elemento Canvas
        var canvas = document.getElementById('firmaCanvas');
        var signaturePad = new SignaturePad(canvas);

        // Configura el grosor de la línea y el color de la firma
        signaturePad.minWidth = 2;
        signaturePad.maxWidth = 3;
        signaturePad.penColor = 'black';

        //manejar el boton de limpiar la firma
        var limpiarFirmaButton = document.getElementById('limpiarFirma');
        limpiarFirmaButton.addEventListener('click', function() {
            signaturePad.clear();
        });


        // Manejar la descarga de la firma
        var descargarFirmaButton = document.getElementById('descargarFirma');
        descargarFirmaButton.addEventListener('click', function() {
            if (signaturePad.isEmpty()) {
                alert('Por favor, capture su firma primero.');
            } else {
                // Convierte la firma en una imagen PNG
                var firmaDataURL = signaturePad.toDataURL('image/png');

                // Crea un enlace de descarga
                var enlaceDescarga = document.createElement('a');
                enlaceDescarga.href = firmaDataURL;
                enlaceDescarga.download = 'firma.png';

                // Simula un clic en el enlace de descarga para iniciar la descarga
                enlaceDescarga.click();

            }
        });
    </script>
</body>

</html>