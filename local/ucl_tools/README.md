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
 * Readme file for local_ucl_tools plugin
 *
 * @package local_ucl_tools
 * @subpackage  ucl_tools
 * @copyright   2014, Nivedita Setru <n.setru@ucl.ac.uk>
 * @license http://www.ucl.ac.uk
 */
 
 Local plugin ucl_tools contains UCL specific functions.
=========================================================
 
  ucl_tools acts as a main plugin, within which there could be number of sub-plugins. While writing a new sub-plugin, follow instructions mentioned below:
  - Edit /local/ucl_tools/settings.php page to add sub-menus(link to access sub-plugins) for 'UCL tools'
  - Directory structure for sub-plugins 
    /ucl_tools/
        --> /<sub-plugin name>/
            --> index.php
            --> lib.php
            --> /<templates>/
                --> <template_name>
            --> /<forms>/
                --> <form_name.php>
               
                
  1) local/ucl_tools/quiz_reset
  ================================
  
  Background
  ------------
  We get lots of user requests to reset quiz attempts that are stuck in 'never submitted' state to 'in progress' state. This requires database update from LTA. 
  Details here https://wiki.ucl.ac.uk/display/ISMoodle/Moodle+Developer+Tips
  
  Purpose
  -----------
  This will allow Moodle administrators to reset the quiz attempts to 'inprogress' state
  
  Technical details
  ------------------
  - Can be accessed via, Site administration->UCL tools->Reset quiz attempts
  - User should enter course shortname
  - This brings list of abandoned quiz attempts for each quiz activity in a course
  - clicking on 'update quiz attempt', will update the quiz attempt state from 'abandoned' to 'inprogress'
  
  
