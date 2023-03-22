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
 * Processor class for insertion and updation of the privileges
 * 
 * @package     tool_userprivileges
 * @copyright   2021 Ahsan Gul <ahsan.gul@seecs.edu.pk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class PROCESSOR{
	function assign_privileges($options){
		global $DB, $USER;
		$response = 0;
		$managers = explode(",", $_REQUEST['managers']);
		unset($_REQUEST['managers']);
		unset($_REQUEST['method']);
		unset($_REQUEST['assign']);
		if (isset($_REQUEST['userids'])) {
			unset($_REQUEST['userids']);
		}
		$dataobject = new stdClass();
		foreach ($managers as $manager) {
			foreach ($_REQUEST as $key => $privilege) {
				$dataobject->userid = $manager;
				$dataobject->privilegeid = $key;
				$dataobject->privilegevalue = is_array($privilege) ? implode(",", $privilege) : $privilege;
				$dataobject->createdon = time();
				$dataobject->updatedon = null;
				$dataobject->createdby = $USER->id;
				$response = $DB->insert_record('user_privileges', $dataobject);
			}			
		}
		return $response;
	}

	// Function for privliges deleting
	function delete_privileges($manager){
		global $DB, $USER;
		$response = 0;
		$response = $DB->delete_records('user_privileges', array('userid'=> $manager));
		return $response;
	}

	function update_privileges(){
		global $DB, $USER;
		// echo "<pre>";
		// print_r($_REQUEST);
		// echo "</pre>";
		// exit;
		$response = 0;
		$manager = $_REQUEST['managerid'];
		unset($_REQUEST['managers']);
		unset($_REQUEST['method']);
		unset($_REQUEST['managerid']);
		unset($_REQUEST['update']);
		unset($_REQUEST['Update_value']);
		
		    $dataobject = new stdClass();
			foreach ($_REQUEST as $key => $privilege) {
			$dataobject->id = $DB->get_record('user_privileges', ['userid'=>$manager, 'privilegeid'=>$key])->id;
				$dataobject->userid = $manager;
				$dataobject->privilegeid = $key;
				$dataobject->privilegevalue = is_array($privilege) ? implode(",", $privilege) : $privilege;
				$dataobject->createdby = $USER->id;
				if (isset($dataobject->id)) {
			     $response = $DB->update_record('user_privileges', $dataobject);
				} else {
				$dataobject->createdon = time();
				$dataobject->updatedon = null;
				
			//	$response = $DB->delete_records('user_privileges', array('userid'=> $manager));

			    $response = $DB->insert_record('user_privileges', $dataobject);

			}

			}
			$array_keys=array_keys($_REQUEST);
			$array_keys_exp=implode(",", $array_keys);
			$delete="DELETE from mdl_user_privileges where privilegeid NOT IN ($array_keys_exp) and userid='$dataobject->userid'";
			$delete_run=$DB->execute($delete);
		return $response;
	}







}
