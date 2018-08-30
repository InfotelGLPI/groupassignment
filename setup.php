<?php
/*
 -------------------------------------------------------------------------
 Groupassignment plugin for GLPI
 Copyright (C) 2014 by the Groupassignment Development Team.
 -------------------------------------------------------------------------

 LICENSE

 This file is part of Groupassignment.

 Groupassignment is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 Groupassignment is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with Groupassignment. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------  */

// Init the hooks of the plugins -Needed
function plugin_init_groupassignment() {
   global $PLUGIN_HOOKS;

   $PLUGIN_HOOKS['csrf_compliant']['groupassignment'] = true;

   $plugin = new Plugin();
   if ($plugin->isActivated("groupassignment")) {

      Plugin::registerClass('PluginGroupassignmentProfile', ['addtabon' => ['Profile']]);
      $PLUGIN_HOOKS['change_profile']['groupassignment'] = ['PluginGroupassignmentProfile', 'changeProfile'];

      $PLUGIN_HOOKS['add_javascript']['groupassignment'][] = 'scripts/function.js';
      if (Session::getLoginUserID() && (strpos($_SERVER['REQUEST_URI'], "ticket.form.php") !== false)) {
         //filter group feature
         $PLUGIN_HOOKS['add_javascript']['groupassignment'][] = 'scripts/filtergroup.js.php';
      }
   }
}

// Get the name and the version of the plugin - Needed
/**
 * @return array
 */
function plugin_version_groupassignment() {

   return ['name'           => __('Ticket group assignment', 'groupassignment'),
                'version'        => '1.0.0',
                'author'         => "<a href='http://infotel.com/services/expertise-technique/glpi/'>Infotel</a>",
                'license'        => 'GPLv2+',
                'minGlpiVersion' => '0.85']; // For compatibility / no install in version < 0.85
}

// Optional : check prerequisites before install : may print errors or add to message after redirect
function plugin_groupassignment_check_prerequisites() {

   if (version_compare(GLPI_VERSION, '0.85', 'lt') || version_compare(GLPI_VERSION, '9.2', 'ge')) {
      _e('This plugin requires GLPI 0.85 or higher', 'groupassignment');
      return false;
   }
   return true;
}

// Uninstall process for plugin : need to return true if succeeded
//may display messages or add to message after redirect
function plugin_groupassignment_check_config() {
   return true;
}



