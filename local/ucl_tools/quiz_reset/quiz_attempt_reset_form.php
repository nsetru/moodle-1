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
 * Form to reset never-submitted/abandoned quiz attempts
 *
 * @package     local_ucl_tools
 * @subpackage  ucl_tools
 * @copyright   2014, Nivedita Setru <n.setru@ucl.ac.uk>
 * @license     http://www.ucl.ac.uk
 */

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    //  It must be included from a Moodle page.
}

require_once($CFG->libdir . '/formslib.php');

class quiz_attempt_reset_form extends moodleform
{
    /**
     * Define this form - called from the parent constructor
     */
    public function definition() {

        $mform = $this->_form;

        $mform->addElement('text', 'courseshortname', get_string('courseshortname', 'local_ucl_tools'));
        $mform->addHelpButton('courseshortname', 'courseshortname', 'local_ucl_tools');
        $mform->addRule('courseshortname', get_string('required'), 'required', null, 'client');
        $mform->setType('courseshortname', PARAM_TEXT);

        $this->add_action_buttons(false, get_string('search', 'local_ucl_tools'));
    }
}