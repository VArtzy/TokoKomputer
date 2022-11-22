
CREATE TABLE `multi_price` (
  `KODE` int NOT NULL,
  `KODE_SATUAN` int NOT NULL,
  `CUSTOMER_ID` varchar(10) DEFAULT NULL,
  `BARANG_ID` varchar(25) NOT NULL,
  `HARGA_KE` smallint NOT NULL,
  `JUMLAH_R1` decimal(9,3) DEFAULT NULL,
  `JUMLAH_R2` decimal(9,3) DEFAULT NULL,
  `HARGA_JUAL` decimal(18,3) DEFAULT NULL
) ;


INSERT INTO `multi_price` (`KODE`, `KODE_SATUAN`, `CUSTOMER_ID`, `BARANG_ID`, `HARGA_KE`, `JUMLAH_R1`, `JUMLAH_R2`, `HARGA_JUAL`) VALUES
(1, 1, '', '123018', 1, '1.000', '1000.000', '75000.000'),
(2, 1, '', '20101015000005', 1, '1.000', '1000.000', '25000.000'),
(3, 1, '', '20101015000006', 1, '1.000', '1000.000', '10000.000'),
(4, 1, '', '20101025000121', 1, '1.000', '1000.000', '15000.000'),
(5, 1, '', '20101026000135', 1, '1.000', '1000.000', '80000.000'),
(6, 1, '', '20101026000137', 1, '1.000', '1000.000', '45000.000'),
(7, 2, '', '20101026000138', 1, '1.000', '1000.000', '40000.000'),
(8, 1, '', '20101026000139', 1, '1.000', '1000.000', '35000.000'),
(9, 1, '', '20101026000142', 1, '1.000', '1000.000', '120000.000'),
(10, 1, '', '20101026000143', 1, '1.000', '1000.000', '25000.000'),
(11, 1, '', '20101026000148', 1, '1.000', '1000.000', '3000.000'),
(12, 1, '', '20101026000149', 1, '1.000', '1000.000', '4000.000'),
(13, 1, '', '20101026000150', 1, '1.000', '1000.000', '25000.000'),
(14, 1, '', '20101026000151', 1, '1.000', '1000.000', '25000.000'),
(15, 1, '', '20101030000019', 1, '1.000', '1000.000', '155000.000'),
(16, 1, '', '20101030000020', 1, '1.000', '1000.000', '185000.000'),
(17, 1, '', '20101030000021', 1, '1.000', '1000.000', '95000.000'),
(18, 1, '', '20101030000023', 1, '1.000', '1000.000', '180000.000'),
(19, 1, '', '20101101000153', 1, '1.000', '1000.000', '105000.000'),
(20, 1, '', '20101101000157', 1, '1.000', '1000.000', '220000.000'),
(21, 1, '', '20101101000159', 1, '1.000', '1000.000', '280000.000'),
(22, 1, '', '20101101000162', 1, '1.000', '1000.000', '90000.000'),
(23, 1, '', '20101101000163', 1, '1.000', '1000.000', '90000.000'),
(24, 1, '', '20101101000168', 1, '1.000', '1000.000', '575000.000'),
(25, 1, '', '20101101000175', 1, '1.000', '1000.000', '1475000.000'),
(26, 1, '', '20101101000178', 1, '1.000', '1000.000', '2000.000'),
(27, 1, '', '20101101000179', 1, '1.000', '1000.000', '325000.000'),
(28, 1, '', '20101101000180', 1, '1.000', '1000.000', '70000.000'),
(29, 1, '', '20101101000188', 1, '1.000', '1000.000', '130000.000'),
(30, 1, '', '20101101000190', 1, '1.000', '1000.000', '90000.000'),
(31, 1, '', '20101102000025', 1, '1.000', '1000.000', '250000.000'),
(32, 1, '', '20101102000026', 1, '1.000', '1000.000', '50000.000'),
(33, 1, '', '20101102000027', 1, '1.000', '1000.000', '20000.000'),
(34, 1, '', '20101102000031', 1, '1.000', '1000.000', '95000.000'),
(35, 1, '', '20101102000033', 1, '1.000', '1000.000', '30000.000'),
(36, 1, '', '20101102000035', 1, '1.000', '1000.000', '150000.000'),
(37, 1, '', '20101102000036', 1, '1.000', '1000.000', '6000.000'),
(38, 1, '', '20101102000041', 1, '1.000', '1000.000', '10000.000'),
(39, 1, '', '20101102000049', 1, '1.000', '1000.000', '60000.000'),
(40, 1, '', '20101102000056', 1, '1.000', '1000.000', '50000.000'),
(41, 1, '', '20101115000063', 1, '1.000', '1000.000', '575000.000'),
(42, 1, '', '20101116000072', 1, '1.000', '1000.000', '115000.000'),
(43, 1, '', '20101116000073', 1, '1.000', '1000.000', '80000.000'),
(44, 1, '', '20101116000086', 1, '1.000', '1000.000', '65000.000'),
(45, 1, '', '20101116000090', 1, '1.000', '1000.000', '450000.000'),
(46, 1, '', '20101116000095', 1, '1.000', '1000.000', '45000.000'),
(47, 1, '', '20101116000096', 1, '1.000', '1000.000', '2000.000'),
(48, 1, '', '20101116000098', 1, '1.000', '1000.000', '150000.000'),
(49, 1, '', '20101116000102', 1, '1.000', '1000.000', '230000.000'),
(50, 1, '', '20101116000103', 1, '1.000', '1000.000', '225000.000'),
(51, 1, '', '20101116000106', 1, '1.000', '1000.000', '725000.000'),
(52, 1, '', '20101116000107', 1, '1.000', '1000.000', '1125000.000'),
(53, 1, '', '20101116000113', 1, '1.000', '1000.000', '150000.000'),
(54, 1, '', '20101129000205', 1, '1.000', '1000.000', '25000.000'),
(55, 1, '', '20101214000217', 1, '1.000', '1000.000', '6500.000'),
(56, 1, '', '20110131000231', 1, '1.000', '1000.000', '950000.000'),
(57, 1, '', '20110504000246', 1, '1.000', '1000.000', '50000.000'),
(58, 1, '', '20110504000247', 1, '1.000', '1000.000', '285000.000'),
(59, 1, '', '20110531000269', 1, '1.000', '1000.000', '25000.000'),
(60, 1, '', '20110531000271', 1, '1.000', '1000.000', '5000.000'),
(61, 1, '', '20110531000273', 1, '1.000', '1000.000', '100000.000'),
(62, 1, '', '20110531000274', 1, '1.000', '1000.000', '125000.000'),
(63, 1, '', '20110531000278', 1, '1.000', '1000.000', '15000.000'),
(64, 1, '', '20110531000281', 1, '1.000', '1000.000', '25000.000'),
(65, 1, '', '20110531000287', 1, '1.000', '1000.000', '75000.000'),
(66, 1, '', '20110531000293', 1, '1.000', '1000.000', '30000.000'),
(67, 1, '', '20110531000294', 1, '1.000', '1000.000', '30000.000'),
(68, 1, '', '20110531000295', 1, '1.000', '1000.000', '45000.000'),
(69, 1, '', '20110531000300', 1, '1.000', '1000.000', '3000.000'),
(70, 1, '', '20110603000301', 1, '1.000', '1000.000', '275000.000'),
(71, 1, '', '20110702000307', 1, '1.000', '1000.000', '70000.000'),
(72, 1, '', '20110709000312', 1, '1.000', '1000.000', '255000.000'),
(73, 1, '', '20110815000320', 1, '1.000', '1000.000', '400000.000'),
(74, 1, '', '20110913000324', 1, '1.000', '1000.000', '20000.000'),
(75, 1, '', '20110913000325', 1, '1.000', '1000.000', '35000.000'),
(76, 1, '', '20110913000330', 1, '1.000', '1000.000', '10000.000'),
(77, 1, '', '20110913000333', 1, '1.000', '1000.000', '70000.000'),
(78, 1, '', '20110913000336', 1, '1.000', '1000.000', '280000.000'),
(79, 1, '', '20110913000338', 1, '1.000', '1000.000', '80000.000'),
(80, 1, '', '20110913000340', 1, '1.000', '1000.000', '180000.000'),
(81, 1, '', '20110913000342', 1, '1.000', '1000.000', '65000.000'),
(82, 1, '', '20110913000350', 1, '1.000', '1000.000', '25000.000'),
(83, 1, '', '20110913000356', 1, '1.000', '1000.000', '60000.000'),
(84, 1, '', '20110913000359', 1, '1.000', '1000.000', '120000.000'),
(85, 1, '', '20110918000360', 1, '1.000', '1000.000', '75000.000'),
(86, 1, '', '20110918000361', 1, '1.000', '1000.000', '235000.000'),
(87, 1, '', '20110918000362', 1, '1.000', '1000.000', '40000.000'),
(88, 1, '', '20110918000366', 1, '1.000', '1000.000', '70000.000'),
(89, 1, '', '20110918000372', 1, '1.000', '1000.000', '25000.000'),
(90, 1, '', '20110918000375', 1, '1.000', '1000.000', '20000.000'),
(91, 1, '', '20110918000376', 1, '1.000', '1000.000', '95000.000'),
(92, 1, '', '20110918000377', 1, '1.000', '1000.000', '80000.000'),
(93, 1, '', '20110918000383', 1, '1.000', '1000.000', '50000.000'),
(94, 1, '', '20111103000394', 1, '1.000', '1000.000', '4000.000'),
(95, 1, '', '20111110000398', 1, '1.000', '1000.000', '300000.000'),
(96, 3, '', '20111110000399', 1, '1.000', '1000.000', '0.000'),
(97, 1, '', '20111115000402', 1, '1.000', '1000.000', '35000.000'),
(98, 1, '', '20111203000416', 1, '1.000', '1000.000', '135000.000'),
(99, 1, '', '20111203000417', 1, '1.000', '1000.000', '20000.000'),
(100, 1, '', '20111214000423', 1, '1.000', '1000.000', '35000.000'),
(101, 2, '', '20111214000424', 1, '1.000', '1000.000', '40000.000'),
(102, 1, '', '20111222000435', 1, '1.000', '1000.000', '25000.000'),
(103, 1, '', '20120121000446', 1, '1.000', '1000.000', '85000.000'),
(104, 1, '', '20120121000447', 1, '1.000', '1000.000', '35000.000'),
(105, 1, '', '20120121000448', 1, '1.000', '1000.000', '1000.000'),
(106, 1, '', '20120301000482', 1, '1.000', '1000.000', '140000.000'),
(107, 1, '', '20120301000483', 1, '1.000', '1000.000', '190000.000'),
(108, 1, '', '20120301000485', 1, '1.000', '1000.000', '30000.000'),
(109, 1, '', '20120301000491', 1, '1.000', '1000.000', '25000.000'),
(110, 1, '', '20120301000495', 1, '1.000', '1000.000', '100000.000'),
(111, 1, '', '20120301000497', 1, '1.000', '1000.000', '200000.000'),
(112, 1, '', '20120301000499', 1, '1.000', '1000.000', '75000.000'),
(113, 1, '', '20120305000507', 1, '1.000', '1000.000', '50000.000'),
(114, 2, '', '20120306000512', 1, '1.000', '1000.000', '40000.000'),
(115, 2, '', '20120306000513', 1, '1.000', '1000.000', '40000.000'),
(116, 1, '', '20120306000514', 1, '1.000', '1000.000', '40000.000'),
(117, 2, '', '20120316000521', 1, '1.000', '1000.000', '40000.000'),
(118, 1, '', '20120316000524', 1, '1.000', '1000.000', '6000.000'),
(119, 1, '', '20120325000530', 1, '1.000', '1000.000', '35000.000'),
(120, 1, '', '20120330000537', 1, '1.000', '1000.000', '35000.000'),
(121, 1, '', '20120429000556', 1, '1.000', '1000.000', '35000.000'),
(122, 1, '', '20120429000559', 1, '1.000', '1000.000', '95000.000'),
(123, 1, '', '20120429000560', 1, '1.000', '1000.000', '75000.000'),
(124, 1, '', '20120429000564', 1, '1.000', '1000.000', '400000.000'),
(125, 1, '', '20120429000568', 1, '1.000', '1000.000', '80000.000'),
(126, 1, '', '20120429000570', 1, '1.000', '1000.000', '20000.000'),
(127, 1, '', '20120429000571', 1, '1.000', '1000.000', '15000.000'),
(128, 1, '', '20120429000574', 1, '1.000', '1000.000', '95000.000'),
(129, 1, '', '20120429000576', 1, '1.000', '1000.000', '150000.000'),
(130, 1, '', '20120429000579', 1, '1.000', '1000.000', '2200000.000'),
(131, 2, '', '20120429000580', 1, '1.000', '1000.000', '40000.000'),
(132, 1, '', '20120429000581', 1, '1.000', '1000.000', '20000.000'),
(133, 2, '', '20120429000582', 1, '1.000', '1000.000', '40000.000'),
(134, 2, '', '20120429000583', 1, '1.000', '1000.000', '40000.000'),
(135, 1, '', '20120429000584', 1, '1.000', '1000.000', '35000.000'),
(136, 1, '', '20120429000586', 1, '1.000', '1000.000', '3500.000'),
(137, 1, '', '20120429000587', 1, '1.000', '1000.000', '20000.000'),
(138, 1, '', '20120429000589', 1, '1.000', '1000.000', '2600000.000'),
(139, 1, '', '20120429000591', 1, '1.000', '1000.000', '250000.000'),
(140, 1, '', '20120429000604', 1, '1.000', '1000.000', '250000.000'),
(141, 1, '', '20120429000623', 1, '1.000', '1000.000', '90000.000'),
(142, 1, '', '20120429000625', 1, '1.000', '1000.000', '315000.000'),
(143, 1, '', '20120429000629', 1, '1.000', '1000.000', '1000000.000'),
(144, 1, '', '20120429000633', 1, '1.000', '1000.000', '100000.000'),
(145, 1, '', '20120429000641', 1, '1.000', '1000.000', '250000.000'),
(146, 1, '', '20120429000642', 1, '1.000', '1000.000', '0.000'),
(147, 1, '', '20120429000645', 1, '1.000', '1000.000', '825000.000'),
(148, 1, '', '20120429000646', 1, '1.000', '1000.000', '90000.000'),
(149, 1, '', '20120429000647', 1, '1.000', '1000.000', '90000.000'),
(150, 1, '', '20120429000651', 1, '1.000', '1000.000', '150000.000'),
(151, 1, '', '20120501000553', 1, '1.000', '1000.000', '3500.000'),
(152, 1, '', '20120501000656', 1, '1.000', '1000.000', '5000.000'),
(153, 1, '', '20120515000669', 1, '1.000', '1000.000', '70000.000'),
(154, 1, '', '20120606000674', 1, '1.000', '1000.000', '130000.000'),
(155, 1, '', '20120608000675', 1, '1.000', '1000.000', '30000.000'),
(156, 1, '', '20120611000678', 1, '1.000', '1000.000', '400000.000'),
(157, 1, '', '20120706000679', 1, '1.000', '1000.000', '45000.000'),
(158, 1, '', '20120706000682', 1, '1.000', '1000.000', '45000.000'),
(159, 1, '', '20120731000689', 1, '1.000', '1000.000', '90000.000'),
(160, 1, '', '20120810000691', 1, '1.000', '1000.000', '310000.000'),
(161, 1, '', '20120820000693', 1, '1.000', '1000.000', '55000.000'),
(162, 1, '', '20120830000697', 1, '1.000', '1000.000', '85000.000'),
(163, 1, '', '20120927000704', 1, '1.000', '1000.000', '610000.000'),
(164, 1, '', '20120927000705', 1, '1.000', '1000.000', '375000.000'),
(165, 1, '', '20120929000706', 1, '1.000', '1000.000', '350000.000'),
(166, 1, '', '20121002000708', 1, '1.000', '1000.000', '10000.000'),
(167, 1, '', '20121004000712', 1, '1.000', '1000.000', '150000.000'),
(168, 1, '', '20121004000713', 1, '1.000', '1000.000', '60000.000'),
(169, 1, '', '20121008000719', 1, '1.000', '1000.000', '215000.000'),
(170, 1, '', '20121008000720', 1, '1.000', '1000.000', '80000.000'),
(171, 1, '', '20121019000726', 1, '1.000', '1000.000', '15000.000'),
(172, 1, '', '20121029000731', 1, '1.000', '1000.000', '60000.000'),
(173, 1, '', '20121031000735', 1, '1.000', '1000.000', '25000.000'),
(174, 1, '', '20121106000744', 1, '1.000', '1000.000', '45000.000'),
(175, 1, '', '20121110000746', 1, '1.000', '1000.000', '55000.000'),
(176, 1, '', '20121110000747', 1, '1.000', '1000.000', '150000.000'),
(177, 1, '', '20121121000749', 1, '1.000', '1000.000', '130000.000'),
(178, 1, '', '20121121000750', 1, '1.000', '1000.000', '130000.000'),
(179, 1, '', '20121204000759', 1, '1.000', '1000.000', '300000.000'),
(180, 1, '', '20130111000771', 1, '1.000', '1000.000', '200000.000'),
(181, 1, '', '20130111000772', 1, '1.000', '1000.000', '60000.000'),
(182, 1, '', '20130119000773', 1, '1.000', '1000.000', '150000.000'),
(183, 1, '', '20130213000778', 1, '1.000', '1000.000', '105000.000'),
(184, 1, '', '20130214000779', 1, '1.000', '1000.000', '75000.000'),
(185, 1, '', '20130219000781', 1, '1.000', '1000.000', '120000.000'),
(186, 1, '', '20130315000787', 1, '1.000', '1000.000', '25000.000'),
(187, 1, '', '20130320000788', 1, '1.000', '1000.000', '150000.000'),
(188, 1, '', '20130510000828', 1, '1.000', '1000.000', '120000.000'),
(189, 1, '', '20130511000830', 1, '1.000', '1000.000', '175000.000'),
(190, 1, '', '20130514000832', 1, '1.000', '1000.000', '20000.000'),
(191, 1, '', '20130516000834', 1, '1.000', '1000.000', '100000.000'),
(192, 1, '', '20130518000836', 1, '1.000', '1000.000', '10000.000'),
(193, 1, '', '20130524000841', 1, '1.000', '1000.000', '50000.000'),
(194, 1, '', '20130728000876', 1, '1.000', '1000.000', '60000.000'),
(195, 1, '', '20130914000895', 1, '1.000', '1000.000', '320000.000'),
(196, 1, '', '20130924000899', 1, '1.000', '1000.000', '100000.000'),
(197, 1, '', '20131121000913', 1, '1.000', '1000.000', '150000.000'),
(198, 1, '', '20131130000915', 1, '1.000', '1000.000', '70000.000'),
(199, 1, '', '20140109000927', 1, '1.000', '1000.000', '30000.000'),
(200, 1, '', '20140205000936', 1, '1.000', '1000.000', '130000.000'),
(201, 1, '', '20140529000939', 1, '1.000', '1000.000', '200000.000'),
(202, 1, '', '20140529000940', 1, '1.000', '1000.000', '290000.000'),
(203, 1, '', '20140625000941', 1, '1.000', '1000.000', '150000.000'),
(204, 1, '', '20140625000942', 1, '1.000', '1000.000', '140000.000'),
(205, 1, '', '20140909000949', 1, '1.000', '1000.000', '120000.000'),
(206, 1, '', '20140909000950', 1, '1.000', '1000.000', '150000.000'),
(207, 1, '', '20140910000951', 1, '1.000', '1000.000', '60000.000'),
(208, 1, '', '20150105000989', 1, '1.000', '1000.000', '7500.000'),
(209, 1, '', '20150701001011', 1, '1.000', '1000.000', '90000.000'),
(210, 1, '', '20150929001028', 1, '1.000', '1000.000', '165000.000'),
(211, 1, '', '20151013001031', 1, '1.000', '1000.000', '25000.000'),
(212, 1, '', '20160323001046', 1, '1.000', '1000.000', '200000.000'),
(213, 1, '', '20160421001050', 1, '1.000', '1000.000', '160000.000'),
(214, 1, '', '20160422001051', 1, '1.000', '1000.000', '160000.000'),
(215, 1, '', '20160509001054', 1, '1.000', '1000.000', '140000.000'),
(216, 1, '', '20160619001064', 1, '1.000', '1000.000', '110000.000'),
(217, 1, '', '20160825001071', 1, '1.000', '1000.000', '225000.000'),
(218, 1, '', '20160903001075', 1, '1.000', '1000.000', '350000.000'),
(219, 1, '', '20160929001079', 1, '1.000', '1000.000', '400000.000'),
(220, 1, '', '20161015001081', 1, '1.000', '1000.000', '150000.000'),
(221, 1, '', '20170711001107', 1, '1.000', '1000.000', '75000.000'),
(222, 1, '', '20180406001115', 1, '1.000', '1000.000', '25000.000'),
(223, 1, '', '20180812001166', 1, '1.000', '1000.000', '95000.000'),
(224, 1, '', '20190114001171', 1, '1.000', '1000.000', '20000.000'),
(225, 1, '', '20190114001173', 1, '1.000', '1000.000', '30000.000'),
(226, 1, '', '20190328001176', 1, '1.000', '1000.000', '120000.000'),
(227, 1, '', '20190427001180', 1, '1.000', '1000.000', '25000.000'),
(228, 1, '', '20190427001181', 1, '1.000', '1000.000', '30000.000'),
(229, 1, '', '20190427001182', 1, '1.000', '1000.000', '10000.000'),
(230, 1, '', '20190427001183', 1, '1.000', '1000.000', '45000.000'),
(231, 1, '', '20190427001184', 1, '1.000', '1000.000', '50000.000'),
(232, 1, '', '20190427001185', 1, '1.000', '1000.000', '45000.000'),
(233, 1, '', '20190427001186', 1, '1.000', '1000.000', '50000.000'),
(234, 1, '', '20190427001187', 1, '1.000', '1000.000', '175000.000'),
(235, 1, '', '20190427001188', 1, '1.000', '1000.000', '40000.000'),
(236, 1, '', '20190427001189', 1, '1.000', '1000.000', '60000.000'),
(237, 1, '', '20190427001190', 1, '1.000', '1000.000', '50000.000'),
(238, 1, '', '20190428001191', 1, '1.000', '1000.000', '20000.000'),
(239, 1, '', '20191120001194', 1, '1.000', '1000.000', '100000.000'),
(240, 1, '', '20191121001195', 1, '1.000', '1000.000', '95000.000'),
(241, 1, '', '20191229001196', 1, '1.000', '1000.000', '55000.000'),
(242, 1, '', '20200409001197', 1, '1.000', '1000.000', '12000.000'),
(243, 1, '', '20200508001201', 1, '1.000', '1000.000', '80000.000'),
(244, 1, '', '20200511001204', 1, '1.000', '1000.000', '50000.000'),
(245, 1, '', '20200518001206', 1, '1.000', '1000.000', '45000.000'),
(246, 1, '', '20200518001207', 1, '1.000', '1000.000', '0.000'),
(247, 1, '', '20200522001209', 1, '1.000', '1000.000', '135000.000'),
(248, 1, '', '20200522001210', 1, '1.000', '1000.000', '25000.000'),
(249, 1, '', '20200604001213', 1, '1.000', '1000.000', '53000.000'),
(250, 1, '', '20200604001214', 1, '1.000', '1000.000', '65000.000'),
(251, 1, '', '20200604001215', 1, '1.000', '1000.000', '100000.000'),
(252, 1, '', '20200609001216', 1, '1.000', '1000.000', '25000.000'),
(253, 1, '', '20200613001218', 1, '1.000', '1000.000', '65000.000'),
(254, 1, '', '20200613001219', 1, '1.000', '1000.000', '45000.000'),
(255, 1, '', '20200613001220', 1, '1.000', '1000.000', '5000.000'),
(256, 1, '', '20200617001221', 1, '1.000', '1000.000', '330000.000'),
(257, 1, '', '20200618001222', 1, '1.000', '1000.000', '150000.000'),
(258, 1, '', '20200618001223', 1, '1.000', '1000.000', '215000.000'),
(259, 1, '', '20200619001224', 1, '1.000', '1000.000', '30000.000'),
(260, 1, '', '20200619001225', 1, '1.000', '1000.000', '30000.000'),
(261, 1, '', '20200620001226', 1, '1.000', '1000.000', '25000.000'),
(262, 1, '', '20200624001227', 1, '1.000', '1000.000', '25000.000'),
(263, 1, '', '20200625001228', 1, '1.000', '1000.000', '275000.000'),
(264, 1, '', '20200625001229', 1, '1.000', '1000.000', '85000.000'),
(265, 1, '', '20200627001231', 1, '1.000', '1000.000', '300000.000'),
(266, 1, '', '20200717001235', 1, '1.000', '1000.000', '90000.000'),
(267, 1, '', '20200718001236', 1, '1.000', '1000.000', '40000.000'),
(268, 1, '', '20200720001237', 1, '1.000', '1000.000', '225000.000'),
(269, 1, '', '20200801001239', 1, '1.000', '1000.000', '50000.000'),
(270, 1, '', '20200806001241', 1, '1.000', '1000.000', '35000.000'),
(271, 1, '', '20200806001242', 1, '1.000', '1000.000', '75000.000'),
(272, 1, '', '20200814001243', 1, '1.000', '1000.000', '100000.000'),
(273, 1, '', '20200814001244', 1, '1.000', '1000.000', '100000.000'),
(274, 1, '', '20200814001245', 1, '1.000', '1000.000', '300000.000'),
(275, 1, '', '20200829001246', 1, '1.000', '1000.000', '60000.000'),
(276, 1, '', '20200928001247', 1, '1.000', '1000.000', '50000.000'),
(277, 1, '', '20200928001248', 1, '1.000', '1000.000', '90000.000'),
(278, 1, '', '20201005001250', 1, '1.000', '1000.000', '150000.000'),
(279, 1, '', '20201005001251', 1, '1.000', '1000.000', '225000.000'),
(280, 1, '', '20201019001252', 1, '1.000', '1000.000', '90000.000'),
(281, 1, '', '20201027001253', 1, '1.000', '1000.000', '155000.000'),
(282, 1, '', '20201027001254', 1, '1.000', '1000.000', '155000.000'),
(283, 1, '', '20201027001255', 1, '1.000', '1000.000', '20000.000'),
(284, 1, '', '20201107001256', 1, '1.000', '1000.000', '450000.000'),
(285, 1, '', '20201109001257', 1, '1.000', '1000.000', '60000.000'),
(286, 1, '', '20201112001258', 1, '1.000', '1000.000', '80000.000'),
(287, 1, '', '20201121001259', 1, '1.000', '1000.000', '75000.000'),
(288, 1, '', '20201121001260', 1, '1.000', '1000.000', '90000.000'),
(289, 1, '', '20201123001261', 1, '1.000', '1000.000', '50000.000'),
(290, 1, '', '20210119001263', 1, '1.000', '1000.000', '25000.000'),
(291, 1, '', '20210120001265', 1, '1.000', '1000.000', '20000.000'),
(292, 1, '', '20210126001266', 1, '1.000', '1000.000', '30000.000'),
(293, 1, '', '20210309001267', 1, '1.000', '1000.000', '20000.000'),
(294, 1, '', '20210315001268', 1, '1.000', '1000.000', '55000.000'),
(295, 1, '', '20210319001269', 1, '1.000', '1000.000', '125000.000'),
(296, 1, '', '20210319001270', 1, '1.000', '1000.000', '100000.000'),
(297, 1, '', '20210401001271', 1, '1.000', '1000.000', '125000.000'),
(298, 1, '', '20210404001272', 1, '1.000', '1000.000', '300000.000'),
(299, 1, '', '20210404001273', 1, '1.000', '1000.000', '85000.000'),
(300, 1, '', '20210404001274', 1, '1.000', '1000.000', '65000.000'),
(301, 1, '', '20210404001275', 1, '1.000', '1000.000', '6805000.000'),
(302, 1, '', '20210404001276', 1, '1.000', '1000.000', '1375000.000'),
(303, 1, '', '20210404001277', 1, '1.000', '1000.000', '2800000.000'),
(304, 1, '', '20210404001278', 1, '1.000', '1000.000', '725000.000'),
(305, 1, '', '20210404001279', 1, '1.000', '1000.000', '840000.000'),
(306, 1, '', '20210404001280', 1, '1.000', '1000.000', '1175000.000'),
(307, 1, '', '20210404001281', 1, '1.000', '1000.000', '860000.000'),
(308, 1, '', '20210404001282', 1, '1.000', '1000.000', '1230000.000'),
(309, 1, '', '20210404001283', 1, '1.000', '1000.000', '870000.000'),
(310, 1, '', '20210404001284', 1, '1.000', '1000.000', '110000.000'),
(311, 1, '', '20210404001285', 1, '1.000', '1000.000', '150000.000'),
(312, 1, '', '20210404001286', 1, '1.000', '1000.000', '70000.000'),
(313, 1, '', '20210404001287', 1, '1.000', '1000.000', '65000.000'),
(314, 1, '', '20210404001288', 1, '1.000', '1000.000', '70000.000'),
(315, 1, '', '20210404001289', 1, '1.000', '1000.000', '50000.000'),
(316, 1, '', '20210404001290', 1, '1.000', '1000.000', '325000.000'),
(317, 1, '', '20210404001291', 1, '1.000', '1000.000', '450000.000'),
(318, 1, '', '20210404001292', 1, '1.000', '1000.000', '120000.000'),
(319, 1, '', '20210404001293', 1, '1.000', '1000.000', '310000.000'),
(320, 1, '', '20210404001294', 1, '1.000', '1000.000', '170000.000'),
(321, 1, '', '20210404001295', 1, '1.000', '1000.000', '200000.000'),
(322, 1, '', '20210405001296', 1, '1.000', '1000.000', '70000.000'),
(323, 1, '', '20210408001297', 1, '1.000', '1000.000', '90000.000'),
(324, 1, '', '20210409001298', 1, '1.000', '1000.000', '65000.000'),
(325, 1, '', '20210415001299', 1, '1.000', '1000.000', '40000.000'),
(326, 1, '', '20210419001300', 1, '1.000', '1000.000', '905000.000'),
(327, 1, '', '20210420001301', 1, '1.000', '1000.000', '1225000.000'),
(328, 1, '', '20210420001302', 1, '1.000', '1000.000', '85000.000'),
(329, 1, '', '20210421001303', 1, '1.000', '1000.000', '575000.000'),
(330, 1, '', '20210422001304', 1, '1.000', '1000.000', '100000.000'),
(331, 1, '', '20210423001305', 1, '1.000', '1000.000', '75000.000'),
(332, 1, '', '20210423001306', 1, '1.000', '1000.000', '80000.000'),
(333, 1, '', '20210423001307', 1, '1.000', '1000.000', '110000.000'),
(334, 1, '', '20210505001308', 1, '1.000', '1000.000', '250000.000'),
(335, 1, '', '20210521001309', 1, '1.000', '1000.000', '550000.000'),
(336, 1, '', '20210531001310', 1, '1.000', '1000.000', '250000.000'),
(337, 1, '', '20210531001311', 1, '1.000', '1000.000', '300000.000'),
(338, 1, '', '20210531001312', 1, '1.000', '1000.000', '100000.000'),
(339, 1, '', '20210603001313', 1, '1.000', '1000.000', '250000.000'),
(340, 1, '', '20210609001314', 1, '1.000', '1000.000', '100000.000'),
(341, 1, '', '20210609001315', 1, '1.000', '1000.000', '150000.000'),
(342, 1, '', '20210612001316', 1, '1.000', '1000.000', '85000.000'),
(343, 1, '', '202106250001', 1, '1.000', '1000.000', '6500000.000'),
(344, 1, '', '202106250002', 1, '1.000', '1000.000', '160000.000'),
(345, 1, '', '202106250003', 1, '1.000', '1000.000', '160000.000'),
(346, 1, '', '202106250004', 1, '1.000', '1000.000', '160000.000'),
(347, 1, '', '202106250005', 1, '1.000', '1000.000', '160000.000'),
(348, 1, '', '202106260003', 1, '1.000', '1000.000', '150000.000'),
(349, 1, '', '202106280001', 1, '1.000', '1000.000', '230000.000'),
(350, 1, '', '202106280002', 1, '1.000', '1000.000', '60000.000'),
(351, 1, '', '202106280003', 1, '1.000', '1000.000', '2150000.000'),
(352, 1, '', '202106290004', 1, '1.000', '1000.000', '66000.000'),
(353, 1, '', '202107120001', 1, '1.000', '1000.000', '200000.000'),
(354, 1, '', '202107120002', 1, '1.000', '1000.000', '180000.000'),
(355, 1, '', '202107090001', 1, '1.000', '1000.000', '72000.000'),
(356, 1, '', '202107130001', 1, '1.000', '1000.000', '12000.000'),
(357, 1, '', '202107130002', 1, '1.000', '1000.000', '1950000.000'),
(358, 1, '', '202107150001', 1, '1.000', '1000.000', '100000.000'),
(359, 1, '', '202107150002', 1, '1.000', '1000.000', '90000.000'),
(360, 1, '', '202107190001', 1, '1.000', '1000.000', '275000.000'),
(361, 1, '', '202107250001', 1, '1.000', '1000.000', '150000.000'),
(362, 1, '', '202107250002', 1, '1.000', '1000.000', '80000.000'),
(363, 1, '', '202107250003', 1, '1.000', '1000.000', '27000.000'),
(364, 1, '', '202107250004', 1, '1.000', '1000.000', '235000.000'),
(365, 1, '', '202107250005', 1, '1.000', '1000.000', '11000.000'),
(366, 1, '', '202107280001', 1, '1.000', '1000.000', '46000.000'),
(367, 1, '', '202108050001', 1, '1.000', '1000.000', '30000.000'),
(368, 1, '', '202108040001', 1, '1.000', '1000.000', '45000.000'),
(369, 1, '', '202108060001', 1, '1.000', '1000.000', '40000.000'),
(370, 1, '', '202108110001', 1, '1.000', '1000.000', '275000.000'),
(371, 1, '', '202108120001', 1, '1.000', '1000.000', '6750000.000'),
(372, 1, '', '202108120002', 1, '1.000', '1000.000', '45000.000'),
(373, 1, '', '202108120003', 1, '1.000', '1000.000', '6000.000'),
(374, 1, '', '202108010001', 1, '1.000', '1000.000', '5000.000'),
(375, 1, '', '202108010002', 1, '1.000', '11.000', '5000.000'),
(376, 4, '', '202108010002', 1, '12.000', '100.000', '55000.000'),
(377, 1, '', '202108140001', 1, '1.000', '1000.000', '40000.000'),
(378, 1, '', '202108140002', 1, '1.000', '1000.000', '55000.000'),
(379, 1, '', '202108160001', 1, '1.000', '1000.000', '385000.000'),
(380, 1, '', '202108240001', 1, '1.000', '1000.000', '400000.000'),
(381, 1, '', '202108230001', 1, '1.000', '1000.000', '55000.000'),
(382, 1, '', '20210828001', 1, '1.000', '1000.000', '1000.000'),
(383, 1, '', '202108300001', 1, '1.000', '1000.000', '690000.000'),
(384, 1, '', '202109090001', 1, '1.000', '1000.000', '8500.000'),
(385, 1, '', '202109080001', 1, '1.000', '1000.000', '5650000.000'),
(386, 1, '', '202109130001', 1, '1.000', '1000.000', '30000.000'),
(387, 1, '', '202109130002', 1, '1.000', '1000.000', '59500.000'),
(388, 1, '', '202109130003', 1, '1.000', '1000.000', '190000.000'),
(389, 1, '', '202109100001', 1, '1.000', '1000.000', '35000.000'),
(390, 1, '', '202109200001', 1, '1.000', '1000.000', '23000.000'),
(391, 1, '', '202109210001', 1, '1.000', '1000.000', '1700000.000'),
(392, 1, '', '202109210002', 1, '1.000', '1000.000', '15000.000'),
(393, 1, '', '202109290001', 1, '1.000', '1000.000', '278000.000'),
(394, 1, '', '202110110001', 1, '1.000', '1000.000', '345000.000'),
(395, 1, '', '202110140001', 1, '1.000', '1000.000', '680000.000'),
(396, 1, '', '202110140002', 1, '1.000', '1000.000', '990000.000'),
(397, 1, '', '202110220001', 1, '1.000', '1000.000', '6600000.000'),
(398, 1, '', '202110260001', 1, '1.000', '1000.000', '6565000.000'),
(399, 1, '', '202110300001', 1, '1.000', '1000.000', '45000.000'),
(400, 1, '', '202110300002', 1, '1.000', '1000.000', '63000.000'),
(401, 1, '', '202110300003', 1, '1.000', '1000.000', '45000.000'),
(402, 1, '', '202110300004', 1, '1.000', '1000.000', '65000.000'),
(403, 1, '', '202110300005', 1, '1.000', '1000.000', '57000.000'),
(404, 1, '', '202110300006', 1, '1.000', '1000.000', '33000.000'),
(405, 1, '', '202110300007', 1, '1.000', '1000.000', '47000.000'),
(406, 1, '', '202110300008', 1, '1.000', '1000.000', '65000.000'),
(407, 1, '', '202110300009', 1, '1.000', '1000.000', '67000.000'),
(408, 1, '', '202110300010', 1, '1.000', '1000.000', '95000.000'),
(409, 1, '', '202110300011', 1, '1.000', '1000.000', '95000.000'),
(410, 1, '', '202110300012', 1, '1.000', '1000.000', '35000.000'),
(411, 1, '', '20211113001', 1, '1.000', '1000.000', '575000.000'),
(412, 1, '', '20211113002', 1, '1.000', '1000.000', '220000.000'),
(413, 1, '', '20211115001', 1, '1.000', '1000.000', '905000.000'),
(414, 1, '', '202111180001', 1, '1.000', '1000.000', '415000.000'),
(415, 1, '', '20211118001', 1, '1.000', '1000.000', '295000.000'),
(416, 1, '', '20211122001', 1, '1.000', '1000.000', '120000.000'),
(417, 1, '', '20211122002', 1, '1.000', '1000.000', '65000.000'),
(418, 1, '', '20211122003', 1, '1.000', '1000.000', '60000.000'),
(419, 1, '', '20211122004', 1, '1.000', '1000.000', '45000.000'),
(420, 1, '', '20211127001', 1, '1.000', '1000.000', '1750000.000'),
(421, 1, '', '20211203001', 1, '1.000', '1000.000', '49000.000'),
(422, 1, '', '20211203002', 1, '1.000', '1000.000', '100000.000'),
(423, 1, '', '202112100001', 1, '1.000', '1000.000', '12500.000'),
(424, 1, '', '202112130001', 1, '1.000', '1000.000', '1660000.000'),
(425, 1, '', '202112130002', 1, '1.000', '1000.000', '1480000.000'),
(426, 1, '', '202112130003', 1, '1.000', '1000.000', '710000.000'),
(427, 1, '', '202112130004', 1, '1.000', '1000.000', '66000.000'),
(428, 1, '', '202112130005', 1, '1.000', '1000.000', '58000.000'),
(429, 1, '', '202112130006', 1, '1.000', '1000.000', '58000.000'),
(430, 1, '', '202112130007', 1, '1.000', '1000.000', '62000.000'),
(431, 1, '', '202112130008', 1, '1.000', '1000.000', '62000.000'),
(432, 1, '', '202112130009', 1, '1.000', '1000.000', '62000.000'),
(433, 1, '', '202112130010', 1, '1.000', '1000.000', '225000.000'),
(434, 1, '', '202112130011', 1, '1.000', '1000.000', '250000.000'),
(435, 1, '', '202112130012', 1, '1.000', '1000.000', '560000.000'),
(436, 1, '', '202112130013', 1, '1.000', '1000.000', '560000.000'),
(437, 1, '', '202112130014', 1, '1.000', '1000.000', '140000.000'),
(438, 1, '', '202112140001', 1, '1.000', '1000.000', '55000.000'),
(439, 1, '', '202112160001', 1, '1.000', '1000.000', '1325000.000'),
(440, 1, '', '202112160002', 1, '1.000', '1000.000', '1400000.000'),
(441, 1, '', '202112160003', 1, '1.000', '1000.000', '538000.000'),
(442, 1, '', '202112160004', 1, '1.000', '1000.000', '1368000.000'),
(443, 1, '', '202112160005', 1, '1.000', '1000.000', '3900000.000'),
(444, 1, '', '202112160006', 1, '1.000', '1000.000', '475000.000'),
(445, 1, '', '202112160007', 1, '1.000', '1000.000', '425000.000'),
(446, 1, '', '202112160008', 1, '1.000', '1000.000', '195000.000'),
(447, 1, '', '202112160009', 1, '1.000', '1000.000', '275000.000'),
(448, 1, '', '202112160010', 1, '1.000', '1000.000', '460000.000'),
(449, 1, '', '202112210001', 1, '1.000', '1000.000', '13000.000'),
(450, 1, '', '202112220001', 1, '1.000', '1000.000', '200000.000'),
(454, 1, '', '202201210001', 1, '1.000', '41000.000', '39000.000'),
(455, 1, '', '202201210002', 1, '1.000', '999999.999', '2912000.000'),
(456, 1, '', '202201210003', 1, '1.000', '999999.999', '4792500.000'),
(457, 1, '', '202201220001', 1, '1.000', '262000.000', '262000.000'),
(458, 1, '', '202201220002', 1, '1.000', '35000.000', '35000.000'),
(459, 1, '', '202202030001', 1, '1.000', '72000.000', '72000.000'),
(460, 4, '1234567892', '20111110000399', 1, '1.000', '750000.000', '750000.000'),
(461, 1, '', '202202270001', 1, '1.000', '925000.000', '925000.000'),
(462, 1, '', '202203170001', 1, '1.000', '8000.000', '8000.000'),
(463, 1, '', '202203170002', 1, '1.000', '8000.000', '8000.000'),
(464, 1, '', '202203200001', 1, '1.000', '999999.999', '5625000.000');


ALTER TABLE `multi_price`
  ADD PRIMARY KEY (`KODE`);

ALTER TABLE `multi_price`
  MODIFY `KODE` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=465;
