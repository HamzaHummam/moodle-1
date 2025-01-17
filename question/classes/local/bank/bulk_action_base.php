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

namespace core_question\local\bank;

/**
 * Class bulk_action_base is the base class for bulk actions ui.
 *
 * Every plugin wants to implement a bulk action, should extend this class, add appropriate values to the methods
 * and finally pass this object via plugin_feature class.
 *
 * @package    core_question
 * @copyright  2021 Catalyst IT Australia Pty Ltd
 * @author     Safat Shahin <safatshahin@catalyst-au.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
abstract class bulk_action_base {

    /**
     * Title of the bulk action.
     * Every bulk action will have a string to show in the list.
     *
     * @return string
     */
    abstract public function get_bulk_action_title(): string;

    /**
     * A unique key for the bulk action, this will be used in the api to identify the action data.
     * Every bulk must have a unique key to perform the action as a part of the form post in the base view.
     * When questions are selected, it will post according to the key its selected from the dropdown.
     *
     * @return string
     */
<<<<<<< HEAD
    public function get_bulk_action_key(): string {
        return '';
    }
=======
    abstract function get_key(): string;
>>>>>>> master

    /**
     * URL of the bulk action redirect page.
     * Bulk action can be performed by redirecting to a page and doing the appropriate selection
     * and finally doing the action. The url will be url of the page where users will be redirected to
     * select what to do with the selected questions.
     *
     * @return \moodle_url
     */
    abstract public function get_bulk_action_url(): \moodle_url;

    /**
     * Get the capabilities for the bulk action.
     * The bulk actions might have some capabilities to action them as a user.
     * This method helps to get those caps which will be used by the base view before actioning the bulk action.
     * For ex: ['moodle/question:moveall', 'moodle/question:add']
     * At least one of the cap need to be true for the user to use this action.
     *
     * @return array|null
     */
    public function get_bulk_action_capabilities(): ?array {
        return null;
    }

<<<<<<< HEAD

=======
>>>>>>> master
    /**
     * A unique key for the bulk action, this will be used in the api to identify the action data.
     * Every bulk must have a unique key to perform the action as a part of the form post in the base view.
     * When questions are selected, it will post according to the key its selected from the dropdown.
     *
<<<<<<< HEAD
     * Note: This method is the first towards moving from get_bulk_action_key() to get_key().
     *
     * @return string
     */
    public function get_key(): string {
        if (!empty($this->get_bulk_action_key())) {
            return $this->get_bulk_action_key();
        }
        throw new \coding_exception('Bulk actions must implement the get_key() or get_bulk_action_key() method. ' .
            'In Moodle 4.1, get_bulk_action_key() is being deprecated and replaced by get_key().');
=======
     * @return string
     * @deprecated since Moodle 4.1
     * @see get_key()
     * @todo Final deprecation on Moodle 4.5 MDL-72438
     */
    public function get_bulk_action_key() {
        debugging(__FUNCTION__ . " is deprecated and should no longer be used. Please use get_key() instead.", DEBUG_DEVELOPER);
        return $this->get_key();
>>>>>>> master
    }
}
