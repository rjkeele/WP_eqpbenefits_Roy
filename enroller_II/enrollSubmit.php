<?php
    if( !session_id() ){
        session_start();
    }
    
    require_once('conf.php' );
    require_once 'includes/function_inc.php';
    if($_SESSION['my_key'] == $_REQUEST['my_key'] and $_SESSION['my_key'] <> ''){
        //$_SESSION['my_key'] = guid();
        if($_REQUEST['package']){
            $package = json_decode($_REQUEST['package']);            
        }else{
            $package = array();
        }
        $action = $_REQUEST['action'];
        $group_id = $_REQUEST['group_id'];
        $session_reg_key = $_REQUEST['session_reg_key'];
        
        $success = 0;
        $attempt = 0;
        while($success == 0 and $attempt++<2){
            ob_start();
            $ch = curl_init (API_URL);
            curl_setopt ($ch, CURLOPT_VERBOSE, 1);
            curl_setopt ($ch, CURLOPT_POST, 1);
            // set POST output
            $post_obj = new stdClass();
            $post_obj->session_reg_key = $session_reg_key;
            $post_obj->group_id = $group_id;
            $post_obj->action = $action;
            $post_obj->json = 2;
            foreach($package as $key => $value){
                $post_obj->$key = $value;
            }
            $post_obj->session_reg_key = $session_reg_key;
            
            $post = http_build_query($post_obj);
            curl_setopt ($ch, CURLOPT_POSTFIELDS, $post);
            // send headers
            $origin = str_replace('www.','',$_SERVER['HTTP_HOST']);
            $headers = array('origin: https://'.$origin,
                            'Content-Length: '. strlen($post)
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
            
            if($json_obj->success <> 1){
                sleep(2);   
            }else{
                $success = 1;
            }
        }
        if($json_obj->success == 1){
            $json_obj->myKey = $_SESSION['my_key'];
            echo json_encode($json_obj); 
        }else{
            var_dump($post_obj);
            echo $process_result;
            echo 'error';
        }
    }else{
        header('HTTP/1.0 403 Forbidden');
    }
?>