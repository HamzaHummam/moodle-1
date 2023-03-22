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
 * This file is part of the Database module for Moodle
 *
 * @copyright 2005 Martin Dougiamas  http://dougiamas.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package mod_data
 */

use mod_data\manager;

require_once('../../config.php');
require_once('lib.php');

$id    = optional_param('id', 0, PARAM_INT);  // course module id
$d     = optional_param('d', 0, PARAM_INT);   // database id
$mode  = optional_param('mode', 'addtemplate', PARAM_ALPHA);
$action  = optional_param('action', '', PARAM_ALPHA);
$useeditor = optional_param('useeditor', null, PARAM_BOOL);

$url = new moodle_url('/mod/data/templates.php');

if ($id) {
    list($course, $cm) = get_course_and_cm_from_cmid($id, manager::MODULE);
    $manager = manager::create_from_coursemodule($cm);
    $url->param('d', $cm->instance);
} else {   // We must have $d.
    $instance = $DB->get_record('data', ['id' => $d], '*', MUST_EXIST);
    $manager = manager::create_from_instance($instance);
    $cm = $manager->get_coursemodule();
    $course = get_course($cm->course);
    $url->param('d', $d);
}

$instance = $manager->get_instance();
$context = $manager->get_context();

$url->param('mode', $mode);
$PAGE->set_url($url);

require_login($course, false, $cm);
require_capability('mod/data:managetemplates', $context);

if ($action == 'resetalltemplates') {
    require_sesskey();
    $manager->reset_all_templates();
    redirect($PAGE->url, get_string('templateresetall', 'mod_data'), null, \core\output\notification::NOTIFY_SUCCESS);
}

$manager->set_template_viewed();

if ($useeditor !== null) {
    // The useeditor param was set. Update the value for this template.
    data_set_config($instance, "editor_{$mode}", !!$useeditor);
}

$PAGE->requires->js('/mod/data/data.js');
$PAGE->set_title($instance->name);
$PAGE->set_heading($course->fullname);
$PAGE->set_pagelayout('admin');
$PAGE->force_settings_menu(true);
$PAGE->activityheader->disable();
$PAGE->add_body_class('mediumwidth');

echo $OUTPUT->header();

$renderer = $manager->get_renderer();
// Check if it is an empty database with no fields.
if (!$manager->has_fields()) {
    echo $renderer->render_templates_zero_state($manager);
    echo $OUTPUT->footer();
    // Don't check the rest of the options. There is no field, there is nothing else to work with.
    exit;
}

$actionbar = new \mod_data\output\action_bar($instance->id, $url);
echo $actionbar->get_templates_action_bar();

if (($formdata = data_submitted()) && confirm_sesskey()) {
    if (!empty($formdata->defaultform)) {
        // Reset the template to default.
        if (!empty($formdata->resetall)) {
            $manager->reset_all_templates();
            $notificationstr = get_string('templateresetall', 'mod_data');
        } else {
            $manager->reset_template($mode);
            $notificationstr = get_string('templatereset', 'data');
        }
    } else {
        $manager->update_templates($formdata);
        $notificationstr = get_string('templatesaved', 'data');
    }
}

if (!empty($notificationstr)) {
    echo $OUTPUT->notification($notificationstr, 'notifysuccess');
}

<<<<<<< HEAD
editors_head_setup();

// Determine whether to use HTML editors.
if (($mode === 'csstemplate') || ($mode === 'jstemplate')) {
    // The CSS and JS templates aren't HTML.
    $usehtmleditor = false;
} else {
    $usehtmleditor = data_get_config($data, "editor_{$mode}", true);
}

$datafieldtype = '';
if ($usehtmleditor) {
    $format = FORMAT_HTML;
    $datafieldtype = ' data-fieldtype="editor" ';
} else {
    $format = FORMAT_PLAIN;
}

$editor = editors_get_preferred_editor($format);
$strformats = format_text_menu();
$formats =  $editor->get_supported_formats();
foreach ($formats as $fid) {
    $formats[$fid] = $strformats[$fid];
}
$options = array();
$options['trusttext'] = false;
$options['forcehttps'] = false;
$options['subdirs'] = false;
$options['maxfiles'] = 0;
$options['maxbytes'] = 0;
$options['changeformat'] = 0;
$options['noclean'] = false;

echo '<form id="tempform" action="templates.php?d='.$data->id.'&amp;mode='.$mode.'" method="post">';
echo '<div>';
echo '<input name="sesskey" value="'.sesskey().'" type="hidden" />';
// Print button to autogen all forms, if all templates are empty

