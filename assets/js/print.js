const sizeFont = 11;
const lineHeight = sizeFont * 0.36;
const font = 'helvetica';
const margeinLeft = 5;
let Yvalue = 10;
const maxWidth = 199;

const { jsPDF } = window.jspdf;
async function descargarPDF() {
    const btn = document.getElementById("btnDownload");
    const text = document.getElementById("btnText");
    const loader = document.getElementById("btnLoader");
    btn.disabled = true;
    text.innerText = "Generando...";
    loader.style.display = "inline";

    const pdf = new jsPDF({
        unit: 'mm',
        format: 'a4',
        orientation: 'portrait'
    });

    for (const item of jsonpdf) {
        switch (item.type) {
            case 1:
                await addImageURL(pdf, item.imageurl);
                break;
            case 2:
                await addImage(pdf, item.image);
                break;
            case 3:
                await addnewPage(pdf);
                break;
            case 4:
                await addTitle(pdf, item.text);
                break;
            case 5:
                await addText(pdf, item.text);
                break;
            case 6:
                await addTitleWidthText(pdf, item);
                break;
            case 7:
                await addSubTitle(pdf, item.text);
                break;
            case 8:
                await addText(pdf, item.text, false);
                break;
            case 9:
                await addImageSize(pdf, item.image,item.size);
                break;
            case 10:
                await addText(pdf, item.text,false,true);
                break;
            case 11:
                await addTextCenter(pdf, item.text);
                break;
            default:
                break;
        }
    }
    pdf.save(filenamepdf + '.pdf');

    btn.disabled = false;
    text.innerText = "DESCARGAR";
    loader.style.display = "none";
    //location.reload();
}


async function addImageURL(pdf, url) {
    const imgWidth = 40;
    const pageWidth = pdf.internal.pageSize.getWidth();
    const x = (pageWidth - imgWidth) / 2;

    return new Promise(resolve => {
        const img = new Image();
        img.crossOrigin = 'Anonymous';
        img.src = url;
        img.onload = () => {
            pdf.addImage(img, 'PNG', x, Yvalue, imgWidth, imgWidth);
            Yvalue += 30;
            resolve();
        };
    });
}

