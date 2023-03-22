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
 * Select the managers you want to assign or update the privileges for 
 * 
 * @package     tool_userprivileges
 * @copyright   2021 Ahsan Gul <ahsan.gul@seecs.edu.pk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require(__DIR__ . '/../../../config.php');
require_once($CFG->libdir . '/adminlib.php');
require_login();
if (!is_siteadmin()) {
    redirect(new moodle_url("/my/"));
}
admin_externalpage_setup('tool_userprivileges');
require_once('classes/processor.php');
//Check if the form is already submitted
if (isset($_REQUEST['btn_submit'])) {
    $managers = $_REQUEST['userids'];
    $managers = implode(",", $managers);
    //Redirecto to step 2 for privileges assignment
    $returnurl = new moodle_url('/admin/tool/userprivileges/step2.php', array('userids' => $managers));
    redirect($returnurl);
}

//Check if the form is already submitted when updating
if (isset($_REQUEST['btn_update'])) {
    $managers = $_REQUEST['managerid'];
    $update_value='Previlige_Update';
  //  $managers = implode(",", $managers);
    //Redirecto to update_step 2 for privileges updating
    $returnurl = new moodle_url('/admin/tool/userprivileges/step2_update.php', array('managerid' => $managers,'Update_value'=>$update_value));
    redirect($returnurl);
}

// called function when privilges deleting
$Processor = new PROCESSOR();
//Privileges assignment process
if (isset($_REQUEST['btn_delete'])) {
    $managerid = isset($_REQUEST['managerid']) ? $_REQUEST['managerid'] : 0;
    if ($Processor->delete_privileges($managerid)) {
        echo $OUTPUT->header();
        echo "<h1>Privileges successfully Deleted to the Managers</h1>";
        //Redirecto to step 2 for privileges assignment
        $returnurl = new moodle_url('/admin/tool/userprivileges/index.php');
        echo "<a class='btn btn-primary' href='{$returnurl}'>BACK</a>";
        echo $OUTPUT->footer();
        exit;
    }
}

$system_context = context_system::instance();
$PAGE->set_context($system_context);
$url = new moodle_url("/admin/tool/userprivileges/index.php");
$title = "Moodle Managers Privileges";
$PAGE->set_pagelayout('standard');
$PAGE->set_url($url);
$PAGE->set_title($title);
$PAGE->set_heading($title);
echo $OUTPUT->header();

//Get all the users with Manager role
$sql = "SELECT mdl_user.id, mdl_user.firstname, mdl_user.lastname
FROM mdl_role_assignments
INNER JOIN mdl_user ON mdl_role_assignments.userid = mdl_user.id
where mdl_user.id NOT IN(SELECT userid FROM mdl_user_privileges)
and mdl_role_assignments.roleid = 1"; // Role id is for Manager

$all_users = $DB->get_records_sql($sql);
echo '<div class="row">';
// select count of users
echo '<form method="POST" enctype="multipart/form-data">
        <div class="row" id="managers">
            <div class="col-md-12">
                <label><h5>Select Managers</h5></label>
            </div>
            
            <div class="col-md-12">
               <select style="width:100% !important;max-width:100% !important;" id="userids" size="15" name="userids[]" multiple="multiple" required>';
foreach ($all_users as $users) {
    echo "<option value='" . $users->id . "' selected>$users->firstname  $users->lastname</option>";
}
echo '</select>
            </div>
        </div>
        <div style="margin-top:10%">
            <input class="btn btn-primary" type="submit" name="btn_submit" value="Next">
        </div>';
echo '</form>';

//Get all the users with Manager role Whose assigned previliges
 $sql = "SELECT u.id, u.firstname, u.lastname FROM mdl_user_privileges up
INNER JOIN mdl_user u ON up.userid = u.id
GROUP BY up.userid"; 
// Role id is for Manager
$all_users_pre = $DB->get_records_sql($sql);

// select count of users
echo '<form method="POST">
        <div id="managers">
            <div class="col-md-12">
                <label><h5>Select Previliged Users</h5></label>
            </div>
            <div class="col-md-12">
               <select class="form-control" style="width:100% !important;max-width:100% !important;" id="managerid" name="managerid" required>';
               echo"<option value='0' selected disabled>Select User</option>";
               foreach ($all_users_pre as $users_pre) {
    echo "<option value='" . $users_pre->id . "'>$users_pre->firstname  $users_pre->lastname</option>";
}
echo '</select>
</div>
        </div>
        <div style="margin-top:10%; margin-left:5%;">
            <input class="btn btn-warning" type="submit" name="btn_update" value="Update">
            <button class="btn btn-danger" type="submit" name="btn_delete" onclick=js_confirm("Delete","Record","")>Delete</button>

        </div>';
echo '</form> </div>';
echo $OUTPUT->footer();
?>
<script>

// ///////////////////////////////DELETE START////////////////////////////////////////////////
 function js_confirm(str_what, what_del){
      var r;
       r=confirm("Are you sure you want to " + str_what + " the selected " + what_del);
     if (r==true){
        $('form').attr('onsubmit','return true;');
       } else {
        $('form').attr('onsubmit','return false;');
       }
    }
   ///////////////////////////////DELETE END////////////////////////////////////////////////////////////////
</script>
