CREATE TABLE `salesman` (
  `KODE` varchar(10) NOT NULL,
  `NAMA` varchar(30) DEFAULT NULL,
  `ALAMAT` varchar(50) DEFAULT NULL,
  `TELEPON` varchar(20) DEFAULT NULL,
  `ALAMAT2` varchar(50) DEFAULT NULL,
  `TELEPON2` varchar(20) DEFAULT NULL,
  `NO_REKENING` varchar(20) DEFAULT NULL,
  `URUT` smallint DEFAULT NULL,
  `PLAFON_PIUTANG` int DEFAULT '0',
  `TOTAL_PIUTANG` decimal(18,2) DEFAULT '0.00',
  `TOTAL_PEMBAYARAN_PIUTANG` decimal(18,2) DEFAULT '0.00',
  `TOTAL_NOTA_PENJUALAN` bigint DEFAULT NULL,
  `TOTAL_ITEM_PENJUALAN` bigint DEFAULT NULL,
  `OPERATOR_ID` varchar(15) DEFAULT NULL,
  `id` int NOT NULL,
  `KODE_BARCODE` varchar(10) NOT NULL
);

ALTER TABLE `salesman`
  ADD PRIMARY KEY (`KODE`),
  ADD KEY `FK_SALESMAN` (`OPERATOR_ID`);

ALTER TABLE `salesman`
  ADD CONSTRAINT `FK_SALESMAN` FOREIGN KEY (`OPERATOR_ID`) REFERENCES `user_admin` (`NAMA`) ON DELETE CASCADE ON UPDATE CASCADE;
