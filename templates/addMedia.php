<?php
        require '../lib/bootstrap.php';

    page_open(array("sess" => "Seminar_Session", "auth" => "Seminar_Default_Auth", "perm" => "Seminar_Perm", "user" => "Seminar_User"));
        $auth->login_if($again && ($auth->auth["uid"] == "nobody"));

        include ('lib/seminar_open.php'); // initialise Stud.IP-Session

        $sem = Seminar::GetInstance($SessSemName[1]);

        Navigation::activateItem('/course/Dienste/addService');


	if ($scount > 1){
//        	Navigation::activateItem('/course/Dienste/addService');
        }
        else{
//        	Navigation::activateItem('/course/'.$servicetitle.'/addService');
        }

	include ('lib/include/html_head.inc.php'); // Output of html head
	include ('lib/include/header.php');   // Output of Stud.IP head


if ($action != "add"){ 
echo'

	<form name="details" method="post" action="http://localhost/studip20/public/addService.php?action=add&scount=2">
	<div style="text-align:center" id="settings" class="steel1">

		<h2 id="bd_basicsettings" class="steelgraulight">Neuen Dienst eintragen</h2>
  	<div><table width="100%">
            <tr>
             <td style="text-align: right; width: 20%; vertical-align: top;">
                 Name des Dienstes                 <span style="color: red; font-size: 1.6em">*</span>             </td>
             <td style="text-align: left" width="80%">    <input  type="text" name="service_name" value="" style="width: 80%">
</td>
          </tr>
                <tr>
             <td style="text-align: right; width: 20%; vertical-align: top;">
                 Adresse des Dienstes                              <span style="color: red; font-size: 1.6em">*</span> </td>
             <td style="text-align: left" width="80%">    <input  type="url" name="service_address" value="" style="width: 80%">
</td>
          </tr>
                <tr>
             <td style="text-align: right; width: 20%; vertical-align: top;">
                 Zielgruppe                 <span style="color: red; font-size: 1.6em">*</span>             </td>
             <td style="text-align: left" width="80%">    <select  name="service_restrictions" style="width: 80%">
            <option value="autor">Studenten</option>
            <option value="dozent" selected>Dozenten</option>
            <option value="autor;dozent">Studenten und Dozenten</option>
        		</select>
		</td>
        </tr>
      	<tr>
             	<td style="text-align: right; width: 20%; vertical-align: top;">
                 Beschreibung                              
		</td>
             	<td style="text-align: left" width="80%">    <textarea  name="service_description" style="width: 80%; height: 100px;" class=""></textarea>
		</td>
	</tr>
</table></div>
	<div style="text-align:center; padding: 15px">
	<input type="hidden" name="lecture_id" value="'._($sem->id).'"> 
	<input class="button" type="image" src="http://localhost/studip20/public/assets/images/locale/de/LC_BUTTONS/uebernehmen-button.png" name="uebernehmen" > <input id="open_variable" type="hidden" name="open" value="">
	</div>
';

}else {
echo'userRole = '._($_POST[service_restrictions]).',
     lecture = '._($_POST[lecture_id]).',
     title = '._($_POST[service_name]).',
     url = '._($_POST[service_address]).'
     description = '._($_POST[service_description]);


            $wsdl = "http://localhost:8080/GUI_Broker_StudIP/GUI_Broker_StudIP?WSDL";
            $options = array();
            $client = new SoapClient($wsdl,$options);
            $ParamList = array(
                                "userRole" => $_POST[service_restrictions],
                                "lecture" => $_POST[lecture_id],
                                "title" => utf8_encode($_POST[service_name]),
                                "url" => $_POST[service_address]);
//				"description" => $_POST[service_description];
           $response = $client->setGUI($ParamList);
        $array = $response->return;
 
}

include ('lib/include/html_end.inc.php');
page_close();

?>
