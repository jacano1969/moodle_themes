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
 * This file contains the course completion badge award criteria type class
 *
 * @package    core
 * @subpackage badges
 * @copyright  2012 onwards Totara Learning Solutions Ltd {@link http://www.totaralms.com/}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author     Yuliya Bozhko <yuliya.bozhko@totaralms.com>
 */

defined('MOODLE_INTERNAL') || die();
require_once($CFG->libdir . '/completionlib.php');
require_once($CFG->dirroot . '/grade/querylib.php');
require_once($CFG->libdir . '/gradelib.php');

/**
 * Badge award criteria -- award on course completion
 *
 */
class award_criteria_course extends award_criteria {

    /* @var int Criteria [BADGE_CRITERIA_TYPE_COURSE] */
    public $criteriatype = BADGE_CRITERIA_TYPE_COURSE;

    public $required_param = 'course';
    public $optional_params = array('grade', 'bydate');

    /**
     * Add appropriate form elements to the criteria form
     *
     * @param moodleform $mform  Moodle forms object
     * @param stdClass $data details of various modules
     */
    public function config_form_criteria($data) {
        global $OUTPUT;

        $editurl = new moodle_url('/badges/criteria_settings.php', array('badgeid' => $this->badgeid, 'edit' => true, 'type' => $this->criteriatype, 'crit' => $this->id));
        $deleteurl = new moodle_url('/badges/criteria_action.php', array('badgeid' => $this->badgeid, 'delete' => true, 'type' => $this->criteriatype));
        $editaction = $OUTPUT->action_icon($editurl, new pix_icon('t/edit', get_string('edit')), null, array('class' => 'criteria-action'));
        $deleteaction = $OUTPUT->action_icon($deleteurl, new pix_icon('t/delete', get_string('delete')), null, array('class' => 'criteria-action'));

        echo $OUTPUT->box_start();
        if (!$data->is_locked() && !$data->is_active()) {
            echo $OUTPUT->box($deleteaction . $editaction, array('criteria-header'));
        }
        echo $OUTPUT->heading($this->get_title() . $OUTPUT->help_icon('criteria_' . $this->criteriatype, 'badges'), 3, 'main help');

        if (!empty($this->params)) {
            echo $OUTPUT->box(get_string('criteria_descr_' . $this->criteriatype, 'badges') . $this->get_details(), array('clearfix'));
        }
        echo $OUTPUT->box_end();
    }

    /**
     * Get criteria details for displaying to users
     *
     * @return string
     */
    public function get_details($short = '') {
        global $DB;
        $param = reset($this->params);

        $course = $DB->get_record('course', array('id' => $param['course']));
        $str = '"' . $course->fullname . '"';
        if (isset($param['bydate'])) {
            $str .= get_string('criteria_descr_bydate', 'badges', userdate($param['bydate'], get_string('strftimedate', 'core_langconfig')));
        }
        if (isset($param['grade'])) {
            $str .= get_string('criteria_descr_grade', 'badges', $param['grade']);
        }
        return $str;
    }

    /**
     * Add appropriate new criteria options to the form
     *
     */
    public function get_options(&$mform) {
        global $PAGE, $DB;
        $param = array_shift($this->params);
        $course = $DB->get_record('course', array('id' => $PAGE->course->id));

        if (!($course->enablecompletion == COMPLETION_ENABLED)) {
            $none = true;
            $message = get_string('completionnotenabled', 'badges');
        } else {
            $mform->addElement('header', 'criteria_course', $this->get_title());
            $mform->addHelpButton('criteria_course', 'criteria_' . $this->criteriatype, 'badges');
            $parameter = array();
            $parameter[] =& $mform->createElement('static', 'mgrade_', null, get_string('mingrade', 'badges'));
            $parameter[] =& $mform->createElement('text', 'grade_' . $param['course'], '', array('size' => '5'));
            $parameter[] =& $mform->createElement('static', 'complby_' . $param['course'], null, get_string('bydate', 'badges'));
            $parameter[] =& $mform->createElement('date_selector', 'bydate_' . $param['course'], '', array('optional' => true));
            $mform->addGroup($parameter, 'param_' . $param['course'], '', array(' '), false);

            $mform->disabledIf('bydate_' . $param['course'] . '[day]', 'bydate_' . $param['course'] . '[enabled]', 'notchecked');
            $mform->disabledIf('bydate_' . $param['course'] . '[month]', 'bydate_' . $param['course'] . '[enabled]', 'notchecked');
            $mform->disabledIf('bydate_' . $param['course'] . '[year]', 'bydate_' . $param['course'] . '[enabled]', 'notchecked');

            // Set existing values.
            if (isset($param['bydate'])) {
                $mform->setDefault('bydate_' . $param['course'], $param['bydate']);
            }

            if (isset($param['grade'])) {
                $mform->setDefault('grade_' . $param['course'], $param['grade']);
            }

            // Add hidden elements.
            $mform->addElement('hidden', 'course_' . $course->id, $course->id);
            $mform->setType('course_' . $course->id, PARAM_INT);
            $mform->addElement('hidden', 'agg', BADGE_CRITERIA_AGGREGATION_ALL);
            $mform->setType('agg', PARAM_INT);

            $none = false;
            $message = '';
        }
        return array($none, $message);
    }

    /**
     * Review this criteria and decide if it has been completed
     *
     * @param int $userid User whose criteria completion needs to be reviewed.
     * @return bool Whether criteria is complete
     */
    public function review($userid) {
        global $DB;
        foreach ($this->params as $param) {
            $course = $DB->get_record('course', array('id' => $param['course']));

            if ($course->startdate > time()) {
                return false;
            }

            $info = new completion_info($course);
            $check_grade = true;
            $check_date = true;

            if (isset($param['grade'])) {
                $grade = grade_get_course_grade($userid, $course->id);
                $check_grade = ($grade->grade >= $param['grade']);
            }

            if (isset($param['bydate'])) {
                $cparams = array(
                        'userid' => $userid,
                        'course' => $course->id,
                );
                $completion = new completion_completion($cparams);
                $date = $completion->timecompleted;
                $check_date = ($date <= $param['bydate']);
            }

            if ($info->is_course_complete($userid) && $check_grade && $check_date) {
                return true;
            }
        }

        return false;
    }
}