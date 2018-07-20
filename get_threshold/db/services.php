<?php

// We defined the web service functions to install.
$functions = array(
        'get_data' => array(
                'classname'   => 'threshold',
                'methodname'  => 'read_threshold',
                'classpath'   => 'local/get_threshold/externallib.php',
                'description' => 'Return the data stored in the table threshold when courseid is given as an in input parameter',
                'type'        => 'read',
        )
);

// We define the services to install as pre-build services. A pre-build service is not editable by administrator.
$services = array(
        'Read_Threshold' => array(
                'functions' => array ('get_data'),
                'restrictedusers' => 0,
                'enabled'=>1,
        )
);