async function addImage(pdf, value,mb = "") {
    const elemento = document.getElementById(value);
    //fix margin
  
    const canvas = await html2canvas(elemento, { scale: 2, useCORS: true });

    const imgData = canvas.toDataURL('image/png');

    pdf.addImage(imgData, 'PNG', margeinLeft, Yvalue, maxWidth, 0);
    const imgHeightPx = canvas.height;
    const imgWidthPx = canvas.width;
    const imgWidthMm = maxWidth;
    const imgHeightMm = (imgHeightPx * imgWidthMm) / imgWidthPx;
    Yvalue += imgHeightMm;
    //Yvalue += 30;
    await addnewLine(pdf);
}
async function addImageSize(pdf, value,size) {
    const scale = 0.85;
    const scale2 = 0.80;

    const elemento = document.getElementById(value);
    const canvas = await html2canvas(elemento, { scale: 2, useCORS: true });

    const resizedCanvas = document.createElement("canvas");
    resizedCanvas.width = Math.floor(canvas.width * scale);
    resizedCanvas.height = Math.floor(canvas.height * scale2);
    const ctx = resizedCanvas.getContext("2d");
    ctx.drawImage(canvas,0,0,resizedCanvas.width,resizedCanvas.height);
    const imgData = resizedCanvas.toDataURL("image/png");
    //const imgData = canvas.toDataURL('image/png');
    const width = maxWidth * scale;
    const extra = (maxWidth - width)/2;
    pdf.addImage(imgData, 'PNG', margeinLeft+extra, Yvalue, width, 0);
    const imgHeightPx = canvas.height;
    const imgWidthPx = canvas.width;
    const imgWidthMm = maxWidth;
    const imgHeightMm = (imgHeightPx * imgWidthMm) / imgWidthPx;
    Yvalue += imgHeightMm;
    //Yvalue += 30;
    await addnewLine(pdf);
}
async function addImageSizeHeight(pdf, value, size) {

    const elemento = document.getElementById(value);
    const canvas = await html2canvas(elemento, {
        scale: 2,
        useCORS: true
    });

    const resizedCanvas = document.createElement("canvas");

    resizedCanvas.height = Math.floor(canvas.height * size);
    resizedCanvas.width = Math.floor(canvas.width * size);

    const ctx = resizedCanvas.getContext("2d");

    ctx.drawImage(
        canvas,
        0,
        0,
        resizedCanvas.width,
        resizedCanvas.height
    );

    const imgData = resizedCanvas.toDataURL("image/png");

    const imgHeightPx = resizedCanvas.height;
    const imgWidthPx = resizedCanvas.width;

    const imgHeightMm = imgHeightPx * size;
    const imgWidthMm = (imgWidthPx * imgHeightMm) / imgHeightPx;

    const extra = (maxWidth - imgWidthMm) / 2;

    pdf.addImage(
        imgData,
        'PNG',
        margeinLeft + extra,
        Yvalue,
        imgWidthMm,
        imgHeightMm
    );

    Yvalue += imgHeightMm;

    await addnewLine(pdf);
}
async function addTitleWidthText(pdf, value) {
    pdf.setFont(font, 'bold');
    pdf.text(value.subtitle, margeinLeft, Yvalue);
    pdf.setFont(font, 'normal');
    let increment = 3;
    if (value.subtitle.length > 25) {
        increment = 6;
    }
    let anchoTitulo = pdf.getTextWidth(value.subtitle) + increment;
    pdf.text(value.text, (margeinLeft + anchoTitulo), Yvalue, { maxWidth: maxWidth - anchoTitulo, align: 'justify' });
    let length = (value.subtitle + value.text).length;
    if (length > 94) {
        const count = length / 94;
        Yvalue += count * lineHeight;
    }

    await addnewLine(pdf);

}
async function addText(pdf, text, justificated = true,bold = false) {
    pdf.setFontSize(sizeFont);
    pdf.setFont(font, 'normal');
    if(bold){
        pdf.setFont(font, 'bold');
    }
    const lines = pdf.splitTextToSize(text, maxWidth);
    const textHeight = lines.length * lineHeight;

    if (Yvalue + textHeight > 285) {
        pdf.addPage();
        Yvalue = 10;
    }

    if (!justificated) {
        pdf.text(text, margeinLeft, Yvalue, { maxWidth: maxWidth });
    } else {
        pdf.text(text, margeinLeft, Yvalue, { maxWidth: maxWidth, align: 'justify' });
    }
    Yvalue += textHeight;

    await addnewLine(pdf);
}
async function addTextCenter(pdf, text) {
    pdf.setFontSize(sizeFont);
    pdf.setFont(font, 'normal');
   
    pdf.text(text, maxWidth/2 , Yvalue, { maxWidth: maxWidth, align: 'center' });

    await addnewLine(pdf);
}
async function addTitle(pdf, text) {
    pdf.setFont(font, 'bold');
    pdf.setFontSize(16);
    pdf.text(text, 105, Yvalue, { maxWidth: maxWidth, align: 'center' });
    await addnewLine(pdf);
}
async function addSubTitle(pdf, text) {
    pdf.setFont(font, 'bold');
    pdf.text(text, margeinLeft, Yvalue, { maxWidth: maxWidth });
    await addnewLine(pdf);
}
async function addnewLine(pdf) {
    Yvalue += lineHeight;
    if (Yvalue > 260) {
        pdf.addPage();
        Yvalue = 10;
        await addImage(pdf, "contenidoID");
        await addnewLine(pdf);
    }
    pdf.setFontSize(sizeFont);
    pdf.setFont(font, 'normal');
}
async function addnewPage(pdf) {
    pdf.addPage();
    Yvalue = 10;
    await addImage(pdf, "contenidoID");
    Yvalue = 30;
}