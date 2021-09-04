var base64 = null;
var file = null;



const verifyPDF = file => {
    let reader = new FileReader();
    reader.onload = function(e) {
        const { verified } = verifyPDF(reader.result);
		console.log(verified);
    }
    reader.readAsArrayBuffer(file);
};

const fileToBase64 = file => {
    return new Promise(resolve => {
        var reader = new FileReader();
        // Read file content on file loaded event
        reader.onload = function(event) {
            resolve(event.target.result.replace(/^data:.+;base64,/, ""));
        };
        // Convert data to base64
        reader.readAsDataURL(file);
    });
};
const showPDF = file => {
    var canvas = document.querySelector("canvas");
    var fileReader = new FileReader();

    fileReader.onload = function() {
        var typedarray = new Uint8Array(this.result);
        //fileReader.readAsDataURL(file);
        PDFJS.getDocument(typedarray).then(function(pdf) {
            // you can now use *pdf* here
            console.log("the pdf has ", pdf.numPages, "page(s).");
            pdf.getPage(pdf.numPages).then(function(page) {
                // you can now use *page* here
                var viewport = page.getViewport(2.0);
                canvas.height = viewport.height;
                canvas.width = viewport.width;
                page.render({
                    canvasContext: canvas.getContext("2d"),
                    viewport: viewport
                });
            });
        });
    };
    fileReader.readAsArrayBuffer(file);
};
document.querySelector("#pdf-upload").addEventListener("change", function(e) {
    file = e.target.files[0];
    if (file.type != "application/pdf") {
        console.error(file.name, "is not a pdf file.");
        return;
    }
    fileToBase64(file).then(b64 => {
        base64 = b64;
        //firmarB64(file, b64);
    });
	verifyPDF(file);
    showPDF(file);
});
document.querySelector("#pdf-sign").addEventListener("click", function(e) {
    if(base64!=null && file!=null)firmarB64(file, base64);
});

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
