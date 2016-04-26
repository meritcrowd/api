<?php

include('MeritCrowdApi.php');

$api = new MeritCrowdApi(
	"3762386312",
	"a5000c28141f71f2d2e19c6d6f9562a6ac85e55f8fd5f126b74d4f888c12f606",
	"http://dev.boostcontent.com/api/"
);

// Example with subject.
//$api->addTask(562, [
//	'subject' => 'Lånebilar i Malmö'
//]);

//$api->setJobStatus(1646, 'active');

$api->setWebhook('taskFinished', 'http://dev.boostcontent.com/testarlite');

die;

// Example with keywords and anchor texts.

/*$api->addTask(JOB_ID, [
	'keywords' => 'Markduk i Östersund',
	'anchorText' => 'Markdukar',
	'anchorUrl' => 'http://www.markdukar.se'
]);*/

?>
