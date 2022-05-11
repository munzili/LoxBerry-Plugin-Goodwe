import asyncio
import goodwe
import json
import subprocess
import os
import tempfile
import sys

async def get_runtime_data():
    ip_address = sys.argv[1]
    dataPath = sys.argv[2]

    inverter = await goodwe.connect(ip_address)
    runtime_data = await inverter.read_runtime_data()

    with open(dataPath + "/data.json", "w") as outfile:
        json.dump(runtime_data, outfile, default=str)

asyncio.run(get_runtime_data())