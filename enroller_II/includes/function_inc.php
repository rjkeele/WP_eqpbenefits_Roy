<?php

/**********
* Copyright GOOSE IAS, LLC 2000-2015 All  Rights Reserved
* @version 2.0
* @author: James Holden
* @created: 07/24/2015 00:00:00
* All Rights Reserved
**********/


function prh($myvar){
    echo '<pre>'.str_replace(array("\n" , " "), array('<br>', '&nbsp;'), print_r($myvar, true)).'</pre>';
}

function next_month($date,$offset = 1){
    /*This function will add or subtract from $date $offest months.
    If the day of the month does not exist in the resulting month, for example
    there is no Feb. 31, then an offset from the last day of the target month
    is equal to that of the initial month
    */
    if($offset<1){
        $offset = abs($offset);
        $month = date("m",$date)-$offset;
        $year = date("Y",$date);
        while($offset > 12){
            $year = $year -1;
            $month = $month+12;
            $offset = $offset - 12;
        }
    } else {
        $month = date("m",$date)+$offset;
        $year = date("Y",$date);
        while($offset > 12){
            $year = $year +1;
            $month = $month-12;
            $offset = $offset - 12;
        }
    }
    if($month > 12){
        while($month >12){
            $year = $year + 1;
            $month = $month - 12;
        }
    }else if($month < 1){
        while($month >12){
            $year = $year - 1;
            $month = $month + 12;
        }
    }

    /*jrh 12/21/06 ID004 Handle Month additions during the last few days of a month */
    $orig_month =date("m",$date);
    $orig_year = date("Y",$date);
    $orig_days_in_month = daysinmonth($orig_month,$orig_year);
    $day = date("d",$date);
    $days_in_month = daysinmonth($month,$year);
    if($day>$days_in_month){
        $diff = daysinmonth($orig_month,$orig_year)-$day;
        $day = $days_in_month - $diff;
    }else if($days_in_month>$orig_days_in_month){
        $diff = $days_in_month - $orig_days_in_month;
        if($day >= $days_in_month - $diff){
            $day = $day + $diff;
        }
    }
    return mktime(date('H',$date), date('i',$date), date('s',$date), $month, $day, $year);
}

function daysinmonth($month, $year){
    if(checkdate($month, 31, $year)) return 31;
    if(checkdate($month, 30, $year)) return 30;
    if(checkdate($month, 29, $year)) return 29;
    if(checkdate($month, 28, $year)) return 28;
    return 0; // error
}

//Accepts M/D/Y and returns timestamp of that day, previous month

function previous_month($mo,$day,$year){
    $previous_mo = ($mo == 1) ? 12 : $mo - 1;
    $previous_year = ($mo == 1) ? $year - 1 : $year;
    $last_mo_ts = mktime(0,0,0,$previous_mo,$day,$previous_year);
    return $last_mo_ts;
}

//Accepts a rate, mo & markup amount, and returns correct premium

function get_trend_kicker($rate,$mo,$markup,$tk=''){
    //JKL Updated 10.25.06 To Allow Dynamic Trend Kicker
    $tk = ($tk > 0) ? $tk : 1.124;
    for($i = 1;$i < $mo * 1;$i++){
        $rate = $rate * exp(.083333333333333333333333333333333 * log($tk));
    }
    return $rate / $markup;
}

//Inpute Day, Year, Month, and Days, and puts out a formatted Date $days in the Future

function date_validate($strdate){
    if(strlen($strdate) == 8 && (substr($strdate,0,2) == 19 || substr($strdate,0,2) == 20 || substr($strdate,0,2) == 99)){
        $year = substr($strdate,0,4);
        $month = substr($strdate,4,2);
        $date = substr($strdate,6,2);
        if($year == 9999 || $year == '9999'){
            $year = 2035;
        }
        $datearr = array($month,$date,$year);
    } else {
        $pos1 = strpos($strdate,"/");
        $pos2 = strpos(substr($strdate,$pos1+1,3),"/");

        //The entered value is checked for proper Date format
        if((substr_count($strdate,"/"))<>2){
            return array(0,"Enter the date in 'dd/mm/yyyy' format");
        } else {
            $month = substr($strdate,0,($pos1));
            $result = preg_match("/^[0-9]+$/",$month,$trashed);
            if(!($result)){
            } else {
                if(($month <= 0) || ($month > 12)){
                    return array(0,"Enter a Valid Month");
                }
            }
        }
        $date = substr($strdate,$pos1+1,$pos2);
        if(($date <= 0) || ($date > 31)){
            return array(0,"Enter a Valid Day");
        } else {
            $result = preg_match("/^[0-9]+$/",$date,$trashed);
            if(!($result)){
                return array(0,"Enter a Valid Day");
            }
        }
        $year = substr($strdate,($pos2 + $pos1 + 2),4);
        $result = preg_match("/^[0-9]+$/",$year,$trashed);
        if(!($result)){
            echo "Enter a Valid year";
        } else {
            if(($year < 1900) || ($year > 2200)){
                return array(0,"Enter a year between 1900-2200");
            }
        }
        $datearr = array($month,$date,$year);
    }
    return array(1,$datearr);
}

function get_age($bMonth='',$bDay='',$bYear='',$effective_date = '',$future_date = '',$birth_ts='') {
    $cMonth = date('n');
    $cDay = date('j');
    $cYear = date('Y');
    $now = time();
    if($effective_date && $effective_date < $now){
        $calc_date = $effective_date;
    }elseif($future_date && $future_date > $now){
        $calc_date = $future_date;
    }else{
        $calc_date = time();
    }
    if(abs($birth_ts)>0){
        $bMonth = date('n',$birth_ts);
        $bDay = date('j',$birth_ts);
        $bYear = date('Y',$birth_ts);
    }
    $cMonth = date('n',$calc_date);
    $cDay = date('j',$calc_date);
    $cYear = date('Y',$calc_date);
    if(($cMonth >= $bMonth && $cDay >= $bDay) || ($cMonth > $bMonth)) {
        return ($cYear - $bYear);
    } else {
        return ($cYear - $bYear - 1);
    }
}

