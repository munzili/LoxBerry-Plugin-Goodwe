import asyncio
import goodwe
import json
import sys
import logging

async def get_runtime_data():
    result = await goodwe.search_inverters()
    data = result.decode("utf-8").split(",")
    json.dump(data, sys.stdout, default=str)

if sys.argv[1] == "1":
    logging.basicConfig(stream = sys.stdout, level=logging.DEBUG)

asyncio.run(get_runtime_data())