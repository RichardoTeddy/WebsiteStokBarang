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
        header('location:cobauser.php');
    } else {
        echo 'Gagal';
        header('location:cobauser.php');
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
        header('location:masukuser.php');
    } else {
        echo 'Gagal';
        header('location:masukuser.php');
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
        header('location:keluaruser.php');
    } else {
        echo 'Gagal';
        header('location:keluaruser.php');
    }
}
    ?>

