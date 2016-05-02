<?php

include('MeritCrowdApi.php');

$api = new MeritCrowdApi(
	"__API_KEY__",
	"__API_SECRET__",
	"http://preview.dev.boostcontent.com/api/"
);

$jobs = $api->getJobs();
$jobTemplates = $api->getJobTemplates();
$tasks = $api->getTasks($jobs[0]->jobId);
$languages = $api->getRealms();

$template = $jobTemplates[0];
$language = $languages[0];

$jobId = $api->createNewJob('Josefs testjobb', $template->jobTemplateId, 600, $language->realmId,
	$language->teamId, 1);

$job = $api->getJob($jobId);

$api->addTask($job->jobId, [
	'Subject' => 'Detta är subject 1'
]);
$api->addTask($job->jobId, [
	'Subject' => 'Detta är subject 2'
]);

$api->enableNewJob($job->jobId);

?>
