<?php
// Carrega o arquivo HTML
$htmlPath = __DIR__ . "/API.html";

if (!file_exists($htmlPath)) {
    die("Arquivo API.html não encontrado.");
}

$form = file_get_contents($htmlPath);

// Exibe o HTML sem nenhum marcador
echo $form;
?>
