var count = 0;
let contentArray = [];
GetArrayFromDatabase();
arrayToWebsite(contentArray);

function addEmptyLine(container) {
    const emptyLine = document.createElement("div");
    emptyLine.classList.add("empty-line");
    container.appendChild(emptyLine);
}

function addTextfield(buttonId) {
    event.preventDefault();

    const element = document.getElementById(buttonId);
    const innerHTMLWert = element.id;

    if (innerHTMLWert.includes("true")) {
        var match = buttonId.match(/\d+/);
        var numberOfButton = match ? parseInt(match[0]) : null;

        var contenDiv = document.getElementById(
            "singleContent" + numberOfButton.toString()
        );

        contenDiv.lastChild.remove();

        var buttonOfTextField = document.getElementById(buttonId);
        buttonOfTextField.id = buttonOfTextField.id.replace("true", "");

        const buttons = contenDiv.querySelectorAll("button");
        buttons.forEach((button) => {
            button.disabled = false;
            button.style.color = "black";
        });

    }
    else {

        var match = buttonId.match(/\d+/);
        var numberOfButton = match ? parseInt(match[0]) : null;

        var newTextarea = document.createElement("textarea");
        newTextarea.className = "TextAreaFieldClass";
        newTextarea.style.resize = "none";
        newTextarea.style.height = "auto";
        newTextarea.style.overflowY = "hidden";
        newTextarea.addEventListener("input", function () {
            this.style.height = this.scrollHeight + "px";
        });
        newTextarea.id = "textArea" + numberOfButton.toString();

        var contenDiv = document.getElementById(
            "singleContent" + numberOfButton.toString()
        );
        newTextarea.style.display = "block";


        contenDiv.appendChild(newTextarea);   

        var buttonOfTextField = document.getElementById(buttonId);
        buttonOfTextField.id = buttonOfTextField.id + "true";

        const buttons = contenDiv.querySelectorAll("button");
        
        buttons.forEach((button) => {
            if (button.id != buttonOfTextField.id) {
                button.disabled = true;
                button.style.color = "gray";
            }
        });
    }
}

function toggleEdit() {
    count = 0;

    event.preventDefault();
    document.getElementById("addButton").style.display = "inline-block";
    document.getElementById("saveButton").style.display = "inline-block";

    const contentForm = document.getElementById("content");
    const firstElement = contentForm.querySelector(":first-child");

    contentForm.innerHTML = firstElement.outerHTML;

    contentArray.forEach((item) => {
        var button = document.getElementById("addButton");
        button.click();
    });

    createEditElements(contentArray);
}

function createEditElements(data) {
    data.forEach((item) => {
        if (item.id.includes("textArea")) {
            var button = document.getElementById(item.id);
            button.click();

            const containerId = item.id;

            const container = document.getElementById(containerId);

            container.value = item.value || "";
        }

        if (item.id.includes("dividingLine")) {
            var button = document.getElementById(item.id);
            button.click();
        }

        if (item.id.includes("FileUpload") && item.id.includes("student")) {
            var button = document.getElementById(item.id);
            button.click();
        }

        if (item.id.includes("fileUpload") && !item.id.includes("student")) {
            var button = document.getElementById(item.id);
            button.click();

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../includes/kursseiteEdit.inc.php?method=getCourseData",false);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        var fileInput = document.getElementById(item.id);

                        var response = xhr.responseText;

                        response = response.replace("connected", "");

                        var base64Blob = response;

                        var blob = base64ToBlob(base64Blob);

                        var blobUrl = URL.createObjectURL(blob);

                        var downloadLink = document.createElement("a");
                        downloadLink.href = blobUrl;
                        downloadLink.download = item.file;
                        downloadLink.textContent = "Aktuelle Datei: " + item.file;

                        fileInput.parentNode.appendChild(downloadLink);

                        
                        const myFile = new File([item.file], item.file, {
                            lastModified: new Date(),
                        });                    
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(myFile);
                        fileInput.files = dataTransfer.files;
                    } else {
                        console.log(
                            "Fehler bei der AJAX-Anfrage. Fehlercode: " + xhr.status
                        );
                    }
                }
            };
            var data = "dataName=" + item.file; 
            xhr.send(data);
        }
    });
}

function base64ToBlob(base64String) {
    var byteCharacters = atob(base64String.split(",")[1]);
    var byteArrays = [];
    for (var i = 0; i < byteCharacters.length; i++) {
        byteArrays.push(byteCharacters.charCodeAt(i));
    }
    return new Blob([new Uint8Array(byteArrays)], {
        type: "image/png",
    });
}

function ContentArrayInFields() { }

