CREATE TABLE `lokasi` (
  `KODE` varchar(6) NOT NULL,
  `KETERANGAN` varchar(50) DEFAULT NULL,
  `DEF` smallint DEFAULT '0'
);


ALTER TABLE `lokasi`
  ADD PRIMARY KEY (`KODE`);

