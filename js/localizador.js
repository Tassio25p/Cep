document.getElementById("geoForm").addEventListener("submit", function (e) {
    e.preventDefault();

    let dados = document.getElementById("dados");
    dados.innerHTML = "Obtendo localização...";

    if (!navigator.geolocation) {
        dados.innerHTML = "Seu navegador não suporta geolocalização.";
        return;
    }

    navigator.geolocation.getCurrentPosition(
        (pos) => {
            const lat = pos.coords.latitude;
            const lon = pos.coords.longitude;

            // Enviando para PHP
            fetch("../back_end/localizacao.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `lat=${lat}&lon=${lon}`
            })
            .then(res => res.text())
            .then(html => {
                dados.innerHTML = html;  // já vem formatado do PHP
            });
        },
        (err) => {
            dados.innerHTML = "Erro ao obter localização: " + err.message;
        }
    );
});

document.getElementById("limparBtn").addEventListener("click", () => {
    document.getElementById("dados").innerHTML = "";
});