function validate_cc($cc_num, $type) {
    if($type == "American" || $type == 3) {
        $denum = "American Express";
    } elseif($type == "Dinners") {
        $denum = "Diner's Club";
    } elseif($type == "Discover" || $type == 4) {
        $denum = "Discover";
    } elseif($type == "Master" || $type == 2) {
        $denum = "Master Card";
    } elseif($type == "Visa" || $type == 1) {
        $denum = "Visa";
    }
    if($denum == "American") {
        $pattern = "/^([34|37]{2})([0-9]{13})$/";//American Express
        if (preg_match($pattern,$cc_num) && validate_mod10($cc_num)) {
            $verified = true;
        } else {
            $verified = false;
        }
    } elseif($denum == "Dinners") {
        $pattern = "/^([30|36|38]{2})([0-9]{12})$/";//Diner's Club
        if (preg_match($pattern,$cc_num) && validate_mod10($cc_num)) {
            $verified = true;
        } else {
            $verified = false;
        }
    } elseif($denum == "Discover") {
        $pattern = "/^([6011]{4})([0-9]{12})$/";//Discover Card
        if (preg_match($pattern,$cc_num) && validate_mod10($cc_num)) {
            $verified = true;
        } else {
            $verified = false;
        }
    } elseif($denum == "Master Card") {
        $pattern = "/^([51|52|53|54|55]{2})([0-9]{14})$/";//Mastercard
        if (preg_match($pattern,$cc_num) && validate_mod10($cc_num)) {
            $verified = true;
        } else {
            $verified = false;
        }
    } elseif($denum == "Visa") {
        $pattern = "/^([4]{1})([0-9]{12,15})$/";//Visa
        if (preg_match($pattern,$cc_num) && validate_mod10($cc_num)) {
            $verified = true;
        } else {
            $verified = false;
        }
    }
    if($verified == false) {

        //Do something here in case the validation fails
        return false;
    } else {
        return true;
    }
}

function validate_mod10($cc_no){
    $NumberLength = strlen ($cc_no);
    $Checksum = 0;

    // 1. Double the value of alternating digits
    // 2. Add the separate digits of all the products
    // 3. Add the unaffected digits
    // 4. Add the results and divide by 10
    //  Add even digits in even length strings
    // test with 1234567812345670  or 5454379001303641
    for ($Location = ($NumberLength - 2); $Location >= 0; $Location -= 2) {
        $digit = substr($cc_no, $Location, 1);
        $sum = $digit *2;
        for ($i = 0; $i< strlen($sum); $i++) {
            $d = substr($sum, $i, 1);
            $Checksum += $d;
        }
    }

    //  Add odd digits in odd length strings.
    for ($Location = $NumberLength-1; $Location >= 0; $Location -= 2) {
        $digit = substr($cc_no, $Location, 1);
        $Checksum += $digit;
    }

    //  If the checksum is divisible by 10, then return TRUE.
    return ($Checksum % 10 == 0) ? TRUE : FALSE;
}

function checkCreditCard($cardnumber, $cardname) {
    // Define the cards we support. You may add additional card types.
    //  Name:      As in the selection box of the form - must be same as user's
    //  Length:    List of possible valid lengths of the card number for the card
    //  prefixes:  List of possible prefixes for the card
    //  checkdigit Boolean to say whether there is a check digit
    // Don't forget - all but the last array definition needs a comma separator!
    if($cardname == 1){
        $cardname = 'Visa';
    } elseif($cardname == 2){
        $cardname = 'MasterCard';
    } elseif ($cardname == 3){
        $cardname = 'American Express';
    } elseif ($cardname == 4){
        $cardname = 'Discover';
    }
    $cards = array (  array ('name' => 'American Express',
            'length' => '15',
            'prefixes' => '34,37',
            'checkdigit' => true
        ),
        array ('name' => 'Discover',
            'length' => '16',
            'prefixes' => '6011',
            'checkdigit' => true
        ),
        array ('name' => 'MasterCard',
            'length' => '16',
            'prefixes' => '51,52,53,54,55',
            'checkdigit' => true
        ),
        array ('name' => 'Visa',
            'length' => '13,16',
            'prefixes' => '4',
            'checkdigit' => true
        )
    );
    $ccErrorNo = 0;
    $ccErrors [0] = "Unknown card type";
    $ccErrors [1] = "No card number provided";
    $ccErrors [2] = "Credit card number has invalid format";
    $ccErrors [3] = "Credit card number is invalid";
    $ccErrors [4] = "Credit card number is wrong length";

    // Establish card type
    $cardType = -1;
    for ($i=0; $i<sizeof($cards); $i++) {

        // See if it is this card (ignoring the case of the string)
        if (strtolower($cardname) == strtolower($cards[$i]['name'])) {
            $cardType = $i;
            break;
        }
    }

    // If card type not found, report an error
    if ($cardType == -1) {
        $errornumber = 0;
        $errortext = $ccErrors [$errornumber];
        return false;
    }

    // Ensure that the user has provided a credit card number
    if (strlen($cardnumber) == 0)  {
        $errornumber = 1;
        $errortext = $ccErrors [$errornumber];
        return false;
    }

    // Remove any spaces from the credit card number
    $cardNo = str_replace (' ', '', $cardnumber);

    // Check that the number is numeric and of the right sort of length.
    if (!preg_match('/^[0-9]{13,19}$/',$cardNo))  {
        $errornumber = 2;
        $errortext = $ccErrors [$errornumber];
        return false;
    }

    // Now check the modulus 10 check digit - if required
    if ($cards[$cardType]['checkdigit']) {
        $checksum = 0;                                  // running checksum total
        $mychar = "";                                   // next char to process
        $j = 1;                                         // takes value of 1 or 2

        // Process each digit one by one starting at the right
        for ($i = strlen($cardNo) - 1; $i >= 0; $i--) {

            // Extract the next digit and multiply by 1 or 2 on alternative digits.
        $calc = $cardNo{$i} * $j;

            // If the result is in two digits add 1 to the checksum total
            if ($calc > 9) {
                $checksum = $checksum + 1;
                $calc = $calc - 10;
            }

            // Add the units element to the checksum total
            $checksum = $checksum + $calc;

            // Switch the value of j
    if ($j ==1) {$j = 2;} else {$j = 1;};
        }

        // All done - if checksum is divisible by 10, it is a valid modulus 10.
        // If not, report an error.
        if ($checksum % 10 != 0) {
            $errornumber = 3;
            $errortext = $ccErrors [$errornumber];
            return false;
        }
    }

    // The following are the card-specific checks we undertake.
    // Load an array with the valid prefixes for this card
    $prefix = explode(',',$cards[$cardType]['prefixes']);

    // Now see if any of them match what we have in the card number
    $PrefixValid = false;
    for ($i=0; $i<sizeof($prefix); $i++) {
        $exp = '/^' . $prefix[$i].'/';
        if (preg_match($exp,$cardNo)) {
            $PrefixValid = true;
            break;
        }
    }

    // If it isn't a valid prefix there's no point at looking at the length
    if (!$PrefixValid) {
        $errornumber = 3;
        $errortext = $ccErrors [$errornumber];
        return false;
    }

    // See if the length is valid for this card
    $LengthValid = false;
    $lengths = explode(',',$cards[$cardType]['length']);
    for ($j=0; $j<sizeof($lengths); $j++) {
        if (strlen($cardNo) == $lengths[$j]) {
            $LengthValid = true;
            break;
        }
    }

    // See if all is OK by seeing if the length was valid.
    if (!$LengthValid) {
        $errornumber = 4;
        $errortext = $ccErrors [$errornumber];
        return false;
    };

    // The credit card is in the required format.
    return true;
}

