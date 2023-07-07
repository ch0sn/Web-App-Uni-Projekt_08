 <?php
if(!isset($_SESSION['loggedin'])){
    include_once '../header.php';
}else{
    header("Location: index.php");
    exit();
}
?>

    <title>Einschreiben Big Data</title>
    <link rel="stylesheet" href="../css/Einschreibeseite.css">
    <link rel="stylesheet" href="../css/GrunddesignKursseiten.css">

    <!-- linke Bar -->
    <div class="barLeft">
    </div>

    <div class="gridCoursesClass">

        <div class="HeaderCourseClass">

            <div class="abmeldeClass">
                <input type="checkbox" id="abmelde_Checkbox">
                <label for="abmelde_Checkbox"><img src="/img/64px_exit.png" alt="abmelden"/> </label>

                <script>
                    let checkBox = document.getElementById("abmelde_Checkbox");
                    checkBox.addEventListener("click", function (){
                       if (this.checked){

                       }
                    });

                </script>
            </div>

            <h1 id="courseNameHeaderId">Big Data</h1>

            <p id= "courseInformation"> Fachbereich 13: MND / Wintersemester / ab 5.Semester / Hr. Sontek Daniel</p>



        </div>

        <div class="BodyCourseClass">

            <h1 id="enrollmentOptionsId">Einschreibeoptionen</h1>

            <p id="courseNameBodyId">Big Data WiSe23</p>

            <p id="teacherNameId">Hr. Sontek Daniel</p>
            <form>
                <input type="password" id="loginKeyPanel"placeholder="Einschreibeschlüssel"/>
                <input type="submit" value="Einschreiben" id="enrollButtonId"/>
                <button type="button" id="cancelButtonId"><a href="../pages/mainsite.php">Abbrechen</a></button>

            </form>
        </div>


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