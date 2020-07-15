<?php

/* debug */
/*
echo '$reg_key: ' . $reg_key . '<br>';
echo '$cur_time: ' . $cur_time . '<br>';
echo '$exp_time: ' . $exp_time . '<br>';
echo '$ttl: ' . $ttl . '<br>';
*/
//prh($sys_plans->plan);
session_start();

$memberId = (isset($_SESSION['memberId'])) ? $_SESSION['memberId'] : '';
$dob = (isset($_SESSION['dob'])) ? $_SESSION['dob'] : '';
$lfourssn = (isset($_SESSION['lfourssn'])) ? $_SESSION['lfourssn'] : '';
$emplyeeNum = (isset($_SESSION['emplyeeNum'])) ? $_SESSION['emplyeeNum'] : '';
$xml_valid = (isset($_SESSION['xml_valid'])) ? $_SESSION['xml_valid'] : '';
$xml = ($xml_valid == 'true') ? simplexml_load_string(file_get_contents('https://www.equipointsystems.com/gooseias/gooseias_api.php?api_key=lXzu8*lPteocEnE8C^63BV8^6qX~)K$7f0I^$gDN&action=eeid&renew_code=' . $emplyeeNum . '&ssn_last_4=' . $lfourssn . '&birth_date=' . $dob . '&em_memberid=' . $memberId)) : '';
?>

<fieldset class="fieldset_member">
    <legend>Primary information</legend>
    <div class="form-field">
        <label>First Name: </label>
        <input type="text" id="enrollees_1_firstName" value="<?= $xml->members->enrollee->first_name ?>"
               name="first_name_1">
        <span
                class="enrlError" id="enrollees_1_firstName_err"></span> <br>
    </div>
    <div class="form-field"><label>Last Name: </label><input type="text" id="enrollees_1_lastName" name="last_name_1"
                                                             value="<?= $xml->members->enrollee->last_name ?>"> <span
                class="enrlError" id="enrollees_1_lastName_err"></span> <br>
    </div>
    <div class="form-field"><label>Birth Date: </label><input type="text" id="enrollees_1_birthDate" name="dob_1"
                                                              value="<?= $dob ?>"> <span
                class="enrlError" id="enrollees_1_birthDate_err"></span><br>
    </div>
    <div class="form-field"><label>Gender: </label><input type="radio" id="enrollees_1_sex" name="gender0" value="M"
            <?php if ($xml->members->enrollee->gender == 'M') { ?> checked <?php } ?> disabled>
        Male
        <input type="radio" id="enrollees_1_sex" name="gender0" value="F"
            <?php if ($xml->members->enrollee->gender == 'F') { ?> checked <?php } ?> disabled>
        Female
        <span class="enrlError" id="enrollees_1_sex_err"></span><br>

        <?php if ($xml->members->enrollee->gender == 'M') { ?>
        <input type="hidden" name="gender0" value="M">
        <?php } ?>

        <?php if ($xml->members->enrollee->gender == 'F') { ?>
            <input type="hidden" name="gender0" value="F">
        <?php } ?>

    </div>
    <div class="form-field"><label>Last four of SSN: </label><input type="text" id="enrollees_1_SSN" name="lfourssn_1"
                                                                    value="<?= $lfourssn ?>"> <span class="enrlError"
                                                                                                    id="enrollees_1_SSN_err"></span><br>
    </div>
    <div class="form-field"><label>Employee Number: </label><input type="text" id="enrollees_1_employeeNumber"
                                                                   name="eeNum_1"
                                                                   value="<?= $emplyeeNum ?>"> <span
                class="enrlError" id="enrollees_1_employeeNumber_err"></span><br>
    </div>
</fieldset>

<br>

