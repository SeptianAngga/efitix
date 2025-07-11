import sys
import json
from datetime import datetime

# Ambil argumen dari command line
if len(sys.argv) != 4:
    print(json.dumps({"error": "Parameter tidak lengkap"}))
    sys.exit(1)

# Input dari PHP: tanggal, tipe_hari, cuaca
tanggal = sys.argv[1]  # format: YYYY-MM-DD
tipe_hari = sys.argv[2].lower()  # contoh: awal pekan
cuaca = sys.argv[3].lower()      # contoh: cerah

# ========== Step 1: Prediksi Pengunjung ==========

# Regresi Linier (Dummy): rumus sederhana
base_pengunjung = 100
tanggal_obj = datetime.strptime(tanggal, "%Y-%m-%d")
hari = tanggal_obj.weekday()  # 0=Senin, 6=Minggu
base_pengunjung += (6 - hari) * 5  # makin dekat weekend, makin ramai

# Random Forest (Dummy cuaca & tipe hari)
if "hujan" in cuaca:
    base_pengunjung -= 20
elif "berawan" in cuaca:
    base_pengunjung -= 10

if "akhir" in tipe_hari:
    base_pengunjung += 15

# KNN (Dummy dari historis)
# Misal weekend & cerah biasanya ramai → tambahkan lagi
if ("akhir" in tipe_hari and "cerah" in cuaca):
    base_pengunjung += 10

# Final jumlah pengunjung (pastikan tidak negatif)
pengunjung = max(base_pengunjung, 0)

# ========== Step 2: Rekomendasi Jumlah Pekerja ==========

tiket = round(pengunjung / 25)
validasi = round(pengunjung / 30)
kebersihan = round(pengunjung / 50)

# ========== Step 3: Outputkan se
