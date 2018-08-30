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

/**
 * @return bool
 */
function plugin_groupassignment_install() {
   global $DB;
   include_once(GLPI_ROOT."/plugins/groupassignment/inc/profile.class.php");

    //First install
   if (!TableExists("glpi_plugin_groupassignment_profilegroups")) {
      $DB->runFile(GLPI_ROOT . "/plugins/groupassignment/install/sql/empty-1.0.0.sql");
   }

   PluginGroupassignmentProfile::initProfile();
   PluginGroupassignmentProfile::createFirstAccess($_SESSION['glpiactiveprofile']['id']);

   return true;
}

/**
 * @return bool
 */
function plugin_groupassignment_uninstall() {
   global $DB;
   include_once (GLPI_ROOT."/plugins/groupassignment/inc/profile.class.php");

   $tables = ["glpi_plugin_groupassignment_profilegroups"];

   foreach ($tables as $table) {
      $DB->query("DROP TABLE IF EXISTS `$table`;");
   }

   //Delete rights associated with the plugin
   $profileRight = new ProfileRight();
   foreach (PluginGroupassignmentProfile::getAllRights() as $right) {
      $profileRight->deleteByCriteria(['name' => $right['field']]);
   }
   PluginGroupassignmentProfile::removeRightsFromSession();

   return true;
}

// Define dropdown relations
/**
 * @return array
 */
function plugin_groupassignment_getPluginsDatabaseRelations() {

   $plugin = new Plugin();
   if ($plugin->isActivated("groupassignment")) {
      return [
         "glpi_groups"   => ["glpi_plugin_groupassignment_profilegroups"   => "groups_id"],
         "glpi_profiles" => ["glpi_plugin_groupassignment_profilegroups"   => "profiles_id"]
      ];
   } else {
      return [];
   }
}