function us_bank_holiday($year){
    /* returns an array of all bank holidays for a given year
    [date] => holiday
    */
    unset($res);

    //new years
    $date = mktime(0,0,0,1,1,$year);
    $org_date = $date;
    if(date('w',$date) == 0){
        $date = mktime(0,0,0,1,2,$year);
    }
    if(date('w',$date) == 6){
        $date = mktime(0,0,0,12,31,$year - 1);
    }
    if($date <> $org_date){
        $res[$date] = "(observed)";
        $res[$org_date] = "New Year's Day";
    }else{
        $res[$date] = "New Year's Day";
    }

    //MLK
    $mon = 0;
    $day = 14;
    while ($mon == 0){
        $day ++;
        $date = mktime(0,0,0,1,$day,$year);
        if(date('w',$date) == 1){
            $mon = 1;
        }
    }
    $res[$date] = "mlk day";

    //President's Day
    $mon = 0;
    $day = 14;
    while ($mon == 0){
        $day ++;
        $date = mktime(0,0,0,2,$day,$year);
        if(date('w',$date) == 1){
            $mon = 1;
        }
    }
    $res[$date] = "President's day";

    //Memorial Day
    $mon = 0;
    $day = 32;
    while ($mon == 0){
        $day --;
        $date = mktime(0,0,0,5,$day,$year);
        if(date('w',$date) == 1){
            $mon = 1;
        }
    }
    $res[$date] = "Memorial day";

    //Independence Day
    $date = mktime(0,0,0,7,4,$year);
    $org_date = $date;
    if(date('w',$date) == 0){
        $date = mktime(0,0,0,7,5,$year);
    }
    if(date('w',$date) == 6){
        $date = mktime(0,0,0,7,3,$year);
    }
    if($date <> $org_date){
        $res[$date] = "(observed)";
        $res[$org_date] = "Independence Day";
    }else{
        $res[$date] = "Independence Day";
    }

    //Labor Day
    $mon = 0;
    $day = 0;
    while ($mon == 0){
        $day ++;
        $date = mktime(0,0,0,9,$day,$year);
        if(date('w',$date) == 1){
            $mon = 1;
        }
    }
    $res[$date] = "Labor day";

    //Columbus Day
    $mon = 0;
    $day = 7;
    while ($mon == 0){
        $day ++;
        $date = mktime(0,0,0,10,$day,$year);
        if(date('w',$date) == 1){
            $mon = 1;
        }
    }
    $res[$date] = "Columbus day";

    //Veteran's Day
    $date = mktime(0,0,0,11,11,$year);
    $org_date = $date;
    if(date('w',$date) == 0){
        $date = mktime(0,0,0,11,12,$year);
    }
    if(date('w',$date) == 6){
        $date = mktime(0,0,0,11,10,$year);
    }
    if($date <> $org_date){
        $res[$date] = "(observed)";
        $res[$org_date] = "Veteran's Day";
    }else{
        $res[$date] = "Veteran's Day";
    }

    //Thanksgiving Day
    $mon = 0;
    $day = 21;
    while ($mon == 0){
        $day ++;
        $date = mktime(0,0,0,11,$day,$year);
        if(date('w',$date) == 4){
            $mon = 1;
        }
    }
    $res[$date] = "Thanksgiving day";

    //Christmas Day
    $date = mktime(0,0,0,12,25,$year);
    $org_date = $date;
    if(date('w',$date) == 0){
        $date = mktime(0,0,0,12,26,$year);
    }
    if(date('w',$date) == 6){
        $date = mktime(0,0,0,12,24,$year);
    }
    $res[$date] = "Christmas";
    if($date <> $org_date){
        $res[$date] = "(observed)";
        $res[$org_date] = "Christmas Day";
    }else{
        $res[$date] = "Christmas Day";
    }
    return $res;
}

function lf_echo($txt,$return_res = 0){
    $lf=chr(13).chr(10);
    $result = str_replace($lf,"<br>",$txt)."<br>";
    if($return_res == 1){
        return $result;
    }else{
        echo $result;
    }
}

function guid(){
    if (function_exists('com_create_guid')){
        return com_create_guid();
    }else{
        $key_val = array(8,9,'A','B');
        $charid = strtoupper(bin2hex(gen_rand()));
        $hyphen = chr(45);// "-"
        $uuid = chr(123)// "{"
        .substr($charid, 0, 8).$hyphen
        .substr($charid, 8, 4).$hyphen
        .'4'
        .substr($charid,13, 3).$hyphen
        .$key_val[rand(0,3)]
        .substr($charid,17, 3).$hyphen
        .substr($charid,20,12)
        .chr(125);// "}"
        return $uuid;
    }
}

function gen_key(){
    global $db;
    $characters = '01234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ^-:!~$*()_';
    $len = strlen($characters);
    $rand_arr = array();
    while(count($rand_arr) < $len){
        $rand = bin2hex(gen_rand(128));
        $possible_arr = explode(',',chunk_split($rand,2,','));
        foreach($possible_arr as $val){
            $test = hexdec($val);
            if($test < $len){
                $rand_arr[] = $test;
            }
        }
    }
    $i = 0;
    $key = '';
    while(strlen($key) < 40){
        $test = $rand_arr[$i++];
        $ptr = $test % $len;
        $key .= $characters[$ptr];
    }
    $key = substr($key,-40);
    $sql = 'select * from tbl_auth
            where password = "' . $key .'"
            ;';
    list($s,$cnt) = $db->doQueryNumRows($sql);
    if($cnt > 0){
        $key = gen_key();
    }
    return $key;
}

function pgp_encrypt($gpg_key = false, $file = false, $gpg_path = "/usr/bin/gpg"){
    if($gpg_key != false && $file != false){
        $unix_command = "$gpg_path --yes --always-trust -e -r '$gpg_key' $file;";
        exec($unix_command);
        return true;
    } else {
        return false;
    }
}

function pgp_decrypt($path= false, $file = false, $gpg_path = "/usr/local/bin/gpg"){
    if($file != false){
        $file = "$path$file";
        $encrypted_file = $file;
        $unencrypted_file = substr($file,0,-3)."txt";
        $handle = fopen($file,'rb');
        $data =fread($handle, filesize($file));
        $size = strlen($data);
        if($size > 0){
            $res = gnupg_init();   // used with http://pecl.php.net/package/gnupg
            $passphrase = $_SESSION['parameters']['sys_key'];
            $fingerprint = $_SESSION['parameters']['fingerprint'];
            gnupg_adddecryptkey($res,$fingerprint,$passphrase);
            $unencrypted_data = gnupg_decrypt($res,$data);
            $size = strlen($unencrypted_data);
            if($size > 0){
                unset($handle);
                unset($data);
                $handle = fopen($unencrypted_file,'w');
                $success = fwrite($handle,$unencrypted_data);
                $result = true;
                if($success === false){
                    $result = false;
                }else{
                    unlink($file);
                }
            }else{
                $result = false;
            }
        }else{
            $result = false;
        }
    }else{
        $result = false;
    }
    return $result;
}

