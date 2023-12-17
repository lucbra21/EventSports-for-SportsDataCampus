
# Event Sports for Sports Data Campus for Community

Botonera es una herramienta de código abierto diseñada para la recolección de eventos en deportes. Permite la configuración personalizada de jugadores y eventos, y ofrece la posibilidad de analizar partidos en vivo a través de YouTube o desde archivos físicos.

## Características

- Importación de la lista de jugadores.
- Personalización de botones para distintos eventos deportivos.
- Configuración de imágenes para campos y porterías.
- Integración con transmisiones de YouTube para el seguimiento de partidos en vivo.
- Registro de detalles del partido como ID, fecha y descripción.
- Selección y control de periodos durante el seguimiento del evento.

## Configuración

### Lista de Jugadores

Para importar la lista de jugadores, sigue estos pasos:

1. Prepara un archivo CSV/JSON con los nombres de los jugadores y sus respectivos números.
2. Dirígete a la sección de Configuración en la aplicación.
3. Utiliza la función de importación para cargar tu lista de jugadores.

### Botones de Eventos

Puedes personalizar los botones de eventos de la siguiente manera:

1. Accede al panel de configuración de eventos.
2. Añade o elimina eventos según las necesidades de tu deporte.
3. Personaliza las etiquetas y colores de los botones para cada evento.

### Imágenes del Campo y Portería

Para cambiar las imágenes predeterminadas:

1. Prepara tus imágenes en formatos compatibles (.png, .jpg, etc.).
2. En la sección de configuración visual, selecciona 'Cambiar imagen'.
3. Sube y ajusta tus imágenes en la interfaz de la aplicación.

### Eventing Online

Para realizar un seguimiento en línea:

1. Obtén el enlace del streaming de YouTube.
2. En la sección correspondiente, pega el enlace para integrarlo con la herramienta.
3. Asegúrate de tener permisos adecuados para usar el contenido del streaming.

## Uso

### Registrar un Partido

Para comenzar a registrar eventos durante un partido:

1. Inicia la aplicación y selecciona 'Nuevo Partido'.
2. Ingresa los detalles del partido, incluyendo ID, fecha y una descripción.
3. Selecciona el periodo actual y comienza a registrar los eventos utilizando la botonera.

## Contribución

Las contribuciones son bienvenidas y apreciadas. Para contribuir:

1. Haz un Fork del proyecto.
2. Crea tu rama de características (`git checkout -b feature/AmazingFeature`).
3. Haz commit de tus cambios (`git commit -m 'Add some AmazingFeature'`).
4. Haz push a la rama (`git push origin feature/AmazingFeature`).
5. Abre un Pull Request.

## Créditos

- Sports Data Campus - Lucas Bracamonte

## Licencia

Este proyecto está liberado bajo la Licencia Sports Data Campus - vea el archivo LICENSE para más detalles.

document.getElementById("eventoSeleccionado").innerHTML = '';

accionSeleccionada = document.getElementById('eventName').value;

const dataString = localStorage.getItem('botonesData');
        if (!dataString) return;  // Si no hay datos, salir

        const data = JSON.parse(dataString).slice(1);  // Ignorar la primera fila

        data.forEach(row => {
            createDynamicButton(row);
        });
