async function solicitarIA(accion) {
    const contenido = document.getElementById('contenido').value;
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

        // Extraemos la respuesta navegando por la estructura JSON que devuelve Google Gemini
        if (datos.candidates && datos.candidates.length > 0) {
            const textoGenerado = datos.candidates[0].content.parts[0].text.trim();

            if (accion === 'titulo') {
                document.getElementById('titulo').value = textoGenerado;
            } else if (accion === 'corregir') {
                document.getElementById('contenido').value = textoGenerado;
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