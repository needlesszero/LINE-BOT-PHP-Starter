import requests
import json

count = 5
while count > 3:
	y = str(count)
	solditems = requests.get('http://api.coinsecrets.org/block/40441'+y) # (your url)
	count -=1
	data = solditems.json()
	with open('data'+y+'.json', 'w') as f:
	    json.dump(data, f)