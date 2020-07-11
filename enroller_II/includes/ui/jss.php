<!-- import external libraries -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">

    <?php
    // load enrollment stack object
    if($path = cust_file('api_controller.php'))include($path);
    ?>

    <?php
    echo '/* populate plan prices */';
    foreach($plans as $type => $id){
        $var_name = plan_to_var('Prices',$type);
        $jss_row = 'var '.$var_name.' = [';
        $comma = '';
        if(is_array($plan_price[$id])){
            foreach($plan_price[$id] as $price){
                $jss_row .=  $comma.$price;
                $comma = ',';
            }
        }
        $jss_row .= '];
    ';
        echo $jss_row;
    }
    echo '
    
    /* populate plan type code */
    ';
    foreach($plans as $type => $id){
        $var_name = plan_to_var('Code',$type);
        $jss_row = 'var '.$var_name.' = "'.$id.'";
    ';
        echo $jss_row;
    }

    echo '
    
    /* populate plan codes */
    ';
    $jss_row = 'var planCodes = [';
    $comma = '';
    foreach($plans as $type => $id){
        $jss_row .=  $comma.$id;
        $comma = ',';
    }
    $jss_row .= '];
    ';
    echo $jss_row;

    echo '
    
    /* populate tier names */
    ';
    $jss_row = 'var tier_name = [';
    $comma = '';
    foreach($tier_name as $tier){
        $jss_row .= $comma .'"'.$tier.'"';
        $comma = ',';
    }
    $jss_row .= '];
    ';
    echo $jss_row;


    echo '
    
    /* populate coverage types */
    ';
    $jss_row = plan_list($plans,1,0,'',1);
    echo $jss_row;

    ?>

    function finalEnrollment()
    {
        finalSubmit();
    }

    function addInput()
    {
        var className = '';
        var newdiv = document.createElement('div');
        var depPntr = enrollmentStack.maxDep; // children start at person code 3
        var depId = enrollmentStack.maxDep - 2;
        newdiv.innerHTML = "<fieldset class='dependent-f'><legend>Child " + depId + " Information:</legend>" +
            "<div class='form-flex'><div class='form-field'><label>First Name: </label><input type='text' id='enrollees_"+ depPntr +"_firstName' onchange='updateEnrollmentStack(this);' ><span class='enrlError' id='enrollees_"+ depPntr +"_firstName_err'></span><br></div>" +
            "<div class='form-field'><label>Last Name: </label><input type='text' id='enrollees_"+ depPntr +"_lastName' onchange='updateEnrollmentStack(this);'><span class='enrlError' id='enrollees_"+ depPntr +"_lastName_err'></span><br></div>" +
            "<div class='form-field'><label>Birth Date: </label><input type='text' id='enrollees_"+ depPntr +"_birthDate' onchange='updateEnrollmentStack(this);'><span class='enrlError' id='enrollees_"+ depPntr +"_birthDate_err'></span><br></div>" +
            "<div class='form-field'><label>Gender: </label><input type='radio' id='enrollees_"+ depPntr +"_sex' value='male' checked onchange='updateEnrollmentStack(this);'> Male <input type='radio' name='enrollees_"+ depPntr +"_sex' value='female' onchange='updateEnrollmentStack(this);'> Female <span class='enrlError' id='enrollees_"+ depPntr +"_sex_err'></span><br></div>" +
            "<div class='form-field'><label>SSN: </label><input type='text'  id='enrollees_"+ depPntr +"_SSN' onchange='updateEnrollmentStack(this);'> <span class='enrlError' id='enrollees_"+ depPntr +"_SSN_err'></span><br></div></div>" +
            "</fieldset>";
        document.getElementById('dynamicInput').appendChild(newdiv);

        var newdiv2 = document.createElement('td');
        var newDepPlans = "<?php  echo plan_list($plans,'xxx999',1,'updateEnrollmentStack(this);') ?> <br>";

        newdiv2.innerHTML = newDepPlans.replace(/xxx999/g, depPntr);
        document.getElementById('dynamicInput2').appendChild(newdiv2);

        var newdiv2_h = document.createElement('th');
        var newDepPlans_h = "Child " + (depId);
        newdiv2_h.innerHTML = newDepPlans_h.replace(/xxx999/g, depPntr);
        document.getElementById('dynamicInput2_h').appendChild(newdiv2_h);

        $.each(planCodes, function( ptr, planNum ) {
            if(plansArr[planNum] == 1){
                className = '.gp_' + planNum;
                $(className).removeAttr('disabled');
            }
        });
        $('#addDepBtn').attr('disabled','disabled');
        $('#enrollees_' + depPntr + '_firstName').focus();
        enrollmentStack.maxDep++;
    }
    
    
    function addInput_d()
    {
        var className = '';
        var newdiv = document.createElement('div');
        var depPntr = enrollmentStack.maxDep; // children start at person code 3
        var depId = enrollmentStack.maxDep - 2;
        newdiv.innerHTML = "<fieldset class='dependent-f'><legend>Child " + depId + " Information:</legend>" +
            "<div class='form-flex'><div class='form-field'><label>First Name: </label><input type='text' id='enrollees_"+ depPntr +"_firstName' onchange='updateEnrollmentStack(this);' ><span class='enrlError' id='enrollees_"+ depPntr +"_firstName_err'></span><br></div>" +
            "<div class='form-field'><label>Last Name: </label><input type='text' id='enrollees_"+ depPntr +"_lastName' onchange='updateEnrollmentStack(this);'><span class='enrlError' id='enrollees_"+ depPntr +"_lastName_err'></span><br></div>" +
            "<div class='form-field'><label>Birth Date: </label><input type='text' id='enrollees_"+ depPntr +"_birthDate' onchange='updateEnrollmentStack(this);'><span class='enrlError' id='enrollees_"+ depPntr +"_birthDate_err'></span><br></div>" +
            "<div class='form-field'><label>Gender: </label><input type='radio' id='enrollees_"+ depPntr +"_sex' value='male' checked onchange='updateEnrollmentStack(this);'> Male <input type='radio' name='enrollees_"+ depPntr +"_sex' value='female' onchange='updateEnrollmentStack(this);'> Female <span class='enrlError' id='enrollees_"+ depPntr +"_sex_err'></span><br></div>" +
            "<div class='form-field'><label>SSN: </label><input type='text'  id='enrollees_"+ depPntr +"_SSN' onchange='updateEnrollmentStack(this);'> <span class='enrlError' id='enrollees_"+ depPntr +"_SSN_err'></span><br></div></div>" +
            "</fieldset>";
        document.getElementById('dynamicInput_d').appendChild(newdiv);

        var newdiv2 = document.createElement('td');
        var newDepPlans = "<?php  echo plan_listd($plans,'xxx999',1,'updateEnrollmentStack(this);') ?> <br>";

        newdiv2.innerHTML = newDepPlans.replace(/xxx999/g, depPntr);
        document.getElementById('dynamicInput2_d').appendChild(newdiv2);

        var newdiv2_h = document.createElement('th');
        var newDepPlans_h = "Child " + (depId);
        newdiv2_h.innerHTML = newDepPlans_h.replace(/xxx999/g, depPntr);
        document.getElementById('dynamicInput2_h_d').appendChild(newdiv2_h);

        $.each(planCodes, function( ptr, planNum ) {
            if(plansArr[planNum] == 1){
                className = '.gp_' + planNum;
                $(className).removeAttr('disabled');
            }
        });
        $('#addDepBtn').attr('disabled','disabled');
        $('#enrollees_' + depPntr + '_firstName').focus();
        enrollmentStack.maxDep++;
    }
    
    function addInput_v()
    {
        var className = '';
        var newdiv = document.createElement('div');
        var depPntr = enrollmentStack.maxDep; // children start at person code 3
        var depId = enrollmentStack.maxDep - 2;
        newdiv.innerHTML = "<fieldset class='dependent-f'><legend>Child " + depId + " Information:</legend>" +
            "<div class='form-flex'><div class='form-field'><label>First Name: </label><input type='text' id='enrollees_"+ depPntr +"_firstName' onchange='updateEnrollmentStack(this);' ><span class='enrlError' id='enrollees_"+ depPntr +"_firstName_err'></span><br></div>" +
            "<div class='form-field'><label>Last Name: </label><input type='text' id='enrollees_"+ depPntr +"_lastName' onchange='updateEnrollmentStack(this);'><span class='enrlError' id='enrollees_"+ depPntr +"_lastName_err'></span><br></div>" +
            "<div class='form-field'><label>Birth Date: </label><input type='text' id='enrollees_"+ depPntr +"_birthDate' onchange='updateEnrollmentStack(this);'><span class='enrlError' id='enrollees_"+ depPntr +"_birthDate_err'></span><br></div>" +
            "<div class='form-field'><label>Gender: </label><input type='radio' id='enrollees_"+ depPntr +"_sex' value='male' checked onchange='updateEnrollmentStack(this);'> Male <input type='radio' name='enrollees_"+ depPntr +"_sex' value='female' onchange='updateEnrollmentStack(this);'> Female <span class='enrlError' id='enrollees_"+ depPntr +"_sex_err'></span><br></div>" +
            "<div class='form-field'><label>SSN: </label><input type='text'  id='enrollees_"+ depPntr +"_SSN' onchange='updateEnrollmentStack(this);'> <span class='enrlError' id='enrollees_"+ depPntr +"_SSN_err'></span><br></div></div>" +
            "</fieldset>";
        document.getElementById('dynamicInput_v').appendChild(newdiv);

        var newdiv2 = document.createElement('td');
        var newDepPlans = "<?php  echo plan_listv($plans,'xxx999',1,'updateEnrollmentStack(this);') ?> <br>";

        newdiv2.innerHTML = newDepPlans.replace(/xxx999/g, depPntr);
        document.getElementById('dynamicInput2_v').appendChild(newdiv2);

        var newdiv2_h = document.createElement('th');
        var newDepPlans_h = "Child " + (depId);
        newdiv2_h.innerHTML = newDepPlans_h.replace(/xxx999/g, depPntr);
        document.getElementById('dynamicInput2_h_v').appendChild(newdiv2_h);

        $.each(planCodes, function( ptr, planNum ) {
            if(plansArr[planNum] == 1){
                className = '.gp_' + planNum;
                $(className).removeAttr('disabled');
            }
        });
        $('#addDepBtn').attr('disabled','disabled');
        $('#enrollees_' + depPntr + '_firstName').focus();
        enrollmentStack.maxDep++;
    }

    function getTier(planCode)
    {
        var result = 0;
        var dep;
        var dep_cnt = 0;
        for (dep = 2; dep < enrollmentStack.maxDep; dep++) {
            if(enrollmentStack.coverage[dep] != undefined)
            {
                if(enrollmentStack.coverage[dep][planCode] == 1)
                {
                    dep_cnt++;
                }
            }
        }
        if(enrollmentStack.hasSpouse == 1 && enrollmentStack.coverage[1] != undefined)
        {
            if(enrollmentStack.coverage[1][planCode] == 1)
            {
                // spouse is covered
                if(dep_cnt == 0)
                {
                    result = 1;
                }
                if(dep_cnt == 1)
                {
                    result = 2;
                }
                if(dep_cnt > 1)
                {
                    result = 3;
                }
            }
            else
            {
                //spouse not covered
                if(dep_cnt == 1)
                {
                    result = 4;
                }
                if(dep_cnt > 1)
                {
                    result = 5;
                }
            }
        }
        else
        {
            // No spouse
            if(dep_cnt == 1)
            {
                result = 4;
            }
            if(dep_cnt > 1)
            {
                result = 5;
            }
        }
        return result;
    }

    function summary()
    {
        console.log(enrollmentStack);
        //console.log(enrollmentStack.deps);
    }
    $(document).ready(function(){
        $('#addDepBtn').hide();
        $('#addDepBtn_d').hide();
        $('#addDepBtn_v').hide();
        $('input[name="childrencheck"]').change(function() {
            console.log(this.value);
            if(this.value == 'Some of the Children'){
                $('#addDepBtn').show();
            }else{
                $('#addDepBtn').hide();
            }
        });
        
        $('input[name="childrencheck_d"]').change(function() {
            console.log(this.value);
            if(this.value == 'Some of the Children'){
                $('#addDepBtn_d').show();
            }else{
                $('#addDepBtn_d').hide();
            }
        });
        
        $('input[name="childrencheck_v"]').change(function() {
            console.log(this.value);
            if(this.value == 'Some of the Children'){
                $('#addDepBtn_v').show();
            }else{
                $('#addDepBtn_v').hide();
            }
        });
    });
</script>