<fieldset class="fieldset_member">
    <legend>Address information</legend>
    <div class="form-field">
        <label>
            Address 1: </label><input type="text" id="address_address1" name="address1_1"
                                      value="<?= $xml->members->enrollee->address_1 ?>"> <span class="enrlError"
                                                                                               id="address_address1_err"></span><br>
    </div>
    <div class="form-field"><label>Address 2: </label><input type="text" id="address_address2" name="address_2_1"
                                                             value="<?= $xml->members->enrollee->address_2 ?>"> <span
                class="enrlError"
                id="address_address2_err"></span><br>
    </div>
    <div class="form-field"><label>City: </label><input type="text" id="address_city" name="city_1"
                                                        value="<?= $xml->members->enrollee->city ?>"> <span
                class="enrlError"
                id="address_city_err"></span><br>
    </div>
    <div class="form-field"><label>State: </label><input type="text" id="address_state" name="state_1"
                                                         value="<?= $xml->members->enrollee->state ?>"> <span
                class="enrlError"
                id="address_state_err"></span><br>
    </div>
    <div class="form-field"><label>Postal Code: </label><input type="text" id="address_zip" name="postal_1"
                                                               value="<?= $xml->members->enrollee->postal_code ?>">
        <span class="enrlError"
              id="address_zip"></span><br>
    </div>
    <div class="form-field"><label>Phone: </label><input type="text" id="phone" name="phone_1"
                                                         value="<?= $xml->members->enrollee->phone ?>"> <span
                class="enrlError"
                id="phone_err"></span><br>
    </div>
    <div class="form-field"><label>Email: </label><input type="text" id="email" name="email_1"
                                                         value="<?= $xml->members->enrollee->email ?>"> <span
                class="enrlError"
                id="email_err"></span><br>
</fieldset>

<br>

<?php if ($xml->members->dependent[0]->type == 'SPOUSE' || $xml == '') { ?>
    <fieldset class="fieldset_member">
        <legend>Spouse information</legend>
        <div class="form-field"><label>
                First Name: </label><input type="text" name="first_name_2" id="enrollees_2_firstName"> <span
                    class="enrlError"
                    id="enrollees_2_firstName_err"></span><br>
        </div>
        <div class="form-field"><label>Last Name: </label><input type="text" id="enrollees_2_lastName"
                                                                 name="last_name_2"> <span
                    class="enrlError" id="enrollees_2_lastName_err"></span><br>
        </div>
        <div class="form-field"><label>Birth Date: </label><input type="text" id="enrollees_2_birthDate" name="dob_2">
            <span
                    class="enrlError" id="enrollees_2_birthDate_err"></span><br>
        </div>
        <div class="form-field"><label>Gender: </label><input type="radio" id="enrollees_2_sex" name="gender1" value="M"
                <?php if ($xml->members->dependent[0]->gender == 'M') { ?> checked <?php }?> disabled
            > Male
            <input type="radio" id="enrollees_2_sex" name="gender1" value="F"
                <?php if ($xml->members->dependent[0]->gender == 'F') { ?> checked <?php }?> disabled
            > Female
            <span class="enrlError" id="enrollees_2_sex_err"></span><br>
        </div>

        <?php if ($xml->members->dependent[0]->gender == 'M') { ?>
            <input type="hidden" name="gender1" value="M">
        <?php } ?>
        <?php if ($xml->members->dependent[0]->gender == 'F') { ?>
            <input type="hidden" name="gender1" value="F">
        <?php } ?>

        <div class="form-field"><label>
                SSN:</label><input type="text" id="enrollees_2_SSN" name="lfourssn_2"> <span class="enrlError"
                                                                                             id="enrollees_2_SSN_err"></span><br>
        </div>
    </fieldset>
<?php } ?>

