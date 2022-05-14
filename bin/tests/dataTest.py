import asyncio
import goodwe
import json
import sys
import logging

async def get_runtime_data():
    ip_address = sys.argv[1]

    inverter = await goodwe.connect(ip_address)
    runtime_data = await inverter.read_runtime_data()

    json.dump(runtime_data, sys.stdout, default=str)

if sys.argv[2] == "1":
    logging.basicConfig(stream = sys.stdout, level=logging.DEBUG)

asyncio.run(get_runtime_data())