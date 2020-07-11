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
<legend>Primary information:</legend>
First Name: <input type="text"  id="enrollees_1_firstName" autofocus> </span>  <span class="enrlError" id="enrollees_1_firstName_err"></span> <br>
Last Name:  <input type="text"  id="enrollees_1_lastName"> <span class="enrlError" id="enrollees_1_lastName_err"></span> <br>
Birth Date: <input type="text"  id="enrollees_1_birthDate"> <span class="enrlError" id="enrollees_1_birthDate_err"></span><br>
Gender:     <input type="radio" id="enrollees_1_sex" name="gender0" value="M"> Male
            <input type="radio" id="enrollees_1_sex" name="gender0" value="F"> Female <span class="enrlError" id="enrollees_1_sex_err"></span><br>
SSN:        <input type="text"  id="enrollees_1_SSN"> <span class="enrlError" id="enrollees_1_SSN_err"></span><br>
Employee Number: <input type="text"  id="enrollees_1_employeeNumber"> <span class="enrlError" id="enrollees_1_employeeNumber_err"></span><br>

</fieldset>        

<br>

<fieldset>
<legend>Address information:</legend>
Address 1: <input type="text" id="address_address1"> <span class="enrlError" id="address_address1_err"></span><br>
Address 2: <input type="text" id="address_address2"> <span class="enrlError" id="address_address2_err"></span><br>
City: <input type="text" id="address_city"> <span class="enrlError" id="address_city_err"></span><br>
State: <input type="text" id="address_state"> <span class="enrlError" id="address_state_err"></span><br>
Zip: <input type="text" id="address_zip"> <span class="enrlError" id="address_zip"></span><br>
Phone: <input type="text" id="phone"> <span class="enrlError" id="phone_err"></span><br>
Email: <input type="text" id="email"> <span class="enrlError" id="email_err"></span><br>
</fieldset>      

<br>

<fieldset>
<legend>Spouse information:</legend>
First Name: <input type="text" id="enrollees_2_firstName"> <span class="enrlError" id="enrollees_2_firstName_err"></span><br>
Last Name:  <input type="text" id="enrollees_2_lastName"> <span class="enrlError" id="enrollees_2_lastName_err"></span><br>
Birth Date: <input type="text" id="enrollees_2_birthDate"> <span class="enrlError" id="enrollees_2_birthDate_err"></span><br>
Gender:     <input type="radio" id="enrollees_2_sex" name="gender1" value="M" checked> Male
            <input type="radio" id="enrollees_2_sex" name="gender1" value="F"> Female  <span class="enrlError" id="enrollees_2_sex_err"></span><br>
SSN:        <input type="text"  id="enrollees_2_SSN"> <span class="enrlError" id="enrollees_2_SSN_err"></span><br>
</fieldset>

<br>

<div id="dynamicInput">
</div>    

<input type="button" id="addDepBtn" value="Add Dependant" onClick="addInput();">
<br>

<fieldset>
<legend>Select Coverage:</legend>
Primary: <span style="margin-left:70px;"></span><?php echo plan_list($plans,1); ?><br>
Spouse: <span style="margin-left:70px;"></span><?php echo plan_list($plans,2); ?><br>
<div id="dynamicInput2">
</div>
</fieldset>

<br>

<fieldset>
<legend>Summary:</legend>
<p id="summary"></p>
</fieldset> 


<br>
          

<!--<input type="button" value="Summary" onClick="summary();">-->
<input type="button" value="Submit" id="finalSubmit" onClick="finalEnrollment();">

<form id="finalform">
</form>