CREATE TABLE `wilayah` (
  `KODE` varchar(5) NOT NULL,
  `KETERANGAN` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

ALTER TABLE `wilayah`
  ADD PRIMARY KEY (`KODE`);