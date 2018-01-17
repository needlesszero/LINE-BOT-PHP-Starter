import json
import timeit
import requests
import os
start = timeit.default_timer()
cNull = 0
cSave = 0
def set_Null():
	global cNull    # Needed to modify global copy of globvar
	cNull += 1
def set_Save():
	global cSave   # Needed to modify global copy of globvar
	cSave += 1

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
			set_Null()
			print i," data empty, Not Save"
			global cNull
			
		else :
			set_Save()
		#with urllib.request.urlopen(bitcoin_block_url) as url:
			#data=json.loads(url.read().decode())
			file_path = _folder+'/'+str(i)+'.json'
			with open(file_path,'w')as f :
				json.dump(data, f)
				print i," Save"
				

	
get_bitcoin_returnop(349850,349900,'block_0_100')
stop = timeit.default_timer()
print ("Data : ",cSave," Data Block and ",cNull," Data Null")
print ("RUN TIME !! : ",stop - start)

