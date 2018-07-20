<?php
defined('MOODLE_INTERNAL') || die();
function xmldb_block_backoffice_upgrade($oldversion, $block) {
    global $DB;
	 $dbman = $DB->get_manager();
    $result = TRUE;
if ($oldversion < 2017042620) {
        // Define table threshold to be created.
       // $table = new xmldb_table('threshold');

        // Adding fields to table threshold.
        
$table = new xmldb_table('threshold');
        // Conditionally launch create table for threshold.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);    
$table->add_field('id', XMLDB_TYPE_INTEGER, '11', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('courseid', XMLDB_TYPE_INTEGER, '11', null, XMLDB_NOTNULL, null, null);
        $table->add_field('startcoursedate', XMLDB_TYPE_INTEGER, '11', null, XMLDB_NOTNULL, null, null);
        $table->add_field('post_high', XMLDB_TYPE_INTEGER, '11', null, XMLDB_NOTNULL, null, null);
        $table->add_field('post_low', XMLDB_TYPE_INTEGER, '11', null, XMLDB_NOTNULL, null, null);
        $table->add_field('login_high', XMLDB_TYPE_INTEGER, '11', null, XMLDB_NOTNULL, null, null);
        $table->add_field('login_low', XMLDB_TYPE_INTEGER, '11', null, XMLDB_NOTNULL, null, null);
        $table->add_field('login_importance', XMLDB_TYPE_INTEGER, '11', null, XMLDB_NOTNULL, null, null);
        $table->add_field('post_importance', XMLDB_TYPE_INTEGER, '11', null, XMLDB_NOTNULL, null, null);
        $table->add_field('assid_low', XMLDB_TYPE_INTEGER, '11', null, XMLDB_NOTNULL, null, null);
        $table->add_field('assid_high', XMLDB_TYPE_INTEGER, '11', null, XMLDB_NOTNULL, null, null);
        $table->add_field('aprov_high', XMLDB_TYPE_INTEGER, '11', null, XMLDB_NOTNULL, null, null);
        $table->add_field('aprov_low', XMLDB_TYPE_INTEGER, '11', null, XMLDB_NOTNULL, null, null);
        // Adding keys to table threshold.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Backoffice savepoint reached.
        upgrade_block_savepoint(true, 2017042620, 'backoffice');
    }
}


    return $result;
}
?>
