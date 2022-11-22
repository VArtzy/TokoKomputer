CREATE TABLE `golongan` (
  `KODE` varchar(6) NOT NULL,
  `KETERANGAN` varchar(50) DEFAULT NULL
) ;

ALTER TABLE `golongan`
  ADD PRIMARY KEY (`KODE`);

