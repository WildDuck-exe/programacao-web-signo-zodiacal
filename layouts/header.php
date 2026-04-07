<?php
/**
 * header.php
 * Layout reutilizável: inclui toda a estrutura <head> da página.
 * Deve ser incluído no topo de cada página com: include 'layouts/header.php';
 */
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Título dinâmico: pode ser sobrescrito definindo $pageTitle antes do include -->
    <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Signo Zodiacal' ?></title>

    <!-- Bootstrap 5 via CDN -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous"
    >

    <!-- Bootstrap Icons via CDN -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS próprio da aplicação (caminho relativo à raiz do projeto) -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
