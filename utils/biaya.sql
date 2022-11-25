CREATE TABLE `biaya` (
  `KODE` varchar(6) NOT NULL,
  `KETERANGAN` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `biaya` (`KODE`, `KETERANGAN`) VALUES
('AQ', 'AIR MINUM AQUA'),
('BBP', 'BIAYA BOLPOIN'),
('BLVCR', 'BELI VOUCHER'),
('BSN', 'BELI BENSIN'),
('BYAIRG', 'BIAYA AIR GALON'),
('BYALTS', 'BIAYA ALAT2 TULIS'),
('BYKMN', 'BIAYA KEAMANAN'),
('BYKRS', 'BIAYA KRESEK PLASTIK'),
('BYKRT', 'BIAYAKARET'),
('BYKRTS', 'BIAYA KERTAS'),
('BYLL', 'BIAYA LAIN-LAIN'),
('BYOKIR', 'BIAYA ONGKIR'),
('BYPEL', 'BIAYA OBAT PELL'),
('BYRKK', 'BIAYA IURAN RKK'),
('BYSMPH', 'BIAYA SAMPAH'),
('BYTHS', 'BIAYA TEH SOSRO DAN TEBS'),
('BYTSSU', 'BIAYA TISSUE'),
('LTK', 'BIAYA LISTRIK'),
('PJK', 'BIAYA PAJAK'),
('SPU', 'BSPU');

ALTER TABLE `biaya`
  ADD PRIMARY KEY (`KODE`);
