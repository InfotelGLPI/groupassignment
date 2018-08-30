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
 * Class PluginGroupassignmentProfileGroup
 */
class PluginGroupassignmentProfileGroup extends CommonDBTM {

   static $rightname = 'plugin_groupassignment';

   /**
    * Form add groups
    * @param type $ID
    */
   static function showProfileGroup($ID) {
      echo "<div class='firstbloc'>";
      $profilegroup = new PluginGroupassignmentProfileGroup();
      echo "<form method='post' action='" . $profilegroup->getFormURL() . "'>";

      echo "<table class='tab_cadre_fixe'>";
      echo "<tr><th colspan='2' class='center b'>" . __('Group');
      echo "</th></tr>";

      //groups already added
      $used = [];
      $profilegroups = $profilegroup->find('`profiles_id` = ' . $ID);
      foreach ($profilegroups as $group) {
         $used[$group['groups_id']] = $group['groups_id'];
      }

      echo "<tr class='tab_bg_1'>";
      echo "<td>" . __('Group') . "</td><td>";
      Dropdown::show('Group', ['name' => 'groups_id', 'used' => $used, 'condition' => "`is_assign` = 1"]);
      echo "</td></tr>";

      echo "<tr class='tab_bg_2'>";
      echo "<td class='center' colspan='2'>";
      echo "<input type='hidden' name='profiles_id' value=$ID>";
      echo "<input type='submit' name='add_group' value=" . __('Add') . " class='submit'>";
      echo "</td></tr>";
      echo "</table>";

      Html::closeForm();
   }

   /**
    * List of groups
    * @param type $ID
    */
   static function showListProfileGroup($ID) {

      $rand = mt_rand();

      $canedit = Session::haveRight('plugin_groupassignment', PURGE);

      //groups add to profile
      $profilegroup  = new self();
      $profilegroups = $profilegroup->find('`profiles_id` = ' . $ID);

      $number = count($profilegroups);

      if ($number) {
         echo "<div class='firstbloc'>";
         if ($canedit) {
            Html::openMassiveActionsForm('mass' . __CLASS__ . $rand);

            $massiveactionparams = ['container' => 'mass' . __CLASS__ . $rand,
                                         'check_itemtype' => 'Config'];
            Html::showMassiveActions($massiveactionparams);
         }

         //Group list
         echo "<table class='tab_cadre_fixe'>";
         echo "<tr><th colspan='2' class='center b'>" . __('Group list', 'groupassignment');
         echo "</th></tr>";
         echo "<tr class='tab_bg_1'>";
         echo "<th width='10'>";
         if ($canedit) {
            echo Html::getCheckAllAsCheckbox('mass' . __CLASS__ . $rand);
         }
         echo "</th>";
         echo "<th>";
         echo _n('Group', 'Groups', 1);
         echo "</th></tr>";

         foreach ($profilegroups as $group) {
            echo "<tr class='tab_bg_1'><td>";
            if ($canedit) {
               Html::showMassiveActionCheckBox(__CLASS__, $group["id"]);
            }
            echo "</td><td>";
            echo Dropdown::getDropdownName('glpi_groups', $group['groups_id']);
            echo "</td></tr>";
         }

         echo "</table>";
         if ($canedit) {
            $massiveactionparams['ontop'] = false;
            Html::showMassiveActions($massiveactionparams);
            Html::closeForm();
         }
         echo "</div>";
      } else {
         echo "<div class='firstbloc'><p>";
         _e('No group is added to the list', 'groupassignment');
         echo "</p></div>";
      }
   }

   /**
    * @since version 0.84
   **/
   function getForbiddenStandardMassiveAction() {

      $forbidden   = parent::getForbiddenStandardMassiveAction();
      $forbidden[] = 'delete';
      $forbidden[] = 'restore';
      $forbidden[] = 'update';

      return $forbidden;
   }

}
