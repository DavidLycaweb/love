<?php 


$stalkers = elgg_get_entities(array(
	'types' => 'object',
	'subtypes' => 'lovearrow',
	'owner_guid' => elgg_get_page_owner_guid(),
	'count' => true
));


if ($stalkers != 0){
echo "<style> div.karmacounter { background:#ce061e!important; } </style>";
}

$pre = elgg_echo('pre:tendientes');
	 
echo <<<HTML
	 
	 <script>
$( document ).ready(function() {   
	$('.elgg-avatar-large').append('<div class="lovecounter">$stalkers<span class="lett">$pre</span></div>');		
});
</script>

HTML;


