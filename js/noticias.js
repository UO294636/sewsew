
class Noticia {
    constructor() {
        if (!(window.File && window.FileReader && window.FileList && window.Blob)) {
            alert("ERROR-->El navegador actual no soporta API FILE, por lo no se podrá ejecutar el programa correctamente");
        }

    }

    readInputFile(archivo) {
        let textoArchivo = null;
        var claseNoticias = this;
        const tipoTexto = /text.*/;

        if (archivo.type.match(tipoTexto)) {
            const lector = new FileReader();
            lector.onload = function () {
                textoArchivo = lector.result;
                const noticias = textoArchivo.split("\n");
                claseNoticias.crearNoticias(noticias);
            };
            lector.readAsText(archivo);
        } else {
            noticia.textContent = "Error : ¡¡¡ Archivo no válido !!!";
        }
    }

    


}
