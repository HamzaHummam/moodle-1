<?php
// This file is part of tool_userprivileges
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Creates settings and links to Moodle Managers Privileges System.
 *
 * @package     tool_userprivileges
 * @category    string
 * @copyright   2021 Ahsan Gul <ahsan.gul@seecs.edu.pk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    
    //Moodle Managers Privileges System
    //@author 2021 Ahsan Gul
    $ADMIN->add('root', new admin_externalpage('tool_userprivileges', "Managers Privileges", "$CFG->wwwroot/$CFG->admin/tool/userprivileges/index.php"));
}
