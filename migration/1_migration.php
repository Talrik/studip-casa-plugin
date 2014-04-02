<?php
/**
 * This file contains the basic migration functionality
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
 * This class is the basic migration class.
 * Others might follow...
 * 
 * @author  Philipp Lehsten <philipp.lehsten@uni-rostock.de>
 */	
class CreateDummyService extends DBMigration
{

	/**
	 * returns the description 
	 */	
    function description ()
    {
        return 'Creates a dummy service';
    }

	/**
	 * enters the dummy values 
	 */	
	
    function up () { 
        $this->db->query("INSERT INTO casa_services VALUES (42, 'DummyService', 'Dummy Beschreibung', 'http://www.dummy.de','dozent','Hörsaal','Dummy Veranstaltung')"); 
    }
	
	/**
	 * drops the dummy 
	 */	
    function down ()
    {
        $this->db->query("DELETE FROM casa_services WHERE id = 42");
    }
}