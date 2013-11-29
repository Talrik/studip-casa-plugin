<?php
/**
 * This file contains the CasaSettings class 
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
 * The CasaSettings contains the casa related configuration parameters
 * It is configured by the CasaAdminPlugin 
 * 
 * @author  Philipp Lehsten <philipp.lehsten@uni-rostock.de>
 */	
class CasaSettings
{
    const CONFIG_KEY = 'CASA_SETTINGS';

	/**
	* retrieves the settings 
	* @return array containing the parameters 
	*/
    static function getCasaSettings()
    {
        $cfg = Config::get();
        if (!isset($cfg[self::CONFIG_KEY]) || '' === $cfg[self::CONFIG_KEY]) {
            return array();
        }

        $decoded = array();
        foreach (json_decode($cfg[self::CONFIG_KEY]) as $k => $v) {
            $decoded[$k] = studip_utf8decode($v);
        }

        return $decoded;
    }

	/**
	* updates the settings
	* @param $settings array containg the settings
	*/
    static function setCasaSettings($settings)
    {
        self::ensureCasaSettings();

        $encoded = array();
        foreach ($settings as $k => $v) {
            $encoded[$k] = studip_utf8encode($v);
        }

        return Config::get()->store(self::CONFIG_KEY, json_encode($encoded));
    }

	/**
	* ensures that settings exist 
	*/
    static function ensureCasaSettings()
    {
        $exists = ConfigEntry::findByField(self::CONFIG_KEY);
        if ($exists) {
            return;
        }

        $result = Config::get()->create(self::CONFIG_KEY);
    }
}