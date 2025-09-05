function getDateFormatContract() {
  const d = new Date();
  const pad = n => String(n).padStart(2, '0');
  return `${d.getFullYear()}${pad(d.getMonth()+1)}${pad(d.getDate())}`;
}

function printContent(type_question_id,id,belong_id,baremo_id) {

    var datos = `${type_question_id}|${id}|${belong_id}|${baremo_id}`;
    var base64 = btoa(datos);
    var form = document.getElementById("formprint");
    document.getElementById("type_question_id").value = base64;
    const divs = ['contenido1', 'contenido2', 'contenido3']; 
    const inputs = ['image_contenido1', 'image_contenido2', 'image_contenido3'];
    let capturados = 0;
    divs.forEach((divId, index) => {
        html2canvas(document.getElementById(divId)).then(canvas => {
            const ctx = canvas.getContext("2d", { willReadFrequently: true });

            // Aquí podrías manipular píxeles si quieres, ejemplo:
            // let imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);

            const imgData = canvas.toDataURL('image/png');
            document.getElementById(inputs[index]).value = imgData;
            capturados++;

            // Si se han capturado los tres divs, enviar el formulario
            if (capturados === divs.length) {
                
            }
        });
    });
    form.submit();
}