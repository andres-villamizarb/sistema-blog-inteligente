<form action="index.php?action=crear_post" method="POST">
    <div class="mb-3">
        <div class="d-flex justify-content-between align-items-end mb-1">
            <label for="titulo" class="form-label fw-bold mb-0">Título de la publicación</label>
            <!-- Botón de IA para el título -->
            <button type="button" class="btn btn-sm btn-outline-primary" id="btn-titulo" onclick="solicitarIA('titulo')">
                ✨ Sugerir Título IA
            </button>
        </div>
        <input type="text" class="form-control" id="titulo" name="titulo" required placeholder="Escribe un título llamativo">
    </div>
    
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-end mb-1">
            <label for="contenido" class="form-label fw-bold mb-0">Contenido</label>
            <!-- Botón de IA para corregir -->
            <button type="button" class="btn btn-sm btn-outline-primary" id="btn-corregir" onclick="solicitarIA('corregir')">
                ✨ Corregir Ortografía IA
            </button>
        </div>
        <textarea class="form-control" id="contenido" name="contenido" rows="6" required placeholder="Escribe tu contenido aquí. Si necesitas ayuda, escribe la idea general y usa los botones de IA."></textarea>
    </div>
    
    <div class="d-flex justify-content-between">
        <a href="index.php?action=home" class="btn btn-outline-secondary">Cancelar</a>
        <button type="submit" class="btn btn-success">Publicar Entrada</button>
    </div>
</form>
<script src="script.js"></script>