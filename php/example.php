<?php

include('MeritCrowdApi.php');

$api = new MeritCrowdApi(
	"3845772082",
	"48bae4986d8db3b16713c81b386462564583b4efb71be24a7dddf4ac535fdb3c",
	"https://www.boostcontent.com/api/"
);

$jobs = $api->getJobs();
$tasks = $api->getTasks($jobs[0]->jobId);

$api->addTask($jobs[0]->jobId, array(
	'Keywords' => 'Keyword1, Keyword2',
	'Link Text' => 'Anchor Text',
	'Link URL' => 'http://example.com',
	'_myCustomId' => 42
));

?>
