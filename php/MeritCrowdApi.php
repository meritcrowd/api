<?php

class MeritCrowdApi {

	const successCode = 0;
	const errorMissingParameter = 1;
	const errorInvalidNonce = 2;
	const errorInvalidKey = 3;
	const errorInvalidHmac = 4;
	const errorInvalidId = 5;
	const errorInsufficientFunds = 6;
	const errorInvalidParameter = 7;
	const errorDeprecated = 8;
	const errorMissing = 9;

	private $endPoint;
	private $apiKey;
	private $apiSecret;
	private $curl;
	private $nonce;

	public function __construct($apiKey, $apiSecret, $endPoint) {
		$this->apiKey = $apiKey;
		$this->apiSecret = $apiSecret;
		$this->endPoint = $endPoint;

		$this->curl = curl_init();
	}

	public function __destruct() {
		curl_close($this->curl);
	}

	public function makeRequest($url, $data) {

		curl_setopt($this->curl, CURLOPT_URL, $url);
		curl_setopt($this->curl, CURLOPT_POST, 1);
		curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);

		$response = curl_exec($this->curl);

		$code = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
		if ($code == 200) {
			$response = json_decode($response);

			if ($response->status != 0) {
				throw new Exception(sprintf("Invalid response. code: %d message: %s", $response->status,
					$response->message));
			}
			return $response->response;
		} else {
			throw new Exception(sprintf("Got invalid http response: %d", $code));
		}
	}

	public function getNonce() {
		$response = $this->makeRequest($this->endPoint.'getNonce', array(
			'apiKey' => $this->apiKey
		));

		return $response->nonce;
	}

	private function api($url, $request = array()) {

		$nonce = $this->getNonce();

		$json = json_encode($request);
		$response = $this->makeRequest($url, array(
			'apiKey' => $this->apiKey,
			'nonce' => $nonce,
			'hmac' => hash_hmac('sha256', $nonce.$json, $this->apiSecret),
			'request' => $json
		));

		return $response;
	}

	public function getJobTemplates() {
		return $this->api($this->endPoint . 'getJobTemplates');
	}

	public function getJobs() {
		return $this->api($this->endPoint . 'getJobs');
	}

	public function getJob($jobId) {
		return $this->api($this->endPoint . 'getJob', [
			'jobId' => $jobId
		]);
	}

	public function getTasks($jobId) {
		return $this->api($this->endPoint.'getTasks', array(
			'jobId' => $jobId
		));
	}

	public function getTask($taskId) {
		return $this->api($this->endPoint.'getTask', array(
			'taskId' => $taskId
		));
	}

	public function addTask($jobId, $parameters) {
		return $this->api($this->endPoint.'addTask', array(
			'jobId' => $jobId,
			'parameters' => json_encode($parameters)
		));
	}

	public function createNewJob($jobName, $jobTemplateId, $minWordCount, $realmId, $teamId) {
		return $this->api($this->endPoint . 'createJob', [
			'jobName' => $jobName,
			'jobTemplateId' => $jobTemplateId,
			'minWordCount' => $minWordCount,
			'realmId' => $realmId,
			'teamId' => $teamId
		]);
	}

	public function getFunds() {
		return $this->api($this->endPoint.'getFunds');
	}

	public function getRealms($realmType = 'language') {
		return $this->api($this->endPoint . 'getRealms', [
			'realmType' => $realmType
		]);
	}

	public function getWebhook($action) {
		return $this->api($this->endPoint.'getWebhook', [
			'action' => $action
		]);
	}

	public function setWebhook($action, $url) {
		return $this->api($this->endPoint.'setWebhook', [
			'action' => $action,
			'url' => $url
		]);
	}

	public function setJobStatus($jobId, $status) {
		return $this->api($this->endPoint.'setJobStatus', array(
			'jobId' => $jobId,
			'status' => $status
		));
	}

	public function enableNewJob($jobId) {
		return $this->api($this->endPoint . 'enableNewJob', [
			'jobId' => $jobId
		]);
	}
}

?>
