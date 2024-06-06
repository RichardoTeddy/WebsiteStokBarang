<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Website Stok Barang</title>
</head>
<body>
    <h2> Data Barang Masuk </h2>
    <table border="1" align="center" width="100%"> 
    <tr bgcolor="green">
        <th>Tanggal</th>
        <th>Nama Barang</th>
        <th>Jumlah</th>
        <th>keterangan</th>
    </tr>
    <tr>
    <?php
        include "function.php";
        $query = mysqli_query ($function, Select *  );
        while ($data = mysqli_fetch_array ($query)){
        ?>
        <td><?php echo $data['tanggal'];?></td>
        <td><?php echo $data['namabarang'];?></td>
        <td><?php echo $data['stock'];?></td>
        <td><?php echo $data['keterangan'];}?></td>
    </tr>
    </table>
</body>
</html>