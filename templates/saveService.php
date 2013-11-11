<?php

# Copyright (c)  2013  <philipp.lehsten@gmail.com>
#
# Permission is hereby granted, free of charge, to any person obtaining a copy
# of this software and associated documentation files (the "Software"), to deal
# in the Software without restriction, including without limitation the rights
# to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
# copies of the Software, and to permit persons to whom the Software is
# furnished to do so, subject to the following conditions:
#
# The above copyright notice and this permission notice shall be included in all
# copies or substantial portions of the Software.
#
# THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
# IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
# FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
# AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
# LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
# OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
# SOFTWARE.


//var_dump($_REQUEST);
$settings = CasaSettings::getCasaSettings();
function getServiceID($service){
	if($settings['useCASA'] == 1){
	$entry = $service->properties->entry;
	for ($i=0; $i<sizeof($entry);$i++){
		if ($entry[$i]->key == 'ID'){
		return $entry[$i]->value;
		}
	}
	}
	else{
		return hash('ripemd160', 
	$service_name.$service_description.$service_address.$service_restrictions.utf8_encode($location). $lecture_id);
	}
}
if($settings['useCASA'] == 1){
	$wsdl = $settings['broker'];
        $options = array();
        $client = new SoapClient($wsdl,$options);
	if ($location == NULL)
	{
        $ParamList = array(
        	"userRole" => $service_restrictions,
                "lecture" => $lecture_id,
                "title" => utf8_encode($service_name),
                "url" => $service_address,
		"description" => utf8_encode($service_description),
		"author" => $username);
        $response = $client->setGUI($ParamList);
        $array = $response->return;
	}
	if ($location != NULL)
        {
        $ParamList = array(
                "userRole" => $service_restrictions,
//		"lecture" => $lecture_id,
                "location" => $location,
                "title" => utf8_encode($service_name),
                "url" => $service_address,
                "description" => utf8_encode($service_description),
                "author" => $username);
        $response = $client->setGUI($ParamList);
        $array = $response->return;
        }
}
if ($location != NULL) {
	$lecture_id = NULL;
}
if ($array != NULL) {
	$service = Service::createFromCASA($array);
	}
else{
	$service = Service::createFromValues($service_name,$service_description,$username,$service_restrictions,$service_address,$serviceID,$lecture_id,utf8_decode($location));	
} 
		$query = "INSERT INTO `casa_services` (`title`, `description`, `url`, `userrole`, `location`, `lecture`, `serviceID`, `createdBy`) 
					VALUES (?,?,?,?,?,?,?,?)";
		$statement = DBManager::get()->prepare($query);
		$statement->execute(array($service_name, $service_description, $service_address, $service_restrictions, utf8_decode($location), $lecture_id, $service->serviceID, $username));
	
	echo MessageBox::success('Dienst erfolgreich eingetragen', 
		array('Der Dienst ' . $ParamList[title] . ' wurde erfolgreich eingetragen.',
		'URL: '.$ParamList[url], 
		'Beschreibung: '.$ParamList[description],
		), true);
?>
