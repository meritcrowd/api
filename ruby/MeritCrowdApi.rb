
require "net/https"
require "uri"
require 'rubygems'
require 'json'
require 'openssl'

class MeritCrowdApi

	@@successCode = 0
	@@errorMissingParameter = 1
	@@errorInvalidNonce = 2
	@@errorInvalidKey = 3
	@@errorInvalidHmac = 4
	@@errorInvalidId = 5
	@@errorInsufficientFunds = 6

	def initialize(apiKey, apiSecret, endPoint)
		@apiKey = apiKey
		@apiSecret = apiSecret
		@endPoint = endPoint
	end

	def makeRequest(url, data)

		url = URI.parse(url)
		response = Net::HTTP.post_form(url, data)

		if response['code'] = 200
			response = JSON.parse(response.body())

			if response['status'] != @@successCode
				raise printf("Invalid response. code: %d message: %s", response['status'], response['message'])
			end

			return response['response']
		else
			raise printf("Got invalid http response: %d", response['code'])
		end
	end

	def getNonce()
		response = makeRequest(@endPoint+"getNonce", {
			"apiKey" => @apiKey
		});

		return response['nonce']
	end

	def api(url, request)

		nonce = getNonce()
		request = JSON.generate(request)
		digest = OpenSSL::Digest.new('sha256')
		apiData = {
			"apiKey" => @apiKey,
			"nonce" => nonce,
			"hmac" => OpenSSL::HMAC.hexdigest(digest, @apiSecret, nonce+request),
			"request" => request
		}
		response = makeRequest(url, apiData)

		return response
	end

	def getJobs()
		return api(@endPoint+"getJobs", {})
	end

	def getTasks(jobId)
		return api(@endPoint+"getTasks", {"jobId" => jobId})
	end

	def addTask(jobId, parameters)
		return api(@endPoint+"addTask", {"jobId" => jobId, "parameters" => JSON.generate(parameters)})
	end
end

