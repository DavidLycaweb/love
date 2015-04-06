<?php
//Lover guid
$user = elgg_get_logged_in_user_guid();
//Target guid
$elguid = get_input('elguid');

// Create a new lovearrow object
$lovearrow = new ElggObject();

// Create a new object subtype lovearrow
$lovearrow->subtype = "lovearrow";

//Checking for arrows by the same lover
$checkingarrows = elgg_get_entities_from_metadata(array(
    'types' => 'object',
    'subtypes' => 'lovearrow',
    'owner_guid' => $elguid,
	'metadata_name_value_pair' => array(array('name' => 'name', 'value' => $user)),
    'count' => true
));

$thearrows = elgg_get_entities_from_metadata(array(
    'types' => 'object',
    'subtypes' => 'lovearrow',
    'owner_guid' => $elguid,
	'metadata_name_value_pair' => array(array('name' => 'name', 'value' => $user)),
    'count' => false
));

//delete previous lovearrow by the same lover
if ($checkingarrows != 0) {
foreach ($thearrows as $arrow) {
elgg_set_ignore_access	( true	);
    $deletearrow =  $arrow->delete();
elgg_set_ignore_access	( false	);
}

if ($deletearrow) {
   $mensa = elgg_echo('remove:love');
   system_message("$mensa");
   forward(REFERER);
   }
else {
$mensa = elgg_echo('remove:love:error');
register_error("$mensa");
forward(REFERER); // REFERER is a global variable that defines the previous page
}

}

// Ignoring default access
elgg_set_ignore_access	( true	);
		
// Making all lovearrows public
$lovearrow->access_id = ACCESS_PUBLIC;

// Setting target of lovearrow
$lovearrow->owner_guid = $elguid;


// Setting name of lover
$lovearrow->name = $user;

// save to database and get id of the new lovearrow
$lovearrow_guid = $lovearrow->save();

//Restoring default access
elgg_set_ignore_access	( false	);

// Otherwise, we want to register an error and forward back to the form
if ($lovearrow_guid) {
   $mensa = elgg_echo('love:success');
   system_message("$mensa");
   
   $checkingmatch = elgg_get_entities_from_metadata(array(
    'types' => 'object',
    'subtypes' => 'lovearrow',
    'owner_guid' => $user,
	'metadata_name_value_pair' => array(array('name' => 'name', 'value' => $elguid)),
    'count' => true
));

//check for match to notification
if ($checkingmatch != 0) {

   $amante = get_user ($user);
   $victima = get_user ($elguid); 
   $nombreamante = $amante->username;     
   $nombrevictima = $victima->username;  
   $namevictima = $victima->name;  
   $directionvictima = $victima->getURL();  
   $linkvictima = "<a href='$directionvictima'>$namevictima</a>";
   $nameamante = $amante->name;
   $directionamante = $amante->getURL();
   $linkamante = "<a href='$directionamante'>$nameamante</a>";
   $dobledireamante = "<a href='$directionamante'>$directionamante</a>";
   $dobledirevictima = "<a href='$directionvictima'>$directionvictima</a>";
  
$subject = elgg_echo('love:notification:subject', array($nameamante), $victima->language);
$summary = elgg_echo('love:notification:summary', array($linkamante, $dobledireamante ), $victima->language);
$body = elgg_echo('love:notification:body', array($linkamante, $directionamante), $victima->language);
$params = array(
        'subject' => $subject,
        'summary' => $summary,
		'body' => $body);

// Send the notification to target
notify_user($elguid, $user, $subject, $body, $params);


$sujeto = elgg_echo('love:notification:subject', array($namevictima), $amante->language);
$sumario = elgg_echo('love:notification:summary', array($linkvictima, $dobledirevictima ), $amante->language);
$cuerpo = elgg_echo('love:notification:body', array($linkvictima, $directionvictima), $amante->language);
$paramos = array(
        'subject' => $sujeto,
        'summary' => $sumario,
		'body' => $cuerpo);

// Send the notification to lover
notify_user($user, $elguid, $sujeto, $cuerpo, $paramos);

}
   forward(REFERER);
      
} else {
   $mensa = elgg_echo('love:error');
   register_error("$mensa");
   forward(REFERER); // REFERER is a global variable that defines the previous page
}