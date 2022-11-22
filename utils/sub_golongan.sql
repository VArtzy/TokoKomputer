CREATE TABLE `sub_golongan` (
  `KODE` varchar(6) NOT NULL,
  `KETERANGAN` varchar(50) DEFAULT NULL
);

ALTER TABLE `sub_golongan`
  ADD PRIMARY KEY (`KODE`);

