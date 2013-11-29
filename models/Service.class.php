<?php
/**
 * This file contains the Service class
 *
 * Copyright (c)  2013  <philipp.lehsten@gmail.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 * @category   StudIP_Plugin
 * @package    de.lehsten.casa.studip.plugin
 * @author     Philipp Lehsten <philipp.lehsten@uni-rostock.de>
 * @copyright  2013 Philipp Lehsten <philipp.lehsten@uni-rostock.de>
 * @since      File available since Release 1.0
 */

/**
 *
 * The Service class holds all information relevant concerning a single service 
 * 
 * @author  Philipp Lehsten <philipp.lehsten@uni-rostock.de>
 */	
class Service
{
    /**
     * title of the service
	 * 
     * @access public
     * @var string
     */
	var $title;
    /**
     * description of the service
	 * 
     * @access public
     * @var string
     */ 
	var $description;
    /**
     * author or provider of the service
	 * 
     * @access public
     * @var string
     */
	var $provider;
    /**
     * restrictions of the service (autor, tutor, ...)
	 * 
     * @access public
     * @var array
     */
	var $restrictions = array();
    /**
     * URL of the service
	 * 
     * @access public
     * @var string
     */
	var $targetURL;
    /**
     * ID of the service
	 * 
     * @access public
     * @var string
     */
	var $serviceID;
    /**
     * courseID of the service
	 * 
     * @access public
     * @var string
     */
	var $lecture;
    /**
     * title of the connected location
	 * 
     * @access public
     * @var string
     */
	var $location;
	
	/**
	 *
	 * standard constructor for a Service object, ServiceID is generated
	 * 
	 * @param string $title 	 	title of the service
	 * @param string $description 	description of the service
	 * @param string $provider 		name of the author of the service
	 * @param array $restrictions  	restrinctions of the service e.g (autor, tutor)
	 * @param string $targetURL 	URL of the provided services
	 * @param string $lecture 		Stud.IP identifier for the course
	 * @param string $location 		name of the location
	 */	
	private function __construct($title,$description,$provider,$restrictions,$targetURL,$lecture,$location ){
        $this->title = $title;
		$this->description = $description;
		$this->targetURL = $targetURL;
		$this->restrictions = $restrictions;
		$this->provider = $provider;
		$this->lecture = $lecture;
		$this->location = $location;
		$this->serviceID = $this->createServiceID($this);
	
	}
	
	/**
	 *
	 * constructor if values are given including a ServiceID - if this is NULL it will be generated
	 * 
	 * 
	 * @param string $title 	 	title of the service
	 * @param string $description 	description of the service
	 * @param string $provider 		name of the author of the service
	 * @param array $restrictions  	restrinctions of the service e.g (autor, tutor)
	 * @param string $targetURL 	URL of the provided services 
	 * @param string $serviceID 	given ServiceID 
	 * @param string $lecture 		Stud.IP identifier for the course
	 * @param string $location 	name of the location
	 */	
	static function createFromValues($title,$description,$provider,$restrictions,$targetURL,$serviceID,$lecture,$location )
	{	
		$service = new self($title,$description,$provider,$restrictions,$targetURL,$lecture,$location);
		if ($serviceID == $service->serviceID || strlen($serviceID) == 0 || $serviceID == 0 || $serviceID == NULL){
			return $service;
		}
		else{
			$service->serviceID = $serviceID;
			return $service;
		}
	}
	
	/**
	 *
	 * constructor if the value source is the response given by the CASA web wervice
	 * 
	 * @param object $WsResult 	 result from web service 
	 */	
	static function createFromCASA($WsResult){
		$title  = utf8_decode($WsResult->title);
		$description = utf8_decode($WsResult->description);
		$provider = $WsResult->provider;
		if (is_array($WsResult->restrictions)){
		$restrictions = $WsResult->restrictions;
		}else{
			$restrictions = array($WsResult->restrictions);	
		}
		$targetURL = $WsResult->targetURL;
		$entry = $WsResult->properties->entry;
		for ($i=0; $i<sizeof($entry);$i++){
			if ($entry[$i]->key == 'ID'){
			$serviceID = $entry[$i]->value;
			}
			if ($entry[$i]->key == 'StudIP_ID'){
			$lecture = $entry[$i]->value;
			}
			if ($entry[$i]->key == 'StudIP_Location'){
			$location = utf8_decode($entry[$i]->value);
			}
		}
		$service = self::createFromValues($title,$description,$provider,$restrictions,$targetURL,$serviceID,$lecture,$location);
		return $service;
	}
    
	/**
	 *
	 * constructor if the value source is the data base
	 * 
	 * @param array $DBEntry 	 entry from data base 
	 */	
	static function createFromDBEntry($DBEntry)
    {
        $title = $DBEntry["title"];
		$description = $DBEntry["description"];
		$targetURL = $DBEntry["url"];
		$restrictions = explode(";",$DBEntry["userrole"]);
		$provider = $DBEntry["createdBy"];
		$serviceID = $DBEntry["serviceID"];
		$lecture = $DBEntry["lecture"];
		$location = $DBEntry["location"];
		$service = new self($title,$description,$provider,$restrictions,$targetURL,$lecture,$location);
		if ($serviceID == $service->serviceID){
			return $service;
		}else 
		{
			$service->serviceID = $serviceID;
			return $service;
		}
	}
	
	/**
	 *
	 * calculates the ServiceID
	 * 
	 * @param object $service 	Service object 
	 */
	private function createServiceID($service){
		return hash('ripemd160', 
			$service->title
			.$service->description
			.$service->provider
			.$service->restrictions
			.$service->targetURL
			.$service->lecture
			.$service->location);
	}

}
?>