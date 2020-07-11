    /* global vars */
    
    var sesRegKey = "<?php echo $reg_key; ?>";
    var ttl = "<?php echo $ttl; ?>";
    var enrollMembedId = '';
    var processing = 0;
    var plansArr = [];
    
    var enrollmentStack = {
        myKey: "<?php echo $_SESSION['my_key']; ?>",
        self_enroll: <?php echo SELF_ENROLL; ?>,
        em_memberid: '',
        enrollee_class_id: '',
        enroll_member_id: '',
        auth_id: '',
        hasSpouse : 0,
        maxDep : 3,         // Next child dependant to be added, children start at 3
        coverage: {},
        errors: {},
        address:{
            address1:'',
            address2:'',
            city:'',
            state:'',
            zip:'',
            attempt: 0
        },
        enrollees : [],    // person objects 1 = prime, 2 = spouse, 3...n = child
        phone:'',
        email:'',
        password: '',
        eula_accept: '',
        IP_Address: '<?php echo $_SERVER['REMOTE_ADDR']; ?>' ,
        location_code: '',
        current_employer: '',
        effective_date: '',
        notes: '',
        payment:{ 
            payment_type: '',
            credit_card:{
                cc_type: '',
                cc_name: '',
                cc_number: '',
                cc_expiration_mo: '',
                cc_expiration_year: '',
                cc_address_1: '',
                cc_address_2: '',
                cc_city: '',
                cc_state: '',
                cc_zipcode: '',
                cc_auth_code: '',
                cc_error_code: '',
                cc_auth_response_text: '',
                cc_avs_result: '',
                cc_transaction_id: '',
                cc_void_auth_code: '',
                cc_void_error_code: '',
                cc_void_auth_response_text: '',
                cc_void_transaction_id: ''
            },
            checking:{
                bank_name: '',
                account_name: '',
                bank_account_name: '',
                account_number: '',
                routing_number: '',
                account_type: '',
                ach_auth_code: '',
                ach_response_code: '',
                ach_response_desc: '',
                ach_transaction_id: '',
                ach_void_auth_code: '',
                ach_void_response_code: '',
                ach_void_response_desc: '',
                ach_void_transaction_id: ''
            },
            pend_payment_date: '',
            delay_payment_date: ''
        },
        verification: {
            verification_code: '',
            verification_agent: '',
            req_tpv: ''
        },
        agent: {
            agent_id: '',
            agent_level_flag: '',
            fdx_licensed_agent: ''
        },
        process_enrollment:{
            processed_date: '',
            processed_by_id: '',
            processed_by_type: '',
            attempted_integration: '',
            rdy_to_proc: ''
        },
        enroll_member_confirmed: '',
        cancel: '',
        fdx_open_enrollee: '',
        ext_ee_id: ''
    };
    
    
    

$(document).ready(function(){
  $("input").change(function() {
    updateEnrollmentStack(this);  
  });
});

function updateEnrollmentStack(element){
    if(element.id == "em_memberid"){
        enrollmentStack.em_memberid = element.value;
    }else{
        var pointer = element.id.split('_');
        switch(pointer[0]){
            case 'enrollees':
                updateEnrollees(pointer[1],pointer[2],element.value);
                break;
            case 'address':
                enrollmentStack.address.address1 = $('#address_address1').val();
                enrollmentStack.address.address2 = $('#address_address2').val();
                enrollmentStack.address.city = $('#address_city').val();
                enrollmentStack.address.state = $('#address_state').val();
                enrollmentStack.address.zip = $('#address_zip').val();
                break;
            case 'gp':
                if ($(element).is(':checked'))
                {
                    updateCoverage(pointer[1],pointer[2],true);
                }
                else
                {
                    updateCoverage(pointer[1],pointer[2],false);
                }
                break;
            default:
                enrollmentStack[pointer[0]] = element.value;
        }
    }
};


