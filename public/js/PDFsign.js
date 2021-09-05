var base64 = null;
var file = null;
var canvas = document.querySelector("canvas");
var fileInput = document.querySelector("#pdf-upload");
var signBtn = document.querySelector("#pdf-sign");
var downloadFile = document.querySelector("#downloadFile");

//var saveBtn = document.querySelector("#pdf-save");
const previewContainer = document.getElementById("previewContainer");
const viewer = document.getElementById("viewerContainer");
const resultContainer = document.getElementById("resultContainer");

var signature;
var mobile = false;
var filename;
var divMensaje = document.getElementById("firmaMsg");
var saveExtension = "*.csig";
var saveDescription = "Firma avanzada CAdES (*.csig)";
var autofirma = false;

var msgSuccess = "Fichero firmado correctamente";
var msgError = "Error al firmar";

var userID = document.getElementById("userID").value;
var reqID = document.getElementById("reqID").value;
var userNIF = document.getElementById("userNIF").value;
var fileName = document.getElementById("fileName").value;
var signedName = document.getElementById("signedName").value;

var signedB64 = "";
if (signedName === null) signedName = userNIF + "_" + fileName;
else downloadPDF();

if (MiniApplet.isAndroid() == true || MiniApplet.isIOS() == true) {
    mobile = true;
}
function getExtension(filename) {
    return /[.]/.exec(filename) ? /[^.]+$/.exec(filename) : undefined;
}
const verify = file => {
    const { verified } = verifyPDF(reader.result);
};

