<?php

# Copyright (c) 2013 - <philipp.lehsten@gmail.com>
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

require_once 'CasaSettings.php';

class CasaAdminPlugin extends StudipPlugin implements SystemPlugin
{
    function __construct()
    {
        parent::__construct();
        $this->setupNavigation();
    }
	
    function show_action()
    {
        $this->requireRoot();

        Navigation::activateItem("/admin/config/casaadmin");
		
        $parameters = array(
           'plugin' => $this
         , 'settings' => CasaSettings::getCasaSettings()
             );

        $factory = new Flexi_TemplateFactory(dirname(__FILE__).'/templates');
        echo $factory->render('configPlugin'
                            , $parameters
                            , $GLOBALS['template_factory']->open('layouts/base_without_infobox')
        );
		
    }
	
    private function setupNavigation()
    {
        global $perm;
        if (!$perm->have_perm("root")) {
            return;
        }

        $url = PluginEngine::getURL('casaadminplugin/show');
        $navigation = new Navigation(_('CASA-Admin'), $url);
        $navigation->setImage(Assets::image_path('icons/16/white/test.png'));
        $navigation->setActiveImage(Assets::image_path('icons/16/black/test.png'));

        Navigation::addItem('/admin/config/casaadmin', $navigation);
    }
	
    function settings_action()
    {
        $this->requireRoot();

        if (Request::method() !== 'POST') {
            throw new AccessDeniedException();
        }

        # get settings
        $settings = Request::getArray("casaConfig");

        # validate them
        list($valid, $err) = $this->validateSettings($settings);
        if (!$valid) {
            $this->redirect('show', compact('err'));
            return;
        }

        # store them
        CasaSettings::setCasaSettings($settings);

        # activate statsd plugin
//       $this->activateStatsdPlugin();
        $this->redirect('show', array('info' => _('Casa-Einstellungen aktualisiert.')));
    }
	
    private function validateSettings($settings)
    {
        $errors = array();

        # Server is reachable
			//TODO
        # Broker has a valid WSDL
			//TODO
		# useCASA is either true or false		
        if (($settings['useCASA'] != 1) && ($settings['useCASA'] != 0))  {
            $errors[] = _("CASA Modus ist nicht spezifiziert");
        }

        return array(sizeof($errors) === 0, $errors);
    }
	
    private function redirect($action)
    {
        header("Location: " . PluginEngine::getURL("casaadminplugin/$action"));
    }
	
    private function requireRoot()
    {
        global $perm;
        if (!$perm->have_perm("root")) {
            throw new AccessDeniedException();
        }
    }
	
}