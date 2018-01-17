import json
import timeit
import requests
import os
start = timeit.default_timer()
def get_bitcoin_returnop(_block_start,_block_end,_folder):
	os.mkdir(_folder)
	for i in range (_block_start,_block_end+1):
		bitcoin_block_url = 'http://api.coinsecrets.org/block/' + str(i)
		block_item =requests.get(bitcoin_block_url)
		data = block_item.json()

		#get data json from url
		json_str = json.dumps(data)
		resp = json.loads(json_str) #load json
		var = resp['timestamp'] #get data timestamp
		if not var: #if json is null
			print "data empty, Not Save"
		else :
		#with urllib.request.urlopen(bitcoin_block_url) as url:
			#data=json.loads(url.read().decode())
			file_path = _folder+'/'+str(i)+'.json'
			with open(file_path,'w')as f :
				json.dump(data, f)
				print(i)
get_bitcoin_returnop(339480,339500,'block_5_100')
stop = timeit.default_timer()
print ("RUN TIME !! : ",stop - start)

