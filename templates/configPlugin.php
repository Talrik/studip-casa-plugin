<?php
$settings['broker'] = 'http://elbe5.uni-rostock.de:8080/GUI_Broker_StudIP/GUI_Broker_StudIP?WSDL';
$settings = CasaSettings::getCasaSettings();
var_dump($settings);
?>

<h2>CASA-Einstellungen</h2>

<? if (!$casa_active) : ?>
<form action="<?= PluginEngine::getLink("casaadminplugin/settings") ?>" method="post">

<fieldset>

<legend>Wo befindet sich Ihr CASA-Server?</legend>

<label>
<?= _('CASA-Server:') ?>
<input  type="text" name="casaConfig[server]" value="<?= htmlReady($settings['server']) ?>">
</label>

<label>
<?= _('Broker:') ?>
<input  type="text" name="casaConfig[broker]" value="<?= htmlReady($settings['broker']) ?>">
</label>

<label>
<?= _('Modus:') ?>
<select required name="casaConfig[useCASA]" >
      <option <?php if ($settings[useCASA]) : ?>selected=true' <?php endif; ?>value="1">CASA mit Server verwenden</option>
      <option <?php if (!$settings[useCASA]) :?>selected=true' <?php endif; ?> value="0">CASA nur lokal verwenden</option>
    </select>
</label>

</fieldset>

<div class="button-group">
<?= \Studip\Button::createAccept(_("Speichern und aktivieren")) ?>
</div>
</form>

<? else : ?>

<dl>
<dt>CASA-Server</dt> <dd><?= htmlReady($settings['server']) ?></dd>
<dt>Broker</dt> <dd><?= htmlReady($settings['broker']) ?></dd>
</dl>

<? endif ?>
