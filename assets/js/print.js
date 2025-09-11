
function printContent(type_question_id,id,belong_id,baremo_id) {
    const overlay = document.getElementById("loadingOverlay");
    overlay.style.display = "flex"; // mostrar overlay
    var datos = `${type_question_id}|${id}|${belong_id}|${baremo_id}`;
    var base64 = btoa(datos);

    // Crear FormData (empaqueta todo como si fuera un form POST con archivos)
    let formData = new FormData();
    formData.append("type_question_id", base64);

    const divs = ['contenido1', 'contenido2', 'contenido3'];

    let promises = divs.map((divId, index) => {
        return html2canvas(document.getElementById(divId)).then(canvas => {
            return new Promise((resolve) => {
                canvas.toBlob(function(blob) {
                    let file = new File([blob], `image_contenido${index + 1}.png`, { type: "image/png" });
                    formData.append(`image_contenido${index + 1}`, file);
                    resolve();
                }, "image/png");
            });
        });
    });

    // Cuando todas las capturas estén listas, enviar por fetch
    Promise.all(promises).then(() => {
        fetch(pathprint+"/view/print.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.text())
        .then(res => {
            
            if(res != '0'){
                overlay.style.display = "none"; // ocultar overlay
                //window.location.href = res;
                window.open(res, "_blank");
            }
            else{
                overlay.style.display = "none"; // ocultar overlay
                alert("EL PDF NO PUDO SER GENERADO");
            }
        })
        .catch(err => {
            overlay.style.display = "none"; // ocultar overlay
            console.log(err);
        });
    });
}