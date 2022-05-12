import asyncio
import goodwe
import json
import sys

async def get_runtime_data():
    ip_address = sys.argv[1]
    dataPath = sys.argv[2]

    inverter = await goodwe.connect(ip_address)
    sensors = inverter.sensors()

    with open(dataPath + "/sensors.json", "w") as outfile:
        json.dump(sensors, outfile, default=str)

try:
    asyncio.run(get_runtime_data())
    sys.exit(0)
except Exception:
    sys.exit(1)