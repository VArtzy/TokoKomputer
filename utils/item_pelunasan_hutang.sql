CREATE TABLE `item_pelunasan_hutang` (
  `NO_PELUNASAN` varchar(15) NOT NULL,
  `NOTA_BELI` varchar(15) NOT NULL,
  `NOMINAL` decimal(18,3) DEFAULT '0.000',
  `KETERANGAN` varchar(200) DEFAULT NULL,
  `DISKON` decimal(3,3) DEFAULT '0.000',
  `RETUR` decimal(18,3) DEFAULT '0.000',
  `DISKON_RP` decimal(18,3) DEFAULT '0.000'
);

ALTER TABLE `item_pelunasan_hutang`
  ADD KEY `FK_ITEM_PELUNASAN_HUTANG_1` (`NO_PELUNASAN`),
  ADD KEY `FK_ITEM_PELUNASAN_HUTANG_2` (`NOTA_BELI`);

