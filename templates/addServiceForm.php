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
// var_dump($locations);
?>

<form id="edit_box" action="<?= URLHelper::getLink('#save') ?>" method="POST">
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
             		<td style="text-align: left" width="80%">    <input  type="text" pattern="(^http://(.*)|^https://(.*))" name="service_address" value="http://" style="width: 80%">
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
                        <td style="text-align: left" width="80%">    
                                <select  name="location" style="width: 80%">
                                        <option></option>
                                        <option value ="<?php echo utf8_encode($locations[0]); ?>" ><?php echo $locations[0] ?></option>
                                        <option value ="<?php echo utf8_encode($locations[1]); ?>" ><?php echo $locations[1] ?></option>
                                </select>
                        </td>
                </tr>

      		<tr>
             		<td style="text-align: right; width: 20%; vertical-align: top;">
                 	Beschreibung
			</td>
             		<td style="text-align: left" width="80%">
			<textarea  name="service_description" style="width: 80%; height: 100px;" class=""><?=htmlready($verz->service_description) ?></textarea>
			</td>
		</tr>
	</table>
	</div>
	<div style="text-align:center; padding: 15px">
    <?= makeButton('uebernehmen', 'input', false, 'save') ?>
    <?= makeButton('abbrechen', 'input', false, 'cancel') ?>
</form>
