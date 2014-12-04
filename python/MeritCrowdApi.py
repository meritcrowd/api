
import urllib
import urllib2
import json
import hmac
import hashlib

class MeritCrowdApi:

	successCode = 0
	errorMissingParameter = 1
	errorInvalidNonce = 2
	errorInvalidKey = 3
	errorInvalidHmac = 4
	errorInvalidId = 5
	errorInsufficientFunds = 6

	def __init__(self, apiKey, apiSecret, endPoint):
		self.apiKey = apiKey
		self.apiSecret = apiSecret
		self.endPoint = endPoint

	def makeRequest(self, url, data):

		data = urllib.urlencode(data)
		request = urllib2.Request(url, data)
		
		try:
			response = urllib2.urlopen(request)
		except HTTPError as error:
			raise Exception('Got invalid http response, code: %d' % (error.code))
		except URLError as error:
			raise Exception('Failed to reach api server')
		else:

			body = response.read()
			data = json.loads(body)

			if data['status'] == MeritCrowdApi.successCode:
				return data['response']
			else:
				raise Exception('Invalid response. code: %d message: %s' % (data['status'], data['message']))

	def getNonce(self):
		response = self.makeRequest(self.endPoint+'getNonce', {'apiKey': self.apiKey})
		return response['nonce']

	def api(self, url, request):

		nonce = self.getNonce()
		request = json.dumps(request)

		digest = hmac.new(self.apiSecret, nonce+request, hashlib.sha256).hexdigest()

		apiData = {
			'apiKey': self.apiKey,
			'nonce': nonce,
			'hmac': digest,
			'request': request
		}
		response = self.makeRequest(url, apiData)

		return response

	def getJobs(self):
		return self.api(self.endPoint+'getJobs', {})

	def getTasks(self, jobId):
		return self.api(self.endPoint+'getTasks', {'jobId': jobId})

	def addTask(self, jobId, parameters):
		return self.api(self.endPoint+'addTask', {'jobId': jobId, 'parameters': json.dumps(parameters)})

