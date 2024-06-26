    <?php
session_start();
//membuat koneksi ke database

$conn = mysqli_connect("localhost", "root", "", "bmkgstokbarang");

//menambah barang baru
if (isset($_POST['addnewbarang'])) {
    $kodebarang = $_POST['kodebarang'];
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];

    $addtotable = mysqli_query($conn, "insert into stock (kodebarang,namabarang, deskripsi, stock) values('$kodebarang','$namabarang', '$deskripsi', '$stock')");
    if ($addtotable) {
        header('location:index.php');
    } else {
        echo 'Gagal';
        header('location:index.php');
    }
}

//menambah barang masuk 
if (isset($_POST['barangmasuk'])) {
    $barangnya = $_POST['barangnya'];
    $qty      = $_POST['qty'];
    $posisibarang      = $_POST['posisibarang'];
    $penerima = $_POST['penerima'];
    $keterangan = $_POST['keterangan'];


    $cekstocksekarang = mysqli_query($conn, "select * from stock where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang + $qty;

    $addtomasuk = mysqli_query($conn, "insert into masuk (idbarang, posisibarang,qty,keterangan,penerima) values('$barangnya','$posisibarang','$qty','$keterangan','$penerima')");
    $updatestockmasuk = mysqli_query($conn, "update stock set stock='$tambahkanstocksekarangdenganquantity' where idbarang='$barangnya'");
    if ($addtomasuk && $updatestockmasuk) {
        header('location:masuk.php');
    } else {
        echo 'Gagal';
        header('location:masuk.php');
    }
}

//menambah barang keluar 
if (isset($_POST['addbarangkeluar'])) {
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $posisibarang      = $_POST['posisibarang'];
    $qty      = $_POST['qty'];

    $cekstocksekarang = mysqli_query($conn, "select * from stock where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang - $qty;

    $addtokeluar = mysqli_query($conn, "insert into keluar (idbarang, posisibarang,qty,penerima) values('$barangnya','$posisibarang','$qty','$penerima')");
    $updatestockmasuk = mysqli_query($conn, "update stock set stock='$tambahkanstocksekarangdenganquantity' where idbarang='$barangnya'");
    if ($addtokeluar && $updatestockmasuk) {
        header('location:keluar.php');
    } else {
        echo 'Gagal';
        header('location:keluar.php');
    }
}

//Update info barang
if (isset($_POST['updatebarang'])) {
    $idb = $_POST['idb'];
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];

    $update = mysqli_query($conn, "update stock set namabarang='$namabarang', deskripsi='$deskripsi' where idbarang='$idb'");
    if ($update) {
        header('location:index.php');
    } else {
        echo 'Gagal';
        header('location:index.php');
    }
}

//Hapus barang
if (isset($_POST['hapusbarang'])) {
    $idb = $_POST['idb'];
    $delete = mysqli_query($conn, "delete from stock where idbarang='$idb'");
    if ($delete) {
        header('location:index.php');
    } else {
        echo 'Gagal';
        header('location:index.php');
    }
}

//Mengubah data yang masuk 
if (isset($_POST['updatebarangmasuk'])) {
    $idb = $_POST['idb'];
    $idm = $_POST['idm'];
    $deskripsi = $_POST['keterangan'];
    $qty = $_POST['qty'];

    $lihatstock = mysqli_query($conn, "select * from stock where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrng = $stocknya['stock'];

    $qtyskrng = mysqli_query($conn, "select * from masuk where idmasuk='$idm'");
    $qtynya = mysqli_fetch_array($qtyskrng);
    $qtyskrng = $qtynya['qty'];

    if ($qty > $qtyskrng) {
        $selisih = $qty - $qtyskrng;
        $kurangin = $stockskrng + $selisih;
        $kuranginstoknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update masuk set qty='$qty',keterangan='$deskripsi' where idmasuk='$idm'");
        if ($kuranginstoknya && $updatenya) {
            header('location:masuk.php');
        } else {
            echo 'Gagal';
            header('location:masuk.php');
        }
    } else {
        $selisih = $qtyskrng - $qty;
        $kurangin = $stockskrng - $selisih;
        $kuranginstoknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update masuk set qty='$qty',keterangan='$deskripsi' where idmasuk='$idm'");
        if ($kuranginstoknya && $updatenya) {
            header('location:masuk.php');
        } else {
            echo 'Gagal';
            header('location:masuk.php');
        }
    }
}

//menhapus barang masuk
if (isset($_POST['hapusbarangmasuk'])) {
    $idb = $_POST['idb'];
    $qty = $_POST['qty'];
    $idm = $_POST['idm'];

    $getdatastock = mysqli_query($conn, "select * from stock where idbarang = $idb");
    $data = mysqli_fetch_array($getdatastock);
    $stok = $data['stock'];


    $selisih = $stok - $qty;
    $update = mysqli_query($conn, "update stock set stock =  $selisih where idbarang = $idb");
    $hapusdata = mysqli_query($conn, "delete from masuk where idmasuk = $idm");
    if ($update && $hapusdata) {
        header('location:masuk.php');
    } else {
        echo 'Gagal';
        header('location:masuk.php');
    }
}


//Mengubah data yang keluar 
if (isset($_POST['updatebarangkeluar'])) {
    $idb = $_POST['idb'];
    $idk = $_POST['idk'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $lihatstock = mysqli_query($conn, "select * from stock where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrng = $stocknya['stock'];

    $qtyskrng = mysqli_query($conn, "select * from keluar where idkeluar='$idk'");
    $qtynya = mysqli_fetch_array($qtyskrng);
    $qtyskrng = $qtynya['qty'];

    if ($qty > $qtyskrng) {
        $selisih = $qty - $qtyskrng;
        $kurangin = $stockskrng - $selisih;
        $kuranginstoknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update keluar set qty='$qty',penerima='$penerima' where idkeluar='$idk");
        if ($kuranginstoknya && $updatenya) {
            header('location:keluar.php');
        } else {
            echo 'Gagal';
            header('location:keluar.php');
        }
    } else {
        $selisih = $qtyskrng - $qty;
        $kurangin = $stockskrng + $selisih;
        $kuranginstoknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update keluar set qty='$qty',penerima='$penerima' where idkeluar='$idk'");
        if ($kuranginstoknya && $updatenya) {
            header('location:keluar.php');
        } else {
            echo 'Gagal';
            header('location:keluar.php');
        }
    }
}

//menghapus barang keluar
if (isset($_POST['hapusbarangkeluar'])) {
    $idb = $_POST['idb'];
    $qty = $_POST['qty'];
    $idk = $_POST['idk'];

    $getdatastock = mysqli_query($conn, "select * from stock where idbarang = $idb");
    $data = mysqli_fetch_array($getdatastock);
    $stok = $data['stock'];


    $selisih = $stok + $qty;
    $update = mysqli_query($conn, "update stock set stock =  $selisih where idbarang = $idb");
    $hapusdata = mysqli_query($conn, "delete from keluar where idkeluar = $idk");
    if ($update && $hapusdata) {
        header('location:keluar.php');
    } else {
        echo 'Gagal';
        header('location:keluar.php');
    }
}
