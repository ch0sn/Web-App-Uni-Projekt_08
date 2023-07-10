let savedHtml = '';

            var count = 0;

            let contentArray = [];

            GetArrayFromDatabase()


            function addEmptyLine(id) {

                const elementsContainer = document.getElementById(id);
                const emptyLine = document.createElement('div');
                emptyLine.classList.add('empty-line');
                elementsContainer.appendChild(emptyLine);
            }

            function addTextfield(buttonId) {
                event.preventDefault();

                const element = document.getElementById(buttonId);
                const innerHTMLWert = element.innerHTML;

                if (innerHTMLWert.includes("true")) {


                    var match = buttonId.match(/\d+/);
                    var numberOfButton = match ? parseInt(match[0]) : null;

                    var contenDiv = document.getElementById('singleContent' + numberOfButton.toString());

                    contenDiv.lastChild.remove();

                    var buttonOfTextField = document.getElementById(buttonId);
                    buttonOfTextField.id = buttonOfTextField.id.replace("true", "");

                    buttonOfTextField.innerHTML = buttonOfTextField.id;


                    const buttons = contenDiv.querySelectorAll("button");
                    buttons.forEach((button) => {

                        button.disabled = false;

                    });



                } else {

                    var match = buttonId.match(/\d+/);
                    var numberOfButton = match ? parseInt(match[0]) : null;



                    var bodyCourseClass = document.querySelector('.BodyCourseClass');
                    var bodyCourseClassWidth = getComputedStyle(bodyCourseClass).width;

                    var newTextarea = document.createElement('textarea');
                    newTextarea.style.resize = "none";
                    newTextarea.style.height = "auto";
                    newTextarea.style.width = bodyCourseClassWidth;
                    newTextarea.style.overflowY = "hidden";
                    newTextarea.addEventListener("input", function() {

                        this.style.height = this.scrollHeight + "px";

                    });
                    newTextarea.id = "textArea" + numberOfButton.toString();


                    var contenDiv = document.getElementById('singleContent' + numberOfButton.toString());
                    var newLine = document.createElement('br');

                    newTextarea.style.display = 'block';
                    contenDiv.appendChild(newTextarea);
                    //contentInputs.appendChild(newInputField);

                    var buttonOfTextField = document.getElementById(buttonId);
                    buttonOfTextField.id = buttonOfTextField.id + "true"


                    const buttons = contenDiv.querySelectorAll("button");
                    buttonOfTextField.innerHTML = buttonOfTextField.id;

                    buttons.forEach((button) => {
                        if (button.id != buttonOfTextField.id) {
                            button.disabled = true;
                        }
                    });



                }

            }

            function toggleEdit() {


                count = 0;

                event.preventDefault();
                document.getElementById('addButton').style.display = 'inline-block';
                document.getElementById('saveButton').style.display = 'inline-block';

                const contentForm = document.getElementById('content');
                const firstElement = contentForm.querySelector(':first-child');

                contentForm.innerHTML = firstElement.outerHTML;

                var tes = document.getElementById('content');

                console.log(tes.outerHTML);


                contentArray.forEach(item => {
                    var button = document.getElementById('addButton');
                    button.click(); // Klick auf den Button auslösen 
                });




                createEditElements(contentArray);
                console.log(contentArray);




            }

            function createEditElements(data) {
                data.forEach(item => {
                    if (item.id.includes("textArea")) {

                        var button = document.getElementById(item.id);;
                        button.click(); // Klick auf den Button auslösen

                        const containerId = item.id; // Erzeuge die ID des Containers basierend auf der ID des Objekts

                        console.log(containerId);
                        const container = document.getElementById(containerId); // Finde den Container anhand der ID


                        container.value = item.value || "";


                    }

                    if (item.id.includes("dividingLine")) {

                        var button = document.getElementById(item.id);;
                        button.click(); // Klick auf den Button auslösen

                    }

                    if (item.id.includes("fileUpload")) {


                        var button = document.getElementById(item.id);;
                        button.click();




                        var xhr = new XMLHttpRequest();
                        xhr.open("POST", "../includes/kursseiteEdit.inc.php?method=getTeacherData", false);
                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === 4) {
                                if (xhr.status === 200) {



                                    var fileInput = document.getElementById(item.id);


                                    var response = xhr.responseText;

                                    response = response.replace("connected", "");

                                    var base64Blob = response;

                                    var blob = base64ToBlob(base64Blob);

                                    console.log(blob)

                                    var blobUrl = URL.createObjectURL(blob);

                                    console.log(blobUrl)


                                    var downloadLink = document.createElement('a');
                                    downloadLink.href = blobUrl;
                                    downloadLink.download = item.file;
                                    downloadLink.textContent = item.file;

                                    fileInput.parentNode.appendChild(downloadLink);




                                } else {
                                    console.log("Fehler bei der AJAX-Anfrage. Fehlercode: " + xhr.status);
                                }
                            }
                        };
                        var data = "courseid=1&dataName=" + item.file // Passen Sie hier die Werte entsprechend an
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
                    type: 'image/png'
                });
            }

            function ContentArrayInFields() {


            }

            function loadContent() {

                const newForm = document.createElement('form');

                // Set the class name and ID for the form
                newForm.className = 'content';
                newForm.id = 'content';

                newForm.innerHTML = savedHtml;

                document.body.appendChild(newForm);
            }

            function addButtons() {

                event.preventDefault();
                var contentClass = document.getElementsByClassName('content');
                var singleContent = document.getElementById('singleContent');

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

                buttonText.innerHTML = buttonText.id;

                singleContentCopy.id = "singleContent" + count

                contentClass[0].appendChild(singleContentCopy)

                count += 1;

            }

            function saveContentInArray() {

                const div = document.getElementById('content');

                const textareaElements = div.querySelectorAll('textarea');

                const textareaList = [];

                textareaElements.forEach((textarea) => {

                    const fileObject = {
                        id: textarea.id,
                        value: textarea.value,

                    };
                    textareaList.push(fileObject);

                });

                const fileInputElments = div.querySelectorAll('Input');
                const fileInputList = [];

                fileInputElments.forEach((fileInput) => {

                    const fileObject = {
                        id: fileInput.id
                    };

                    if (!fileObject.id.includes("student")) {

                        console.log(fileInput.id);
                        fileObject.file = fileInput.files[0].name;
                    }
                    fileInputList.push(fileObject);

                });

                const hrElements = div.querySelectorAll('hr');
                const hrList = [];

                hrElements.forEach((hrElement) => {
                    const hrObject = {
                        id: hrElement.id,
                        value: hrElement.value
                    };
                    hrList.push(hrObject);
                });

                contentArray = textareaList.concat(fileInputList).concat(hrList);


                for (var i = 0; i < contentArray.length; i++) {
                    var currentItem = contentArray[i];
                    var id = currentItem.id;
                    var prefix = id.match(/[A-Za-z]+/)[0];
                    var newId = prefix + i;
                    currentItem.id = newId;
                }

                contentArray.sort((a, b) => {
                    const numA = parseInt(a.id.match(/\d+/)[0]);
                    const numB = parseInt(b.id.match(/\d+/)[0]);

                    return numA - numB;
                });

                console.log(contentArray)
                console.log("Arrayyyy");



                var xhr = new XMLHttpRequest();
                xhr.open("POST", "../includes/kursseiteEdit.inc.php?method=saveContentArray", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {


                            var response = xhr.responseText;




                        } else {
                            console.log("Fehler bei der AJAX-Anfrage. Fehlercode: " + xhr.status);
                        }
                    }
                };
                var data = "courseid=1&contentArray=" + JSON.stringify(contentArray);
                xhr.send(data);






                const fileInputElements = div.querySelectorAll('input:not([id*="student"])');
                xhr = new XMLHttpRequest();

                for (let i = 0; i < fileInputElements.length; i++) {
                    const fileInput = fileInputElements[i];
                    const file = fileInput.files[0];

                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const base64Data = event.target.result.split(',')[1];
                        const courseid = 1; // Setze hier den entsprechenden Kurs-ID-Wert

                        const xhr = new XMLHttpRequest();
                        xhr.open('POST', '../includes/kursseiteEdit.inc.php?method=saveTeacherData', true);
                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === 4) {
                                if (xhr.status === 200) {
                                    console.log('Datei erfolgreich hochgeladen.');
                                } else {
                                    console.log('Fehler beim Hochladen der Datei. Fehlercode: ' + xhr.status);
                                }
                            }
                        };

                        const data = 'courseid=1' + '&dataName=' + file.name + '&base64Image=' + encodeURIComponent(base64Data);
                        xhr.send(data);
                    };

                    reader.readAsDataURL(file);
                }

            }

            function addStudentFileUpload(buttonId) {

                event.preventDefault();

                const element = document.getElementById(buttonId);
                const innerHTMLWert = element.innerHTML;

                if (innerHTMLWert.includes("true")) {

                    var match = buttonId.match(/\d+/);
                    var numberOfButton = match ? parseInt(match[0]) : null;

                    var contenDiv = document.getElementById('singleContent' + numberOfButton.toString());

                    contenDiv.lastChild.remove();

                    var buttonOfTextField = document.getElementById(buttonId);
                    buttonOfTextField.id = buttonOfTextField.id.replace("true", "");

                    buttonOfTextField.innerHTML = buttonOfTextField.id;


                    const buttons = contenDiv.querySelectorAll("button");
                    buttons.forEach((button) => {

                        button.disabled = false;

                    });

                } else {

                    var match = buttonId.match(/\d+/);
                    var numberOfButton = match ? parseInt(match[0]) : null;


                    var newDataUpload = document.createElement('input');
                    newDataUpload.id = "studentFileUpload" + numberOfButton.toString();

                    var contenDiv = document.getElementById('singleContent' + numberOfButton.toString());
                    var newLine = document.createElement('br');

                    newDataUpload.style.display = 'block';


                    newDataUpload.type = 'file';
                    newDataUpload.disabled = true;

                    contenDiv.appendChild(newDataUpload);
                    //contentInputs.appendChild(newInputField);

                    var buttonOfTextField = document.getElementById(buttonId);
                    buttonOfTextField.id = buttonOfTextField.id + "true"


                    const buttons = contenDiv.querySelectorAll("button");
                    buttonOfTextField.innerHTML = buttonOfTextField.id;


                    buttons.forEach((button) => {
                        if (button.id != buttonOfTextField.id) {
                            button.disabled = true;
                        }
                    });

                }
            }

            function addFileUpload(buttonId) {

                event.preventDefault();

                const element = document.getElementById(buttonId);
                const innerHTMLWert = element.innerHTML;

                if (innerHTMLWert.includes("true")) {

                    var match = buttonId.match(/\d+/);
                    var numberOfButton = match ? parseInt(match[0]) : null;

                    var contenDiv = document.getElementById('singleContent' + numberOfButton.toString());

                    for (var i = contenDiv.children.length - 1; i >= 0; i--) {
                        var child = contenDiv.children[i];

                        // Überprüfe, ob das Kind ein <a>- oder <input>-Element ist
                        if (child.tagName === 'A' || child.tagName === 'INPUT') {
                            // Entferne das Kind aus dem Container
                            contenDiv.removeChild(child);
                        }
                    }

                    var buttonOfTextField = document.getElementById(buttonId);
                    buttonOfTextField.id = buttonOfTextField.id.replace("true", "");

                    buttonOfTextField.innerHTML = buttonOfTextField.id;


                    const buttons = contenDiv.querySelectorAll("button");
                    buttons.forEach((button) => {

                        button.disabled = false;

                    });
                } else {

                    var match = buttonId.match(/\d+/);
                    var numberOfButton = match ? parseInt(match[0]) : null;


                    var newDataUpload = document.createElement('input');
                    newDataUpload.id = "fileUpload" + numberOfButton.toString();

                    var contenDiv = document.getElementById('singleContent' + numberOfButton.toString());
                    var newLine = document.createElement('br');

                    newDataUpload.style.display = 'block';


                    newDataUpload.type = 'file';


                    contenDiv.appendChild(newDataUpload);
                    //contentInputs.appendChild(newInputField);

                    var buttonOfTextField = document.getElementById(buttonId);
                    buttonOfTextField.id = buttonOfTextField.id + "true"


                    const buttons = contenDiv.querySelectorAll("button");
                    buttonOfTextField.innerHTML = buttonOfTextField.id;


                    buttons.forEach((button) => {
                        if (button.id != buttonOfTextField.id) {
                            button.disabled = true;
                        }
                    });

                }
            }

            function addDividingLine(buttonId) {

                event.preventDefault();

                const element = document.getElementById(buttonId);
                const innerHTMLWert = element.innerHTML;

                if (innerHTMLWert.includes("true")) {



                    var match = buttonId.match(/\d+/);
                    var numberOfButton = match ? parseInt(match[0]) : null;

                    var contenDiv = document.getElementById('singleContent' + numberOfButton.toString());

                    contenDiv.lastChild.remove();

                    var buttonOfTextField = document.getElementById(buttonId);
                    buttonOfTextField.id = buttonOfTextField.id.replace("true", "");

                    buttonOfTextField.innerHTML = buttonOfTextField.id;


                    const buttons = contenDiv.querySelectorAll("button");
                    buttons.forEach((button) => {

                        button.disabled = false;

                    });

                } else {


                    var match = buttonId.match(/\d+/);
                    var numberOfButton = match ? parseInt(match[0]) : null;


                    const newLine = document.createElement('hr')


                    newLine.id = "dividingLine" + numberOfButton.toString();

                    var contenDiv = document.getElementById('singleContent' + numberOfButton.toString());


                    contenDiv.appendChild(newLine);

                    var buttonOfTextField = document.getElementById(buttonId);
                    buttonOfTextField.id = buttonOfTextField.id + "true"


                    const buttons = contenDiv.querySelectorAll("button");
                    buttonOfTextField.innerHTML = buttonOfTextField.id;


                    buttons.forEach((button) => {
                        if (button.id != buttonOfTextField.id) {
                            button.disabled = true;
                        }
                    });

                }

            }

            function deleteCurrentDiv(buttonId) {
                event.preventDefault();


                const element = document.getElementById(buttonId);
                const innerHTMLWert = element.innerHTML;

                element.innerHTML = element.id;


                var match = buttonId.match(/\d+/);
                var numberOfButton = match ? parseInt(match[0]) : null;

                var contenDiv = document.getElementById('singleContent' + numberOfButton.toString());

                contenDiv.remove();

            }


            function GetArrayFromDatabase() {



                var xhr = new XMLHttpRequest();
                xhr.open("POST", "../includes/kursseiteEdit.inc.php?method=getCourseContent", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            var response = xhr.responseText;


                            if (response == "connected") {
                                return;
                            }




                            var response = xhr.responseText;
                            var jsonStartIndex = response.indexOf("[");
                            var jsonEndIndex = response.lastIndexOf("]");
                            var jsonSubstring = response.substring(jsonStartIndex, jsonEndIndex + 1);


                            console.log(response);
                            var array = JSON.parse(jsonSubstring);
                            arrayToWebsite(array)
                            contentArray = array;

                            console.log(contentArray)




                        } else {
                            console.log("Fehler bei der AJAX-Anfrage. Fehlercode: " + xhr.status);
                        }
                    }
                };
                var data = "courseid=1";
                xhr.send(data);
            }



            function arrayToWebsite(array) {










                const elementsContainer = document.getElementById('content');
                const firstElement = elementsContainer.querySelector(':first-child');

                elementsContainer.innerHTML = firstElement.outerHTML;




                for (let i = 0; i < array.length; i++) {
                    const item = array[i];


                    if (item.id.includes('textArea')) {
                        // Erstelle ein <div>-Element
                        const div = document.createElement('div');
                        div.id = item.id;
                        div.innerHTML = item.value.replace(/\n/g, '<br>'); // Ersetze Zeilenumbrüche mit <br>-Tags
                        elementsContainer.appendChild(div);
                        const emptyLine = document.createElement('div');
                        emptyLine.classList.add('empty-line');
                        elementsContainer.appendChild(emptyLine);








                    }

                    if (item.id.includes('studentFileUpload')) {
                        // Erstelle ein File-Input-Element
                        const fileInput = document.createElement('input');
                        fileInput.type = 'file';
                        fileInput.id = item.id;
                        elementsContainer.appendChild(fileInput)
                        const emptyLine = document.createElement('div');
                        emptyLine.classList.add('empty-line');
                        elementsContainer.appendChild(emptyLine);
                    }

                    if (item.id.includes('fileUpload') && !item.id.includes('student')) {




                        var xhr = new XMLHttpRequest();
                        xhr.open("POST", "../includes/kursseiteEdit.inc.php?method=getTeacherData", false);
                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === 4) {
                                if (xhr.status === 200) {


                                    var response = xhr.responseText;

                                    if (!response.includes('data:')) {
                                        return;
                                    }

                                    response = response.substring(response.indexOf('data'));



                                    // Erstellen der URL für den Blob
                                    // Decodiere das Base64-Bild in einen Byte-Array
                                    var byteCharacters = atob(response.split(',')[1]);

                                    // Erstelle ein Byte-Array
                                    var byteArrays = [];

                                    for (var j = 0; j < byteCharacters.length; j++) {
                                        byteArrays.push(byteCharacters.charCodeAt(j));
                                    }

                                    // Konvertiere das Byte-Array in ein Blob
                                    var blob = new Blob([new Uint8Array(byteArrays)], {
                                        type: 'image/png'
                                    });

                                    // Erstelle die URL für das Blob
                                    var blobUrl = URL.createObjectURL(blob);

                                    // Erstelle den Download-Link
                                    var downloadLink = document.createElement('a');
                                    downloadLink.href = blobUrl;
                                    downloadLink.download = item.file; // Dateiname für den Download
                                    downloadLink.textContent = item.file;

                                    // Füge den Download-Link zum Dokument hinzu
                                    elementsContainer.appendChild(downloadLink);


                                    // Verwenden Sie 'blobUrl' für Ihren Dateilink oder andere Zwecke

                                } else {
                                    console.log("Fehler bei der AJAX-Anfrage. Fehlercode: " + xhr.status);
                                }
                            }
                        };
                        var data = "courseid=1&dataName=" + item.file // Passen Sie hier die Werte entsprechend an
                        xhr.send(data);





                    }

                    if (item.id.includes('dividingLine')) {
                        // Erstelle eine Trennlinie
                        const divideLineContainer = document.createElement('div');


                        // Erstelle eine Trennlinie
                        const divideLine = document.createElement('hr');

                        // Füge die Trennlinie dem Container hinzu
                        divideLineContainer.appendChild(divideLine);

                        // Füge den Container mit der Trennlinie zu elementsContainer hinzu
                        elementsContainer.appendChild(divideLineContainer);
                        const emptyLine = document.createElement('div');
                        emptyLine.classList.add('empty-line');
                        elementsContainer.appendChild(emptyLine);

                    }




                }

                elementsContainer.style.display = "flex";
                elementsContainer.style.flexDirection = "column";




            }