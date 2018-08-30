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

if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access directly to this file");
}

/**
 * Class PluginGroupassignmentGroup
 */
class PluginGroupassignmentGroup extends CommonDBTM {

   static $rightname = 'plugin_groupassignment';

   /**
    * Returns groups profile
    * @return array
    */
   function getGroups() {

      $profilegroup = new PluginGroupassignmentProfileGroup();

      //search groups with profile
      $groups = $profilegroup->find("`profiles_id` = ".$_SESSION['glpiactiveprofile']['id']);
      $tab = [];
      if (count($groups)) {
         foreach ($groups as $group) {
            $tab[$group['groups_id']] = Dropdown::getDropdownName('glpi_groups', $group['groups_id']);
         }
         return $tab;
      } else {
         return [];
      }
   }
}

