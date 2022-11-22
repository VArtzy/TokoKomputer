CREATE TABLE `item_beli` (
  `ID` int NOT NULL,
  `NOTA` varchar(15) NOT NULL,
  `BARANG_ID` varchar(14) NOT NULL,
  `JUMLAH` decimal(9,3) DEFAULT '0.000',
  `HARGA_BELI` decimal(18,3) DEFAULT '0.000',
  `DISKON_1` decimal(5,2) DEFAULT '0.00',
  `DISKON_2` decimal(5,2) DEFAULT '0.00',
  `DISKON_3` decimal(5,2) DEFAULT '0.00',
  `DISKON_4` decimal(5,2) DEFAULT '0.00',
  `HARGA_JUAL` decimal(18,3) DEFAULT '0.000',
  `KETERANGAN` varchar(100) NOT NULL,
  `DISKON_RP` int DEFAULT '0',
  `TGL_RETUR` date DEFAULT NULL,
  `JUMLAH2` decimal(9,3) DEFAULT '0.000',
  `MULTI_PRICE` varchar(10) DEFAULT NULL,
  `DAFTAR_SATUAN` varchar(50) DEFAULT NULL,
  `KET1` varchar(4) DEFAULT NULL,
  `KET2` varchar(4) DEFAULT NULL,
  `IMEI` varchar(50) DEFAULT NULL
) ;

ALTER TABLE `item_beli`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_ITEM_BELI_1` (`NOTA`),
  ADD KEY `FK_ITEM_BELI_2` (`BARANG_ID`);

ALTER TABLE `item_beli`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;
