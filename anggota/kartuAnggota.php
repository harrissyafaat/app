 <meta http-equiv="refresh" content="1">
<body onload="">
<?php
include "../config/conn.php";
include "../fungsi/fungsi.php";
?>

<?php

$kode=$_GET['kode_anggota'];
$query=mysqli_query($koneksi, "SELECT * 
                    FROM t_anggota
                    WHERE kode_anggota = '$kode'");
while($data=mysqli_fetch_array($query, MYSQLI_ASSOC)){
?>
	<table>
    	<tr>
        	<td rowspan="2" align="center"><img src="../logo_kop.gif" width="50" height="45" /></td>
            <td colspan="3"><b>Jam'iyah Waqi'ah "Sunan Kalijogo"</b></td>
        </tr>
        <tr>
        	<td colspan="3">Jln. Pesantren I No. 2 Kediri</td>
        </tr>
         <tr>
        	<td colspan="4"><hr /><hr /></td>
        </tr>
        <tr>
        	<td>No Anggota</td>
            <td>:</td>
            <td><?php echo $data['kode_anggota'];?></td>
            <td rowspan="4"><?php echo $data['photo'];?></td>
        </tr>
        <tr>
        	<td>Nama</td>
            <td>:</td>
            <td><?php echo $data['nama_anggota'];?></td>
        </tr>
        <tr>
        	<td>Alamat</td>
            <td>:</td>
            <td><?php echo $data['alamat_anggota'];?></td>
        </tr>
        <tr>
        	<td>Tanggal Masuk</td>
            <td>:</td>
            <td><?php echo Tgl($data['tgl_masuk']);?></td>
        </tr>
    </table><br />
<?php
}
?>
<table style="padding-top: 100px; " width="700" align="center">
    <tr>
        <td><input style="width: 100px; height: 30px;" type="button" onclick="window.print();" value="Cetak"></td>
        <td><input style="width: 100px; height: 30px;" type="button" onclick="self.close();" value="Tutup"></td>
    </tr>
</table>
</body>