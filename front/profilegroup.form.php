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

include ("../../../inc/includes.php");

Session::haveRight("plugin_groupassignment", UPDATE);

$profilegroup = new PluginGroupassignmentProfileGroup();

if (isset($_POST['add_group'])) {
   $profilegroup->add($_POST);
   Html::back();
}
