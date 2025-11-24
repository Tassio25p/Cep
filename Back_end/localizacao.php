<?php
$lat = $_POST['lat'] ?? null;
$lon = $_POST['lon'] ?? null;

if (!$lat || !$lon) {
    echo "<p style='color:red;'>Erro: latitude ou longitude não enviadas.</p>";
    exit;
}

$url = "https://nominatim.openstreetmap.org/reverse?format=json&lat=$lat&lon=$lon&addressdetails=1";

// Nominatim exige User-Agent
$opts = [
    "http" => [
        "header" => "User-Agent: SeuSistemaLocalizacao/1.0\r\n"
    ]
];

$context = stream_context_create($opts);
$response = file_get_contents($url, false, $context);

if ($response === false) {
    echo "<p style='color:red;'>Erro ao consultar serviço de localização.</p>";
    exit;
}

$data = json_decode($response, true);

// Extração segura
$addr = $data["address"];

$logradouro = $addr["road"] ?? "Não informado";
$bairro = $addr["suburb"] ?? $addr["neighbourhood"] ?? "Não informado";
$cidade = $addr["city"] ?? $addr["town"] ?? $addr["village"] ?? "Não informado";
$estado = $addr["state"] ?? "Não informado";
$cep = $addr["postcode"] ?? "Não informado";
$pais = $addr["country"] ?? "Não informado";

echo "
<div class='info-box'>
    <h3>📍 Localização Detectada</h3>

    <p><strong>Latitude:</strong> $lat</p>
    <p><strong>Longitude:</strong> $lon</p>

    <h3>📌 Endereço</h3>
    <p><strong>Logradouro:</strong> $logradouro</p>
    <p><strong>Bairro:</strong> $bairro</p>
    <p><strong>Cidade:</strong> $cidade</p>
    <p><strong>Estado:</strong> $estado</p>
    <p><strong>CEP:</strong> $cep</p>
    <p><strong>País:</strong> $pais</p>
</div>
";
?>