function addButtons() {
    event.preventDefault();
    var contentClass = document.getElementsByClassName("content");
    var singleContent = document.getElementById("singleContent");

    var singleContentCopy = singleContent.cloneNode(true);

    var buttonText = singleContentCopy.children[0];
    var buttonStudentUpload = singleContentCopy.children[1];
    var buttonUpload = singleContentCopy.children[2];
    var buttonLine = singleContentCopy.children[3];
    var buttonDelete = singleContentCopy.children[4];

    buttonText.id = buttonText.id + count.toString();
    buttonStudentUpload.id = buttonStudentUpload.id + count.toString();
    buttonUpload.id = buttonUpload.id + count.toString();
    buttonLine.id = buttonLine.id + count.toString();
    buttonDelete.id = buttonDelete.id + count.toString();

    singleContentCopy.id = "singleContent" + count;

    contentClass[0].appendChild(singleContentCopy);
    count += 1;
}

function saveContentInArray() {
    const div = document.getElementById("content");

    const textareaElements = div.querySelectorAll("textarea");

    const textareaList = [];

    textareaElements.forEach((textarea) => {
        const fileObject = {
            id: textarea.id,
            value: textarea.value,
        };
        textareaList.push(fileObject);
    });

    const fileInputElments = div.querySelectorAll("Input");
    const fileInputList = [];

    fileInputElments.forEach((fileInput) => {
        if (fileInput.files[0] != null) {
            const fileObject = {
                id: fileInput.id,
            };

            fileObject.file = fileInput.files[0].name;

            fileInputList.push(fileObject);
        }
        if (fileInput.files[0] == null && !fileInput.id.includes("student")) {
            const num = parseInt(fileInput.id.match(/\d+/));

            if (contentArray[num] == undefined) return;

            const fileObject = {
                id: contentArray[num].id,
            };

            fileObject.file = contentArray[num].file;

            fileInputList.push(fileObject);
        }

        if (fileInput.files[0] == null && fileInput.id.includes("student")) {
            const fileObject = {
                id: fileInput.id,
                file: "",
            };

            fileInputList.push(fileObject);
        }
    });

    const hrElements = div.querySelectorAll("hr");
    const hrList = [];

    hrElements.forEach((hrElement) => {
        const hrObject = {
            id: hrElement.id,
            value: hrElement.value,
        };
        hrList.push(hrObject);
    });

    contentArray = textareaList.concat(fileInputList).concat(hrList);

    contentArray = contentArray.sort((a, b) => {
        const numberA = parseInt(a.id.match(/\d+$/)[0]);
        const numberB = parseInt(b.id.match(/\d+$/)[0]);
        return numberA - numberB;
    });

    SaveContentArrayToDatabase();

    const fileInputElements = div.querySelectorAll('input:not([id*="student"])');
    xhr = new XMLHttpRequest();

    for (let i = 0; i < fileInputElements.length; i++) {
        const fileInput = fileInputElements[i];
        const file = fileInput.files[0];

        if (file == null || fileInput.disabled == true) continue;

        const reader = new FileReader();
        reader.onload = function (event) {
            const base64Data = event.target.result.split(",")[1];
            const courseid = 1;
            const xhr = new XMLHttpRequest();
            xhr.open("POST","../includes/kursseiteEdit.inc.php?method=saveCourseData",false);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        console.log("Datei erfolgreich hochgeladen.");
                    } else {
                        console.log(
                            "Fehler beim Hochladen der Datei. Fehlercode: " + xhr.status
                        );
                    }
                }
            };
            const data = "dataName=" + file.name + "&base64Image=" + encodeURIComponent(base64Data);
            xhr.send(data);
        };

        reader.readAsDataURL(file);
    }
}

function SaveContentArrayToDatabase() {
    var xhr = new XMLHttpRequest();
    xhr.open("POST","../includes/kursseiteEdit.inc.php?method=saveContentArray",false);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                var response = xhr.responseText;
            } else {
                console.log("Fehler bei der AJAX-Anfrage. Fehlercode: " + xhr.status);
            }
        }
    };
    var data = "contentArray=" + JSON.stringify(contentArray);
    xhr.send(data);
}

