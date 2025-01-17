<?php
// This file is part of Moodle - http://moodle.org/
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
 * Label module upgrade
 *
 * @package mod_label
 * @copyright  2006 onwards Eloy Lafuente (stronk7) {@link http://stronk7.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// This file keeps track of upgrades to
// the label module
//
// Sometimes, changes between versions involve
// alterations to database structures and other
// major things that may break installations.
//
// The upgrade function in this file will attempt
// to perform all the necessary actions to upgrade
// your older installation to the current version.
//
// If there's something it cannot do itself, it
// will tell you what you need to do.
//
// The commands in here will all be database-neutral,
// using the methods of database_manager class
//
// Please do not forget to use upgrade_set_timeout()
// before any action that may take longer time to finish.

defined('MOODLE_INTERNAL') || die;

function xmldb_label_upgrade($oldversion) {
    global $CFG, $DB;
<<<<<<< HEAD

    // Automatically generated Moodle v3.6.0 release upgrade line.
    // Put any upgrade step following this.

    // Automatically generated Moodle v3.7.0 release upgrade line.
    // Put any upgrade step following this.

    // Automatically generated Moodle v3.8.0 release upgrade line.
    // Put any upgrade step following this.
=======
>>>>>>> master

    // Automatically generated Moodle v3.9.0 release upgrade line.
    // Put any upgrade step following this.

    // Automatically generated Moodle v4.0.0 release upgrade line.
    // Put any upgrade step following this.

<<<<<<< HEAD
    if ($oldversion < 2022041901) {
=======
    if ($oldversion < 2022101300) {
>>>>>>> master
        $module = $DB->get_field('modules', 'id', ['name' => 'label']);
        $DB->execute('
            UPDATE {course_modules}
               SET visible = 0, visibleoncoursepage = 1
             WHERE module = :module
                   AND visible = 1
                   AND visibleoncoursepage = 0',
            ['module' => $module]
        );
<<<<<<< HEAD
        upgrade_mod_savepoint(true, 2022041901, 'label');
    }

=======
        upgrade_mod_savepoint(true, 2022101300, 'label');
    }

    // Automatically generated Moodle v4.1.0 release upgrade line.
    // Put any upgrade step following this.

>>>>>>> master
    return true;
}