const fileToBase64 = fileData => {
    return new Promise(resolve => {
        resolve(fileData.replace(/^data:.+;base64,/, ""));
        /*var binary = "";
        var b64 = "";
        var bytes = new Uint8Array(fileData);
        var len = bytes.byteLength;
        for (var i = 0; i < len; i++) {
            binary += String.fromCharCode(bytes[i]);
        }
        b64 = window.btoa(binary);
        resolve(b64);*/
    });
};
const showPDF = async (file = "/documents/junta.pdf", type = "file") => {
    if (!pdfjsLib.getDocument || !pdfjsViewer.PDFPageView) {
        // eslint-disable-next-line no-alert
        alert(
            "Please build the pdfjs-dist library using\n  `gulp dist-install`"
        );
    }
    var loadingTask = null;
    const SANDBOX_BUNDLE_SRC =
        "https://cdn.jsdelivr.net/npm/pdfjs-dist@2.9.359/build/pdf.sandbox.js";
    const WORKER_SRC =
        "https://cdn.jsdelivr.net/npm/pdfjs-dist@2.9.359/build/pdf.worker.js";
    const CMAP_URL = "https://cdn.jsdelivr.net/npm/pdfjs-dist@2.9.359/cmaps/";
    const CMAP_PACKED = true;
    const PAGE_TO_VIEW = 1;
    const SCALE = 1.0;
    const SEARCH_FOR = "Centre";

    pdfjsLib.GlobalWorkerOptions.workerSrc = WORKER_SRC;

    const eventBus = new pdfjsViewer.EventBus();
    const pdfLinkService = new pdfjsViewer.PDFLinkService({
        eventBus
    });
    const pdfFindController = new pdfjsViewer.PDFFindController({
        eventBus,
        linkService: pdfLinkService
    });
    const pdfScriptingManager = new pdfjsViewer.PDFScriptingManager({
        eventBus,
        sandboxBundleSrc: SANDBOX_BUNDLE_SRC
    });

    let pdfViewer = new pdfjsViewer.PDFViewer({
        container: viewer,
        scale: SCALE,
        //renderer: "svg",
        findController: pdfFindController,
        scriptingManager: pdfScriptingManager,
        //renderInteractiveForms:true,
        //downloadManager:true,
        //enableScripting: true,
        eventBus

        //linkService: pdfLinkService
    });
    pdfLinkService.setViewer(pdfViewer);
    pdfScriptingManager.setViewer(pdfViewer);
    eventBus.on("pagesinit", function() {
        if (SEARCH_FOR) {
            //pdfFindController.executeCommand("find", { query: SEARCH_FOR });
        }
    });
    if (type == "data") {
        var typedarray = new Uint8Array(file);
        loadingTask = pdfjsLib.getDocument({
            data: typedarray,
            cMapUrl: CMAP_URL,
            cMapPacked: CMAP_PACKED
        });
    }
    if (type == "file") {
        loadingTask = pdfjsLib.getDocument({
            url: file,
            cMapUrl: CMAP_URL,
            cMapPacked: CMAP_PACKED
        });
    }
    loadingTask.promise.then(function(pdfDocument) {
        pdfDocument.getPage(PAGE_TO_VIEW).then(function(pdfPage) {
            var viewport = pdfPage.getViewport({ scale: SCALE });
            viewer.parentElement.style.height = viewport.height + "px";
            /*pdfPage.render({
                canvasContext: canvas.getContext("2d"),
                viewport: viewport
            });*/
        });

        pdfViewer.setDocument(pdfDocument);
    });
};
if (fileInput) {
    fileInput.addEventListener("change", function(e) {
        var file = getFile();
        // Read file content on file loaded event
        var reader = new FileReader();
        reader.onload = function(event) {
            var fileData = event.target.result;
            showPDF(fileData, "data");
            previewContainer.style.display = "block";
        };
        reader.readAsArrayBuffer(file);
    });
}
/*saveBtn.addEventListener("click", function(e) {
    //title, filename, extension
    toPDF(signature);
});*/
if (signBtn) {
    signBtn.addEventListener("click", function(e) {
        var file = getFile();
        // Read file content on file loaded event
        var reader = new FileReader();
        reader.onload = function(event) {
            var fileData = event.target.result;
            fileToBase64(fileData).then(b64 => {
                firmarB64(b64);
            });
        };
        reader.readAsDataURL(file);
    });
}
downloadFile.addEventListener("click", function(e) {
    var element = document.createElement("a");
    element.setAttribute(
        "href",
        "data:application/octet-stream;base64," + signedB64
    );
    element.setAttribute("download", signedName);

    element.style.display = "none";
    document.body.appendChild(element);
    element.click();
    document.body.removeChild(element);
});
function getFile() {
    var file = fileInput.files[0];
    if (file.type != "application/pdf") {
        console.error(file.name, "is not a pdf file.");
        return;
    }
    return file;
}
function downloadPDF() {
    let url = "/requests/" + reqID + "/pdf"; //Ruta que hemos creado para que nos devuelva todas las tareas
    axios
        .get(url)
        .then(function(response) {
            signedB64 = response.data;
            loadResultView();
            downloadFile.disabled = false;
        })
        .catch(function(error) {
            console.log(error);
        });
}
function uploadPDF(b64) {
    let url = "/PDFfromB64"; //Ruta que hemos creado para que nos devuelva todas las tareas
    axios
        .post(url, {
            b64: b64,
            fileName: signedName,
            fileExt: ".pdf",
            userID: userID,
            reqID: reqID
        })
        .then(function(response) {
            signedB64 = response.data;
            loadResultView();
            requestUpdate();
            downloadFile.disabled = false;
        })
        .catch(function(error) {
            console.log(error);
        });
}
function requestUpdate() {
    let url = "/requests/" + reqID; //Ruta que hemos creado para que nos devuelva todas las tareas
    axios
        .put(url, {
            signedName: signedName,
            status: 1
        })
        .then(function(response) {})
        .catch(function(error) {
            console.log(error);
        });
}
function loadResultView() {
    // Decode Base64 to binary and show some information about the PDF file (note that I skipped all checks)
    var bin = window.atob(signedB64);
    console.log(bin);
    console.log("File Size:", Math.round(bin.length / 1024), "KB");
    console.log("PDF Version:", bin.match(/^.PDF-([0-9.]+)/)[1]);
    console.log(
        "Create Date:",
        bin.match(/<xmp:CreateDate>(.+?)<\/xmp:CreateDate>/)[1]
    );
    console.log(
        "Modify Date:",
        bin.match(/<xmp:ModifyDate>(.+?)<\/xmp:ModifyDate>/)[1]
    );
    console.log(
        "Creator Tool:",
        bin.match(/<xmp:CreatorTool>(.+?)<\/xmp:CreatorTool>/)[1]
    );

    // Embed the PDF into the HTML page and show it to the user

    var obj = document.createElement("object");
    obj.style.width = "100%";
    obj.style.height = "842pt";
    obj.type = "application/pdf";
    obj.data = "data:application/pdf;base64," + signedB64;
    resultContainer.appendChild(obj);

    // Insert a link that allows the user to download the PDF file
    /*var link = document.createElement("a");
    link.innerHTML = "Download PDF file";
    link.download = "file.pdf";
    link.href = "data:application/octet-stream;base64," + signedB64;
    document.body.appendChild(link);
    */
}
function isLoad() {
    var tempCliente = document.getElementById("miniApplet");
    var appletLoaded;
    try {
        appletLoaded =
            tempCliente != null && tempCliente.echo() != "Cliente JavaScript";
    } catch (e) {
        appletLoaded = false;
    }
    if (appletLoaded) {
        return true;
    } else {
        return false;
    }
}
function firmarB64(dataB64) {
    if (isLoad() == false) {
        autofirma = true;
    } else {
        autofirma = false;
    }

    divMensaje.innerHTML = "&nbsp;";

    var format = "AUTO";
    var params = "";
    try {
        if (mobile == false) {
            //params += "mode=implicit\n";
            params +=
                "signaturePositionOnPageLowerLeftX=100\nsignaturePositionOnPageLowerLeftY=50\nsignaturePositionOnPageUpperRightX=600\nsignaturePositionOnPageUpperRightY=100\nsignaturePage=-1\n";
            params +=
                "layer2Text=Firmado por $$SUBJECTCN$$ el día $$SIGNDATE=dd/MM/yyyy$$\n";
            params += "layer2FontSize=8\n";
            //params +="signatureRubricImage=\n";

            MiniApplet.sign(
                //"cosign",
                dataB64,
                "SHA256withRSA",
                format,
                params,
                //"baja.pdf",
                successCallback,
                errorCallback
            );
        }
    } catch (e) {
        //Se muestra el mensaje de error si NO es de cancelación de la operación
        if (
            e.message.indexOf("PrivilegedActionException") == -1 &&
            e.message.indexOf("AOCancelledOperationException") == -1 &&
            e.message.indexOf("Error calling method on NPObject") == -1 &&
            e.message.indexOf("Operacion cancelada por el usuario") == -1
        ) {
            divMensaje.innerHTML =
                '<div class="iconErrorFirma">' +
                msgError +
                '</div><br><div style="width:300pt">&nbsp;' +
                e.message +
                "</div>";
        }
    }
}
function successCallback(signatureB64, certificateB64) {
    signature = signatureB64;
    uploadPDF(signatureB64);
    previewContainer.style.display = "none";
    if (autofirma == false) {
        divMensaje.innerHTML =
            '<div class="alert alert-primary">' +
            msgSuccess +
            "</div><br>" +
            filename;
    } else {
        divMensaje.innerHTML =
            '<br><div class="alert alert-primary">' + msgSuccess + "</div><br>";
    }
}
function errorCallback(errorType, errorMessage) {
    if (
        errorMessage &&
        errorMessage.indexOf("AOCancelledOperationException") == -1 &&
        errorMessage.indexOf("Operacion cancelada por el usuario") == -1
    ) {
        if (errorMessage.indexOf("El almacen no contenia entradas") != -1) {
            divMensaje.innerHTML =
                '<img class="alert alert-danger" src="/valide/img/iconFALLO.png">No existen certificados en el almacén de su navegador<br><br>';
        } else {
            divMensaje.innerHTML =
                '<div class="alert alert-danger">' +
                msgError +
                '</div><br><div style="width:300pt">' +
                errorMessage +
                "</div>";
        }
    }
}
function waiting(comando, segundos) {
    var waiting;
    var intento;

    if (waiting) {
        return true;
    } else {
        if (segundos == 0) {
            eval(comando);
        } else {
            segundos = segundos - 1;
        }

        var func = function() {
            this.waiting(comando, segundos);
        };
        setTimeout(func, 1000);
    }
}