if (!$resettemplate) {
    // Only reload if we are not resetting the template to default.
    $data = $DB->get_record('data', array('id'=>$d));
}
echo $OUTPUT->box_start('generalbox boxaligncenter boxwidthwide');
echo '<table cellpadding="4" cellspacing="0" border="0">';

if ($mode == 'listtemplate'){
    // Print the list template header.
    echo '<tr>';
    echo '<td>&nbsp;</td>';
    echo '<td>';
    echo '<div class="template_heading"><label for="edit-listtemplateheader">'.get_string('header','data').'</label></div>';

    $field = 'listtemplateheader';
    $editor->set_text($data->listtemplateheader);
    $editor->use_editor($field, $options);
    echo "<div><textarea id='{$field}' {$datafieldtype} name='{$field}' class='form-control' rows='15' cols='80'>" .
        s($data->listtemplateheader) . '</textarea></div>';

    echo '</td>';
    echo '</tr>';
}

// Print the main template.

echo '<tr><td valign="top">';
if ($mode != 'csstemplate' and $mode != 'jstemplate') {
    // Add all the available fields for this data.
    echo '<label for="availabletags">'.get_string('availabletags','data').'</label>';
    echo $OUTPUT->help_icon('availabletags', 'data');
    echo '<br />';

    echo '<div class="no-overflow" id="availabletags_wrapper">';
    echo '<select name="fields1[]" id="availabletags" size="12" onclick="insert_field_tags(this)" class="form-control">';

    $fields = $DB->get_records('data_fields', array('dataid'=>$data->id));
    echo '<optgroup label="'.get_string('fields', 'data').'">';
    foreach ($fields as $field) {
        echo '<option value="[['.$field->name.']]" title="'.$field->description.'">'.$field->name.' - [['.$field->name.']]</option>';
    }
    echo '</optgroup>';

    if ($mode == 'addtemplate') {
        echo '<optgroup label="'.get_string('fieldids', 'data').'">';
        foreach ($fields as $field) {
            if (in_array($field->type, array('picture', 'checkbox', 'date', 'latlong', 'radiobutton'))) {
                continue; //ids are not usable for these composed items
            }
            echo '<option value="[['.$field->name.'#id]]" title="'.$field->description.' id">'.$field->name.' id - [['.$field->name.'#id]]</option>';
        }
        echo '</optgroup>';
        if (core_tag_tag::is_enabled('mod_data', 'data_records')) {
            echo '<optgroup label="'.get_string('other', 'data').'">';
            echo '<option value="##tags##">' . get_string('tags') . ' - ##tags##</option>';
            echo '</optgroup>';
        }
    }

    // Print special tags. fix for MDL-7031
    if ($mode != 'addtemplate' && $mode != 'asearchtemplate') {             //Don't print special tags when viewing the advanced search template and add template.
        echo '<optgroup label="'.get_string('buttons', 'data').'">';
        echo '<option value="##edit##">' .get_string('edit', 'data'). ' - ##edit##</option>';
        echo '<option value="##delete##">' .get_string('delete', 'data'). ' - ##delete##</option>';
        echo '<option value="##approve##">' .get_string('approve', 'data'). ' - ##approve##</option>';
        echo '<option value="##disapprove##">' .get_string('disapprove', 'data'). ' - ##disapprove##</option>';
        if ($mode != 'rsstemplate') {
            echo '<option value="##export##">' .get_string('export', 'data'). ' - ##export##</option>';
        }
        if ($mode != 'singletemplate') {
            // more points to single template - not useable there
            echo '<option value="##more##">' .get_string('more', 'data'). ' - ##more##</option>';
            echo '<option value="##moreurl##">' .get_string('moreurl', 'data'). ' - ##moreurl##</option>';
            echo '<option value="##delcheck##">' .get_string('delcheck', 'data'). ' - ##delcheck##</option>';
        }
        echo '</optgroup>';
        echo '<optgroup label="'.get_string('other', 'data').'">';
        echo '<option value="##timeadded##">'.get_string('timeadded', 'data'). ' - ##timeadded##</option>';
        echo '<option value="##timemodified##">'.get_string('timemodified', 'data'). ' - ##timemodified##</option>';
        echo '<option value="##user##">' .get_string('user'). ' - ##user##</option>';
        echo '<option value="##userpicture##">' . get_string('userpic') . ' - ##userpicture##</option>';
        echo '<option value="##approvalstatus##">' .get_string('approvalstatus', 'data'). ' - ##approvalstatus##</option>';

        if (core_tag_tag::is_enabled('mod_data', 'data_records')) {
            echo '<option value="##tags##">' . get_string('tags') . ' - ##tags##</option>';
        }

        if ($mode != 'singletemplate') {
            // more points to single template - not useable there
            echo '<option value="##comments##">' .get_string('comments', 'data'). ' - ##comments##</option>';
        }
        echo '</optgroup>';
    }

    if ($mode == 'asearchtemplate') {
        echo '<optgroup label="'.get_string('other', 'data').'">';
        echo '<option value="##firstname##">' .get_string('authorfirstname', 'data'). ' - ##firstname##</option>';
        echo '<option value="##lastname##">' .get_string('authorlastname', 'data'). ' - ##lastname##</option>';
        echo '</optgroup>';
    }

    echo '</select>';
    echo '</div>';
}
echo '</td>';

