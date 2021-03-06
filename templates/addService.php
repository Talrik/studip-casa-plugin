<?php
/*        require '../lib/bootstrap.php';

    page_open(array("sess" => "Seminar_Session", "auth" => "Seminar_Default_Auth", "perm" => "Seminar_Perm", "user" => "Seminar_User"));
        $auth->login_if($again && ($auth->auth["uid"] == "nobody"));

        include ('lib/seminar_open.php'); // initialise Stud.IP-Session

        $sem = Seminar::GetInstance($SessSemName[1]);

        Navigation::activateItem('/course/Dienste/addService');

	include ('lib/include/html_head.inc.php'); // Output of html head
	include ('lib/include/header.php');   // Output of Stud.IP head
*/
	$sem = Seminar::GetInstance($GLOBALS['SessSemName'][1]);
	$username = (get_username($auth->auth["uid"]));
// Diese Seite ist f�r das Einfuegen neuer Dienste aus dem StudIP heraus verantwortlich

// Zuerst Behandlung des Standardfalls, dass gerade kein Dienst eigegeben wurde
//var_dump($sem);
//var_dump($username);
if ($action != "add"){ 
	echo'
		<form name="details" method="post" action=<?= URLHelper::getLink('#addService/add') ?>>
		<div style="text-align:center" id="settings" class="steel1">
		<h2 id="bd_basicsettings" class="steelgraulight">Neuen Dienst eintragen</h2>
  		<div><table width="100%">
            	<tr>
             		<td style="text-align: right; width: 20%; vertical-align: top;">
                 	Name des Dienstes
			<span style="color: red; font-size: 1.6em">*</span>
			</td>
             		<td style="text-align: left" width="80%">    <input  type="text" name="service_name" value="" style="width: 80%">
			</td>
          	</tr>
                <tr>
             		<td style="text-align: right; width: 20%; vertical-align: top;">
                 	Adresse des Dienstes
			<span style="color: red; font-size: 1.6em">*</span> 
			</td>
             		<td style="text-align: left" width="80%">    <input  type="url" name="service_address" value="http:" style="width: 80%">
			</td>
          	</tr>
                <tr>
             		<td style="text-align: right; width: 20%; vertical-align: top;">
                 	Zielgruppe
			<span style="color: red; font-size: 1.6em">*</span>
			</td>
             		<td style="text-align: left" width="80%">
				<select  name="service_restrictions" style="width: 80%">
            				<option value="autor">Studenten</option>
           				<option value="dozent" selected>Dozenten</option>
            				<option value="autor;dozent">Studenten und Dozenten</option>
        			</select>
			</td>
        	</tr>

                <tr>
                        <td style="text-align: right; width: 20%; vertical-align: top;">
                        Verkn�pfen mit Ort
                        <span style="color: red; font-size: 1.6em"></span>
                        </td>
                        <td style="text-align: left" width="80%">    <input  type="text" name="location" value="" style="width: 80%">
                        </td>
                </tr>

      		<tr>
             		<td style="text-align: right; width: 20%; vertical-align: top;">
                 	Beschreibung
			</td>
             		<td style="text-align: left" width="80%">
			<textarea  name="service_description" style="width: 80%; height: 100px;" class=""></textarea>
			</td>
		</tr>
	</table>
	</div>
	<div style="text-align:center; padding: 15px">
	<input type="hidden" name="lecture_id" value="'._($sem->id).'">
	<input type="hidden" name="username" value="'._($username).'"> 
	<input class="button" type="image" src="/assets/images/locale/de/LC_BUTTONS/uebernehmen-button.png" name="uebernehmen" > <input id="open_variable" type="hidden" name="open" value="">
	</div>
';
}
//  Wenn das Formular abgeschickt wurde wird die Seite mit der $action add ausgef�hrt
else {
	$wsdl = "http://elbe5:8080/GUI_Broker_StudIP/GUI_Broker_StudIP?WSDL";
        $options = array();
        $client = new SoapClient($wsdl,$options);
	if ($_POST[location] == NULL)
	{
        $ParamList = array(
        	"userRole" => $_POST[service_restrictions],
                "lecture" => $_POST[lecture_id],
                "title" => utf8_encode($_POST[service_name]),
                "url" => $_POST[service_address],
		"description" => iconv('windows-1252','UTF-8',$_POST[service_description]),
		"author" => $_POST[username]);
        $response = $client->setGUI($ParamList);
        $array = $response->return;
	}
	if ($_POST[location] != NULL)
        {
	echo $_POST[location];
        $ParamList = array(
                "userRole" => $_POST[service_restrictions],
                "location" => iconv('windows-1252','UTF-8',$_POST[location]),
                "title" => utf8_encode($_POST[service_name]),
                "url" => $_POST[service_address],
                "description" => iconv('windows-1252','UTF-8',$_POST[service_description]),
                "author" => $_POST[username]);
        $response = $client->setGUI($ParamList);
        $array = $response->return;
        }

}
//  Navigation::activateItem('/course/Dienste/viewService');

//include ('lib/include/html_end.inc.php');
//page_close();

?>
