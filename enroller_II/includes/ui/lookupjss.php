<!-- import external libraries -->              
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript">
    
    <?php
        // load enrollment stack object
        if($path = cust_file('api_controller.php'))include($path);
    ?>
    
    function lookupEnrollee()
    {
        var jsonPackage = {renew_code: enrollmentStack.enrollees[1].employeeNumber,
                           ssn_last_4: enrollmentStack.enrollees[1].lastFourSSN,
                           birth_date: enrollmentStack.enrollees[1].birthDate,
                           em_memberid: enrollmentStack.em_memberid
                           };
        $.ajax({
            type: "POST",
            url: '/enroller_II/enrollSubmit.php',
            data:{
                package: JSON.stringify(jsonPackage),
                action: 'eeid',
                session_reg_key: sesRegKey,
                my_key: enrollmentStack.myKey                
            },
            async:true,
            success: function(data, status, xhr) {
                result = JSON.parse(data);
                sesRegKey = result.session_reg_key;
                ttl = result.expiration - result.current_time;
                if(result.error != ''){
                    $('#em_memberid_err').html(result.error);       
                }else{
                    $.get('/enroller_II/index.php', function(page){
                        $('#enroller-content').html(page);
                        enrollmentStack = result;
                        enrollMembedId = enrollmentStack.enroll_member_id;
                        processEnrollmentStack();    
                    });                                   
                }
            }
        });
        
    }
    
    </script>