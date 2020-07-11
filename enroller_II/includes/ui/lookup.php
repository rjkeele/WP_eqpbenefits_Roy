<?php      
    
    /* debug */
    /*
    echo '$reg_key: ' . $reg_key . '<br>';
    echo '$cur_time: ' . $cur_time . '<br>';
    echo '$exp_time: ' . $exp_time . '<br>';
    echo '$ttl: ' . $ttl . '<br>';
    */
?>

<fieldset>
<legend>Resume Enrollment Lookup:</legend>
Member ID:<input type="text"  id="em_memberid" autofocus> </span>  <span class="enrlError" id="em_memberid_err"></span> <br>
Employee Number: <input type="text"  id="enrollees_1_employeeNumber"> <span class="enrlError" id="enrollees_1_employeeNumber_err"></span><br>
Birth Date: <input type="text"  id="enrollees_1_birthDate"> <span class="enrlError" id="enrollees_1_birthDate_err"></span><br>
Last four of SSN:<input type="text"  id="enrollees_1_lastFourSSN"> <span class="enrlError" id="enrollees_1_lastFourSSN_err"></span><br>
</fieldset>
          

<input type="button" value="Submit" id="finalSubmit" onClick="lookupEnrollee();">

<form id="lookUpForm">
</form>