echo '<td valign="top">';
if ($mode == 'listtemplate'){
    echo '<div class="template_heading"><label for="edit-template">'.get_string('multientry','data').'</label></div>';
} else {
    echo '<div class="template_heading"><label for="edit-template">'.get_string($mode,'data').'</label></div>';
}

$field = 'template';
$editor->set_text($data->{$mode});
$editor->use_editor($field, $options);
echo '<div>';
echo '<textarea class="form-control" id="' . $field . '" ' . $datafieldtype .
     'name="' . $field . '" rows="15" cols="80">' . s($data->{$mode}) . '</textarea>';
echo '</div>';
echo '</td>';
echo '</tr>';

if ($mode == 'listtemplate'){
    echo '<tr>';
    echo '<td>&nbsp;</td>';
    echo '<td>';
    echo '<div class="template_heading"><label for="edit-listtemplatefooter">'.get_string('footer','data').'</label></div>';

    $field = 'listtemplatefooter';
    $editor->set_text($data->listtemplatefooter);
    $editor->use_editor($field, $options);
    echo '<div>';
    echo '<textarea id="' . $field . '" class="form-control" ' . $datafieldtype .
         'name="' . $field . '" rows="15" cols="80">' . s($data->listtemplatefooter) . '</textarea>';
    echo '</div>';
    echo '</td>';
    echo '</tr>';
} else if ($mode == 'rsstemplate') {
    echo '<tr>';
    echo '<td>&nbsp;</td>';
    echo '<td>';
    echo '<div class="template_heading">';
    echo '<label for="edit-rsstitletemplate">' . get_string('rsstitletemplate', 'data') . '</label>';
    echo '</div>';

    $field = 'rsstitletemplate';
    $editor->set_text($data->rsstitletemplate);
    $editor->use_editor($field, $options);
    echo '<div>';
    echo '<textarea id="' . $field . '" name="' . $field . '" ' . $datafieldtype .
         'class="form-control" rows="15" cols="80">' . s($data->rsstitletemplate) . '</textarea>';
    echo '</div>';
    echo '</td>';
    echo '</tr>';
}

echo '</table>';
echo html_writer::start_div('container-fluid mt-4');
echo html_writer::start_div('row');

$resettemplatebutton = html_writer::empty_tag('input', ['type' => 'submit', 'name' => 'defaultform',
    'class' => 'btn btn-secondary', 'value' => get_string('resettemplate', 'data')]);
$savetemplatebutton = html_writer::empty_tag('input', ['type' => 'submit', 'class' => 'btn btn-primary ml-2',
    'value' => get_string('savetemplate', 'data')]);

echo html_writer::div($resettemplatebutton . $savetemplatebutton);

if ($mode != 'csstemplate' and $mode != 'jstemplate') {
    // Output the toggle template editor element.
    $toggletemplateeditor = html_writer::checkbox('useeditor', 1, $usehtmleditor,
        get_string('editorenable', 'data'), null, ['class' => 'pl-2']);
    echo html_writer::div($toggletemplateeditor, 'ml-auto');
    $PAGE->requires->js_call_amd('mod_data/templateseditor', 'init', ['d' => $d, 'mode' => $mode]);
}
echo html_writer::end_div();
echo html_writer::end_div();

echo $OUTPUT->box_end();
echo '</div>';
echo '</form>';
=======
$templateeditor = new \mod_data\output\template_editor($manager, $mode);
echo $renderer->render($templateeditor);
>>>>>>> master

/// Finish the page
echo $OUTPUT->footer();
