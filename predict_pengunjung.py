# predict_pengunjung.py
import json
from datetime import datetime

# Dummy logic sementara
hasil = {
    "tanggal": datetime.now().strftime("%Y-%m-%d"),
    "cuaca": "Clear",
    "jumlah_pengunjung": 120
}

print(json.dumps(hasil))
