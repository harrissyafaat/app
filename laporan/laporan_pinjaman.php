<?php 
	include "config/koneksi.php";
	include "fungsi/fungsi.php";

	$aksi=$_GET['aksi'];
	$kategori = ($kategori=$_POST['kategori'])?$kategori : $_GET['kategori'];
	$cari = ($cari = $_POST['input_cari'])? $cari: $_GET['input_cari'];
?>

<?php
	// **STYLE FORM
?>
<script language="javascript" type="text/javascript" src="js/niceforms.js"></script>
<link rel="stylesheet" type="text/css" href="css/theme1.css" />

<?php
	if(empty($aksi)){
?>
<body>
<div id="box">
<h3>Laporan Pinjaman</h3>
<form action="<?php $_SERVER['PHP_SELF']?>" method="post">
    <select name="kategori">
        <option value="" selected="selected" disabled="disabled">Pilihan Kategori</option>
        <option value="kode_pinjam">Kode Pinjaman</option>
        <option value="nama_anggota">Nama Anggota</option>
    </select> 
    <input type="text" name="input_cari" value="<?php echo $cari;?>"><input type="submit" value="Cari">
</form>
<table width="100%">
    <thead>
		<tr>
             <th><a href="#">No</a></th>
             <th><a href="#">Nama Anggota</a></th>
             <th><a href="#">Jumlah Pinjaman</a></th>
			 <th><a href="#">Sisa Pinjaman</a></th>             
			 <th><a href="#">Aksi</a></th>
       	</tr>
    </thead>
<?php
	// PAGING
		$batas=25;
		$halaman=$_GET['halaman'];
		if(empty($halaman)){
			$posisi=0;
			$halaman=1;
		}else{
			$posisi=($halaman-1)*$batas;
		}
		if($kategori!=""){
			$query = mysql_query("SELECT P.*, SUM(P.besar_pinjaman) AS total, A.kode_anggota,A.nama_anggota, T.besar_tabungan
								FROM t_pinjam P, t_anggota A, t_tabungan T
								WHERE $kategori LIKE '%$cari%'
								AND P.kode_anggota = A.kode_anggota
								AND A.kode_tabungan = T.kode_tabungan
								GROUP BY A.nama_anggota ASC 
								LIMIT $posisi, $batas");
		}else{
			$query = mysql_query("SELECT P.*, SUM(P.besar_pinjaman) AS total, A.kode_anggota,A.nama_anggota ,T.besar_tabungan
								FROM t_pinjam P, t_anggota A, t_tabungan T
								WHERE P.kode_anggota = A.kode_anggota
								AND A.kode_tabungan = T.kode_tabungan
								GROUP BY A.nama_anggota ASC  
								LIMIT $posisi, $batas");
		}		
		$no=$posisi+1;
		
	while($data=mysql_fetch_array($query)){
?>
    <tbody>
    	<tr>
			<td align="center"><?php echo $no++;?></td>
			<td><?php echo $data['nama_anggota'];?></td>
			<td align="center"><?php echo "Rp. ".($data['total']);?></td>
			<td align="center"><?php echo "Rp. ".($data['sisa_pinjaman']);?></td>
			<td align="center">
	<a href=index.php?pilih=3.3&aksi=show&kode_anggota=<?php echo $data['kode_anggota'];?>><img src="img/user.png" title="Detail" width="16" height="16" /></a>
			</td>
        </tr> 
	</tbody>   
<?php
	}
?>
		<tr class="paging">
            <td colspan="12">
         <?php
            // PAGING
           if($kategori!=""){
				$query2 = mysql_query("SELECT P.*, A.nama_anggota 
									FROM t_pinjam P, t_anggota A
									WHERE $kategori = '%$cari%'
									AND P.kode_anggota = A.kode_anggota
									ORDER BY kode_pinjam ASC");
			}else{
				$query2 = mysql_query("SELECT P.*, A.nama_anggota 
									FROM t_pinjam P, t_anggota A
									WHERE P.kode_anggota = A.kode_anggota
									ORDER BY kode_pinjam ASC");
			}
            $jmldata=mysql_num_rows($query2);
            $jmlhalaman=ceil($jmldata/$batas);
			
                // previous link
				if($halaman == 1){ 
					echo '<span class="prn">&lt; Previous</span>&nbsp;';
                }else{
					$i = $halaman-1;
					echo '<a href="?pilih=4.1&halaman='.$i.'" class="prn" rel="nofollow" title="go to page '.$i.'">&lt; Previous</a>&nbsp;';
					echo '<span class="prn">...</span>&nbsp;';
				}	
                for($i = 1; $i <= $jmlhalaman && $i <= $jmlhalaman; $i++){ 
                    if(($halaman) == $i){ 
                        echo '<span>'.$i.'</span>&nbsp;'; 
                    }else{ 
                        echo '<a href=?pilih=4.1&halaman='.$i.'>'.$i.'</a>';
                    } 
                } 
				
                // next link 
                if($halaman < $jmlhalaman){ 
                    $next = ($halaman + 1); 
					echo '<span class="prn">...</span>&nbsp;';
                    echo '<a href=?pilih=4.1&halaman='.$next.' class="prn" rel="nofollow" title="go to page '.$next.'">Next &gt;</a>&nbsp;'; 
                }else {
					echo '<span class="prn">Next &gt;</span>&nbsp;';
				}
				
				 if ($jmldata != 0){
					echo '<p id="total_count">(total '.$jmldata.' records)</p></div>';
				}
	
            ?>
            </td>
        </tr>
	</table>
</div>

<?php 
	}elseif($aksi=='show'){
	$kode=$_GET['kode_anggota'];
	$q=mysql_query("SELECT P.*, A.nama_anggota FROM t_pinjam P, t_anggota A
					WHERE P.kode_anggota = A.kode_anggota AND P.kode_anggota = '$kode'");
	$ang=mysql_fetch_array($q);
?>

<div id="box">
<h3>Laporan Pinjaman "<?php echo $ang['nama_anggota'];?>"</h3>
<!--<form action="<?php// $_SERVER['PHP_SELF']?>" method="post">
    <select name="kategori">
        <option value="" selected="selected" disabled="disabled">Pilihan Kategori</option>
        <option value="kode_pinjam">Kode Pinjaman</option>
        <option value="nama_anggota">Nama Anggota</option>
    </select> 
    <input type="text" name="input_cari" value="<?php// echo $cari;?>"><input type="submit" value="Cari">
</form>-->
<table width="100%">
    <thead>
		<tr>
             <th><a href="#">No</a></th>
             <th><a href="#">Nama</a></th>
             <th><a href="#">Tanggal Pinjam</a></th>
             <th><a href="#">Jumlah Pinjaman</a></th>
             <th><a href="#">Lama Angsuran</a></th>
             <th><a href="#">Besar Angsuran</a></th>
			 <th><a href="#">Sisa Angsuran</a></th>
			 <th><a href="#">Sisa Pinjaman</a></th>
       	</tr>
    </thead>
<?php
	// PAGING
		$batas=5;
		$halaman=$_GET['halaman'];
		if(empty($halaman)){
			$posisi=0;
			$halaman=1;
		}else{
			$posisi=($halaman-1)*$batas;
		}
		if($kategori!=""){
			$query = mysql_query("SELECT P.*, A.nama_anggota 
								FROM t_pinjam P, t_anggota A
								WHERE $kategori LIKE '%$cari%'
								AND P.kode_anggota = '$kode'
								AND P.kode_anggota = A.kode_anggota
								ORDER BY kode_pinjam ASC 
								LIMIT $posisi, $batas");
		}else{
			$query = mysql_query("SELECT P.*, A.nama_anggota 
								FROM t_pinjam P, t_anggota A
								WHERE P.kode_anggota = '$kode'
								AND P.kode_anggota = A.kode_anggota
								ORDER BY kode_pinjam ASC 
								LIMIT $posisi, $batas");
		}
		$no=$posisi+1;
		
	while($data=mysql_fetch_array($query)){
?>
    <tbody>
    	<tr>
			<td><?php echo $no++;?></td>
			<td><?php echo $data['nama_anggota'];?></td>
			<td><?php echo Tgl($data['tgl_pinjam']);?></td>
			<td><?php echo Rp($data['besar_pinjaman']);?></td>
            <td><?php echo $data['lama_angsuran'];?></td>
			<td><?php echo Rp($data['besar_angsuran']);?></td>
			<td><?php echo $data['sisa_angsuran'];?></td>
			<td><?php echo Rp($data['sisa_pinjaman']);?></td>
        </tr> 
	</tbody>   
<?php
	}
?>
		<tr class="paging">
            <td colspan="12">
         <?php
            // PAGING
           if($kategori!=""){
				$query2 = mysql_query("SELECT P.*, A.nama_anggota 
									FROM t_pinjam P, t_anggota A
									WHERE $kategori LIKE '%$cari%'
									AND P.kode_anggota = '$kode'
									AND P.kode_anggota = A.kode_anggota
									ORDER BY kode_pinjam ASC ");
			}else{
				$query2 = mysql_query("SELECT P.*, A.nama_anggota 
									FROM t_pinjam P, t_anggota A
									WHERE P.kode_anggota = '$kode'
									AND P.kode_anggota = A.kode_anggota
									ORDER BY kode_pinjam ASC ");
			}
            $jmldata=mysql_num_rows($query2);
            $jmlhalaman=ceil($jmldata/$batas);
			
                // previous link
				if($halaman == 1){ 
					echo '<span class="prn">&lt; Previous</span>&nbsp;';
                }else{
					$i = $halaman-1;
					echo '<a href="?pilih=4.1&halaman='.$i.'" class="prn" rel="nofollow" title="go to page '.$i.'">&lt; Previous</a>&nbsp;';
					echo '<span class="prn">...</span>&nbsp;';
				}	
                for($i = 1; $i <= $jmlhalaman && $i <= $jmlhalaman; $i++){ 
                    if(($halaman) == $i){ 
                        echo '<span>'.$i.'</span>&nbsp;'; 
                    }else{ 
                        echo '<a href=?pilih=4.1&halaman='.$i.'>'.$i.'</a>';
                    } 
                } 
				
                // next link 
                if($halaman < $jmlhalaman){ 
                    $next = ($halaman + 1); 
					echo '<span class="prn">...</span>&nbsp;';
                    echo '<a href=?pilih=4.1&halaman='.$next.' class="prn" rel="nofollow" title="go to page '.$next.'">Next &gt;</a>&nbsp;'; 
                }else {
					echo '<span class="prn">Next &gt;</span>&nbsp;';
				}
				
				 if ($jmldata != 0){
					echo '<p id="total_count">(total '.$jmldata.' records)</p></div>';
				}
	
            ?>
            </td>
        </tr>
	</table><br />
	<div align="center">
		<a href="laporan/cetak_laporan_pinjaman.php"><img src="images/cetak_word.png" width="32" height="32" title="cetak data pinjaman anggota"></a>
		<a href="#"><img src="images/cetak_excel.png" width="32" height="32" title="cetak data pinjaman anggota"></a>
		<a href="#"><img src="images/cetak_pdf.png" width="32" height="32" title="cetak data pinjaman anggota"></a>
		<input type="button" name="back" id="button1" value="Kembali" onClick="self.history.back()"/>
	</div>
</div>

<?php
}
?>

</body>