# ChatGPT Sederhana

Proyek ini adalah implementasi sederhana dari chatbot berbasis PHP yang menyerupai ChatGPT. Chatbot ini menggunakan database untuk menyimpan pertanyaan dan jawaban, serta menerapkan teknik Information Retrieval seperti TF-IDF untuk mencocokkan pertanyaan pengguna dengan data yang ada.

## Fitur
1. **Antarmuka Chat**: Antarmuka pengguna yang menyerupai chatbox WhatsApp menggunakan Bootstrap.
2. **Riwayat Chat**: Menampilkan riwayat percakapan pengguna.
3. **Text Processing**: Preprocessing teks seperti tokenisasi dan penghapusan tanda baca.
4. **TF-IDF**: Menggunakan algoritma TF-IDF untuk mencocokkan pertanyaan pengguna dengan data di database.
5. **Personalisasi**: Menambahkan sapaan ramah di awal respons.
6. **Modularitas**: Memisahkan logika ke dalam kelas `TextProcessor` dan file CSS eksternal.

## Struktur Proyek
```
ChatGPT_Simple/
├── index.php          # File utama untuk antarmuka pengguna
├── TextProcessor.php  # Kelas untuk text processing dan TF-IDF
├── style.css          # File CSS untuk styling
├── db_connection.php  # File untuk koneksi database
├── database.sql       # Skrip SQL untuk membuat database dan tabel
├── README.md          # Dokumentasi proyek
```

## Langkah-Langkah Implementasi
1. **Membuat Antarmuka Chat**:
   - Menggunakan Bootstrap untuk membuat antarmuka chat yang responsif.
   - Menambahkan fitur auto-scroll untuk menampilkan pesan terbaru.

2. **Menambahkan Text Processing**:
   - Membuat fungsi `preprocessText` untuk membersihkan teks.
   - Membuat fungsi `calculateTFIDF` untuk menghitung skor relevansi.

3. **Memisahkan Logika**:
   - Memindahkan fungsi text processing ke dalam kelas `TextProcessor`.
   - Memisahkan CSS ke file eksternal `style.css`.

4. **Menghubungkan Database**:
   - Membuat tabel `qa` untuk menyimpan pertanyaan dan jawaban.
   - Menggunakan SQL untuk mengambil data dari database.

5. **Personalisasi dan Validasi**:
   - Menambahkan validasi untuk pertanyaan kosong.
   - Menambahkan sapaan ramah di awal respons.

## Cara Menjalankan
1. **Persiapan Database**:
   - Impor file `database.sql` ke MySQL untuk membuat database dan tabel.

2. **Konfigurasi Koneksi Database**:
   - Sesuaikan kredensial database di file `db_connection.php`.

3. **Menjalankan Aplikasi**:
   - Jalankan server web lokal (seperti XAMPP).
   - Akses file `index.php` melalui browser.

## Teknologi yang Digunakan
- **PHP**: Bahasa pemrograman untuk backend.
- **MySQL**: Database untuk menyimpan data pertanyaan dan jawaban.
- **Bootstrap**: Framework CSS untuk antarmuka pengguna.

## Pengembangan Selanjutnya
- Integrasi dengan model AI seperti GPT-3 untuk respons yang lebih dinamis.
- Menambahkan fitur pencarian fuzzy untuk menangani kesalahan pengetikan.
- Menambahkan metrik evaluasi seperti precision dan recall.

---
Dibuat pada: 17 Januari 2026