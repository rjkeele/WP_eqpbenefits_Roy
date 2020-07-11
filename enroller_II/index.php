<?php
if( !session_id() ){
    session_start();
}
/** Loads the Enroller */
require( dirname( __FILE__ ) . '/enroller.php' );
