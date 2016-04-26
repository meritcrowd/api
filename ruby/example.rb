
require 'MeritCrowdApi'

api = MeritCrowdApi.new(
	"341094006588",
	"e042b47f3e88ef10e7c76f1c9d8842403669e927dab4cd0757572b229330674f",
	"http://www.boostcontent.com/api/"
)

jobs = api.getJobs()
tasks = api.getTasks(jobs[0]['jobId'])

puts tasks[0]['content']

