
require 'MeritCrowdApi'

api = MeritCrowdApi.new(
	"3845772082",
	"48bae4986d8db3b16713c81b386462564583b4efb71be24a7dddf4ac535fdb3c",
	"https://www.boostcontent.com/api/"
)

jobs = api.getJobs()
tasks = api.getTasks(jobs[0]['jobId'])

puts tasks[0]['content']

