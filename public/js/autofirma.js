var signature;
var mobile = false;
var filename;
var divMensaje = document.getElementById("divmensaje");
var btn_firmar = document.getElementById("botonFirmar");
var btn_save = document.getElementById("saveFile");
var saveExtension = "*.csig";
var saveDescription = "Firma avanzada CAdES (*.csig)";

var autofirma = false;

if (MiniApplet.isAndroid() == true || MiniApplet.isIOS() == true) {
    mobile = true;
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
    btn_firmar.disabled = true;
    btn_save.disabled = true;

    divMensaje.innerHTML = "&nbsp;";

    var format = "AUTO";
    var params = "";
    try {
        if (mobile == false) {
            //params += "mode=implicit\n";
            params +=
                "signaturePositionOnPageLowerLeftX=100\nsignaturePositionOnPageLowerLeftY=50\nsignaturePositionOnPageUpperRightX=600\nsignaturePositionOnPageUpperRightY=100\nsignaturePage=-1\n";
            params += "layer2Text=Firmado por $$SUBJECTCN$$ el día $$SIGNDATE=dd/MM/yyyy$$\n";
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
                '<div class="iconErrorFirma">Error al firmar</div><br><div style="width:300pt">&nbsp;' +
                e.message +
                "</div>";
        }
        btn_firmar.disabled = false;
    }
}
function firmar() {
    if (isLoad() == false) {
        autofirma = true;
    } else {
        autofirma = false;
    }
    btn_firmar.disabled = true;
    btn_save.disabled = true;

    divMensaje.innerHTML = "&nbsp;";

    var dataB64 = null;
    var format = "AUTO";
    var params;
    try {
        if (mobile == false) {
            params = "mode=implicit";
            if (autofirma == true) {
                dataB64 = null;
            } else {
                var fichero = MiniApplet.getFileNameContentBase64(
                    "Selecciona un archivo ",
                    "",
                    ""
                );
                var separatorIdx = fichero.indexOf("|");
                if (separatorIdx + 1 < fichero.length) {
                    filename = fichero.substring(0, separatorIdx);
                    dataB64 = fichero.substring(separatorIdx + 1);

                    var extension = getExtension(filename) + "";
                    extension = extension.toUpperCase();

                    if (extension == "PDF") {
                        saveExtension = "*.pdf";
                        saveDescription = "Adobe PDF (*.pdf)";
                    } else if (extension == "XML" || extension == "XSIG") {
                        saveExtension = "*.xsig";
                        saveDescription = "Firma XML (*.xsig, *.xml)";
                    }
                }
            }
            console.log(dataB64);
            MiniApplet.sign(
                dataB64,
                "SHA256withRSA",
                format,
                params,
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
                '<div class="iconErrorFirma">Error al firmar</div><br><div style="width:300pt">&nbsp;' +
                e.message +
                "</div>";
        }
        btn_firmar.disabled = false;
    }
}

function guardarFirma() {
    if (mobile == false) {
        if (autofirma == true) {
            MiniApplet.saveDataToFile(
                signature,
                "Guardar firma",
                null,
                null,
                null,
                successSaveCallback,
                errorSaveCallback
            );
        } else {
            var saveFile = MiniApplet.saveDataToFile(
                signature,
                "Guardar firma",
                null,
                null,
                saveDescription
            );
            if (saveFile == true) {
                divMensaje.innerHTML =
                    '<div class="iconOKFirma">Fichero firmado y almacenado correctamente</div><br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;' +
                    filename;
            }
        }
    }
}

function getExtension(filename) {
    return /[.]/.exec(filename) ? /[^.]+$/.exec(filename) : undefined;
}

function mostrarPantalla() {
    if (isLoad() == false) {
        autofirma = true;
    }

    document.getElementById("cargandoApplet").style.display = "none";
    document.getElementById("pantalla").style.display = "block";
    if (mobile == true) {
        document.getElementById("firmaProceso1").style.display = "none";
        document.getElementById("botones").style.display = "none";
        document.getElementById("divmensaje").style.display = "none";

        if (MiniApplet.isAndroid()) {
            document.getElementById("firmaProcesoAND").style.display = "inline";
        } else if (MiniApplet.isIOS()) {
            document.getElementById("firmaProcesoIOS").style.display = "inline";
        }
        document.getElementById("firmaMovil").style.display = "inline";
        document.getElementById("saveFile").style.display = "none";
        document.getElementById("clienteEscritorio").style.display = "none";
        document.getElementById("nota").style.display = "none";
        document.getElementById("nota2").style.display = "inline";
    }
}

function successCallback(signatureB64, certificateB64) {
    signature = signatureB64;
    console.log(signatureB64);
    if (autofirma == false) {
        divMensaje.innerHTML =
            '<div class="iconOKFirma">Fichero firmado correctamente</div><br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;' +
            filename;
    } else {
        divMensaje.innerHTML =
            '<br><div class="iconOKFirma">Fichero firmado correctamente</div><br>&nbsp;';
    }
    btn_firmar.disabled = false;
    btn_save.disabled = false;
}

function errorCallback(errorType, errorMessage) {
    if (
        errorMessage &&
        errorMessage.indexOf("AOCancelledOperationException") == -1 &&
        errorMessage.indexOf("Operacion cancelada por el usuario") == -1
    ) {
        if (errorMessage.indexOf("El almacen no contenia entradas") != -1) {
            divMensaje.innerHTML =
                '<img class="iconStatus" src="/valide/img/iconFALLO.png">No existen certificados en el almacén de su navegador<br><br>';
        } else {
            divMensaje.innerHTML =
                '<div class="iconErrorFirma">Error al firmar</div><br><div style="width:300pt">' +
                errorMessage +
                "</div>";
        }
    }
    btn_firmar.disabled = false;
}

function successSaveCallback() {
    divMensaje.innerHTML =
        '<div class="iconOKFirma">Fichero firmado y almacenado correctamente</div><br>&nbsp;';
}

function errorSaveCallback(errorType, errorMessage) {
    divMensaje.innerHTML =
        '<div class="iconErrorFirma">Error al firmar</div><br><div style="width:300pt">' +
        errorMessage +
        "</div>";
    btn_firmar.disabled = false;
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
