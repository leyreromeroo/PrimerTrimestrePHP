-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS LaLiga
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

USE LaLiga;

-- =========================================================
-- Tabla: equipos
-- =========================================================
CREATE TABLE equipos (
  id_equipo INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL UNIQUE,
  estadio VARCHAR(100) NOT NULL
);

-- =========================================================
-- Tabla: partidos
-- =========================================================
CREATE TABLE partidos (
  id_partido INT AUTO_INCREMENT PRIMARY KEY,
  id_local INT NOT NULL,
  id_visitante INT NOT NULL,
  jornada INT NOT NULL,
  resultado ENUM('1','X','2') NOT NULL,
  estadio VARCHAR(100) NOT NULL,
  FOREIGN KEY (id_local) REFERENCES equipos(id_equipo) ON DELETE CASCADE,
  FOREIGN KEY (id_visitante) REFERENCES equipos(id_equipo) ON DELETE CASCADE,
  CONSTRAINT partidos_unicos UNIQUE (id_local, id_visitante)
);

-- =========================================================
-- Datos iniciales
-- =========================================================
INSERT INTO equipos (nombre, estadio) VALUES
('Real Madrid', 'Santiago Bernabéu'),
('FC Barcelona', 'Spotify Camp Nou'),
('Atlético de Madrid', 'Cívitas Metropolitano'),
('Athletic Club', 'San Mamés'),
('Real Sociedad', 'Reale Arena'),
('Sevilla FC', 'Ramón Sánchez Pizjuán');

-- =========================================================
-- Partidos de ejemplo
-- =========================================================
INSERT INTO partidos (id_local, id_visitante, jornada, resultado, estadio) VALUES
(1, 2, 1, '1', 'Santiago Bernabéu'),
(3, 4, 1, 'X', 'Cívitas Metropolitano'),
(5, 6, 1, '2', 'Reale Arena'),
(2, 3, 2, '2', 'Spotify Camp Nou'),
(4, 5, 2, '1', 'San Mamés');
