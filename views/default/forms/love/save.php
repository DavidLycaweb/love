<?php
$elguid = elgg_get_page_owner_guid();
$eluno = elgg_view('input/hidden',array('name' => 'elguid', 'value' =>$elguid)); 
$eluser = elgg_get_logged_in_user_guid();
$mylove = elgg_get_entities_from_metadata(array(
    'types' => 'object',
    'subtypes' => 'lovearrow',
    'owner_guid' => $elguid,
	'metadata_name_value_pair' => array(array('name' => 'name', 'value' => $eluser)),
    'count' => true
));

if ($mylove != 0) {
$elotro = elgg_view('input/submit', array('value' => elgg_echo('remove:love:here')));
echo "
<style>
.lovespace .elgg-form-love-save input.elgg-button {
background:#d21414!important;
}
</style>
";
}
else {
$elotro = elgg_view('input/submit', array('value' => elgg_echo('love:here')));
}
$rollo = "<div>$eluno</div><div>$elotro</div>"; 
echo $rollo;


