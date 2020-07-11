<?php 
    
    /***********************************
    * Connects to server  API_URL using key API_KEY
    * 
    * 
    * @return string    $session_reg_key - Temp key for API interaction
    * @return int       $current_time - Server time
    * @return int       $expiration - Temp key expiration time
    */
    function register_client()
    {      
        $success = 0;
        $attempt = 0;
        while($success == 0 and $attempt++<5){
            ob_start();
            $ch = curl_init (API_URL);
            
            curl_setopt ($ch, CURLOPT_VERBOSE, 1);
            curl_setopt ($ch, CURLOPT_POST, 1);
            // set POST output
            $login_arr = array('api_key' => API_KEY,
                               'action' => 'register_client',
                               'json' => 1,
                               );
            $login_string = http_build_query($login_arr);
            curl_setopt ($ch, CURLOPT_POSTFIELDS, $login_string);
            // send headers
            $origin = str_replace('www.','',$_SERVER['HTTP_HOST']);
            $headers = array('origin: https://'.$origin,
                             'Content-Length: '. strlen($login_string)
                             );
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            
            //execute curl and return result to STDOUT
            curl_exec ($ch);
            
            //close curl connection
            curl_close ($ch);

            // set variable eq to output buffer
            $process_result = ob_get_contents();
            
            // close and clean output buffer
            ob_end_clean();
            $json_obj = json_decode($process_result);
            $result = $json_obj->result;
            if($result->success <> 1){
                sleep(2);   
            }else{
                $success = 1;
            }
        }
        if($result->success == 1){
            return $result; 
        }else{
            include(cust_file('connect_err.php'));
            exit;                    
        }
    }
    
    
    function load_plans($session_reg_key)
    {      
        $success = 0;
        $attempt = 0;
        while($success == 0 and $attempt++<5){ 
            ob_start();
            $ch = curl_init (API_URL);
            
            curl_setopt ($ch, CURLOPT_VERBOSE, 1);
            curl_setopt ($ch, CURLOPT_POST, 1);
            // set POST output
            $login_arr = array('session_reg_key' => $session_reg_key,
                               'group_id' => GROUP_ID,
                               'self_enroll' => 1,
                               'action' => 'list_plans',
                               'json' => 1,
                               );
            $login_string = http_build_query($login_arr);
            curl_setopt ($ch, CURLOPT_POSTFIELDS, $login_string);
            // send headers
            $origin = str_replace('www.','',$_SERVER['HTTP_HOST']);
            $headers = array('origin: https://'.$origin,
                             'Content-Length: '. strlen($login_string)
                             );
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            
            //execute curl and return result to STDOUT
            curl_exec ($ch);
            
            //close curl connection
            curl_close ($ch);

            // set variable eq to output buffer
            $process_result = ob_get_contents();
            
            // close and clean output buffer
            ob_end_clean();
            $json_obj = json_decode($process_result);
            $result = $json_obj->result;
            if($result->success <> 1){
                sleep(2);   
            }else{
                $success = 1;
            }
        }
        if($result->success == 1){
            return $result; 
        }else{
            include(cust_file('connect_err.php'));
            exit;                    
        }
    }
    
    
    /***********************************
    * Look for custom version of file
    * 
    * @param string         $file_name
    * 
    * @return bool|string   False on no custom exist, include path on true
    */
    function cust_file($file_name){
        
        if(file_exists(CUSTOMUI.LANGUAGE.$file_name)){
            return CUSTOMUI.LANGUAGE.$file_name;
        }elseif(file_exists(USERINT.LANGUAGE.$file_name)){
            return USERINT.LANGUAGE.$file_name;
        }else{
            return false;
        }
    }
    
    
    /**************************
    * display plan/ tier price
    */
    function disp_price($plan,$tier,$echo=0){
        global $plans;
        global $plan_price;
        
        $price  = $plan_price[$plans[$plan]][$tier]; 
        if($echo){
            echo sprintf('%.2f',$price);
        }else{
            return $price;
        }
    }
    
    /***********************
    * state select
    */
    function state_sel($id,$name){
        
        echo '<select type="text" class="form-control" id="'.$id.'" placeholder="'.$name.'" name="'.$name.'">
                    <option value="AK">Alaska</option>
                    <option value="AL">Alabama</option>
                    <option value="AR">Arkansas</option>
                    <option value="AZ">Arizona</option>
                    <option value="CA">California</option>
                    <option value="CO">Colorado</option>
                    <option value="CT">Connecticut</option>
                    <option value="DC">District of Columbia</option>
                    <option value="DE">Delaware</option>
                    <option value="FL">Florida</option>
                    <option value="GA">Georgia</option>
                    <option value="HI">Hawaii</option>
                    <option value="IA">Iowa</option>
                    <option value="ID">Idaho</option>
                    <option value="IL">Illinois</option>
                    <option value="IN">Indiana</option>
                    <option value="KS">Kansas</option>
                    <option value="KY">Kentucky</option>
                    <option value="LA">Louisiana</option>
                    <option value="MA">Massachusetts</option>
                    <option value="MD">Maryland</option>
                    <option value="ME">Maine</option>
                    <option value="MI">Michigan</option>
                    <option value="MN">Minnesota</option>
                    <option value="MO">Missouri</option>
                    <option value="MS">Mississippi</option>
                    <option value="MT">Montana</option>
                    <option value="NC">North Carolina</option>
                    <option value="ND">North Dakota</option>
                    <option value="NE">Nebraska</option>
                    <option value="NH">New Hampshire</option>
                    <option value="NJ">New Jersey</option>
                    <option value="NM">New Mexico</option>
                    <option value="NV">Nevada</option>
                    <option value="NY">New York</option>
                    <option value="OH">Ohio</option>
                    <option value="OK">Oklahoma</option>
                    <option value="OR">Oregon</option>
                    <option value="PA">Pennsylvania</option>
                    <option value="PR">Puerto Rico</option>
                    <option value="RI">Rhode Island</option>
                    <option value="SC">South Carolina</option>
                    <option value="SD">South Dakota</option>
                    <option value="TN">Tennessee</option>
                    <option value="TX">Texas</option>
                    <option value="UT">Utah</option>
                    <option value="VA">Virginia</option>
                    <option value="VT">Vermont</option>
                    <option value="WA">Washington</option>
                    <option value="WI">Wisconsin</option>
                    <option value="WV">West Virginia</option>
                    <option value="WY">Wyoming</option>
                </select>';
    }  
    
    /************************
    * group ID                    
    */
    function group_id(){
        echo GROUP_ID;
    }
    
    
    /************************
    * Return the tier
    * @param int    $spouse 1 has spouse, 0 does not
    * @param int    $child Number of non-spouse dependents
    * @param int    $name 1 = text tier name, 0 = tier code
    * 
    * @return int   0 = Primary only
    *               1 = Prim + Spouse   
    *               2 = Prim + Spouse + Child   
    *               3 = Prim + Spouse + Children   
    *               4 = Prim + Child   
    *               5 = Prim + Children   
    */
    function tier($sp=0,$ch=0,$name=0){
        global $tier_name;
        
        $tier = 0;
        if($sp == 0){
            if($ch==1){
                $tier = 4;
            }elseif($ch>1){
                $tier = 5;
            }
        }else{
            if($ch==1){
                $tier = 2;
            }elseif($ch>1){
                $tier = 3;
            }else{
                $tier = 1;
            }
        }
        if($name = 1){
            $tier = $tier_name[$tier]; 
        }
        return $tier;
    }
    
    ?>