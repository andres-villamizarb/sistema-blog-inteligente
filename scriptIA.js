async function solicitarIA(accion) {
    // Obtenemos el texto limpio, sin etiquetas HTML, para no confundir a la IA
    const contenido = (typeof tinymce !== 'undefined' && tinymce.activeEditor) 
        ? tinymce.activeEditor.getContent({format: 'text'}) 
        : document.getElementById('contenido').value;
        
    const btn = accion === 'titulo' ? document.getElementById('btn-titulo') : document.getElementById('btn-corregir');
    const textoOriginalBtn = btn.innerHTML;

    // Validación básica
    if (contenido.trim() === '') {
        alert("Por favor, escribe algo en el contenido primero para que la IA tenga contexto.");
        return;
    }

    // Cambiamos el texto del botón a "Cargando..." para que el usuario sepa que está pensando
    btn.innerHTML = "⏳ Pensando...";
    btn.disabled = true;

    try {
        // Hacemos la petición a tu propio servidor (al caso 'api_ia' de tu index.php)
        const respuesta = await fetch('index.php?action=api_ia', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                texto: contenido,
                accion: accion
            })
        });

        const datos = await respuesta.json();

        // Extraemos la respuesta directa que envía nuestro controlador PHP
        if (datos.resultado) {
            const textoGenerado = datos.resultado;

            if (accion === 'titulo') {
                document.getElementById('titulo').value = textoGenerado;
            } else if (accion === 'corregir') {
                // APLICAMOS EL TEXTO DIRECTAMENTE AL EDITOR VISUAL
                if (typeof tinymce !== 'undefined' && tinymce.activeEditor) {
                    // Mantiene el formato básico reemplazando los saltos de línea por etiquetas <p>
                    const textoFormateado = textoGenerado.replace(/\n/g, '<br>');
                    tinymce.activeEditor.setContent(textoFormateado);
                } else {
                    document.getElementById('contenido').value = textoGenerado;
                }
            }
        } else {
            console.error("Respuesta inesperada de la API:", datos);
            alert("Hubo un error procesando la IA. Revisa la consola.");
        }

    } catch (error) {
        console.error("Error de conexión:", error);
        alert("Error de conexión con el servidor.");
    } finally {
        // Devolvemos el botón a la normalidad
        btn.innerHTML = textoOriginalBtn;
        btn.disabled = false;
    }
}

async function resumirPost() {
    // Leemos el texto del post (ajusta el ID si en tu HTML se llama diferente)
    const contenidoElemento = document.getElementById('contenido-del-post');
    const contenido = contenidoElemento ? contenidoElemento.innerText : '';
    
    const btn = document.getElementById('btn-resumir');
    const cajaResumen = document.getElementById('caja-resumen');
    const textoResumen = document.getElementById('texto-resumen');

    if (!contenido || contenido.trim() === '') return;

    btn.innerHTML = "⏳ Resumiendo...";
    btn.disabled = true;

    try {
        const respuesta = await fetch('index.php?action=api_ia', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                texto: contenido,
                accion: 'resumir'
            })
        });

        const datos = await respuesta.json();

        if (datos.resultado) {
            // Mostramos la caja y el texto
            textoResumen.innerText = datos.resultado;
            cajaResumen.style.display = 'block';
            btn.innerHTML = "✨ Resumido con éxito";
        } else {
            alert("Hubo un error al resumir.");
            btn.innerHTML = "✨ Resumir post con IA";
            btn.disabled = false;
        }

    } catch (error) {
        console.error("Error:", error);
        alert("Error de conexión al resumir.");
        btn.innerHTML = "✨ Resumir post con IA";
        btn.disabled = false;
    }
}