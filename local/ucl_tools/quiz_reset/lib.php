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
 *
 * functions to process specific
 *
 * @package local_ucl_tools
 * @subpackage  ucl_tools
 * @copyright   2014, Nivedita Setru <n.setru@ucl.ac.uk>
 * @license http://www.ucl.ac.uk
 */


function local_ucl_tools_quizresetgetquizzes($courseshortname) {
    global $DB;

    $params = array('shortname' => $courseshortname);
    $sql = 'select * from {quiz} where course = (select id from {course} where shortname = :shortname)';

    $quiz = array();
    $quiz = $DB->get_records_sql($sql, $params);

    return $quiz;
}

function local_ucl_tools_printquizattemptstable($quizattempts, $quiz){
    global $DB;

    $table = new html_table();
    $table->width = "100%";
    $table->head = array('quiz', 'fullname', 'email', 'state', 'edit');
    $table->align = array('center', 'center', 'center', 'center', 'center');
    //$columns = array('username','fullname', 'email');

    $namefields = get_all_user_name_fields(true);
    foreach($quizattempts as $quizattempt) {
        $user = $DB->get_record('user', array('id' => $quizattempt->userid), 'id, ' . $namefields . ', username, email');
        $user->fullname = fullname($user, true);
        $table->data[] = array (
            $quiz->name,
            $user->fullname,
            $user->email,
            $quizattempt->state,
            'image'
        );
    }
    return $table;
}