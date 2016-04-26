
from MeritCrowdApi import *

api = MeritCrowdApi(
	"3845772082",
	"48bae4986d8db3b16713c81b386462564583b4efb71be24a7dddf4ac535fdb3c",
	"http://www.boostcontent.com/api/"
)

jobs = api.getJobs()
tasks = api.getTasks(jobs[0]['jobId'])

print tasks[0]['content']

