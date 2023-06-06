<?php
if(!isset($_SESSION['loggedin'])){
    include_once '../header.php';
}else{
    header("Location: index.php");
    exit();
}
?>
    <title>Kurssseite bearbeiten</title>
    <link rel="stylesheet" href="../css/KurssseiteEdit.css">
<link rel="stylesheet" href="../css/GrunddesignKursseiten.css">


    <!-- linke Bar -->
    <div class="barLeft">
    </div>

    <div class="gridCoursesClass">

        <div class="HeaderCourseClass">
            

        </div>

        <div class="BodyCourseClass">


        </div>

    </div>
    
    <ul class="infoBar">

        <li><a href="https://www.thm.de/site/impressum.html" target="_blank">Impressum</a></li>

        <li><a href="https://www.thm.de/site/hochschule/service/infocenter-thm.html" target="_blank">Hilfe</a></li>

        <li><a href="https://www.thm.de/datenschutz/" target="_blank">Datenschutz</a></li>

        <img src="/Icons/bitcoin.svg" class="bitcoinLogo" alt="THM Logo Icon" height="32px" width="32px">

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