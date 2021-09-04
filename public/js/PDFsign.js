var base64 = null;
var file = null;
var fileInput = document.querySelector("#pdf-upload");
var signBtn = document.querySelector("#pdf-sign");
const viewer = document.getElementById("viewerContainer");
var canvas = document.querySelector("canvas");

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
            viewer.parentElement.style.height=viewport.height+"px";
            /*pdfPage.render({
                canvasContext: canvas.getContext("2d"),
                viewport: viewport
            });*/
        });
        
        pdfViewer.setDocument(pdfDocument);
    });
};
fileInput.addEventListener("change", function(e) {
    var file = getFile();
    // Read file content on file loaded event
    var reader = new FileReader();
    reader.onload = function(event) {
        var fileData = event.target.result;
        showPDF(fileData, "data");
        signBtn.style.display = "block";
    };
    reader.readAsArrayBuffer(file);
});
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
function getFile() {
    var file = fileInput.files[0];
    if (file.type != "application/pdf") {
        console.error(file.name, "is not a pdf file.");
        return;
    }
    return file;
}
function toPDF(b64) {
    // Decode Base64 to binary and show some information about the PDF file (note that I skipped all checks)
    var bin = window.atob(b64);
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
    obj.data = "data:application/pdf;base64," + b64;
    document.body.appendChild(obj);

    // Insert a link that allows the user to download the PDF file
    var link = document.createElement("a");
    link.innerHTML = "Download PDF file";
    link.download = "file.pdf";
    link.href = "data:application/octet-stream;base64," + b64;
    document.body.appendChild(link);
}
//showPDF2();