function oo_copy($obj,$base=1){
    $my_name = get_class($obj);
    $skip['cdbinterface']['_connection'] = 1;
    $skip['cdbinterface']['_result'] = 1;
    $skip['cdbinterface']['handle'] = 1;
    if (version_compare(phpversion(), '5.0') < 0) {
        eval('$result = $obj;');
    }else{
        eval('$result = clone $obj;');
    }
    foreach($obj as $key => $val){
        if(isset($_SESSION['debug_mem']) and $_SESSION['debug_mem'] == 1){
            $_SESSION['debug_mem'] = 0;
            $mem_debug = 1;
        }else{
            $mem_debug = 0;
        }
        if(is_object($obj->$key) and !isset($skip[$my_name][$key])){
            $result->$key = oo_copy($obj->$key,0);
        }
        if($mem_debug == 1){
            $_SESSION['debug_mem'] = 1;
        }
    }
    if(isset($_SESSION['debug_mem']) and $_SESSION['debug_mem'] == 1){
        $used = memory_get_usage();
        if($base == 1){
            gc_collect_cycles();
        }
        $left = memory_get_usage();
        $allowed = ini_get('memory_limit') * 1000000;
        if($used / $allowed > .9){
            $where = debug_backtrace();
            $called = array();
            for($i=0;$i<count($where);$i++){
                $called[] = $where[$i]['file'].': '.$where[$i]['line'];
            }

            prh($called);
            echo 'allocated: '. format_bytes($used) . ', ' . format_bytes($left) .'<br>';
        }
    }

    return $result;
}

function oo_ref($obj){
    //pass by reference
    if (version_compare(phpversion(), '5.0') < 0) {

        // haha, not likely go sit on a pole.
    }else{
        $result = $obj;
    }
    return $result;
}

function password_complex($pass){
    $complex = 0;
    for($i=97;$i<123;$i++){
        $lower[]=chr($i);
    }
    for($i=65;$i<91;$i++){
        $upper[]=chr($i);
    }
    for($i=48;$i<58;$i++){
        $num[]=chr($i);
    }
    for($i=33;$i<48;$i++){
        $othr[]=chr($i);
    }
    for($i=58;$i<65;$i++){
        $othr[]=chr($i);
    }
    for($i=91;$i<96;$i++){
        $othr[]=chr($i);
    }
    for($i=122;$i<127;$i++){
        $othr[]=chr($i);
    }
    if(strlen($pass)<9){
        $complex -= 9 - strlen($pass);
    }
    $found = 0;
    foreach($lower as $char){
        if(substr_count($pass,$char) and $found == 0){
            $complex++;
            $found = 1;
        }
    }
    $found = 0;
    foreach($upper as $char){
        if(substr_count($pass,$char) and $found == 0){
            $complex++;
            $found = 1;
        }
    }
    $found = 0;
    foreach($num as $char){
        if(substr_count($pass,$char) and $found == 0){
            $complex++;
            $found = 1;
        }
    }
    $found = 0;
    foreach($othr as $char){
        if(substr_count($pass,$char) and $found == 0){
            $complex++;
            $found = 1;
        }
    }
    if($complex < 0){
        $result = 0;
    }else{
        $result = 1;
    }
    return  $result;
}

function date_conv($date,$format=''){
    /*  attempts to determine the date from a human readable string
    *   Works with multiple delimters or none at all
    *   assumes either CCYYMMDD or MMDDCCYY as the over all sequence
    *   will not work with European dates
    */
    if($format){
        switch($format){
            case 1:
            //MMDDCCYY
            $n[0] = substr($date,0,2);
            $n[1] = substr($date,2,2);
            $n[2] = substr($date,-4);
            break;
            case 2:
            //CCYY-MM-DD
            $n[0] = substr($date,5,2);
            $n[1] = substr($date,-2);
            $n[2] = substr($date,0,4);
            break;
        }
    }else{

        // break apart based on possible delimiters
        $n = explode("-",$date);
        if(count($n)< 3){
            $n = explode('/',$date);
        }
        if(count($n)< 3){
            $n = explode('.',$date);
        }
        if(count($n)< 3){
            $n = explode(' ',$date);
        }
        if(count($n)<3){
            if(strlen($date) == 8){

                //check for CCYYMMDD
                $year = substr($date,0,4);
                if($year > 1899 and $year < 2200){
                    $n[0] = $year;
                    $n[1] = substr($date,4,2);
                    $n[2] = substr($date,6,2);
                }else{
                    $year = substr($date,4,4);
                    if($year > 1899 and $year < 2200){
                        $n[0] = $year;
                        $n[1] = substr($date,0,2);
                        $n[2] = substr($date,2,2);
                    }
                }
            }
        }
    }
    if(count($n) == 3){

        // determine the sequence
        //find the year
        $val = 1;
        if(strlen($n[0]) == 4 and $n[0] > 1899 and $n[0] < 2200){
            $y = $n[0] * 1;
            $m = $n[1] * 1;
            $d = $n[2] * 1;
        }elseif(strlen($n[2]) == 4 and $n[2] > 1899 and $n[2] < 2200){
            $y = $n[2] * 1;
            $m = $n[0] * 1;
            $d = $n[1] * 1;
        }else{
            $val = 0;
        }
        if($val == 1){

            //verify the month and date fields
            $dpm[1] = 31;
            $dpm[2] = 28 + date('L',mktime(2,0,0,1,1,$y));
            $dpm[3] = 31;
            $dpm[4] = 30;
            $dpm[5] = 31;
            $dpm[6] = 30;
            $dpm[7] = 31;
            $dpm[8] = 31;
            $dpm[9] = 30;
            $dpm[10] = 31;
            $dpm[11] = 30;
            $dpm[12] = 31;
            if($m < 1 or $m > 12){

                //month issue look for possible month day swap
                if($d > 0 and $d <  13 and $m > 0 and $m < ($dpm[$d] + 1)){
                    $day = $m;
                    $m = $d;
                    $d = $day;
                }else{
                    $val = 0;
                }
            }else{
                if($d < 1 or $d > $dpm[$m]){
                    $val = 0;
                }
            }
        }
    }else{
        $val = 0;
    }
    if($val == 1){
        if($y > 2035){
            $result = DEFAULT_TERM;
        }else{
            $result = mktime(2,0,0,$m,$d,$y);
        }
    }else{
        $result = "Unknown Date";
    }
    return array($val,$result);
}

function elapsed_time($x){
    // returns the elapsed time in the format hh:mm:ss
    $h = substr('00'.($x - $x % 3600) / 3600,-2);
    $t = ($x % 3600);
    $m = substr('00'.($t - $t % 60) / 60,-2);
    $s = substr('00'.$t % 60,-2);
    $te = $h .':'.$m.':'.$s;
    return $te;
}

