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
 * Welcome to Moodle Managers Privileges System
 * Select the privileges you want to assign or update for selected managers
 * 
 * @package     tool_userprivileges
 * @copyright   2021 Ahsan Gul <ahsan.gul@seecs.edu.pk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require(__DIR__ . '/../../../config.php');
require_once($CFG->libdir . '/adminlib.php');
require_once('classes/processor.php');
require_login();

if (!is_siteadmin()) {
    redirect(new moodle_url("/my/"));
}

admin_externalpage_setup('tool_userprivileges');

global $DB, $USER;

$Processor = new PROCESSOR();
//Privileges assignment process
if (isset($_REQUEST['assign']) && $_REQUEST['method'] == 'assign_privileges') {
    if ($Processor->assign_privileges($_REQUEST)) {
        echo $OUTPUT->header();
        echo "<h1>Privileges successfully assigned to the Managers</h1>";
        //Redirecto to step 2 for privileges assignment
        $returnurl = new moodle_url('/admin/tool/userprivileges/index.php');
        echo "<a class='btn btn-primary' href='{$returnurl}'>BACK</a>";
        echo $OUTPUT->footer();
        exit;
    }
}

$userids = required_param('userids', PARAM_TEXT);

$system_context = context_system::instance();
$PAGE->set_context($system_context);
$url = new moodle_url("/admin/tool/userprivileges/step2.php");
$title = "Moodle Managers Privileges";
$PAGE->set_pagelayout('standard');
$PAGE->set_url($url);
$PAGE->set_title($title);
$PAGE->set_heading($title);

echo $OUTPUT->header();

$sql_reports = "SELECT DISTINCT(p.report) FROM mdl_privileges p";
$reports = $DB->get_records_sql($sql_reports);
$counter = 1;
foreach ($reports as $report) {
    $sql = "SELECT p.* FROM mdl_privileges p WHERE p.report = '$report->report'";
    $privileges = $DB->get_records_sql($sql);

    $report_name1 = $report->report;
    $report_name2 = str_replace("_", " ", $report_name1);
    $report_name = ucwords($report_name2, " ");

    $checked = "";
    $checkboxes .= "<div class='row'>
            <div class='col-12'>               
                <h5>{$counter}. {$report_name}</h5>             
            </div>
        </div>";
    foreach ($privileges as $privilege) {
        $checked = "";
        $check_schools = "";
        $check_activities = "";
        $reporttype = $privilege->report . "_" . $privilege->type;
        switch ($privilege->type) {
            case 'schools':
                //Only for schools - Write your code
                $sql_school = "SELECT * FROM mdl_statistics_schools";
                $school_names = $DB->get_records_sql($sql_school);
                $check_schools .= "<strong style='margin-left:4%;'>Schools</strong>
            <div class='row border' style='margin-left:4%;'>
            ";
                foreach ($school_names as $school_name) {
                    $checked_schoool = "";
                    $short_name = $school_name->shortname;
                    $schools_list = $privilege->id . '[]';
                    $check_schools .= "
                <div class='col-md-2'>
                <div class='form-check'>
                    <input class='form-check-input' type='checkbox' value='$school_name->id' name='{$schools_list}' id='{$school_name->id}' {$checked_schoool}>
                    <label class='form-check-label' for='{$schools_list}'>
                    {$short_name}
                    </label>
                </div>
                </div>
            ";
            
                }
                $check_schools .= "</div>";
                break;
            case 'activities':
                //Only for activities - Write your code
                $sql_activties = "SELECT * FROM mdl_modules WHERE visible = 1";
                $activities_names = $DB->get_records_sql($sql_activties);
                $check_activities .= "<strong style='margin-left:4%;'>Activities</strong><div class='row border' style='margin-left:4%;'>";
                foreach ($activities_names as $activity_name) {
                    $checked_activities = "";
                    $name = $activity_name->name;
                    $activities_list = $privilege->id . '[]';
                    $check_activities .= "
                <div class='col-md-2'>
                <div class='form-check'>
                    <input class='form-check-input' type='checkbox' value='$activity_name->id' name='{$activities_list}' id='{$activities_list}' {$checked_activities}>
                    <label class='form-check-label' for='{$activities_list}'>
                    {$name}
                    </label>
                </div>
                </div>";
                }
                $check_activities .= "</div>";
                break;
            default:
                $checkboxes .= "<div class='row' style='margin-left:2%;'>
            <div class='form-check'>
            <div>
                <input class='form-check-input' type='checkbox' value='1' name='{$privilege->id}' id='{$reporttype}' {$checked}>
                <label class='form-check-label' for='{$privilege->id}'>{$privilege->type}
                </label>
            </div>
            </div>
        </div>";
        }
        $checkboxes .= $check_schools . $check_activities;
    }
    $counter++;
}

echo <<<HTML
<div class='container'>
    <form method='post' action=''>
    {$checkboxes}    
    <input type='hidden' name='method' value='assign_privileges' />
    <input type='hidden' name='managers' value='{$userids}' />
    <br>
    <button type="submit" name="assign" class="btn btn-primary">Assign Privileges</button>
    </form>
</div>
HTML;

echo $OUTPUT->footer();
