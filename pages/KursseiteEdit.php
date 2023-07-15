<?php
include_once "../header.php";
?>

<body>
    <link rel="stylesheet" href="../css/KursseiteEdit.css">
    <link rel="stylesheet" href="../css/GrunddesignKursseiten.css">
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Disable all clickable elements on the page except for the popup form
            var elementsToDisable = document.querySelectorAll(
                "a, li, label, textarea, button, input, img");
            for (var i = 0; i < elementsToDisable.length; i++) {
                if (!elementsToDisable[i].closest(".popup-form")) {
                    elementsToDisable[i].setAttribute("disabled", "disabled");
                    elementsToDisable[i].classList.add("blur-effect");
                }
            }
        });
    </script>






    <!-- linke Bar -->
    <div class="barLeft">
    </div>

    <div class="gridCoursesClass">

    <div class="HeaderCourseClass">
        <?php
        if (!isset($_GET['courseid'])) {
            echo '<h1></h1>';
            echo '<title>Kurserstellung</title>';
        } else {
            include_once "../includes/functions.inc.php";
            $courseIdNr = $_GET['courseid'];
            /* Abmeldebutton wird hinzugefügt, falls Kurs existiert (also in der SQL-Tabelle "courses" */
            echo '<div class="abmeldeClass">
                    <form action="../includes/delisting.inc.php?userid=' . $_SESSION['usersID'] . '&courseid=' . $courseIdNr . '"' . 'method="post">
                    <button type="submit" id="abmelde_button"><img src="/img/64px_exit.png" alt="abmelden" style="height: 50px;"></button>
                    <label for="abmelde_Checkbox"></label>
                    </form>  
                  </div>';

                getExistingCourseInfo($courseIdNr);
            }
            ?>

        </div>

        <form class='popup-form' action="../includes/courseEdit.inc.php" method="post">
            <h1>Kurserstellung</h1>
            <!-- Kursname-Eingabefeld -->
            <input type='text' id="course_name" name="course_name" placeholder="Kursname eingeben" />
            <!-- Fachbereich-Auswahl -->
            <select id="course_subjectarea" name="course_subjectarea">
                <option value="" selected="selected">Alle Fachbereiche</option>
                <option value="B">B (01)</option>
                <option value="EI">EI (02)</option>
                <option value="ME">ME (03)</option>
                <option value="LSE">LSE (04)</option>
                <option value="GES">GES (05)</option>
                <option value="MNI">MNI (06)</option>
                <option value="MND">MND (13)</option>
            </select>
            <!-- Semester-Auswahl, wo der Kurs angeboten wird -->
            <select id="course_semesternumber" name="course_semesternumber">
                <option value="" selected="selected">Alle Semester</option>
                <option value="1">1.Semester</option>
                <option value="2">2.Semester</option>
                <option value="3">3.Semester</option>
                <option value="4">4.Semester</option>
                <option value="5">5.Semester</option>
            </select>
            <!-- Semesterzeit-Auswahl -->
            <div class="rg_course_semestertime">
                <input type="radio" id="winter" name="course_semestertime" value="Winter"><label for="winter">Wintersemester</label>
                <input type="radio" id="summer" name="course_semestertime" value="Sommer"><label for="summer">Sommersemester</label>
            </div>
            <!-- Einschreibeschlüssel-Eingabe -->
            <input type="password" name="coursePassword" id="coursePassword" placeholder="(optional) Einschreibeschlüssel eingeben">
            <button type="submit" id="course_completion_btn">Erstellen</button>

            <div id="popup-bottom">
                <button type="button" id="course_completion_cancel_btn"><a href="../pages/mainsite.php">Abbrechen</a></button>

            <!-- Falls "error" in der URL übergeben wird, handelt es sich um ein Fehler. -->
            <?php
            if (!isset($_GET['error'])) {
            } else {
                $errorCheck = $_GET['error'];
                if ($errorCheck == "emptyfield") {
                    echo "<p class='error'>Fehler: Sie haben nicht die benötigten Daten eingetragen.</p><i>*Einschreibeschlüssel ist nicht verpflichtend.</i>";
                }
            }

             /* Falls "courseid" in der URL übergeben wird, war die Kurserstellung erfolgreich und
                Weichenzeichner, sowie die restlichen Buttons funktionieren wieder.*/
            if (!isset($_GET['courseid'])) {
            } else {
                $courseExists = $_GET['courseid'];
                if ($courseExists) {
                    echo '<script> 
                      document.addEventListener("DOMContentLoaded", function() {
                      // Disable all clickable elements on the page except for the popup form
                        var elementsToDisable = document.querySelectorAll(
                                                "a, li, label, textarea, button, input, img, class");
        
                        // Remove the disabled attribute from the elements
                        for (var i = 0; i < elementsToDisable.length; i++) {
                            elementsToDisable[i].removeAttribute("disabled");
                            elementsToDisable[i].classList.remove("blur-effect");
                        }                 
                      });
                    // Hide the popup form
                      var popupForm = document.querySelector(".popup-form");
                      popupForm.style.visibility = "hidden";
                      popupForm.style.pointerEvents = "none";</script>';
            }
        }
        ?>
        </div>
    </form>

    <!-- Falls "enrolled" in der URL übergeben wird, wird bei einem "no" die Einschreibeseite angezeigt.
         Mit der Einschreibung wird dann ein Eintrag in "enrollment" gespeichert. -->
    <?php
    if (!isset($_GET['enrolled'])) {
    } else {
        $enrolled = $_GET['enrolled'];
        if ($enrolled == "no") {
            include "Einschreibeseite.php";
            exit();
        }
    }
    ?>

        <div class="BodyCourseClass">


            <?php
            if (!isset($_GET['courseid'])) {
            } else {
                if (
                    isset($_SESSION["role"]) && $_SESSION['role'] == "dozent" &&
                    $_SESSION['usersID'] == getCourseTeacherByCourseId($_GET['courseid'])
                ) {
                    echo ' <button id="editButton" onclick="toggleEdit()">Bearbeiten</button>';
                }
            }
            ?>
            <button id="addButton" hidden onclick="addButtons()">Abschnitt hinzufügen</button>
            <button id="saveButton" hidden onclick="saveContentInArray(); GetArrayFromDatabase(); arrayToWebsite(contentArray);
        
                document.getElementById('addButton').style.display = 'none';
                document.getElementById('saveButton').style.display = 'none';
        ">Speichern und Bearbeitungsmodus verlassen</button>

            <br>
            <br>
            <br>

            <form class="content" id="content">

                <div id="singleContent">


                    <button class="textAreaClass" id="textArea" onclick="addTextfield(this.id);">Text</button>
                    <button class="studentsFileUploadClass" id="studentFileUpload" onclick="addStudentFileUpload(this.id); ">Abgabe Studenten</button>
                    <button class="fileUploadClass" id="fileUpload" onclick="addFileUpload(this.id); ">Datei hochladen</button>
                    <button class="dividingLineClass" id="dividingLine" onclick="addDividingLine(this.id);">Trennlinie</button>
                    <button class="deleteButtonClass" id="deleteButton" onclick="deleteCurrentDiv(this.id); ">X</button>



                </div>

            </form>

            <script src="../KursseiteEdit.js"></script>



           <!--  <script>
                var count = 0;
                let contentArray = [];
                GetArrayFromDatabase()
                arrayToWebsite(contentArray);


                function addEmptyLine(container) {

                    const emptyLine = document.createElement('div');
                    emptyLine.classList.add('empty-line');
                    container.appendChild(emptyLine);
                }

                function addTextfield(buttonId) {
                    event.preventDefault();

                    const element = document.getElementById(buttonId);
                    const innerHTMLWert = element.id;

                    if (innerHTMLWert.includes("true")) {


                        var match = buttonId.match(/\d+/);
                        var numberOfButton = match ? parseInt(match[0]) : null;

                        var contenDiv = document.getElementById('singleContent' + numberOfButton.toString());

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

                        var bodyCourseClass = document.querySelector('.BodyCourseClass');
                        var bodyCourseClassWidth = getComputedStyle(bodyCourseClass).width;



                        var newTextarea = document.createElement('textarea');
                        newTextarea.className = "TextAreaFieldClass";
                        newTextarea.style.resize = "none";
                        newTextarea.style.height = "auto";
                        //newTextarea.style.width = bodyCourseClassWidth;
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
                        //buttonOfTextField.innerHTML = buttonOfTextField.id;

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
                    document.getElementById('addButton').style.display = 'inline-block';
                    document.getElementById('saveButton').style.display = 'inline-block';

                    const contentForm = document.getElementById('content');
                    const firstElement = contentForm.querySelector(':first-child');

                    contentForm.innerHTML = firstElement.outerHTML;

                    var tes = document.getElementById('content');




                    contentArray.forEach(item => {
                        var button = document.getElementById('addButton');
                        button.click();
                    });


                    createEditElements(contentArray);





                }

                function createEditElements(data) {
                    data.forEach(item => {
                        if (item.id.includes("textArea")) {

                            var button = document.getElementById(item.id);;
                            button.click();

                            const containerId = item.id;


                            const container = document.getElementById(containerId);


                            container.value = item.value || "";


                        }

                        if (item.id.includes("dividingLine")) {

                            var button = document.getElementById(item.id);;
                            button.click();

                        }

                        if (item.id.includes("FileUpload") && item.id.includes("student")) {



                            var button = document.getElementById(item.id);;
                            button.click();






                        }

                        if (item.id.includes("fileUpload") && !item.id.includes("student")) {


                            var button = document.getElementById(item.id);;
                            button.click();

                            var xhr = new XMLHttpRequest();
                            xhr.open("POST", "../includes/kursseiteEdit.inc.php?method=getCourseData", false);
                            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                            xhr.onreadystatechange = function() {
                                if (xhr.readyState === 4) {
                                    if (xhr.status === 200) {



                                        var fileInput = document.getElementById(item.id);


                                        var response = xhr.responseText;

                                        response = response.replace("connected", "");

                                        var base64Blob = response;

                                        var blob = base64ToBlob(base64Blob);



                                        var blobUrl = URL.createObjectURL(blob);




                                        var downloadLink = document.createElement('a');
                                        downloadLink.href = blobUrl;
                                        downloadLink.download = item.file;
                                        downloadLink.textContent = "Aktuelle Datei: " + item.file;

                                        fileInput.parentNode.appendChild(downloadLink);





                                        // Create a new File object
                                        const myFile = new File([item.file], item.file, {

                                            lastModified: new Date(),
                                        });

                                        // Now let's create a DataTransfer to get a FileList
                                        const dataTransfer = new DataTransfer();
                                        dataTransfer.items.add(myFile);
                                        fileInput.files = dataTransfer.files;




                                    } else {
                                        console.log("Fehler bei der AJAX-Anfrage. Fehlercode: " + xhr.status);
                                    }
                                }
                            };
                            var data = "courseid=1&dataName=" + item.file; // Passen Sie hier die Werte entsprechend an
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

                        if (fileInput.files[0] != null) {
                            const fileObject = {
                                id: fileInput.id
                            };


                            fileObject.file = fileInput.files[0].name;


                            fileInputList.push(fileObject);




                        }
                        if (fileInput.files[0] == null && !fileInput.id.includes("student")) {


                            const num = parseInt(fileInput.id.match(/\d+/));

                            if (contentArray[num] == undefined) return;

                            const fileObject = {
                                id: contentArray[num].id
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
                        reader.onload = function(event) {
                            const base64Data = event.target.result.split(',')[1];
                            const courseid = 1;
                            const xhr = new XMLHttpRequest();
                            xhr.open('POST', '../includes/kursseiteEdit.inc.php?method=saveCourseData', false);
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

                function SaveContentArrayToDatabase() {
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "../includes/kursseiteEdit.inc.php?method=saveContentArray", false);
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
                }

                function clearDataArray() {


                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "../includes/kursseiteEdit.inc.php?method=cleanContentArray", false);
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






                }

                function addStudentFileUpload(buttonId) {

                    event.preventDefault();

                    const element = document.getElementById(buttonId);
                    const innerHTMLWert = element.id;

                    if (innerHTMLWert.includes("true")) {

                        var match = buttonId.match(/\d+/);
                        var numberOfButton = match ? parseInt(match[0]) : null;

                        var contenDiv = document.getElementById('singleContent' + numberOfButton.toString());

                        contenDiv.lastChild.remove();

                        var buttonOfTextField = document.getElementById(buttonId);
                        buttonOfTextField.id = buttonOfTextField.id.replace("true", "");

                        //buttonOfTextField.innerHTML = buttonOfTextField.id;


                        const buttons = contenDiv.querySelectorAll("button");
                        buttons.forEach((button) => {

                            button.disabled = false;
                            button.style.color = "black";

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
                        //buttonOfTextField.innerHTML = buttonOfTextField.id;


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

                        var contenDiv = document.getElementById('singleContent' + numberOfButton.toString());

                        for (var i = contenDiv.children.length - 1; i >= 0; i--) {
                            var child = contenDiv.children[i];


                            if (child.tagName === 'A' || child.tagName === 'INPUT') {

                                contenDiv.removeChild(child);
                            }
                        }

                        var buttonOfTextField = document.getElementById(buttonId);
                        buttonOfTextField.id = buttonOfTextField.id.replace("true", "");

                        //buttonOfTextField.innerHTML = buttonOfTextField.id;


                        const buttons = contenDiv.querySelectorAll("button");
                        buttons.forEach((button) => {

                            button.disabled = false;
                            button.style.color = "black";

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
                        //buttonOfTextField.innerHTML = buttonOfTextField.id;


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

                        var contenDiv = document.getElementById('singleContent' + numberOfButton.toString());

                        contenDiv.lastChild.remove();

                        var buttonOfTextField = document.getElementById(buttonId);
                        buttonOfTextField.id = buttonOfTextField.id.replace("true", "");

                        //buttonOfTextField.innerHTML = buttonOfTextField.id;


                        const buttons = contenDiv.querySelectorAll("button");
                        buttons.forEach((button) => {

                            button.disabled = false;
                            button.style.color = "black";

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
                        //buttonOfTextField.innerHTML = buttonOfTextField.id;


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

                    //element.innerHTML = element.id;


                    var match = buttonId.match(/\d+/);
                    var numberOfButton = match ? parseInt(match[0]) : null;

                    var contenDiv = document.getElementById('singleContent' + numberOfButton.toString());

                    contenDiv.remove();

                }


                function GetArrayFromDatabase() {

                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "../includes/kursseiteEdit.inc.php?method=getCourseContent", false);
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



                                var array = JSON.parse(jsonSubstring);

                                contentArray = array;



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

                    var button;

                    for (let i = 0; i < array.length; i++) {
                        const item = array[i];


                        if (item.id.includes('textArea')) {
                            // Erstelle ein <div>-Element
                            const div = document.createElement('div');
                            div.id = item.id;
                            div.innerHTML = item.value.replace(/\n/g, '<br>'); // Ersetze Zeilenumbrüche mit <br>-Tags
                            elementsContainer.appendChild(div);
                            addEmptyLine(elementsContainer);

                        }

                        if (item.id.includes('studentFileUpload')) {
                            // Erstelle ein File-Input-Element
                            const fileInput = document.createElement('input');
                            fileInput.type = 'file';
                            fileInput.id = item.id;
                            elementsContainer.appendChild(fileInput)
                            addEmptyLine(elementsContainer);

                            var match = item.id.match(/\d+/);

                            button = document.createElement("button");
                            button.textContent = "Speichern";
                            button.setAttribute("id", "saveStudentFileButton" + match);
                            button.setAttribute("class", "saveStudentFileButton" + match);
                            button.style.width = "130px";


                            fileInput.insertAdjacentElement("afterend", button);

                            button.addEventListener("click", function() {
                                event.preventDefault();

                                var match = button.id.match(/\d+/);

                                var studentFileUploadId = "studentFileUpload" + match;




                                const fileInputElement = document.querySelector('input[id*="' + studentFileUploadId + '"]');

                                const fileInput = fileInputElement;
                                const file = fileInput.files[0];



                                GetArrayFromDatabase();

                                contentArray[match].file = file.name;

                                SaveContentArrayToDatabase();



                                xhr = new XMLHttpRequest();

                                const reader = new FileReader();
                                reader.onload = function(event) {
                                    const base64Data = event.target.result.split(',')[1];
                                    const courseid = 1;
                                    const xhr = new XMLHttpRequest();
                                    xhr.open('POST', '../includes/kursseiteEdit.inc.php?method=saveCourseData', false);
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




                            });


                        }

                        if (item.id.includes('fileUpload') && !item.id.includes('student')) {

                            var xhr = new XMLHttpRequest();
                            xhr.open("POST", "../includes/kursseiteEdit.inc.php?method=getCourseData", false);
                            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                            xhr.onreadystatechange = function() {
                                if (xhr.readyState === 4) {
                                    if (xhr.status === 200) {


                                        var response = xhr.responseText;

                                        if (!response.includes('data:')) {
                                            return;
                                        }

                                        response = response.substring(response.indexOf('data'));

                                        var byteCharacters = atob(response.split(',')[1]);


                                        var byteArrays = [];

                                        for (var j = 0; j < byteCharacters.length; j++) {
                                            byteArrays.push(byteCharacters.charCodeAt(j));
                                        }


                                        var blob = new Blob([new Uint8Array(byteArrays)], {
                                            type: 'image/png'
                                        });


                                        var blobUrl = URL.createObjectURL(blob);


                                        var downloadLink = document.createElement('a');
                                        downloadLink.href = blobUrl;
                                        downloadLink.download = item.file;
                                        downloadLink.textContent = item.file;




                                        elementsContainer.appendChild(downloadLink);
                                        addEmptyLine(elementsContainer);







                                    } else {
                                        console.log("Fehler bei der AJAX-Anfrage. Fehlercode: " + xhr.status);
                                    }
                                }
                            };
                            var data = "courseid=1&dataName=" + item.file;
                            xhr.send(data);

                        }




                        if (item.id.includes('FileUpload') && item.id.includes('student')) {

                            var xhr = new XMLHttpRequest();
                            xhr.open("POST", "../includes/kursseiteEdit.inc.php?method=getCourseData", false);
                            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                            xhr.onreadystatechange = function() {
                                if (xhr.readyState === 4) {
                                    if (xhr.status === 200) {


                                        var response = xhr.responseText;

                                        if (!response.includes('data:')) {
                                            return;
                                        }

                                        response = response.substring(response.indexOf('data'));

                                        var byteCharacters = atob(response.split(',')[1]);


                                        var byteArrays = [];

                                        for (var j = 0; j < byteCharacters.length; j++) {
                                            byteArrays.push(byteCharacters.charCodeAt(j));
                                        }


                                        var blob = new Blob([new Uint8Array(byteArrays)], {
                                            type: 'image/png'
                                        });


                                        var blobUrl = URL.createObjectURL(blob);


                                        var downloadLink = document.createElement('a');
                                        downloadLink.href = blobUrl;
                                        downloadLink.download = item.file;
                                        downloadLink.textContent = item.file;


                                        button.insertAdjacentElement("afterend", downloadLink);


                                    } else {
                                        console.log("Fehler bei der AJAX-Anfrage. Fehlercode: " + xhr.status);
                                    }
                                }
                            };
                            var data = "courseid=1&dataName=" + item.file;
                            xhr.send(data);

                        }























                        if (item.id.includes('dividingLine')) {

                            const divideLineContainer = document.createElement('div');

                            const divideLine = document.createElement('hr');

                            divideLineContainer.appendChild(divideLine);

                            elementsContainer.appendChild(divideLineContainer);
                            addEmptyLine(elementsContainer);

                        }

                    }

                    elementsContainer.style.display = "flex";
                    elementsContainer.style.flexDirection = "column";

                }
            </script> -->



        </div>

        <footer id="footer">
            <ul class="infoBar">

                <li><a href="https://www.thm.de/site/impressum.html" target="_blank">Impressum</a></li>

                <li><a href="https://www.thm.de/site/hochschule/service/infocenter-thm.html" target="_blank">Hilfe</a></li>

                <li><a href="https://www.thm.de/datenschutz/" target="_blank">Datenschutz</a></li>

                <img src="/img/bitcoin.svg" class="bitcoinLogo" alt="THM Logo Icon" height="32px" width="32px">

                <script>
                    var button = document.querySelector('.bitcoinLogo');
                    button.addEventListener('click', function() {
                        document.documentElement.scrollTop = 0;
                    });
                </script>

            </ul>
        </footer>
        <br>
    </div>



</body>

</html>