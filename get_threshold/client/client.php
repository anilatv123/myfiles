<?php
/**
 * XMLRPC client for Moodle 2 - get_threshold
 *
 * This script does not depend of any Moodle code,
 * and it can be called from a browser.
 *
 */

/// MOODLE ADMINISTRATION SETUP STEPS
// 1- Install the plugin
// 2- Enable web service advance feature (Admin > Advanced features)
// 3- Enable XMLRPC protocol (Admin > Plugins > Web services > Manage protocols)
// 4- Create a token for a specific user and for the service 'My service' (Admin > Plugins > Web services > Manage tokens)
// 5- Run this script directly from your browser: you should see the threshold value maintained for the given courseid.

/// SETUP - NEED TO BE CHANGED
// token of admin
$token = 'e0584987f03897af3fab1f969f117c99';
// token of Mathew
//$token = '32b64cf4aca93d90401f6fd7d0ffdf0d';
//Domain of moodle
$domainname = 'http://127.0.0.1/edsa-moodle';

/// FUNCTION NAME
$functionname = 'get_data';

/// PARAMETERS
global $courseid;
$courseid= (int) $_GET['courseid'];
//$course_id[]=$courseid;

///// XML-RPC CALL
header('Content-Type: text/plain');
$serverurl = $domainname . '/webservice/xmlrpc/server.php'. '?wstoken=' . $token.'&courseid='.$courseid;
require_once('./curl.php');
$curl = new curl;
$post = xmlrpc_encode_request($functionname, array($courseid));
$resp = xmlrpc_decode($curl->post($serverurl, $post));
print_r($resp);
