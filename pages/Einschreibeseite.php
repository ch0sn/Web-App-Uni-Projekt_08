

    <title>Einsschreiben_MUSTER</title>
    <link rel="stylesheet" href="../css/Einschreibeseite.css">
    <link rel="stylesheet" href="../css/GrunddesignKursseiten.css">



    <div class="gridCoursesClass">


        <div class="BodyCourseClass">

            <h1 id="enrollmentOptionsId">Einschreibeoptionen</h1> 
            
            <p id="courseNameBodyId">WK_1100 Einführung in die Wirtschaftsinfromatik SoSe23</p>

            <p id="teacherNameId">Prof. Hopfen</p>                       
            
            <input type="password" id="loginKeyPanel"placeholder="Einschreibeschlüssel"/>
            
            <input type="submit" value="Einschreiben" id="enrollButtonId"/>

            <input type="submit" value="Abbrechen" id="cancelButtonId"/>


        </div>

    </div>
    
    <ul class="infoBar">

        <li><a href="https://www.thm.de/site/impressum.html" target="_blank">Impressum</a></li>

        <li><a href="https://www.thm.de/site/hochschule/service/infocenter-thm.html" target="_blank">Hilfe</a></li>

        <li><a href="https://www.thm.de/datenschutz/" target="_blank">Datenschutz</a></li>

        <img src="/img/bitcoin.svg" class="bitcoinLogo" alt="THM Logo Icon" height="32px" width="32px">

        <script>
            var button = document.querySelector('.bitcoinLogo');
            button.addEventListener('click', function () {
                document.documentElement.scrollTop = 0;
            });
        </script>

    </ul>
    </div>

</body>

</html>