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
 * Add UCL tools menu and sub-menus within site-administration block
 *
 * @package local_ucl_tools
 * @subpackage  ucl_tools
 * @copyright   2014, Nivedita Setru <n.setru@ucl.ac.uk>
 * @license http://www.ucl.ac.uk
 */

$ADMIN->add('root', new admin_category('ucl_tools', get_string('ucltools', 'local_ucl_tools')));
$ADMIN->add('ucl_tools', new admin_externalpage('quiz_reset', get_string('quizreset', 'local_ucl_tools'),
    $CFG->wwwroot.'/local/ucl_tools/quiz_reset/index.php'));