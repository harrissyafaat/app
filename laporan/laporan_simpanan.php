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
<h3>Laporan Simpanan</h3>
<!--<form action="<?php// $_SERVER['PHP_SELF']?>" method="post">
	<select name="kategori">
		<option value="" selected="selected" disabled="disabled"></option>
		<option value="kode_simpan">Simpanan per Anggota</option>
		<option value="nama_anggota">Rekapitulasi Simpanan Anggota</option>
		<option value="nama_anggota">Per Tanggal</option>
	</select>
	<input type="submit" value="Preview">
</form>-->
<table width="100%">
    <thead>
		<tr>
			<th rowspan="2"><a href="#">No</a></th>
			<th rowspan="2" width="220"><a href="#">Nama</a></th>
			<th colspan="3"><a href="#">Simpanan</a></th>
			<th rowspan="2"><a href="#">Total Simpanan</a></th>	
			<th rowspan="2"><a href="#">Aksi</a></th>					
		</tr>
		<tr>
			<th><a href="#">Pokok</a></th>
			<th><a href="#">Wajib</a></th>
			<th><a href="#">Sukarela</a></th>
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
			$query = mysql_query("SELECT S.*, A.nama_anggota, J.nama_simpanan, J.besar_simpanan
								FROM t_simpan S, t_anggota A, t_jenis_simpan J
								WHERE $kategori LIKE '%$cari%'
								AND S.kode_anggota = A.kode_anggota
								AND S.kode_jenis_simpan = J.kode_jenis_simpan
								GROUP BY A.kode_anggota 
								LIMIT $posisi, $batas");
		}else{
			$query = mysql_query("SELECT S.*, A.nama_anggota, J.nama_simpanan, J.besar_simpanan
								FROM t_simpan S, t_anggota A, t_jenis_simpan J
								WHERE S.kode_anggota = A.kode_anggota
								AND S.kode_jenis_simpan = J.kode_jenis_simpan
								GROUP BY A.kode_anggota
								LIMIT $posisi, $batas");
		}
		$no=$posisi+1;
		
	while($data=mysql_fetch_array($query)){
		$kode=$data['kode_anggota'];
		$query1=mysql_query("SELECT S.*,SUM(S.besar_simpanan) AS total
							FROM t_simpan S, t_anggota A
							WHERE S.kode_anggota=A.kode_anggota
							AND S.kode_jenis_simpan='S0001'
							AND A.kode_anggota='$kode'
							GROUP BY A.kode_anggota");
		$qpokok=mysql_fetch_array($query1);
		
		$query2=mysql_query("SELECT S.*,SUM(S.besar_simpanan) AS total
							FROM t_simpan S, t_anggota A
							WHERE S.kode_anggota=A.kode_anggota
							AND  S.kode_jenis_simpan='S0002'
							AND A.kode_anggota='$kode'
							GROUP BY A.kode_anggota");
		$qwajib=mysql_fetch_array($query2);
		
		$query3=mysql_query("SELECT S.*,SUM(S.besar_simpanan) AS total
							FROM t_simpan S, t_anggota A
							WHERE S.kode_anggota=A.kode_anggota
							AND  S.kode_jenis_simpan='S0003'
							AND A.kode_anggota='$kode'
							GROUP BY A.kode_anggota");
		$qsukarela=mysql_fetch_array($query3);
		
		$total = $qpokok['total'] + $qwajib['total'] + $qsukarela['total'];
		//echo $qwajib;echo $data['kode_anggota'];
		//echo $kode;
		//echo $total;
?>
    <tbody>
    	<tr>
			<td><?php echo $no++;?></td>
			<td style="text-align:left"><?php echo $data['nama_anggota'];?></td>
			<td align="center"><?php echo Rp($qpokok['total']?$qpokok['total']:0);?></td>
			<td align="center"><?php echo Rp($qwajib['total']?$qwajib['total']:0);?></td>
			<td align="center"><?php echo Rp($qsukarela['total']?$qsukarela['total']:0);?></td>
			<td align="center"><?php echo Rp($total);?></td>
			<td align="center">
	<a href=index.php?pilih=3.2&aksi=show&kode_anggota=<?php echo $data['kode_anggota'];?>><img src="img/user.png" title="Detail" width="16" height="16" /></a></td>
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
				$query2 = mysql_query("SELECT S.*, A.nama_anggota, J.nama_simpanan, J.besar_simpanan
								FROM t_simpan S, t_anggota A, t_jenis_simpan J
								WHERE $kategori LIKE '%$cari%'
								AND S.kode_anggota = A.kode_anggota
								AND S.kode_jenis_simpan = J.kode_jenis_simpan
								GROUP BY A.kode_anggota");
			}else{
				$query2 = mysql_query("SELECT S.*, A.nama_anggota, J.nama_simpanan, J.besar_simpanan
								FROM t_simpan S, t_anggota A, t_jenis_simpan J
								WHERE S.kode_anggota = A.kode_anggota
								AND S.kode_jenis_simpan = J.kode_jenis_simpan
								GROUP BY A.kode_anggota");
			}
            $jmldata=mysql_num_rows($query2);
            $jmlhalaman=ceil($jmldata/$batas);
			
                // previous link
				if($halaman == 1){ 
					echo '<span class="prn">&lt; Previous</span>&nbsp;';
                }else{
					$i = $halaman-1;
					echo '<a href="?pilih=3.2&halaman='.$i.'" class="prn" rel="nofollow" title="go to page '.$i.'">&lt; Previous</a>&nbsp;';
					echo '<span class="prn">...</span>&nbsp;';
				}	
                for($i = 1; $i <= $jmlhalaman && $i <= $jmlhalaman; $i++){ 
                    if(($halaman) == $i){ 
                        echo '<span>'.$i.'</span>&nbsp;'; 
                    }else{ 
                        echo '<a href=?pilih=3.2&halaman='.$i.'>'.$i.'</a>';
                    } 
                } 
				
                // next link 
                if($halaman < $jmlhalaman){ 
                    $next = ($halaman + 1); 
					echo '<span class="prn">...</span>&nbsp;';
                    echo '<a href=?pilih=3.2&halaman='.$next.' class="prn" rel="nofollow" title="go to page '.$next.'">Next &gt;</a>&nbsp;'; 
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
	$q=mysql_query("SELECT S.*, A.nama_anggota FROM t_simpan S, t_anggota A
					WHERE S.kode_anggota = A.kode_anggota AND S.kode_anggota = '$kode'");
	$ang=mysql_fetch_array($q);
?>

<div id="box">
<h3>Laporan Simpanan Anggota "<?php echo $ang['nama_anggota'];?>"</h3>
<!--<form action="<?php// $_SERVER['PHP_SELF']?>" method="post">
    <select name="kategori">
        <option value="" selected="selected" disabled="disabled">Pilihan Kategori</option>
        <option value="tgl_simpan">Tanggal Simpan</option>
        <option value="nama_simpanan">Nama Simpanan</option>
    </select> 
    <input type="text" name="input_cari" value="<?php// echo $cari;?>"><input type="submit" value="Cari">
</form>-->
<table width="100%">
    <thead>
		<tr>
             <th rowspan="2"><a href="#">No</a></th>
             <th><a href="#">Tanggal Simpan</a></th>
             <th><a href="#">Nama Simpanan</a></th>
			 <th><a href="#">Besar Simpanan</a></th>
			 <th><a href="#">Petugas</a></th>
       	</tr>
    </thead>
<?php
	// PAGING
		$batas=10;
		$halaman=$_GET['halaman'];
		if(empty($halaman)){
			$posisi=0;
			$halaman=1;
		}else{
			$posisi=($halaman-1)*$batas;
		}
		if($kategori!=""){
			$query = mysql_query("SELECT S.*, A.nama_anggota, J.nama_simpanan
								FROM t_simpan S, t_anggota A, t_jenis_simpan J
								WHERE $kategori LIKE '%$cari%'
								AND S.kode_anggota = '$kode'
								AND S.kode_anggota = A.kode_anggota
								AND S.kode_jenis_simpan = J.kode_jenis_simpan
								ORDER BY kode_simpan ASC 
								LIMIT $posisi, $batas");
		}else{
			$query = mysql_query("SELECT S.*, A.nama_anggota, J.nama_simpanan
								FROM t_simpan S, t_anggota A, t_jenis_simpan J
								WHERE S.kode_anggota = '$kode'
								AND S.kode_anggota = A.kode_anggota
								AND S.kode_jenis_simpan = J.kode_jenis_simpan
								ORDER BY kode_simpan ASC 
								LIMIT $posisi, $batas");
		}
		$no=$posisi+1;
		//echo $kode;
		
	while($data=mysql_fetch_array($query)){
?>
    <tbody>
    	<tr>
			<td><?php echo $no++;?></td>
			<td><?php echo Tgl($data['tgl_simpan']);?></td>
			<td><?php echo $data['nama_simpanan'];?></td>
            <td><?php echo Rp($data['besar_simpanan']);?></td>
			<td><?php echo $data['u_entry'];?></td>
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
				$query2 = mysql_query("SELECT S.*, A.nama_anggota, J.nama_simpanan
								FROM t_simpan S, t_anggota A, t_jenis_simpan J
								WHERE $kategori LIKE '%$cari%'
								AND S.kode_anggota = '$kode'
								AND S.kode_anggota = A.kode_anggota
								AND S.kode_jenis_simpan = J.kode_jenis_simpan
								ORDER BY kode_simpan ASC");
			}else{
				$query2 = mysql_query("SELECT S.*, A.nama_anggota, J.nama_simpanan
									FROM t_simpan S, t_anggota A, t_jenis_simpan J
									WHERE S.kode_anggota = '$kode'
									AND S.kode_anggota = A.kode_anggota
									AND S.kode_jenis_simpan = J.kode_jenis_simpan
									ORDER BY kode_simpan ASC");
			}
            $jmldata=mysql_num_rows($query2);
            $jmlhalaman=ceil($jmldata/$batas);
			
                // previous link
				if($halaman == 1){ 
					echo '<span class="prn">&lt; Previous</span>&nbsp;';
                }else{
					$i = $halaman-1;
					echo '<a href="?pilih=3.2&halaman='.$i.'" class="prn" rel="nofollow" title="go to page '.$i.'">&lt; Previous</a>&nbsp;';
					echo '<span class="prn">...</span>&nbsp;';
				}	
                for($i = 1; $i <= $jmlhalaman && $i <= $jmlhalaman; $i++){ 
                    if(($halaman) == $i){ 
                        echo '<span>'.$i.'</span>&nbsp;'; 
                    }else{ 
                        echo '<a href=?pilih=3.2&halaman='.$i.'>'.$i.'</a>';
                    } 
                } 
				
                // next link 
                if($halaman < $jmlhalaman){ 
                    $next = ($halaman + 1); 
					echo '<span class="prn">...</span>&nbsp;';
                    echo '<a href=?pilih=3.2&halaman='.$next.' class="prn" rel="nofollow" title="go to page '.$next.'">Next &gt;</a>&nbsp;'; 
                }else {
					echo '<span class="prn">Next &gt;</span>&nbsp;';
				}
				
				 if ($jmldata != 0){
					echo '<p id="total_count">(total '.$jmldata.' records)</p></div>';
				}
	
            ?>
            </td>
        </tr>
	</table><br>
	<div align="center">
		<a href="laporan/cetak_laporan_simpanan.php"><img src="images/cetak_word.png" width="32" height="32" title="cetak data pinjaman anggota"></a>
		<a href="#"><img src="images/cetak_excel.png" width="32" height="32" title="cetak data pinjaman anggota"></a>
		<a href="#"><img src="images/cetak_pdf.png" width="32" height="32" title="cetak data pinjaman anggota"></a>
		<input type="button" name="back" id="button1" value="Kembali" onClick="self.history.back()"/>
	</div>
</div>

<?php
}
?>

</body>