function phone_num_format($phone,$num_only=0){
    $phone = preg_replace("/[^0-9]/", "", $phone);
    $phone = substr($phone,-10);
    if($num_only == 1){
        return $phone;
    }else{
        if(strlen($phone) == 7){
            return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $phone);
        } elseif(strlen($phone) == 10){
            return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $phone);
        } else {
            return $phone;
        }
    }
}

function format_bytes($size) {
    $units = array(' B', ' KB', ' MB', ' GB', ' TB');
    for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024;
    return round($size, 2).$units[$i];
}

function associate_values($data, $data_format){
    /******************
    * Takes $data in the form of a 2 degree array and $data_format
    * as an array of field names and returns a 2 degree array of
    * name value pairs.
    *
    *   $data[0][0] = data
    *   $data[0][1] = data
    *   $data[0][2] = data
    *   $data[0][3] = data
    *   $data[0][4] = data
    *   $data[1][0] = data
    *   $data[1][1] = data
    *   $data[1][2] = data
    *   $data[1][3] = data
    *   $data[1][4] = data
    *
    *   $data_format[1]['fn'] = name
    *   $data_format[1]['fl'] = max length
    *   $data_format[1]['ft'] = type
    *   $data_format[2]['fn'] = name
    *   $data_format[2]['fl'] = max length
    *   $data_format[2]['ft'] = type
    *   $data_format[3]['fn'] = name
    *   $data_format[3]['fl'] = max length
    *   $data_format[3]['ft'] = type
    *
    *
    */
    $result = array();
    if(is_array($data) and is_array($data_format)){
        foreach($data as $line){
            $x = 1;
            $row = array();
            foreach($line as $field){
                $row[$data_format[$x]['fn']] = trim(substr($field,0,$data_format[$x]['fl']));
                $x++;
            }
            $result[] = $row;
        }
    }else{
        $result = $data;
    }
    return $result;
}

function last_four($num){
    // returns XXXXXXXXXXX1234 format
    $len = strlen($num);
    $lst_four = substr($num,-4);
    return substr('XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX'.$lst_four,(0-$len));
}

function alpha_only($str){
    // removes all but leters and spaces
    $str = strtoupper($str);
    $str = preg_replace("/[^A-Z ]/", "", $str);
    return $str;
}

function num_only($str){
    // removes all but numbers
    $str = strtoupper($str);
    $str = preg_replace("/[^0-9.-]/", "", $str);
    return $str;
}

function alpha_num_only($str){
    // removes all but numbers, leters, and spaces 
    $str = strtoupper($str);
    $str = preg_replace("/[^A-Za-z0-9\/ .,-]/", "", $str);
    return $str;
}

function alpha_num_only_strict($str){
    // removes all but numbers, leters, and spaces 
    $str = strtoupper($str);
    $str = preg_replace("/[^A-Za-z0-9]/", "", $str);
    return $str;
}

function day_offset($reference,$days,$dir = 1){
    // calculates the number of seconds in a day based offset while accounting for Day Light Savings
    //$dir of -1 willresult in a negative offset (previous time)
    // ensure that the reference time is 5am of the reference day
    $reference = mktime(5,0,0,date('m',$reference),date('d',$reference),date('Y',$reference));
    $prev_dls = date('I',$reference);
    $target = $reference;
    for($i=0;$i<$days;$i++){
        $target += (86400 * $dir);
        $tar_dls = date('I',$target);
        if($dir > 0){
            if($prev_dls > $tar_dls){

                // spring to fall transition, add 1 hour
                $target += 3600;
            }elseif($prev_dls < $tar_dls){

                // fall to spring transition, subtract 1 hour
                $target -= 3600;
            }
        }else{
            if($prev_dls > $tar_dls){

                // fall to spring transition, add 1 hour
                $target += 3600;
            }elseif($prev_dls < $tar_dls){

                // spring to fall transition, subtract 1 hour
                $target -= 3600;
            }
        }
        $prev_dls = $tar_dls;
    }
    $offset = $target - $reference;
    return $offset;
}

function RGBtoHSL($red, $green, $blue){
    $r = $red / 255.0;
    $g = $green / 255.0;
    $b = $blue / 255.0;
    $H = 0;
    $S = 0;
    $V = 0;
    $min = min($r,$g,$b);
    $max = max($r,$g,$b);
    $delta = ($max - $min);
    $L = ($max + $min) / 2.0;
    if($delta == 0) {
        $H = 0;
        $S = 0;
    } else {
        $S = $L > 0.5 ? $delta / (2 - $max - $min) : $delta / ($max + $min);
        $dR = ((($max - $r) / 6) + ($delta / 2)) / $delta;
        $dG = ((($max - $g) / 6) + ($delta / 2)) / $delta;
        $dB = ((($max - $b) / 6) + ($delta / 2)) / $delta;
        if ($r == $max)
        $H = $dB - $dG;
        else if($g == $max)
        $H = (1/3) + $dR - $dB;
        else
        $H = (2/3) + $dG - $dR;
        if ($H < 0)
        $H += 1;
        if ($H > 1)
        $H -= 1;
    }
    return array(($H*360),
        ($S*100),
        round(($L*100),0),
    );
}

function HEXtoRGB($hex){
    $r = (16 * hexdec(substr($hex,0,1))) + hexdec(substr($hex,1,1)) * 1;
    $g = (16 * hexdec(substr($hex,2,1))) + hexdec(substr($hex,3,1)) * 1;
    $b = (16 * hexdec(substr($hex,4,1))) + hexdec(substr($hex,5,1)) * 1;
    return array($r,$g,$b);
}

function hue2rgb($v1, $v2, $vH){
    $sH = $vH;
    if($vH<0) $sH += 1;
    if($vH>1) $sH -= 1;
    if((6*$sH)<1) return $v1+($v2-$v1)*6*$sH;
    if((2*$sH)<1) return $v2;
    if((3*$sH)<2) return $v1+($v2-$v1)*((2/3)-$sH)*6;
    return $v1;
}

function HSLtoRGB ($h, $s, $l){
    $h /= 360;
    $s /= 100;
    $l /= 100;
    $r=$g=$b=NULL;
    if($s==0){
        $r=$l*255;
        $g=$l*255;
        $b=$l*255;
    }else{
        if($l<0.5)
        $var_2 = $l*(1+$s);
        else
        $var_2 = ($l+$s)-($s*$l);
        $var_1 = 2*$l-$var_2;
        $r = 255*hue2rgb($var_1, $var_2, $h+(1/3));
        $g = 255*hue2rgb($var_1, $var_2, $h);
        $b = 255*hue2rgb($var_1, $var_2, $h-(1/3));
    }
    return array($r,$g,$b);
}

function RGBtoHex($r,$g,$b){
    $hex = strtoupper(substr('00'.dechex($r),-2));
    $hex .= strtoupper(substr('00'.dechex($g),-2));
    $hex .= strtoupper(substr('00'.dechex($b),-2));
    return $hex;
}

