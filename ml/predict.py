import sys
from datetime import datetime

# Ambil argumen dari command line
try:
    tanggal = sys.argv[1]
    tipe_hari = sys.argv[2]
    cuaca = sys.argv[3]
except IndexError:
    print(0)
    sys.exit(1)

# Konversi tanggal jadi hari (Senin, Selasa, ...)
try:
    hari = datetime.strptime(tanggal, "%Y-%m-%d").strftime('%A')
except ValueError:
    print(0)
    sys.exit(1)

# Dummy logic prediksi (ganti nanti dengan ML model)
base = 100
if tipe_hari == 'Akhir Pekan':
    base += 50
elif tipe_hari == 'Hari Libur':
    base += 80

if cuaca == 'Berawan':
    base -= 20
elif cuaca == 'Hujan':
    base -= 40

# Output prediksi (harus berupa integer)
print(max(base, 0))
