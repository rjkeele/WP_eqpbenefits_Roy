<?php
    namespace eqp_enroller;
    
    define( 'PATHROOT', dirname( __FILE__ ) . '/' );    
    define( 'CUSTOMUI', dirname( __FILE__ ) . '/custom_ui/' );    
    define( 'USERINT', dirname( __FILE__ ) . '/includes/ui/' );    
    
    require_once('conf.php' );           
    require_once 'includes/api_cntrl.php';
    require_once 'includes/function_inc.php';
    
    // establish enroller security
    $_SESSION['my_key'] = guid();
    
    // connect to server and register client
    $preflight = register_client();
    $sys_plans = load_plans($preflight->session_reg_key);
    
    if(count($sys_plans->plan) == 1){
        $plans[$sys_plans->plan->plan_name] = $sys_plans->plan->plan_id;
        foreach($sys_plans->plan->rates->rate as $tier){
            $plan_price[$sys_plans->plan->plan_id][] = $tier->tier_rate;    
        }    
    }else{
        foreach($sys_plans->plan as $cov){
            $plans[$cov->plan_name] = $cov->plan_id;
            foreach($cov->rates->rate as $tier){
                $plan_price[$cov->plan_id][] = $tier->tier_rate;    
            }
        }
    }
    
    foreach($sys_plans->group->tiers->tier as $tier){
        $tier_name[] = $tier->tier_name;
    }
    $reg_key = $sys_plans->session_reg_key;
    $cur_time = $preflight->current_time;
    $exp_time = $preflight->expiration;
    $ttl = $exp_time - $cur_time;
    $wanr_time = $ttl - 60;
    
    // begin page
    if($path = cust_file('header.php'))include($path);

?>