function color_theme($theme_code){
    // returns a color family from the given code.
    $result = array();
    $control_arr = array();
    $cntrl = array('comp',
        'angle',
        'offset_1',
        'offset_2',
        'hex',
        'sec_hex',
        'third_hex',
        'use_comp'
    );
    $code = base64_decode($theme_code);
    $code_arr = explode('|',$code);
    foreach($code_arr as $k => $v){
        $control_arr[$cntrl[$k]] = $v;
    }
    $hex = substr('000000'.$control_arr['hex'],-6);
    $sec_hex = '';
    $third_hex = '';
    if(!$control_arr['use_comp']){
        if($control_arr['sec_hex'] <> ''){
            $sec_hex = strtoupper(substr('000000'.$control_arr['sec_hex'],-6));
        }
        if($control_arr['third_hex'] <> ''){
            $third_hex = strtoupper(substr('000000'.$control_arr['third_hex'],-6));
        }
    }
    $hex = strtoupper($hex);
    if(isset($control_arr['comp'])){
        $comp = ($control_arr['comp'] * 1) % 361;
    }else{
        $comp = 180;
    }
    if(isset($control_arr['angle'])){
        $angle = ($control_arr['angle'] * 1) % 91;
    }else{
        $angle = 36;
    }
    if(isset($control_arr['offset_1'])){
        $offset_1 = ($control_arr['offset_1'] * 1) % 100;
    }else{
        $offset_1 = 30;
    }
    if(isset($control_arr['offset_2'])){
        $offset_2 = ($control_arr['offset_2'] * 1) % 100;
    }else{
        $offset_2 = 10;
    }
    $text = array();
    $text['dark'] = array('font' => '#1A1A1A;  /* 10% */',
        'a:link' => '#333333  /* 20% */',
        'a:visited' => '#404040  /* 25% */',
        'a:hover' => '#4D4D4D  /* 40% */',
    'a:active' => '#262626  /* 15% */');
    $text['light'] = array('font' => '#E6E6E6; /* 90% */',
        'a:link' => '#CCCCCC  /* 80% */',
        'a:visited' => '#BFBFBF  /* 75% */',
        'a:hover' => '#999999  /* 60% */',
    'a:active' => '#D9D9D9  /* 85% */');
    $color_fam['first'] = 0;
    $color_fam['second'] = ($comp - ($angle / 2)) % 360;
    $color_fam['third'] = ($comp + ($angle / 2)) % 360;
    $fam_orders = array(array(0,0),
        array(-$offset_1,-$offset_2),
        array(-$offset_2,-$offset_1),
        array($offset_1,$offset_2),
        array($offset_2,$offset_1),
    );
    if($hex == '000000' or $hex == 'FFFFFF'){
        $fam_orders[0] = array(0,50);
        $color_scheme = array('first' => array('454545', //33%
                '333333', //27%
                '000000', //0%
                '0F0F0F', //6%
                '242424', //14%
            ),
            'second' => array('A8A8A8', //66%
                '969696', //59%
                '666666', //40%
                '757575', //46%
                '878787', //53%
            ),
            'third' => array('FFFFFF', //100%
                'EDEDED', //93%
                'B8B8B8', //72%
                'C9C9C9', //79%
                'D9D9D9', //85%
            ),
        );
        if($hex == 'FFFFFF'){
            $third = $color_scheme['first'];
            $color_scheme['first'] = $color_scheme['third'];
            $color_scheme['third'] = $third;
        }
    }else{
        foreach($color_fam as $name => $hue_adj){
            $defined_hex = '';
            switch($name){
                case'first':
                $defined_hex = $hex;
                break;
                case'second':
                $defined_hex = $sec_hex;
                break;
                case'third':
                $defined_hex = $third_hex;
                break;
            }
            if($defined_hex == ''){
                list($r,$g,$b) = HEXtoRGB($hex);
                list($h,$s,$l) = RGBtoHSL($r,$g,$b);
                if($h + $hue_adj > 360){
                    $nh = $h + $hue_adj - 360;
                }elseif($h + $hue_adj < 0){
                    $nh = $h + $hue_adj + 360;
                }else{
                    $nh = $h + $hue_adj;
                }
                $fam_base = $hex;
            }else{
                $hue_adj = 0;
                list($r,$g,$b) = HEXtoRGB($defined_hex);
                list($nh,$s,$l) = RGBtoHSL($r,$g,$b);
                $fam_base = $defined_hex;
            }
            foreach($fam_orders as $order => $adj){
                if($hue_adj == 0 and $adj[0] == 0 and $adj[1] == 0){
                    $new_hex = $fam_base;
                }else{
                    if($s == 100 or $s == 0){
                        $offset = abs($adj[0]);
                    }elseif($s > 50){
                        $offset = (100 - $s) * (abs($adj[0])/100);
                    }else{
                        $offset = $s * (abs($adj[0]/100));
                    }
                    if($adj[0] < 0){
                        $offset *= -1;
                    }
                    $ns = $s + $offset;
                    if($ns > 100){
                        $ns -= 100;
                    }
                    if($ns < 0){
                        $ns += 100;
                    }
                    if($l == 100 or $l == 0){
                        $offset = abs($adj[1]);
                    }elseif($l > 50){
                        $offset = (100 - $l) * (abs($adj[1])/100);
                    }else{
                        $offset = $l * (abs($adj[1])/100);
                    }
                    if($adj[1] < 0){
                        $offset *= -1;
                    }
                    $nl = $l + $offset;
                    if($nl > 100){
                        $nl -= 100;
                    }
                    if($nl < 0){
                        $nl += 100;
                    }
                    list($r,$g,$b) = HSLtoRGB($nh,$ns,$nl);
                    $new_hex = RGBtoHex($r,$g,$b);
                }
                $color_scheme[$name][$order] = $new_hex;
            }
            switch($name){
                case'second':
                $sec_hex = $color_scheme[$name][0];
                break;
                case'third':
                $third_hex = $color_scheme[$name][0];
                break;
            }
        }
    }
    $color_style = '';
    foreach($color_scheme as $name => $family){
        foreach($family as $k => $h){
            $rgb = HEXtoRGB($h);
            $hue = RGBtoHSL($rgb[0],$rgb[1],$rgb[2]);
            $fam_hue[$k] = $hue[0].', '.$hue[1].', '.$hue[2];
            $fam_rgb[$k] = $rgb[0].', '.$rgb[1].', '.$rgb[2];
            if($k > 0){
                $fname = $name.'_'.$k;
            }else{
                $fname = $name;
            }
            $names[$k] = $fname;
            $lum = ((.2126 * $rgb[0]) + (.7152  * $rgb[1]) +(.0722 * $rgb[2]))/255;
            if($lum < .50){
                $class[$k] = 'light';
            }else{
                $class[$k] = 'dark';
            }
            $result[$fname] = array('text' => $text[$class[$k]],
                'hex' => '#'.$family[$k],
            );
        }
    }
    $result['parameters'] = array('hex' => $hex,
        'sec_hex' => $sec_hex,
        'third_hex' => $third_hex,
        'comp' => $comp,
        'angle' => $angle,
        'offset_1' => $offset_1,
        'offset_2' => $offset_2,
    );
    return $result;
}

