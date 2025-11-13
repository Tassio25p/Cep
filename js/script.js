const form = document.getElementById("cepForm");
const inputCep = document.getElementById("cep");
const dadosDiv = document.getElementById("dados");
const limparBtn = document.getElementById("limparBtn");

form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const cep = inputCep.value.trim();
    if (cep === "") {
        dadosDiv.innerHTML = "<p style='color:red;'>⚠️ Digite um CEP válido.</p>";
        return;
    }

    dadosDiv.innerHTML = "<p>🔎 Buscando informações...</p>";

    try {
        const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
        const data = await response.json();

        if (data.erro) {
            dadosDiv.innerHTML = "<p style='color:red;'>❌ CEP não encontrado.</p>";
        } else {
            dadosDiv.innerHTML = `
                <div class="info-box">
                    <p><strong>Logradouro:</strong> ${data.logradouro}</p>
                    <p><strong>Bairro:</strong> ${data.bairro}</p>
                    <p><strong>Cidade:</strong> ${data.localidade}</p>
                    <p><strong>Estado:</strong> ${data.uf}</p>
                </div>
            `;
        }
    } catch (error) {
        dadosDiv.innerHTML = "<p style='color:red;'>⚠️ Erro ao buscar o CEP. Verifique sua conexão.</p>";
    }
});

limparBtn.addEventListener("click", () => {
    inputCep.value = "";
    dadosDiv.innerHTML = "";
    inputCep.focus();
});
