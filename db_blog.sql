-- ============================================
-- Database: db_blog
-- Export untuk UTS Pemrograman Web
-- ============================================

CREATE DATABASE IF NOT EXISTS db_blog
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE db_blog;

-- Membuat tabel penulis
CREATE TABLE penulis (
    id             INT          NOT NULL AUTO_INCREMENT,
    nama_depan     VARCHAR(100) NOT NULL,
    nama_belakang  VARCHAR(100) NOT NULL,
    user_name      VARCHAR(50)  NOT NULL,
    password       VARCHAR(255) NOT NULL,
    foto           VARCHAR(255) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uq_user_name (user_name)
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Membuat tabel kategori_artikel
CREATE TABLE kategori_artikel (
    id             INT          NOT NULL AUTO_INCREMENT,
    nama_kategori  VARCHAR(100) NOT NULL,
    keterangan     TEXT,
    PRIMARY KEY (id),
    UNIQUE KEY uq_nama_kategori (nama_kategori)
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Membuat tabel artikel
CREATE TABLE artikel (
    id           INT          NOT NULL AUTO_INCREMENT,
    id_penulis   INT          NOT NULL,
    id_kategori  INT          NOT NULL,
    judul        VARCHAR(255) NOT NULL,
    isi          TEXT         NOT NULL,
    gambar       VARCHAR(255) NOT NULL,
    hari_tanggal VARCHAR(50)  NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT fk_artikel_penulis
        FOREIGN KEY (id_penulis)
        REFERENCES penulis (id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,
    CONSTRAINT fk_artikel_kategori
        FOREIGN KEY (id_kategori)
        REFERENCES kategori_artikel (id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