function parse_css($css){
    preg_match_all( '/(?ims)([a-z0-9\s\.\:#_\-@,]+)\{([^\}]*)\}/', $css, $arr);
    $result = array();
    foreach ($arr[0] as $i => $x){
        $selector = trim($arr[1][$i]);
        $rules = explode(';', trim($arr[2][$i]));
        $rules_arr = array();
        foreach ($rules as $strRule){
            if (!empty($strRule)){
                $rule = explode(":", $strRule);
                $rules_arr[trim($rule[0])] = trim($rule[1]);
            }
        }
        $selectors = explode(',', trim($selector));
        foreach ($selectors as $strSel){
            $result[$strSel] = $rules_arr;
        }
    }
    return $result;
}

function gen_rand($len=256){
    $h = fopen('/dev/urandom','r');
    $rand = fread($h,$len);
    fclose($h);
    return $rand;
}

function kr_sort($arr){
    // recursive key sort
    if(is_array($arr)){
        $result = array();
        ksort($arr);
        foreach($arr as $key => $value){
            $result[$key] = kr_sort($value);
        }
        $arr = $result;
    }
    return $arr;
}

/*****************
* converts the numeric values of $val to int or float
*
* @param mixed $val data to be converted can be an array or single value
*/

function num_to_int($val){
    if(is_array($val)){
        $result = array();
        foreach($val as $key => $value){
            $result[$key] = num_to_int($value);
        }
    }else{
        $result = '';
        if(is_numeric($val)){

            // convert the numeric string to float or int
            $result = $val + 0;
        }else{
            $result = $val;
        }
    }
    return $result;
}

function process_time(){
    list($usec, $sec) = explode(" ", microtime());
    $cur_time = ((float)$usec + (float)$sec);
    $proc_time = $cur_time - $_SESSION['proc_time'];
    $_SESSION['proc_time'] = $cur_time;
    return $proc_time;
}

/***********
* Similar to date(), except returns blank on a 0 timestamp
*
* @param mixed $format use date() format rules
* @param mixed $ts unix time stamp
* @return string
*/
function gdate($format,$ts = ''){
    if($ts === 0){
        $result = '';
    }elseif($ts == ''){
        $result = date($format);
    }else{
        $result = date($format,$ts);
    }
    return $result;
}

function timing($echo = 1){
    if(!isset($_SESSION['time_hack'])){
        $_SESSION['time_hack'] = time();
    }
    $now = time();
    $elapsed = $now - $_SESSION['time_hack'];
    $_SESSION['time_hack'] = time();
    if($echo == 1){
        $where = debug_backtrace();
        $called = $where[0]['file'].': '.$where[0]['line'];
        echo $called . ' elapsed: '.$elapsed.'<br>';
    }else{
        return $elapsed;
    }
}

function debug_disp(){
    $debug = debug_backtrace();
    foreach($debug as $k => $v){
        unset($debug[$k]['object']);
    }
    var_dump($debug);
    exit;


}
function get_timezone_offset($remote_tz, $origin_tz = null) {
    if($origin_tz === null) {
        if(!is_string($origin_tz = date_default_timezone_get())) {
            return false; // A UTC timestamp was returned -- bail out!
        }
    }
    $origin_dtz = new DateTimeZone($origin_tz);
    $remote_dtz = new DateTimeZone($remote_tz);
    $origin_dt = new DateTime("now", $origin_dtz);
    $remote_dt = new DateTime("now", $remote_dtz);
    $offset = $origin_dtz->getOffset($origin_dt) - $remote_dtz->getOffset($remote_dt);
    return $offset;
}

function plan_list($plan_arr, $per_code, $escape = 0, $onchange='',$return_plan_var = 0){
    global $sys_plans;

    if($escape == 1){
        $quot = '\"';
    }else{
        $quot = '"';
    }

    if($per_code == 1){
        $onchange .= ' availablePlans(this);';
        $check_class = '';
    }

    if($onchange <> ''){
        $onchange = 'onchange='.$quot.$onchange.$quot;
    }

    $result = '<div class='.$quot.'plans_list row'.$quot.' id='.$quot.'plan_list_medical'.$quot.'>';
//    $result = '';
    $type_array = array();$i=0;

    $length = count($plan_arr);
    if ($length > 3) $length = 3;
    $col_length = 12 / $length;
    $level = '';

    foreach($plan_arr as $name => $plan_id){$i++;
    	/*echo '<pre>';
        print_r(array_values($plan_arr));
        echo '</pre>';*/

    	if ($i == 1) $level = 'Primary';
    	if ($i == 2) $level = 'Professional';
    	if ($i == 3) $level = 'Premier';

        $rate_list = '<ul class='.$quot.'tierRates'.$quot.'>';
        foreach($sys_plans->plan as $pln_obj){
            if($pln_obj->plan_name == $name){
                $pln_desc = preg_replace( "/\r|\n/", "", $pln_obj->plan_desc);
                foreach($pln_obj->rates->rate as $pntr => $rate){
                    $rate_list .= '<li><span class='.$quot.'tierName'.$quot.'>'.$sys_plans->group->tiers->tier[$pntr]->tier_name.'</span><span class='.$quot.'tierRate'.$quot.'>$'.$rate->tier_rate.'</span></li>';

                }
                $pln_class = 'planType_' . $pln_obj->plan_type;
                $pln_type = $pln_obj->plan_type;
                $type_array[$pln_class] = 1;
            }

        }
        $rate_list .= '</ul></div></div>';
        if($per_code <> 1){
            $check_class = ' disabled class='.$quot.'gp_'.$plan_id.$quot;
        }
        $result .= '<div class="col col-md-'.$col_length.'"><div class="membership_card"><div class='.$quot.$pln_class.$quot.'><div class="membership_header"><h3>'.$level.'</h3>
        <div class="round_cost"><h2>$xx</h2>per year</div><p>'.ucwords($name).'</p><button type="button" class="btn_select_plan" plan-type="'.$pln_type.'">Select Plan</button></div> 
        <span class='.$quot.'enrlError'.$quot.' id='.$quot.'gp_'.$plan_id.'_'.$per_code.'_err'.$quot.'></span></div>';
        //$result .= '<ul class='.$quot.'planDesc'.$quot.'><li>'.$pln_desc.'</li></ul>';
        $result .= $rate_list;
        if ($i==3)
            {
            	break;
            }
    }
    $result .= '</ul>';

    if($return_plan_var == 1){
        $result = 'var planTypeArr = [';
        $comma = '';
        foreach($type_array as $type => $x){
            $result .= $comma . '"'.$type. '"';
            $comma = ',';
        }
        $result .= '];';
    }

    return $result;
}

