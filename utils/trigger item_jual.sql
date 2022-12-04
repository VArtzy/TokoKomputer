/*Dikerjakan pada saat ada UPDATE Record di dalam tabel item_jual*/
CREATE TRIGGER `item_jualAI0` AFTER INSERT ON `item_jual` FOR EACH ROW BEGIN
UPDATE barang SET barang.STOK=
(
    barang.STOK_AWAL +
    (
    	(SELECT COALESCE(SUM(item_beli.JUMLAH*item_beli.JUMLAH2),0) FROM item_beli WHERE item_beli.BARANG_ID = NEW.BARANG_ID)
         	-
         (SELECT COALESCE(SUM(item_jual.JUMLAH*item_jual.JUMLAH2),0) FROM item_jual WHERE item_jual.BARANG_ID = NEW.BARANG_ID)
     )
),
barang.HARGA_BELI=NEW.HARGA_BELI
WHERE barang.KODE=NEW.BARANG_ID;

/*Dikerjakan pada saat ada UPDATE Record di dalam tabel item_jual*/
CREATE TRIGGER `item_jualAU0` AFTER UPDATE ON `item_jual` FOR EACH ROW BEGIN
UPDATE barang SET barang.STOK=
(
    barang.STOK_AWAL +
    (
    	(SELECT COALESCE(SUM(item_beli.JUMLAH),0) FROM item_beli WHERE item_beli.BARANG_ID = NEW.BARANG_ID)
         	-
         (SELECT COALESCE(SUM(item_jual.JUMLAH),0) FROM item_jual WHERE item_jual.BARANG_ID = NEW.BARANG_ID)
     )
)
WHERE barang.KODE=NEW.BARANG_ID;

