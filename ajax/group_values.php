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


$AJAX_INCLUDE = 1;
include ("../../../inc/includes.php");
header("Content-Type: text/html; charset=UTF-8");
Html::header_nocache();
Session::checkLoginUser();

$ticket_id = (isset($_REQUEST['ticket_id'])) ? $_REQUEST['ticket_id'] : 0;
$entities_id = (isset($_REQUEST['entities_id'])) ? $_REQUEST['entities_id'] : 0;

$PluginGroupassignmentGroup = new PluginGroupassignmentGroup();

$groups_id_filtred = $PluginGroupassignmentGroup->getGroups();

if (count($groups_id_filtred) > 0) {
   $myarray = [];
   foreach ($groups_id_filtred as $groups_id => $groups_name) {
      $myarray[] = $groups_id;
   }
   $newarray = implode(", ", $myarray);
   $condition = " id IN ($newarray)";

} else {
   $condition = "`is_assign`";
   $_POST['entity_restrict'] = $entities_id;
}

$rand = mt_rand();
$_SESSION['glpicondition'][$rand] = $condition;

$_POST["condition"] = $rand;

if ($ticket_id) {
   $ticket = new Ticket();
   $ticket->getFromDB($ticket_id);
   $_POST["entity_restrict"] = $ticket->fields['entities_id'];
} else {
   $_POST['entity_restrict'] = $entities_id;
}

require ("../../../ajax/getDropdownValue.php");