<?php if ($xml != '' && isset($xml->members->dependent)) {
    if ($xml->members->dependent[count($xml->members->dependent) - 1]->type == 'CHILD') {
        $i = 2;
        foreach ($xml->members->dependent as $dependentKey => $dependent) {
            $i++; ?>
            <div id="dynamicInput">
                <div>
                    <fieldset class="dependent-f fieldset_member">
                        <legend>Child <?= $dependent['person_code'] - 2 ?> Information</legend>
                        <div class="form-flex">
                            <div class="form-field"><label>First Name: </label><input type="text"
                                                                                      id="enrollees_3_firstName"
                                                                                      name="first_name_<?= $dependent['person_code'] ?>"
                                                                                      value="<?= $dependent->first_name ?>"
                                                                                      onchange="updateEnrollmentStack(this);"><span
                                        class="enrlError" id="enrollees_3_firstName_err"></span><br></div>
                            <div class="form-field"><label>Last Name: </label><input type="text"
                                                                                     id="enrollees_3_lastName"
                                                                                     name="last_name_<?= $dependent['person_code'] ?>"
                                                                                     value="<?= $dependent->last_name ?>"
                                                                                     onchange="updateEnrollmentStack(this);"><span
                                        class="enrlError" id="enrollees_3_lastName_err"></span><br></div>
                            <div class="form-field"><label>Birth Date: </label><input type="text"
                                                                                      id="enrollees_3_birthDate"
                                                                                      name="dob_<?= $dependent['person_code'] ?>"
                                                                                      value="<?= $dependent->DOB ?>"
                                                                                      onchange="updateEnrollmentStack(this);"><span
                                        class="enrlError" id="enrollees_3_birthDate_err"></span><br></div>
                            <div class="form-field"><label>Gender: </label>
                                <span class="d-flex gender_check">
                                    <span class="d-flex">
                                    <input type="radio" id="enrollees_3_sex"
                                           name="gender_<?= $dependent['person_code'] ?>"
                                           value="M"
                                        <?php if ($dependent->gender == 'M') { ?> checked <?php } ?> disabled
                                           onchange="updateEnrollmentStack(this);">
                                    <span>Male</span>
                                </span>
                                <span class="d-flex">
                                    <input type="radio" name="gender_<?= $dependent['person_code'] ?>" value="F"
                                        <?php if ($dependent->gender == 'F') { ?> checked <?php } ?> disabled
                                           onchange="updateEnrollmentStack(this);">
                                    <span>Female</span>
                                </span>
                                </span>
                                <span class="enrlError" id="enrollees_3_sex_err"></span><br>
                            </div>

                            <?php if ($dependent->gender == 'M') { ?>
                                <input type="hidden" name="gender_<?= $dependent['person_code'] ?>" value="M">
                            <?php } ?>
                            <?php if ($dependent->gender == 'F') { ?>
                                <input type="hidden" name="gender_<?= $dependent['person_code'] ?>" value="F">
                            <?php } ?>

                            <!--                    <div class="form-field"><label>SSN: </label><input type="text" id="enrollees_3_SSN"-->
                            <!--                                                                       onchange="updateEnrollmentStack(this);"> <span-->
                            <!--                                class="enrlError" id="enrollees_3_SSN_err"></span><br></div>-->
                        </div>
                    </fieldset>
                </div>
            </div>
            <br>
        <?php } ?>
        <input type="hidden" name="max_code" value="<?= $i ?>">
        <?php
    }
} ?>

<br>
<fieldset>
    <legend>Please select one of the medical plans below</legend>
    <?php if ($xml == '') { ?>
        <label><input type="radio" class="form-ratio" name="childrencheck" value="Some of the Children"/> Some of the
            Children</label>
        <label><input type="radio" class="form-ratio" name="childrencheck" value="None of the Children"/> None of the
            Children</label>
        <label><input type="radio" class="form-ratio" name="childrencheck" value="All of the Children"/> All of the
            Children</label>
    <?php } ?>
    <?php if (isset($xml->members->dependent)) {
        if ($xml->members->dependent[count($xml->members->dependent) - 1]->type != 'CHILD') { ?>
            <label><input type="radio" class="form-ratio" name="childrencheck" value="Some of the Children"/> Some of
                the
                Children</label>
            <label><input type="radio" class="form-ratio" name="childrencheck" value="None of the Children"/> None of
                the
                Children</label>
            <label><input type="radio" class="form-ratio" name="childrencheck" value="All of the Children"/> All of the
                Children</label>
            <?php
        }
    } ?>
</fieldset>


<div id="dynamicInput">

</div>

<?php if ($xml == '') { ?>
    <input type="button" id="addDepBtn" value="Add Dependant" onClick="addInput();">
<?php } ?>

