CREATE TABLE `jasa` (
  `KODE` varchar(6) NOT NULL,
  `KETERANGAN` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `jasa` (`KODE`, `KETERANGAN`) VALUES
('CEKLS', 'CEK LISTRIK'),
('CEKPC', 'CEK CPU'),
('CEKPRT', 'CEK PRINTER 1');

ALTER TABLE `jasa`
  ADD PRIMARY KEY (`KODE`);