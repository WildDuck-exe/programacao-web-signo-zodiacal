<?php
/**
 * show_zodiac_sign.php
 * Página de resultado — exibe o signo zodiacal correspondente à data informada.
 *
 * Fluxo:
 *  1. Verifica se o acesso foi via POST (formulário enviado).
 *  2. Valida e sanitiza a data recebida.
 *  3. Carrega o arquivo XML com os signos.
 *  4. Compara o dia/mês da data com os intervalos do XML.
 *  5. Exibe o resultado ou uma mensagem de erro.
 */

/* ----------------------------------------------------------------
   FUNÇÃO: encontrarSigno
   Recebe o dia e o mês do nascimento e o objeto SimpleXML dos signos.
   Retorna o objeto <signo> correspondente ou null se não encontrar.
   ---------------------------------------------------------------- */
function encontrarSigno(int $diaNasc, int $mesNasc, SimpleXMLElement $signos): ?SimpleXMLElement
{
    foreach ($signos->signo as $signo) {

        // Extrai dia e mês de dataInicio e dataFim (formato DD/MM)
        [$diaIni, $mesIni] = array_map('intval', explode('/', (string) $signo->dataInicio));
        [$diaFim, $mesFim] = array_map('intval', explode('/', (string) $signo->dataFim));

        /*
         * Estratégia: converter dia e mês em um número inteiro de 4 dígitos
         * no formato MMDD para facilitar comparações numéricas simples.
         *
         * Ex.: 21/03 → 0321  |  20/04 → 0420  |  22/12 → 1222  |  20/01 → 0120
         *
         * Caso especial — Capricórnio (22/12 a 20/01): o intervalo
         * atravessa a virada do ano. Nesses casos mesFim < mesIni.
         * Um nascimento é capricorniano se:
         *   → data >= 22/12  (MMDD >= 1222)  OU
         *   → data <= 20/01  (MMDD <= 0120)
         */

        $nascMMDD = $mesNasc * 100 + $diaNasc;
        $iniMMDD  = $mesIni  * 100 + $diaIni;
        $fimMMDD  = $mesFim  * 100 + $diaFim;

        if ($iniMMDD <= $fimMMDD) {
            // Intervalo normal: não atravessa a virada do ano
            if ($nascMMDD >= $iniMMDD && $nascMMDD <= $fimMMDD) {
                return $signo;
            }
        } else {
            // Intervalo que atravessa a virada do ano (ex.: Capricórnio)
            if ($nascMMDD >= $iniMMDD || $nascMMDD <= $fimMMDD) {
                return $signo;
            }
        }
    }

    return null; // Não encontrado (não deve ocorrer com dados XML corretos)
}

/* ----------------------------------------------------------------
   FUNÇÃO: emojiDoSigno
   Retorna o emoji correspondente ao nome do signo.
   ---------------------------------------------------------------- */
function emojiDoSigno(string $nome): string
{
    $emojis = [
        'Áries'       => '♈',
        'Touro'       => '♉',
        'Gêmeos'      => '♊',
        'Câncer'      => '♋',
        'Leão'        => '♌',
        'Virgem'      => '♍',
        'Libra'       => '♎',
        'Escorpião'   => '♏',
        'Sagitário'   => '♐',
        'Capricórnio' => '♑',
        'Aquário'     => '♒',
        'Peixes'      => '♓',
    ];

    return $emojis[$nome] ?? '⭐';
}

/* ================================================================
   INÍCIO DO PROCESSAMENTO
   ================================================================ */

$erro         = '';       // Mensagem de erro (se houver)
$signoEncontrado = null;  // Objeto signo do XML
$dataFormatada   = '';    // Data formatada para exibição
$pageTitle       = 'Resultado — Seu Signo Zodiacal';

// ------------------------------------------------------------------
// 1. Verificar se o acesso foi via POST (proteção contra acesso direto)
// ------------------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Usuário acessou a URL diretamente, sem enviar o formulário
    header('Location: index.php');
    exit;
}

// ------------------------------------------------------------------
// 2. Validar e sanitizar a data recebida
// ------------------------------------------------------------------
$dataBruta = isset($_POST['data_nascimento']) ? trim($_POST['data_nascimento']) : '';