function plan_listd($plan_arr, $per_code, $escape = 0, $onchange='',$return_plan_var = 0){
    global $sys_plans;
    if($escape == 1){
        $quot = '\"';
    }else{
        $quot = '"';
    }

    if($per_code == 1){
        $onchange .= ' availablePlans(this);';
        $check_class = '';
    }

    if($onchange <> ''){
        $onchange = 'onchange='.$quot.$onchange.$quot;
    }

    $result = '<div class='.$quot.'plans_list row'.$quot.' id='.$quot.'plan_list_dental'.$quot.'>';
    $type_array = array();$i=0;

    foreach($plan_arr as $name => $plan_id){$i++;
    	/*echo '<pre>';
        print_r(($plan_arr));
        echo '</pre>';*/
        if($name == "DentalGuard PPO"){
        $rate_list = '<ul class='.$quot.'tierRates'.$quot.'>';

        foreach($sys_plans->plan as $pln_obj){
            if($pln_obj->plan_name == $name){
                $pln_desc = preg_replace( "/\r|\n/", "", $pln_obj->plan_desc);
                foreach($pln_obj->rates->rate as $pntr => $rate){
                    $rate_list .= '<li><span class='.$quot.'tierName'.$quot.'>'.$sys_plans->group->tiers->tier[$pntr]->tier_name.'</span><span class='.$quot.'tierRate'.$quot.'>$'.$rate->tier_rate.'</span></li>';

                }
                $pln_class = 'planType_' . $pln_obj->plan_type;
                $pln_type = $pln_obj->plan_type;
                $type_array[$pln_class] = 1;
            }

        }
        $rate_list .= '</ul></div></div>';
        if($per_code <> 1){
            $check_class = ' disabled class='.$quot.'gp_'.$plan_id.$quot;
        }
        $result .= '<div class="col col-md-12"><div class="membership_card"><div class='.$quot.$pln_class.$quot.'><div class="membership_header"><h3>Primary</h3>
        <div class="round_cost"><h2>$xx</h2>per year</div><p>'.ucwords($name).'</p><button type="button" class="btn_select_plan" plan-type="'.$pln_type.'">Select Plan</button></div> 
        <span class='.$quot.'enrlError'.$quot.' id='.$quot.'gp_'.$plan_id.'_'.$per_code.'_err'.$quot.'></span></div>';
        //$result .= '<ul class='.$quot.'planDesc'.$quot.'><li>'.$pln_desc.'</li></ul>';
        $result .= $rate_list;
        }

    }
    $result .= '</ul>';

    if($return_plan_var == 1){
        $result = 'var planTypeArr = [';
        $comma = '';
        foreach($type_array as $type => $x){
            $result .= $comma . '"'.$type. '"';
            $comma = ',';
        }
        $result .= '];';
    }

    return $result;
}

function plan_listv($plan_arr, $per_code, $escape = 0, $onchange='',$return_plan_var = 0){
    global $sys_plans;
    if($escape == 1){
        $quot = '\"';
    }else{
        $quot = '"';
    }

    if($per_code == 1){
        $onchange .= ' availablePlans(this);';
        $check_class = '';
    }

    if($onchange <> ''){
        $onchange = 'onchange='.$quot.$onchange.$quot;
    }

    $result = '<div class='.$quot.'plans_list row'.$quot.' id='.$quot.'plan_list_vision'.$quot.'>';
    $type_array = array();$i=0;
    foreach($plan_arr as $name => $plan_id){$i++;
    	/*echo '<pre>';
        print_r(($plan_arr));
        echo '</pre>';*/
        if($name == "Vision"){
        $rate_list = '<ul class='.$quot.'tierRates'.$quot.'>';

        foreach($sys_plans->plan as $pln_obj){
            if($pln_obj->plan_name == $name){
                $pln_desc = preg_replace( "/\r|\n/", "", $pln_obj->plan_desc);
                foreach($pln_obj->rates->rate as $pntr => $rate){
                    $rate_list .= '<li><span class='.$quot.'tierName'.$quot.'>'.$sys_plans->group->tiers->tier[$pntr]->tier_name.'</span><span class='.$quot.'tierRate'.$quot.'>$'.$rate->tier_rate.'</span></li>';

                }
                $pln_class = 'planType_' . $pln_obj->plan_type;
                $pln_type = $pln_obj->plan_type;
                $type_array[$pln_class] = 1;
            }

        }
        $rate_list .= '</ul></div></div>';
        if($per_code <> 1){
            $check_class = ' disabled class='.$quot.'gp_'.$plan_id.$quot;
        }
        $result .= '<div class="col col-md-12"><div class="membership_card"><div class='.$quot.$pln_class.$quot.'><div class="membership_header"><h3>Primary</h3>
        <div class="round_cost"><h2>$xx</h2>per year</div><p>'.ucwords($name).'</p><button type="button" class="btn_select_plan" plan-type="'.$pln_type.'">Select Plan</button></div> 
        <span class='.$quot.'enrlError'.$quot.' id='.$quot.'gp_'.$plan_id.'_'.$per_code.'_err'.$quot.'></span></div>';
        //$result .= '<ul class='.$quot.'planDesc'.$quot.'><li>'.$pln_desc.'</li></ul>';
        $result .= $rate_list;
        }

    }
    $result .= '</ul>';

    if($return_plan_var == 1){
        $result = 'var planTypeArr = [';
        $comma = '';
        foreach($type_array as $type => $x){
            $result .= $comma . '"'.$type. '"';
            $comma = ',';
        }
        $result .= '];';
    }

    return $result;
}

function plan_info($plan_arr, $escape = 0){
    global $sys_plans;
    if($escape == 1){
        $quot = '\"';
    }else{
        $quot = '"';
    }
    $result ='<ul class="infoPlanList">';
    foreach($plan_arr as $name => $plan_id){
        $rate_list = '<ul class='.$quot.'infoTierRates'.$quot.'>';
        foreach($sys_plans->plan as $pln_obj){
            if($pln_obj->plan_name == $name){
                $pln_desc = $pln_obj->plan_desc;
                foreach($pln_obj->rates->rate as $pntr => $rate){
                    $rate_list .= '<li><span class='.$quot.'infoTierName'.$quot.'>'.$sys_plans->group->tiers->tier[$pntr]->tier_name.'</span><span class='.$quot.'infoTierRate'.$quot.'>'.$rate->tier_rate.'</span></li>';

                }
            }
        }
        $rate_list .= '</ul>';
        $result .= '<li>'.ucwords($name).'</li>';
        $result .= '<ul class='.$quot.'planDesc'.$quot.'><li>'.$pln_desc.'</li></ul>';
        $result .= $rate_list;
    }
    $result .= '</ul>';
    return $result;
}

function plan_to_var($prefix,$name){
    $result = $prefix . ucwords($name);
    $result = alpha_num_only_strict($result);
    $result = str_replace(' ','',$result);
    return $result;
}
?>