<h2 id="bd_basicsettings" class="steelgraulight">Das CASA-Plugin f&uuml;r Stud.IP</h2>
<h3>Hinweise zur Nutzung</h3>
<b>Allgemeines: </b></br>
<br> Dieses Plugin erlaubt die Einbindung von Webseiten, Dokumenten und anderen </br>
Diensten in die Stud.IP-Seiten. F&uuml;r Beispiele und eine detailierte Anleitung </br>
klicken Sie bitte hier.</br>
</br>
<b>Rechtliches: </b></br></br>
Zu jeder Webseite wird der Nutzer gespeichert, der sie eingetragen hat.</br>
Dieser ist verantwortlich f&uuml;r die Inhalte auf der verlinkten Seite. Bitte seien </br>
Sie sich dessen bewusst, wenn sie einen Seite verlinken. 
<br></br>
<b>Fragen und Probleme:</b><br></br>
Mit Fragen, Hinweisen und Problemen wenden Sie sich bitte an: <br>
<b>
philipp.lehsten@uni-rostock.de </br>
studip-support@uni-rostock.de</b></br></br>
<script type="text/javascript">
<?php 
$manual = URLHelper::getURL('plugins_packages/PhilippLehsten/CasaPlugin/static/manual/assets/fallback/index.html');
$examples = URLHelper::getURL('plugins_packages/PhilippLehsten/CasaPlugin/static/examples/assets/fallback/index.html');
$services[0]->title = 'Anleitung';
$services[0]->targetURL = $examples;
$services[1]->title = 'Beispiele';
$services[1]->targetURL = $manual;
$scount = count($services);
echo 'var links = new Array("';
echo $manual;
echo '","';
echo $examples;
echo '");'; ?>


    function toggle(control){
        var elem = document.getElementById("block"+control);
        if(elem.style.display == "none"){
            document.getElementById("klappen"+control).childNodes[2].nodeValue = "ausblenden";
            document.getElementById("klappenImg"+control).src = "./../../assets/images/forumgraurunt2.png";
            elem.style.display = "block";
            elem.src = links[control];
        }
        else{
            elem.style.display = "none";
            document.getElementById("klappen"+control).childNodes[2].nodeValue = "anzeigen";
            document.getElementById("klappenImg"+control).src = "./../../assets/images/forumgrau2.png";
        }
    }
    </script>
    <table class="index_box"  style="width: 100%;">

</script>
    <table class="index_box"  style="width: 100%;">
<?php
for ($i = 0; $i < $scount; $i++){
    echo'
        <tr><td class="topic" colspan="2">
        <img src="./../../assets/images/icons/16/white/admin.png" border="0" alt="Dienste"  title="Dienste">
    ';
    echo'   <b>'._($services[$i]->title).'</b>';
    echo'
        </td></tr>
        <tr><td class="steel1" colspan="3">
        <a id="klappen'._($i).'" href="javascript:toggle('._($i).')">
        <img id="klappenImg'._($i).'" src="./../../assets/images/forumgrau2.png" alt="Objekt aufklappen">
            anzeigen</a> / 
    ';
    echo '<a href="'._(urldecode($services[$i]->targetURL)).'" target="_blank">Neu &ouml;ffnen</a>';
    echo'
        <br /><iframe id="block'._($i).'" style="display: none" src="" width="98%" height="500" name="'._("Dienste").'" frameborder="0">
        <p>Ihr Browser kann leider keine eingebetteten Frames anzeigen:
        Sie k&ouml;nnen die eingebettete Seite &uuml;ber den folgenden Verweis
        aufrufen: <a href="'._(urldecode($services[$i]->targetURL)).'">"'._("Dienst").'"</a></p>
        </iframe>
    ';
    echo'</td></tr>
    ';
};
echo'
    <script type="text/javascript">
    </script>
    </tr></td></table>
';
?>

