function loadPDF(url) {
    var container = document.getElementById("dynamic-content");
    if (!container) {
        console.error('Container with ID dynamic-content not found.');
        return false;
    }

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            // Limpa o conteúdo anterior da div
            container.innerHTML = '';

            // Cria um Blob com os dados do PDF
            var blob = new Blob([this.response], { type: 'application/pdf' });

            // Cria um objeto URL para o Blob
            var url = URL.createObjectURL(blob);

            // Cria um iframe para exibir o PDF
            var iframe = document.createElement('iframe');
            iframe.src = url;
            iframe.width = '100%';
            iframe.height = '600px';

            // Adiciona o iframe à div
            container.appendChild(iframe);
        }
    };
    xhttp.open("GET", url, true);
    xhttp.responseType = 'arraybuffer'; // Adiciona isto para tratar a resposta como um ArrayBuffer
    xhttp.send();
    return false;
}