<br>
<fieldset>
<!--    <legend>Select Coverge:</legend>-->
    <input type="hidden" name="medical_member" id="medical_member">
    <input type="hidden" name="medical_plan_price" id="medical_plan_price">
    <input type="hidden" name="medical_plan_type" id="medical_plan_type">
    <table class="table table-bordered tablepress">
        <!--        <thead>-->
        <!--        <tr id="dynamicInput2_h">-->
        <!--            <th>Primary</th>-->
        <!--            --><?php //if ($xml == '') { ?>
        <!--                <th>Spouse</th>-->
        <!--            --><?php //} else if (isset($xml->members->dependent)) {
        //                foreach ($xml->members->dependent as $dependentKey => $dependent) {
        //                    if ($dependent->type == 'SPOUSE') {
        //                        ?>
        <!--                        <th>Spouse</th>-->
        <!--                    --><?php //} else { ?>
        <!--                        <th>Child --><? //= $dependent['person_code'] - 2 ?><!--</th>-->
        <!--                    --><?php //} ?>
        <!--                --><?php //}
        //            } ?>
        <!--        </tr>-->
        <!--        </thead>-->
        <tbody>
        <tr id="dynamicInput2">
            <?php echo plan_list($plans, 1); ?>
            <!--            --><?php //if ($xml == '') { ?>
            <!--                <td>--><?php //echo plan_list($plans, 2); ?><!--</td>-->
            <!--            --><?php //} else if (isset($xml->members->dependent)) {
            //                foreach ($xml->members->dependent as $dependentKey => $dependent) {
            //                    if ($dependent->type == 'SPOUSE') {
            //                        ?>
            <!--                        <td>--><?php //echo plan_list($plans, 2); ?><!--</td>-->
            <!--                    --><?php //} else { ?>
            <!--                        <td>--><?php //echo plan_list($plans, $dependent['person_code']); ?><!--</td>-->
            <!--                    --><?php //} ?>
            <!--                --><?php //}
            //            } ?>
        </tr>

        <div class="checkbox_group row" id="medical_plan_checkbox_group">
            <div class="col col-md-4 form-group">
                <input type="checkbox" name="gp_43741_1" id="gp_43741_1" value="1" checked disabled="disabled">
                <label for="gp_43741_1">Employee</label>
            </div>
            <?php if ($xml == '') { ?>
                <div class="col col-md-4 form-group">
                    <input type="checkbox" name="gp_43741_2" id="gp_43741_2" value="2">
                    <label >Spouse</label>
                </div>
            <?php } else if (isset($xml->members->dependent)) {
                foreach ($xml->members->dependent as $dependentKey => $dependent) {
                    if ($dependent->type == 'SPOUSE') {
                        ?>
                        <div class="col col-md-4 form-group">
                            <input type="checkbox" name="gp_43741_2" id="gp_43741_2" value="2">
                            <label >Spouse</label>
                        </div>
                    <?php } else { ?>
                        <div class="col col-md-4 form-group">
                            <input type="checkbox" name="gp_43741_<?= $dependent['person_code'] ?>"
                                   value="<?= $dependent['person_code'] ?>"
                                   id="gp_43741_<?= $dependent['person_code'] ?>">
                            <label>Child <?= $dependent['person_code'] - 2 ?></label>
                        </div>
                    <?php } ?>
                <?php }
            } ?>
        </div>

        </tbody>
    </table>
</fieldset>


<br>
<fieldset>
    <legend>Please select one of the dental plans below</legend>
    <?php if ($xml == '') { ?>
        <label><input type="radio" class="form-ratio" name="childrencheck_d" value="Some of the Children"/> Some of the
            Children</label>
        <label><input type="radio" class="form-ratio" name="childrencheck_d" value="None of the Children"/> None of the
            Children</label>
        <label><input type="radio" class="form-ratio" name="childrencheck_d" value="All of the Children"/> All of the
            Children</label>
    <?php } ?>
    <?php if (isset($xml->members->dependent)) {
        if ($xml->members->dependent[count($xml->members->dependent) - 1]->type != 'CHILD') { ?>
            <label><input type="radio" class="form-ratio" name="childrencheck_d" value="Some of the Children"/> Some of
                the
                Children</label>
            <label><input type="radio" class="form-ratio" name="childrencheck_d" value="None of the Children"/> None of
                the
                Children</label>
            <label><input type="radio" class="form-ratio" name="childrencheck_d" value="All of the Children"/> All of
                the
                Children</label>
            <?php
        }
    } ?>
</fieldset>


<div id="dynamicInput_d">
</div>

<?php if ($xml == '') { ?>
    <input type="button" id="addDepBtn_d" value="Add Dependant" onClick="addInput_d();">
<?php } ?>

