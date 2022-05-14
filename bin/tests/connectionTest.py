import asyncio
import goodwe
import sys
import logging

async def get_runtime_data():
    ip_address = sys.argv[1]
    await goodwe.connect(ip_address)    

if sys.argv[2] == "1":
    logging.basicConfig(stream = sys.stdout, level=logging.DEBUG)

asyncio.run(get_runtime_data())