
-- Tabel `lagu`

CREATE TABLE `lagu` (
  `id` int(10) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `penyanyi` varchar(255) NOT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `filemp3` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data tabel `lagu`

INSERT INTO `lagu` (`id`, `judul`, `penyanyi`, `cover`, `filemp3`) VALUES
(1, 'Dear God', 'Avenged Sevenfold', 'Dear_God.jpg', 'Dear God.mp3'),
(2, "Don't Look Back In Anger", 'Oasis', "Don't_Look_Back_In_Anger.jpg", "Don't Look Back In Anger.mp3"),
(3, 'Kuning', 'rumahsakit', 'Kuning.jpg', 'Kuning.mp3'),
(4, 'Last Night on Earth', 'Green Day', 'Last_Night_on_Earth.jpeg', 'Last Night on Earth.mp3'),
(5, 'Terlatih Patah Hati', 'The Rain', 'Terlatih_Patah_Hati.jpg', 'Terlatih Patah Hati.mp3');


-- Tabel `users`
CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `peran` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Buat data di tabel `users`

INSERT INTO `users` (`id`, `username`, `password`, `peran`) VALUES
(1, 'admin', '$2y$10$FM.ftUoKqlKfkDw9MDqiFegZoT9bXg8e060HHFkg2fZLQ579SL6DG', 'admin'),
(2, 'user', '$2y$10$KRBmvYT4xz2tqj83o5xlp.twr44rMM4F4xT3uH4Eres4pHa8mqvB6', 'user');

-- Index tabel `lagu`
ALTER TABLE `lagu`
  ADD PRIMARY KEY (`id`);

-- Index tabel `users`
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

-- AUTO_INCREMENT tabel `lagu`
ALTER TABLE `lagu`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

