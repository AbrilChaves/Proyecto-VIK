-- Creación de la base de datos
CREATE DATABASE Vik_database;
USE Vik_database;


CREATE TABLE Usuarios (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    correo VARCHAR(100) UNIQUE NOT NULL,
    contraseña VARCHAR(255) NOT NULL,
    rol ENUM('normal', 'admin') NOT NULL DEFAULT 'normal';
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE Posts (
    id_post INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT,
    titulo VARCHAR(255) NOT NULL,
    contenido TEXT NOT NULL,
    fecha_publicacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario) ON DELETE SET NULL
);


CREATE TABLE Comentarios (
    id_comentario INT PRIMARY KEY AUTO_INCREMENT,
    id_post INT,
    id_usuario INT,
    contenido TEXT NOT NULL,
    fecha_comentario TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_post) REFERENCES Posts(id_post) ON DELETE CASCADE,
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario) ON DELETE SET NULL
);


CREATE TABLE Eventos (
    id_evento INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(255) NOT NULL,
    lugar VARCHAR(255) NOT NULL,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    descripcion TEXT
);


CREATE TABLE Suscriptores (
    id_suscriptor INT PRIMARY KEY AUTO_INCREMENT,
    correo VARCHAR(100) UNIQUE NOT NULL,
    fecha_suscripcion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE RedesSociales (
    id_red INT PRIMARY KEY AUTO_INCREMENT,
    nombre_red VARCHAR(50) NOT NULL,
    url VARCHAR(255) NOT NULL
);


CREATE TABLE Multimedia (
    id_multimedia INT PRIMARY KEY AUTO_INCREMENT,
    tipo ENUM('video', 'musica') NOT NULL,
    titulo VARCHAR(255) NOT NULL,
    url VARCHAR(255) NOT NULL,
    fecha_agregado TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE Discografia (
    id_disco INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(255) NOT NULL,
    tipo ENUM('LP', 'EP', 'Single') NOT NULL,
    url_spotify VARCHAR(255) NOT NULL,
    fecha_lanzamiento DATE NOT NULL
);


CREATE TABLE Merch (
    id_merch INT PRIMARY KEY AUTO_INCREMENT,
    nombre_producto VARCHAR(255) NOT NULL,
    descripcion TEXT NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    url_imagen VARCHAR(255)
);


CREATE TABLE Donaciones (
    id_donacion INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT,
    monto DECIMAL(10, 2) NOT NULL,
    fecha_donacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario) ON DELETE SET NULL
);


CREATE TABLE MiembrosBanda (
    id_miembro INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    rol VARCHAR(100) NOT NULL,
    biografia TEXT,
    foto_url VARCHAR(255)
);


CREATE TABLE Interacciones (
    id_interaccion INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT,
    tipo_interaccion ENUM('like_post', 'comentario_post', 'suscripcion_newsletter', 'donacion') NOT NULL,
    id_referencia INT,
    fecha_interaccion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario) ON DELETE SET NULL
);
