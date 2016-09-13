<?php
// session_start();

include_once( 'config.php' );
include_once( 'saetv2.ex.class.php' );

$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );
// var_dump($o);die;
$code_url = $o->getAuthorizeURL( WB_CALLBACK_URL );
// var_dump($code_url);die;
if(!empty($code_url)){
	header("Location:$code_url");die;
}else{
	echo "false";die;
}
?>