<?php
/**
 * index.php
 * Página inicial — formulário para descobrir o signo zodiacal.
 *
 * Define o título da página ANTES de incluir o header,
 * pois o header usa a variável $pageTitle dinamicamente.
 */

$pageTitle = 'Descubra seu Signo Zodiacal';

// Caminho relativo ao header (está em layouts/header.php)
include 'layouts/header.php';
?>

    <!-- ============================================================
         CONTEÚDO PRINCIPAL
    ============================================================ -->
    <div class="app-wrapper">

        <!-- Cabeçalho visual da página -->
        <header class="app-header">
            <span class="badge-tag">✦ Astrologia</span>
            <h1>Descubra seu Signo</h1>
            <p class="subtitulo">
                Informe sua data de nascimento e revelamos qual signo do zodíaco rege seu destino.
            </p>
        </header>

        <!-- Card com formulário -->
        <main>
            <div class="glass-card">

                <form
                    method="POST"
                    action="show_zodiac_sign.php"
                    novalidate
                    id="form-signo"
                >
                    <!-- Campo: data de nascimento -->
                    <div class="mb-4">
                        <label for="data_nascimento" class="form-label-custom">
                            <i class="bi bi-calendar3 me-1"></i> Data de Nascimento
                        </label>
                        <input
                            type="date"
                            id="data_nascimento"
                            name="data_nascimento"
                            class="form-control-custom"
                            required
                            max="<?= date('Y-m-d') ?>"
                            min="1900-01-01"
                            aria-describedby="data-help"
                        >
                        <div id="data-help" class="form-text mt-2" style="color: var(--cor-texto-muted); font-size: 0.8rem;">
                            Selecione ou digite sua data de nascimento.
                        </div>
                    </div>

                    <!-- Botão de envio -->
                    <button type="submit" class="btn-zodiac" id="btn-descobrir">
                        <i class="bi bi-stars me-2"></i> Descobrir meu signo
                    </button>
                </form>

            </div><!-- /.glass-card -->
        </main>

        <!-- Rodapé discreto -->
        <footer class="app-footer">
            <p>Desenvolvido como projeto acadêmico da disciplina de Programação Web | <?= date('Y') ?></p>
        </footer>

    </div><!-- /.app-wrapper -->

    <!-- Bootstrap JS (opcional, mas incluso para completude) -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc4s9bIOgUxi8T/jzmQGiKMhRGLF5BnRJhUJBGCpCAIe"
        crossorigin="anonymous"
    ></script>

    <!--
        Validação HTML5 simples: garante que o campo seja preenchido
        antes de submeter. A lógica principal de segurança está no PHP.
    -->
    <script>
        document.getElementById('form-signo').addEventListener('submit', function (e) {
            var campo = document.getElementById('data_nascimento');
            if (!campo.value) {
                e.preventDefault();
                campo.focus();
                campo.style.borderColor = 'rgba(239, 68, 68, 0.8)';
                campo.style.boxShadow  = '0 0 0 3px rgba(239,68,68,0.25)';
            }
        });
    </script>

</body>
</html>
