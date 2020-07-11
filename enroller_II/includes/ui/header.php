<?php 
    if($path = cust_file('style.php'))include($path);
    switch($_REQUEST['action']){
        case 'lookup':   
            if($path = cust_file('lookupjss.php'))include($path);
            if($path = cust_file('lookup.php'))include($path); 
            break;
        default:
            if($path = cust_file('jss.php'))include($path);
            if($path = cust_file('body.php'))include($path); 
    };   
?>


