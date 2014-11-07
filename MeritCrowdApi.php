<?php

class MeritCrowdApi {

	const successCode = 0;
	const errorMissingParameter = 1;
	const errorInvalidNonce = 2;
	const errorInvalidKey = 3;
	const errorInvalidHmac = 4;
	const errorInvalidId = 5;
	const errorInsufficientFunds = 6;

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

	private function api($url, $data = array()) {

		$nonce = $this->getNonce();

		$response = $this->makeRequest($url, array_merge(array(
			'apiKey' => $this->apiKey,
			'nonce' => $nonce,
			'hmac' => hash_hmac('sha256', $nonce, $this->apiSecret)
		), $data));

		return $response;
	}

	public function getOrders() {
		return $this->api($this->endPoint.'getOrders');
	}

	public function getTasks($jobId) {
		return $this->api($this->endPoint.'getTasks', array(
			'jobId' => $jobId
		));
	}

	public function addTask($jobId, $parameters) {
		return $this->api($this->endPoint.'addTask', array(
			'jobId' => $jobId,
			'parameters' => json_encode($parameters)
		));
	}
}

?>
