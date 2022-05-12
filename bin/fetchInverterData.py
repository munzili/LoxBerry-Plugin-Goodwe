import asyncio
import goodwe
import json
import sys

async def get_runtime_data():
    ip_address = sys.argv[1]

    inverter = await goodwe.connect(ip_address)
    runtime_data = await inverter.read_runtime_data()

    json.dump(runtime_data, sys.stdout, default=str)

try:
    asyncio.run(get_runtime_data())
    sys.exit(0)
except Exception:
    sys.exit(1)