if (empty($dataBruta)) {
    $erro = 'A data de nascimento não foi informada. Por favor, preencha o formulário.';
} else {
    /*
     * O campo <input type="date"> envia no formato ISO: YYYY-MM-DD.
     * Vamos converter para um objeto DateTime para validação robusta.
     */
    $dateObj = DateTime::createFromFormat('Y-m-d', $dataBruta);

    if (!$dateObj || $dateObj->format('Y-m-d') !== $dataBruta) {
        $erro = 'A data informada é inválida. Use o formato correto (AAAA-MM-DD).';
    } elseif ($dateObj > new DateTime()) {
        $erro = 'A data de nascimento não pode ser uma data futura.';
    } else {
        // Data válida — extrair dia, mês e ano
        $diaNasc  = (int) $dateObj->format('d');
        $mesNasc  = (int) $dateObj->format('m');
        $anoNasc  = (int) $dateObj->format('Y');

        // Formatar a data para exibição amigável em português
        $mesesPT = [
            1  => 'janeiro',   2  => 'fevereiro', 3  => 'março',
            4  => 'abril',     5  => 'maio',       6  => 'junho',
            7  => 'julho',     8  => 'agosto',     9  => 'setembro',
            10 => 'outubro',   11 => 'novembro',   12 => 'dezembro',
        ];
        $dataFormatada = sprintf('%02d de %s de %d', $diaNasc, $mesesPT[$mesNasc], $anoNasc);

        // ------------------------------------------------------------------
        // 3. Carregar o arquivo XML dos signos
        // ------------------------------------------------------------------
        $caminhoXml = __DIR__ . '/signos.xml';

        if (!file_exists($caminhoXml)) {
            $erro = 'Arquivo de signos (signos.xml) não foi encontrado. Verifique a instalação do projeto.';
        } else {
            // Suprime avisos do PHP para tratar erros manualmente
            libxml_use_internal_errors(true);
            $xml = simplexml_load_file($caminhoXml);

            if ($xml === false) {
                $errosXml = libxml_get_errors();
                libxml_clear_errors();
                $erro = 'Erro ao carregar o arquivo XML. Verifique se ele é válido.';
            } else {
                // ------------------------------------------------------------------
                // 4. Encontrar o signo correspondente
                // ------------------------------------------------------------------
                $signoEncontrado = encontrarSigno($diaNasc, $mesNasc, $xml);

                if ($signoEncontrado === null) {
                    $erro = 'Não foi possível determinar o signo para a data informada. Verifique o arquivo XML.';
                }
            }
        }
    }
}

// Inclui o cabeçalho HTML (após definir $pageTitle)
include 'layouts/header.php';
?>

    <!-- ============================================================
         CONTEÚDO PRINCIPAL
    ============================================================ -->
    <div class="app-wrapper">

        <?php if ($erro): ?>
            <!-- ---- Tela de ERRO ---- -->
            <header class="app-header">
                <span class="badge-tag">⚠ Atenção</span>
                <h1>Ops, algo deu errado</h1>
            </header>

            <main>
                <div class="glass-card" style="max-width: 480px;">
                    <div class="alerta-erro">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        <span><?= htmlspecialchars($erro) ?></span>
                    </div>
                    <a href="index.php" class="btn-voltar" style="justify-content: center; width: 100%; display: flex;">
                        <i class="bi bi-arrow-left"></i> Voltar ao início
                    </a>
                </div>
            </main>

        <?php else: ?>
            <!-- ---- Tela de RESULTADO ---- -->
            <?php
                // Preparar dados para exibição (escapados para segurança)
                $nomeSigno   = htmlspecialchars((string) $signoEncontrado->signoNome);
                $descSigno   = htmlspecialchars((string) $signoEncontrado->descricao);
                $periodoIni  = htmlspecialchars((string) $signoEncontrado->dataInicio);
                $periodoFim  = htmlspecialchars((string) $signoEncontrado->dataFim);
                $emoji       = emojiDoSigno((string) $signoEncontrado->signoNome);
            ?>

            <header class="app-header">
                <span class="badge-tag">✦ Resultado</span>
                <h1>Seu signo foi encontrado!</h1>
                <p class="subtitulo">Veja abaixo as características do seu signo zodiacal.</p>
            </header>

            <main>
                <div class="resultado-card">

                    <!-- Emoji do signo com animação -->
                    <span class="signo-emoji" role="img" aria-label="Símbolo de <?= $nomeSigno ?>">
                        <?= $emoji ?>
                    </span>

                    <!-- Nome do signo -->
                    <h2 class="signo-nome"><?= $nomeSigno ?></h2>

                    <!-- Período do signo -->
                    <div class="periodo-badge">
                        <i class="bi bi-calendar3 me-1"></i>
                        <?= $periodoIni ?> &mdash; <?= $periodoFim ?>
                    </div>

                    <!-- Data informada pelo usuário -->
                    <p class="data-informada">
                        <i class="bi bi-person me-1"></i>
                        Você nasceu em <span><?= htmlspecialchars($dataFormatada) ?></span>
                    </p>

                    <hr class="divider-linha">

                    <!-- Descrição do signo -->
                    <p class="descricao-texto">
                        <?= $descSigno ?>
                    </p>

                    <hr class="divider-linha">

                    <!-- Botão de voltar -->
                    <a href="index.php" class="btn-voltar" style="justify-content: center; width: 100%; display: flex;">
                        <i class="bi bi-arrow-left"></i> Descobrir outro signo
                    </a>

                </div><!-- /.resultado-card -->
            </main>

        <?php endif; ?>

        <!-- Rodapé discreto -->
        <footer class="app-footer">
            <p>Desenvolvido como projeto acadêmico da disciplina de Programação Web | <?= date('Y') ?></p>
        </footer>

    </div><!-- /.app-wrapper -->

    <!-- Bootstrap JS -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc4s9bIOgUxi8T/jzmQGiKMhRGLF5BnRJhUJBGCpCAIe"
        crossorigin="anonymous"
    ></script>

</body>
</html>
