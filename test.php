<!DOCTYPE html>
<html>

<head>
    <title>Moodle Kursseite</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .course-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 21px;
        }

        #editButton {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        #editButton:hover {
            background-color: #45a049;
        }

        .course-content {
            margin-top: 20px;
            white-space: pre-wrap;
        }

        #addButton {
            background-color: #008CBA;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 0px;
        }

        #addButton:hover {
            background-color: #0077a7;
        }

        #singleContent {
            display: none;
        }

        #saveButton {
            background-color: purple;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 0px;
        }
    </style>
</head>

<body>

    <button id="editButton" onclick="toggleEdit()">Bearbeiten</button>
    <button id="addButton" hidden onclick="addButtons()">Abschnitt hinzufügen</button>
    <button id="saveButton" hidden onclick="saveContentInArray()">Speichern und Bearbeitungsmodus verlassen</button>

    <br>
    <br>
    <br>

    <form class="content" id="content">

        <div id="singleContent">

            <button id="textField" onclick="addTextfield(this.id)">Text</button>
            <button id="studentsFileUpload" onclick="addStudentFileUpload(this.id)">Abgabe Studenten</button>
            <button id="fileUpload" onclick="addFileUpload(this.id)">Datei hochladen</button>
            <button id="dividingLine" onclick="addDividingLine(this.id)">Trennlinie</button>
            <button id="deleteButton" onclick="deleteCurrentDiv(this.id)">X</button>

        </div>

    </form>

    <script>

        let savedHtml = '';

        var count = 0;

        let combinedArray = [];

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


                var newTextarea = document.createElement('textarea');
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

            event.preventDefault();
            document.getElementById('addButton').style.display = 'inline-block';
            document.getElementById('saveButton').style.display = 'inline-block';

            const contentForm = document.getElementById('content')
                     
            if (savedHtml != '')
            {
                
                contentForm.innerHTML = ''
                contentForm.appendChild(savedHtml);
   
                console.log(savedHtml);

                 
            }            

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
                    id: fileInput.id,
                    file: fileInput.files[0],

                };
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

            combinedArray = textareaList.concat(fileInputList).concat(hrList);

            combinedArray.sort((a, b) => {
                const numA = parseInt(a.id.match(/\d+/)[0]);
                const numB = parseInt(b.id.match(/\d+/)[0]);

                return numA - numB;
            });



            arrayToWebsite(combinedArray)

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

            }

            else {

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

                contenDiv.lastChild.remove();

                var buttonOfTextField = document.getElementById(buttonId);
                buttonOfTextField.id = buttonOfTextField.id.replace("true", "");

                buttonOfTextField.innerHTML = buttonOfTextField.id;


                const buttons = contenDiv.querySelectorAll("button");
                buttons.forEach((button) => {

                    button.disabled = false;

                });
            }

            else {

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

            }

            else {


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

        function arrayToWebsite(array) {

            const elementsContainer = document.getElementById('content');

            var originalDiv = document.getElementById('content');

            // Div-Element klonen
            savedHtml = originalDiv.cloneNode(true);                

            elementsContainer.innerHTML = '';
            

            array.forEach((item) => {
                if (item.hasOwnProperty('id')) {

                    if (item.id.includes('textArea')) {
                        // Erstelle ein <div>-Element
                        const div = document.createElement('div');
                        div.id = item.id;
                        div.innerHTML = item.value.replace(/\n/g, '<br>'); // Ersetze Zeilenumbrüche mit <br>-Tags
                        elementsContainer.appendChild(div);
                    }

                    if (item.id.includes('studentFileUpload')) {
                        // Erstelle ein File-Input-Element
                        const fileInput = document.createElement('input');
                        fileInput.type = 'file';
                        fileInput.id = item.id;
                        elementsContainer.appendChild(fileInput)
                    }

                    if (item.id.includes('fileUpload') && !item.id.includes('student')) {

                        if (item.file && item.file.name != null) {
                            // Create a link to display and download the file
                            const fileLink = document.createElement('a');
                            fileLink.href = URL.createObjectURL(item.file);
                            fileLink.download = item.file.name;
                            fileLink.textContent = item.file.name;

                            elementsContainer.appendChild(fileLink);
                        }
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

                    }

                }


            });

            elementsContainer.style.display = "flex";
            elementsContainer.style.flexDirection = "column";


            document.getElementById('addButton').style.display = 'none';
            document.getElementById('saveButton').style.display = 'none';


        }

    </script>
</body>

</html>