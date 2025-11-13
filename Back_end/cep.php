<?php
$cep = $_REQUEST['cep'] ?? '';

if (empty($cep)) {
    die('CEP não informado.');
}

$requisicaoHttp = curl_init("https://viacep.com.br/ws/$cep/json/");
curl_setopt($requisicaoHttp, CURLOPT_RETURNTRANSFER, true);
$resposta = curl_exec($requisicaoHttp);
curl_close($requisicaoHttp);

$dados = json_decode($resposta, true);

if (isset($dados['erro'])) {
    $resultado = "<p style='color:red;'>❌ CEP não encontrado. Tente novamente.</p>";
} else {
    $resultado = "
        <div class='info-box'>
            <p><strong>Logradouro:</strong> {$dados['logradouro']}</p>
            <p><strong>Bairro:</strong> {$dados['bairro']}</p>
            <p><strong>Cidade:</strong> {$dados['localidade']}</p>
            <p><strong>Estado:</strong> {$dados['uf']}</p>
        </div>
    ";
}

// Carrega o HTML e injeta o resultado direto na div id="dados"
$html = file_get_contents("API.html");
$html = str_replace('<div id="dados"></div>', "<div id='dados'>$resultado</div>", $html);

echo $html;
?>