function addStudentFileUpload(buttonId) {
    event.preventDefault();

    const element = document.getElementById(buttonId);
    const innerHTMLWert = element.id;

    if (innerHTMLWert.includes("true")) {
        var match = buttonId.match(/\d+/);
        var numberOfButton = match ? parseInt(match[0]) : null;

        var contenDiv = document.getElementById(
            "singleContent" + numberOfButton.toString()
        );

        contenDiv.lastChild.remove();

        var buttonOfTextField = document.getElementById(buttonId);
        buttonOfTextField.id = buttonOfTextField.id.replace("true", "");


        const buttons = contenDiv.querySelectorAll("button");
        buttons.forEach((button) => {
            button.disabled = false;
            button.style.color = "black";
        });
    } else {
        var match = buttonId.match(/\d+/);
        var numberOfButton = match ? parseInt(match[0]) : null;

        var newDataUpload = document.createElement("input");
        newDataUpload.id = "studentFileUpload" + numberOfButton.toString();

        var contenDiv = document.getElementById(
            "singleContent" + numberOfButton.toString()
        );
        var newLine = document.createElement("br");

        newDataUpload.style.display = "block";

        newDataUpload.type = "file";
        newDataUpload.disabled = true;

        contenDiv.appendChild(newDataUpload);
       

        var buttonOfTextField = document.getElementById(buttonId);
        buttonOfTextField.id = buttonOfTextField.id + "true";

        const buttons = contenDiv.querySelectorAll("button");
        

        buttons.forEach((button) => {
            if (button.id != buttonOfTextField.id) {
                button.disabled = true;
                button.style.color = "gray";
            }
        });
    }
}

function addFileUpload(buttonId) {
    event.preventDefault();

    const element = document.getElementById(buttonId);
    const innerHTMLWert = element.id;

    if (innerHTMLWert.includes("true")) {
        var match = buttonId.match(/\d+/);
        var numberOfButton = match ? parseInt(match[0]) : null;

        var contenDiv = document.getElementById(
            "singleContent" + numberOfButton.toString()
        );

        for (var i = contenDiv.children.length - 1; i >= 0; i--) {
            var child = contenDiv.children[i];

            if (child.tagName === "A" || child.tagName === "INPUT") {
                contenDiv.removeChild(child);
            }
        }

        var buttonOfTextField = document.getElementById(buttonId);
        buttonOfTextField.id = buttonOfTextField.id.replace("true", "");

      

        const buttons = contenDiv.querySelectorAll("button");
        buttons.forEach((button) => {
            button.disabled = false;
            button.style.color = "black";
        });
    } else {
        var match = buttonId.match(/\d+/);
        var numberOfButton = match ? parseInt(match[0]) : null;

        var newDataUpload = document.createElement("input");
        newDataUpload.id = "fileUpload" + numberOfButton.toString();

        var contenDiv = document.getElementById(
            "singleContent" + numberOfButton.toString()
        );
        var newLine = document.createElement("br");

        newDataUpload.style.display = "block";

        newDataUpload.type = "file";

        contenDiv.appendChild(newDataUpload);
        

        var buttonOfTextField = document.getElementById(buttonId);
        buttonOfTextField.id = buttonOfTextField.id + "true";

        const buttons = contenDiv.querySelectorAll("button");
      

        buttons.forEach((button) => {
            if (button.id != buttonOfTextField.id) {
                button.disabled = true;
                button.style.color = "gray";
            }
        });
    }
}

function addDividingLine(buttonId) {
    event.preventDefault();

    const element = document.getElementById(buttonId);
    const innerHTMLWert = element.id;

    if (innerHTMLWert.includes("true")) {
        var match = buttonId.match(/\d+/);
        var numberOfButton = match ? parseInt(match[0]) : null;

        var contenDiv = document.getElementById(
            "singleContent" + numberOfButton.toString()
        );

        contenDiv.lastChild.remove();

        var buttonOfTextField = document.getElementById(buttonId);
        buttonOfTextField.id = buttonOfTextField.id.replace("true", "");

       

        const buttons = contenDiv.querySelectorAll("button");
        buttons.forEach((button) => {
            button.disabled = false;
            button.style.color = "black";
        });
    } else {
        var match = buttonId.match(/\d+/);
        var numberOfButton = match ? parseInt(match[0]) : null;

        const newLine = document.createElement("hr");

        newLine.id = "dividingLine" + numberOfButton.toString();

        var contenDiv = document.getElementById(
            "singleContent" + numberOfButton.toString()
        );

        contenDiv.appendChild(newLine);

        var buttonOfTextField = document.getElementById(buttonId);
        buttonOfTextField.id = buttonOfTextField.id + "true";

        const buttons = contenDiv.querySelectorAll("button");
       

        buttons.forEach((button) => {
            if (button.id != buttonOfTextField.id) {
                button.disabled = true;
                button.style.color = "gray";
            }
        });
    }
}

function deleteCurrentDiv(buttonId) {
    event.preventDefault();

    const element = document.getElementById(buttonId);
    const innerHTMLWert = element.innerHTML;

  

    var match = buttonId.match(/\d+/);
    var numberOfButton = match ? parseInt(match[0]) : null;

    var contenDiv = document.getElementById(
        "singleContent" + numberOfButton.toString()
    );

    contenDiv.remove();
}

