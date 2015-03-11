<?php  // Moodle configuration file

unset($CFG);
global $CFG;
$CFG = new stdClass();

$CFG->dbtype    = 'mysqli';
$CFG->dblibrary = 'native';
$CFG->dbhost    = 'localhost';
$CFG->dbname    = 'moodlecore_v274';
$CFG->dbuser    = 'root';
$CFG->dbpass    = '';
$CFG->prefix    = 'mdl_';
$CFG->dboptions = array (
  'dbpersist' => 0,
  'dbport' => '',
  'dbsocket' => '',
);

$CFG->wwwroot   = 'http://localhost/moodle/moodlefork';
$CFG->dataroot  = 'C:\\xampp\\moodledata\\moodlecoreniv_v274';
$CFG->admin     = 'admin';

$CFG->directorypermissions = 0777;

//=========================================================================
// 9. PHPUNIT SUPPORT
//=========================================================================
 $CFG->phpunit_prefix = 'phpu_';
 $CFG->phpunit_dataroot = 'C:\\xampp\\moodledata\\phpu_moodledata';
 //$CFG->phpunit_directorypermissions = 02777; // optional
//===========================================================================

$CFG->altcacheconfigpath = 'C:\\xampp\\moodledata\\moodlecoreniv_v274\\muc_280115';

require_once(dirname(__FILE__) . '/lib/setup.php');

// There is no php closing tag in this file,
// it is intentional because it prevents trailing whitespace problems!