<br>
<fieldset>
<!--    <legend>Select Coverge:</legend>-->
    <input type="hidden" id="dental_member" name="dental_member">
    <input type="hidden" id="dental_plan_price" name="dental_plan_price">
    <input type="hidden" id="dental_plan_type" name="dental_plan_type">
    <table class="table table-bordered tablepress">
        <!--        <thead>-->
        <!--        <tr id="dynamicInput2_h_d">-->
        <!--            <th>Primary</th>-->
        <!--            --><?php //if ($xml == '') { ?>
        <!--                <th>Spouse</th>-->
        <!--            --><?php //} else if (isset($xml->members->dependent)) {
        //                foreach ($xml->members->dependent as $dependentKey => $dependent) {
        //                    if ($dependent->type == 'SPOUSE') {
        //                        ?>
        <!--                        <th>Spouse</th>-->
        <!--                    --><?php //} else { ?>
        <!--                        <th>Child --><? //= $dependent['person_code'] - 2 ?><!--</th>-->
        <!--                    --><?php //} ?>
        <!--                --><?php //}
        //            } ?>
        <!--        </tr>-->
        <!--        </thead>-->
        <tbody>
        <tr id="dynamicInput2_d">
            <?php echo plan_listd($plans, 1); ?>
            <!--            --><?php //if ($xml == '') { ?>
            <!--                <td>--><?php //echo plan_listd($plans, 2); ?><!--</td>-->
            <!--            --><?php //} else if (isset($xml->members->dependent)) {
            //                foreach ($xml->members->dependent as $dependentKey => $dependent) {
            //                    if ($dependent->type == 'SPOUSE') {
            //                        ?>
            <!--                        <td>--><?php //echo plan_listd($plans, 2); ?><!--</td>-->
            <!--                    --><?php //} else { ?>
            <!--                        <td>-->
            <?php //echo plan_listd($plans, $dependent['person_code']); ?><!--</td>-->
            <!--                    --><?php //} ?>
            <!--                --><?php //}
            //            } ?>
        </tr>
        </tbody>
    </table>
</fieldset>


<br>
<fieldset>
    <legend>Please select one of the vision plans below</legend>
    <?php if ($xml == '') { ?>
        <label><input type="radio" class="form-ratio" name="childrencheck_v" value="Some of the Children"/> Some of the
            Children</label>
        <label><input type="radio" class="form-ratio" name="childrencheck_v" value="None of the Children"/> None of the
            Children</label>
        <label><input type="radio" class="form-ratio" name="childrencheck_v" value="All of the Children"/> All of the
            Children</label>
    <?php } ?>
    <?php if (isset($xml->members->dependent)) {
        if ($xml->members->dependent[count($xml->members->dependent) - 1]->type != 'CHILD') { ?>
            <label><input type="radio" class="form-ratio" name="childrencheck_v" value="Some of the Children"/> Some of
                the
                Children</label>
            <label><input type="radio" class="form-ratio" name="childrencheck_v" value="None of the Children"/> None of
                the
                Children</label>
            <label><input type="radio" class="form-ratio" name="childrencheck_v" value="All of the Children"/> All of
                the
                Children</label>
            <?php
        }
    } ?>
</fieldset>


<div id="dynamicInput_v">
</div>

<?php if ($xml == '') { ?>
    <input type="button" id="addDepBtn_v" value="Add Dependant" onClick="addInput_v();">
<?php } ?>

<br>
<fieldset>
<!--    <legend>Select Coverge:</legend>-->
    <input type="hidden" name="vision_member" id="vision_member">
    <input type="hidden" name="vision_plan_price" id="vision_plan_price">
    <input type="hidden" name="vision_plan_type" id="vision_plan_type">
    <table class="table table-bordered tablepress">
        <!--        <thead>-->
        <!--        <tr id="dynamicInput2_h_v">-->
        <!--            <th>Primary</th>-->
        <!--            --><?php //if ($xml == '') { ?>
        <!--                <th>Spouse</th>-->
        <!--            --><?php //} else if (isset($xml->members->dependent)) {
        //                foreach ($xml->members->dependent as $dependentKey => $dependent) {
        //                    if ($dependent->type == 'SPOUSE') {
        //                        ?>
        <!--                        <th>Spouse</th>-->
        <!--                    --><?php //} else { ?>
        <!--                        <th>Child --><? //= $dependent['person_code'] - 2 ?><!--</th>-->
        <!--                    --><?php //} ?>
        <!--                --><?php //}
        //            } ?>
        <!--        </tr>-->
        <!--        </thead>-->
        <tbody>
        <tr id="dynamicInput2_v">
            <?php echo plan_listv($plans, 1); ?>
            <!--            --><?php //if ($xml == '') { ?>
            <!--                <td>--><?php //echo plan_listv($plans, 2); ?><!--</td>-->
            <!--            --><?php //} else if (isset($xml->members->dependent)) {
            //                foreach ($xml->members->dependent as $dependentKey => $dependent) {
            //                    if ($dependent->type == 'SPOUSE') {
            //                        ?>
            <!--                        <td>--><?php //echo plan_listv($plans, 2); ?><!--</td>-->
            <!--                    --><?php //} else { ?>
            <!--                        <td>-->
            <?php //echo plan_listv($plans, $dependent['person_code']); ?><!--</td>-->
            <!--                    --><?php //} ?>
            <!--                --><?php //}
            //            } ?>
        </tr>
        </tbody>
    </table>