function updateEnrollees(id,field,value){
    if (typeof(enrollmentStack.enrollees[id]) == "undefined"){
        //define the person object
        enrollmentStack.enrollees[id] = {
            firstName: '',
            lastName: '',
            middleInit: '',
            sex: '',
            birthDate: '',
            SSN: '',        
            employeeNumber: '',
            hire_date: '',
            lastFourSSN: ''        
        };    
    }
    enrollmentStack.enrollees[id][field] = value;
    
    // check for has spouse
    if(id == 2){
        var spouse = '';
        if(typeof(enrollmentStack.enrollees[2].firstName) != "undefined"){
            spouse = spouse + enrollmentStack.enrollees[2].firstName;
        }
        if(typeof(enrollmentStack.enrollees[2].lastName) != "undefined"){
            spouse = spouse + enrollmentStack.enrollees[2].lastName;
        }
        
        if(spouse != ''){
            enrollmentStack.hasSpouse = 1;
        }else{
            enrollmentStack.hasSpouse = 0;
        }
    }
    
    // updating child dep, reenable add dep button
    if(id > 2){
        $('#addDepBtn').removeAttr('disabled');
    }
    
};

function updateCoverage(plan,perCode,value){
    var hasCov = 0;
    var mem = 'per_' + perCode;
    var planPtr = 'gp_' + plan;
    if (typeof(enrollmentStack.coverage[mem]) == "undefined"){
        //define the coverage array
        enrollmentStack.coverage[mem] = {};
    }
    if(value == true){
        hasCov = 1;
    }
    enrollmentStack.coverage[mem][planPtr] = hasCov;
    if(perCode == 1 && hasCov == 0){
        var depPntr;
        for(depPntr=2; depPntr < enrollmentStack.maxDep; depPntr++){
            mem = 'per_' + depPntr;
            if (typeof(enrollmentStack.coverage[mem]) != "undefined"){
                enrollmentStack.coverage[mem][planPtr] = hasCov;
            }
        }        
    }
};

function finalSubmit()
    {
        if(processing == 0){
            processing = 1;
            // populate enrollees array with corresponding coveragetype

            enrollmentStack.enroll_member_id = enrollMembedId;
            var jsonPackage = {enrollment: enrollmentStack};
            
            $.ajax({
                type: "POST",
                url: '/enroller_II/enrollSubmit.php',
                data:{
                    package: JSON.stringify(jsonPackage),
                    action: 'online_enroller',
                    group_id: '<?php group_id();?>',
                    session_reg_key: sesRegKey,
                    my_key: enrollmentStack.myKey
                },
                async:true,
                success: function(data, status, xhr) {
                    enrollmentStack = JSON.parse(data);
                    sesRegKey = enrollmentStack.session_reg_key;
                    ttl = enrollmentStack.expiration - enrollmentStack.current_time;
                    enrollMembedId = enrollmentStack.enroll_member_id;
                    processEnrollmentStack();                
                }
            });
        }
        processing = 0;
    }
    
function processEnrollmentStack()
    {
        //Update page with data from the enrollmentStack
        var errField = '';
        $('.enrlError').empty();
        $.each(enrollmentStack, function( key, value ) {
          switch(key){
            case 'enrollees':
                $.each(value, function (percode, member) {
                    if(member != null){
                        $.each(member, function (field, fieldVal){
                            $('#enrollees_' + percode + '_' + field).val(fieldVal);
                        });
                    }
                });
                break;
            case 'address':
                $('#address_address1').val(enrollmentStack.address.address1);
                $('#address_address2').val(enrollmentStack.address.address2);
                $('#address_city').val(enrollmentStack.address.city);
                $('#address_state').val(enrollmentStack.address.state);
                $('#address_zip').val(enrollmentStack.address.zip);
                break;
            case 'gp':
                
                break;
            case 'errors':
                $.each(value, function (field, err){
                    errField =  field + '_err';
                    if($('#' + errField).length > 0) {
                        $('#' + errField).html(err);                    
                    }
                });
                enrollmentStack.errors = {};
                break;
            default:
                if($("#" + key).length){
                    $("#" + key).val(value)    
                }
                break;           
          };
        });
    }
    
    function availablePlans(element){
        var pointer = element.id.split('_');
        var className = '.' + pointer[0] + '_' + pointer[1];
        var idName = pointer[0] + '_' + pointer[1];
        
        if ($(element).is(':checked'))
        {
            plansArr[pointer[1]] = 1;
            $(className).removeAttr('disabled');
        }
        else
        {
            plansArr[pointer[1]] = 0; 
            $(className).attr('disabled','disabled');
            $(className).prop( "checked", false );
        }
    }