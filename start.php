<?php
function love_init() {	
elgg_extend_view('profile/owner_block','love/counter', 24); 
elgg_extend_view("css/elgg", "css/love");
}
elgg_register_event_handler('init','system','love_init'); 
elgg_register_action("love/save", elgg_get_plugins_path() . "love/actions/love/save.php");