</fieldset>

<?php /*
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

<div id="planInfo">
<?php echo plan_info($plans); ?>
</div>
*/ ?>

<br>

<!--<input type="button" value="Summary" onClick="summary();">-->
<!--<input type="submit" value="Submit" id="finalSubmit" onClick="finalEnrollment();">-->
<input type="submit" value="Submit" id="finalSubmit">

<form id="finalform">
</form>

<style>
    div.plans_list {
        margin: auto;
        border-bottom: none;
        max-width: none;
    }

    .plans_list > ul {
        margin-bottom: 25px;
    }
</style>

<script>
    $(document).ready(function () {

        // var first_name_1 = $('#enrollees_1_firstName').val();
        // if (first_name_1 == '') window.location.reload();

        var checkbox_group = $('#medical_plan_checkbox_group').wrap('<p/>').parent().html();
        $('#medical_plan_checkbox_group').hide();

        $('.membership_header .btn_select_plan').click(function () {
            $(this).parents('.row').find('.checkbox_group').remove();
            $(this).parents('.row').find('.btn_current_plan').text('Select Plan');
            $(this).parents('.row').find('.btn_current_plan').removeClass('btn_current_plan');
            $(this).parent().append(checkbox_group);
            $(this).addClass('btn_current_plan');
            $(this).text('Selected Plan');
            // $(this).parents('.membership_card').css('border', '3px solid #707084');
        });

        $('#plan_list_medical .btn_select_plan').click(function () {
            $('#medical_plan_type').val($(this).attr('plan-type'));
        });

        $('#plan_list_dental .btn_select_plan').click(function () {
            $('#dental_plan_type').val($(this).attr('plan-type'));
        });

        $('#plan_list_vision .btn_select_plan').click(function () {
            $('#vision_plan_type').val($(this).attr('plan-type'));
        });

        $('.btn_current_plan').attr('disabled', 'disabled');

        $('input:text').attr('readonly', 'readonly');

        $('#form_enroll').submit(function (e) {

            var medical_member = '';
            var medical_plan_price = '';
            var dental_member = '';
            var dental_plan_price = '';
            var vision_member = '';
            var vision_plan_price = '';
            var medical_checkbox_group = $('#plan_list_medical .checkbox_group');
            var dental_checkbox_group = $('#plan_list_dental .checkbox_group');
            var vision_checkbox_group = $('#plan_list_vision .checkbox_group');
            if (medical_checkbox_group.length == 0 || dental_checkbox_group.length == 0 || vision_checkbox_group.length == 0) {
                alert('Please select the insurance types.');
                e.preventDefault();
            } else {
                if (medical_checkbox_group.length) {
                    var medical_checked_array = $(medical_checkbox_group).find('input:checked').map(function () {
                        return $(this).val();
                    }).get();
                    if (medical_checked_array.length == 1) {
                        medical_member = 'Employee';
                        medical_plan_price = $(medical_checkbox_group).parents('.membership_card').find('.tierRate:eq(0)').text();
                    }
                    else if (medical_checked_array.length > 3) {
                        if (medical_checked_array.includes("2")) {
                            medical_member = 'Employee + Spouse + Children';
                            medical_plan_price = $(medical_checkbox_group).parents('.membership_card').find('.tierRate:eq(3)').text();
                        } else {
                            medical_member = 'Employee + Children';
                            medical_plan_price = $(medical_checkbox_group).parents('.membership_card').find('.tierRate:eq(5)').text();
                        }
                    }
                    else if (medical_checked_array.length == 2) {
                        if (medical_checked_array.includes("2")) {
                            medical_member = 'Employee + Spouse';
                            medical_plan_price = $(medical_checkbox_group).parents('.membership_card').find('.tierRate:eq(1)').text();
                        } else {
                            medical_member = 'Employee + Child';
                            medical_plan_price = $(medical_checkbox_group).parents('.membership_card').find('.tierRate:eq(4)').text();
                        }
                    } else if (medical_checked_array.length == 3) {
                        if (medical_checked_array.includes("2")) {
                            medical_member = 'Employee + Spouse + Child';
                            medical_plan_price = $(medical_checkbox_group).parents('.membership_card').find('.tierRate:eq(2)').text();
                        } else {
                            medical_member = 'Employee + Children';
                            medical_plan_price = $(medical_checkbox_group).parents('.membership_card').find('.tierRate:eq(5)').text();
                        }
                    }

                    $('#medical_member').val(medical_member);
                    $('#medical_plan_price').val(medical_plan_price);

                }
                if (dental_checkbox_group.length) {
                    var dental_checked_array = $(dental_checkbox_group).find('input:checked').map(function () {
                        return $(this).val();
                    }).get();
                    if (dental_checked_array.length == 1) {
                        dental_member = 'Employee';
                        dental_plan_price = $(dental_checkbox_group).parents('.membership_card').find('.tierRate:eq(0)').text();
                    }
                    else if (dental_checked_array.length > 3) {
                        if (dental_checked_array.includes("2")) {
                            dental_member = 'Employee + Spouse + Children';
                            dental_plan_price = $(dental_checkbox_group).parents('.membership_card').find('.tierRate:eq(3)').text();
                        } else {
                            dental_member = 'Employee + Children';
                            dental_plan_price = $(dental_checkbox_group).parents('.membership_card').find('.tierRate:eq(5)').text();
                        }
                    }
                    else if (dental_checked_array.length == 2) {
                        if (dental_checked_array.includes("2")) {
                            dental_member = 'Employee + Spouse';
                            dental_plan_price = $(dental_checkbox_group).parents('.membership_card').find('.tierRate:eq(1)').text();
                        } else {
                            dental_member = 'Employee + Child';
                            dental_plan_price = $(dental_checkbox_group).parents('.membership_card').find('.tierRate:eq(4)').text();
                        }
                    } else if (dental_checked_array.length == 3) {
                        if (dental_checked_array.includes("2")) {
                            dental_member = 'Employee + Spouse + Child';
                            dental_plan_price = $(dental_checkbox_group).parents('.membership_card').find('.tierRate:eq(2)').text();
                        } else {
                            dental_member = 'Employee + Children';
                            dental_plan_price = $(dental_checkbox_group).parents('.membership_card').find('.tierRate:eq(5)').text();
                        }
                    }

                    $('#dental_member').val(dental_member);
                    $('#dental_plan_price').val(dental_plan_price);

                }
                if (vision_checkbox_group.length) {
                    var vision_checked_array = $(vision_checkbox_group).find('input:checked').map(function () {
                        return $(this).val();
                    }).get();
                    if (vision_checked_array.length == 1) {
                        vision_member = 'Employee';
                        vision_plan_price = $(vision_checkbox_group).parents('.membership_card').find('.tierRate:eq(0)').text();
                    }
                    else if (vision_checked_array.length > 3) {
                        if (vision_checked_array.includes("2")) {
                            vision_member = 'Employee + Spouse + Children';
                            vision_plan_price = $(vision_checkbox_group).parents('.membership_card').find('.tierRate:eq(3)').text();
                        } else {
                            vision_member = 'Employee + Children';
                            vision_plan_price = $(vision_checkbox_group).parents('.membership_card').find('.tierRate:eq(5)').text();
                        }
                    }
                    else if (vision_checked_array.length == 2) {
                        if (vision_checked_array.includes("2")) {
                            vision_member = 'Employee + Spouse';
                            vision_plan_price = $(vision_checkbox_group).parents('.membership_card').find('.tierRate:eq(1)').text();
                        } else {
                            vision_member = 'Employee + Child';
                            vision_plan_price = $(vision_checkbox_group).parents('.membership_card').find('.tierRate:eq(4)').text();
                        }
                    } else if (vision_checked_array.length == 3) {
                        if (vision_checked_array.includes("2")) {
                            vision_member = 'Employee + Spouse + Child';
                            vision_plan_price = $(vision_checkbox_group).parents('.membership_card').find('.tierRate:eq(2)').text();
                        } else {
                            vision_member = 'Employee + Children';
                            vision_plan_price = $(vision_checkbox_group).parents('.membership_card').find('.tierRate:eq(5)').text();
                        }
                    }

                    $('#vision_member').val(vision_member);
                    $('#vision_plan_price').val(vision_plan_price);

                }

                // $('#form_enroll').submit();
            }

        })
    })
</script>