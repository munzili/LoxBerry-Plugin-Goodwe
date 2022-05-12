import asyncio
import goodwe
import sys
import os
import json

try:
    result = asyncio.run(goodwe.search_inverters()).decode("utf-8").split(",")
    json.dump(result)
    sys.exit(0)
except Exception:
    sys.exit(1)