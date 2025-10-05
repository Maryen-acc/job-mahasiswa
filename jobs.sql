-- Buat database (kalau belum ada)
CREATE DATABASE IF NOT EXISTS job_mahasiswa;
USE job_mahasiswa;

-- Buat tabel jobs
CREATE TABLE IF NOT EXISTS jobs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(200) NOT NULL,
    gaji INT NOT NULL,
    kategori VARCHAR(50) NOT NULL,
    laporan TEXT,
    nohp VARCHAR(20),
    email VARCHAR(100),
    whatsapp VARCHAR(20),
    email_contact VARCHAR(100),
    ewallet VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Contoh data awal
INSERT INTO jobs (judul, gaji, kategori, laporan, nohp, email, whatsapp, email_contact, ewallet) 
VALUES 
('Minta Tanda Tangan Staf Fakultas Teknik', 10000, 'LAPORAN', 'Butuh tanda tangan staf untuk laporan', '08123456789', 'staff@example.com', '08123456789', 'kontak@example.com', 'Dana - 08123456789'),
('Laporan Skripsi (Perikanan)', 25000, 'LAPORAN', 'Laporan hasil perkuliahan semester 3', '08234567890', 'mahasiswa@example.com', '08234567890', 'mahasiswa@example.com', 'OVO - 08234567890');