function GetArrayFromDatabase() {
    var xhr = new XMLHttpRequest();
    xhr.open("POST","../includes/kursseiteEdit.inc.php?method=getCourseContent",false);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                var response = xhr.responseText;

                if (response == "connected") {
                    return;
                }

                var response = xhr.responseText;
                var jsonStartIndex = response.indexOf("[");
                var jsonEndIndex = response.lastIndexOf("]");
                var jsonSubstring = response.substring(
                    jsonStartIndex,
                    jsonEndIndex + 1
                );

                var array = JSON.parse(jsonSubstring);

                contentArray = array;
            } else {
                console.log("Fehler bei der AJAX-Anfrage. Fehlercode: " + xhr.status);
            }
        }
    };
    xhr.send();
}

function arrayToWebsite(array) {
    const elementsContainer = document.getElementById("content");
    const firstElement = elementsContainer.querySelector(":first-child");

    elementsContainer.innerHTML = firstElement.outerHTML;

    var button;

    for (let i = 0; i < array.length; i++) {
        const item = array[i];

        if (item.id.includes("textArea")) {
            
            const div = document.createElement("div");
            div.id = item.id;
            div.innerHTML = item.value.replace(/\n/g, "<br>"); 
            elementsContainer.appendChild(div);
            addEmptyLine(elementsContainer);
        }

        if (item.id.includes("studentFileUpload")) {
            
            const fileInput = document.createElement("input");
            fileInput.type = "file";
            fileInput.id = item.id;
            elementsContainer.appendChild(fileInput);
            addEmptyLine(elementsContainer);

            var match = item.id.match(/\d+/);

            button = document.createElement("button");
            button.textContent = "Speichern";
            button.setAttribute("id", "saveStudentFileButton" + match);
            button.setAttribute("class", "saveStudentFileButton" + match);
            button.style.width = "130px";

            fileInput.insertAdjacentElement("afterend", button);

            button.addEventListener("click", function () {
                event.preventDefault();

                var match = button.id.match(/\d+/);

                var studentFileUploadId = "studentFileUpload" + match;

                const fileInputElement = document.querySelector(
                    'input[id*="' + studentFileUploadId + '"]'
                );

                const fileInput = fileInputElement;
                const file = fileInput.files[0];

                GetArrayFromDatabase();

                contentArray[match].file = file.name;

                SaveContentArrayToDatabase();

                xhr = new XMLHttpRequest();

                const reader = new FileReader();
                reader.onload = function (event) {
                    const base64Data = event.target.result.split(",")[1];
                    const xhr = new XMLHttpRequest();
                    xhr.open("POST","../includes/kursseiteEdit.inc.php?method=saveCourseData",false);
                    xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4) {
                            if (xhr.status === 200) {
                                console.log("Datei erfolgreich hochgeladen.");
                            } else {
                                console.log(
                                    "Fehler beim Hochladen der Datei. Fehlercode: " + xhr.status
                                );
                            }
                        }
                    };

                    const data = "dataName=" + file.name + "&base64Image=" + encodeURIComponent(base64Data);
                    xhr.send(data);
                };

                reader.readAsDataURL(file);
            });
        }

        if (item.id.includes("Upload")) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST","../includes/kursseiteEdit.inc.php?method=getCourseData",false);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        var response = xhr.responseText;

                        if (!response.includes("data:")) {
                            return;
                        }

                        response = response.substring(response.indexOf("data"));

                        var byteCharacters = atob(response.split(",")[1]);

                        var byteArrays = [];

                        for (var j = 0; j < byteCharacters.length; j++) {
                            byteArrays.push(byteCharacters.charCodeAt(j));
                        }

                        var blob = new Blob([new Uint8Array(byteArrays)], {
                            type: "image/png",
                        });

                        var blobUrl = URL.createObjectURL(blob);

                        var downloadLink = document.createElement("a");
                        downloadLink.href = blobUrl;
                        downloadLink.download = item.file;
                        downloadLink.textContent = item.file;



                        if (item.id.includes("student")){
                            button.insertAdjacentElement("afterend", downloadLink);
                        }
                        else{

                            elementsContainer.appendChild(downloadLink);
                            addEmptyLine(elementsContainer);

                        }

                    } else {
                        console.log(
                            "Fehler bei der AJAX-Anfrage. Fehlercode: " + xhr.status
                        );
                    }
                }
            };
            var data = "dataName=" + item.file;
            xhr.send(data);
        }

        if (item.id.includes("dividingLine")) {
            const divideLineContainer = document.createElement("div");

            const divideLine = document.createElement("hr");
            divideLineContainer.appendChild(divideLine);

            elementsContainer.appendChild(divideLineContainer);
            addEmptyLine(elementsContainer);
        }
    }

    elementsContainer.style.display = "flex";
    elementsContainer.style.flexDirection = "column";
}
