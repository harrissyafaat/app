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
</head>

<body>
<div id="box">
<h3>Laporan Anggota</h3>
<!--<form action="<?php// $_SERVER['PHP_SELF']?>" method="post">
    <select name="kategori">
        <option value="" selected="selected" disabled="disabled"></option>
        <option value="kode_anggota">Per Halaman</option>
        <option value="nama_anggota">Semua Anggota</option>
    </select>
	<input type="button" id="button1" value="Preview">
</form>-->

<?php
	if(empty($aksi)){
?>
<table width="100%">
    <thead>
		<tr>
             <th rowspan="2"><a href="#">No</a></th>
             <th><a href="#">Kode Anggota</a></th>
             <th><a href="#">Nama Anggota</a></th>
             <th><a href="#">Pekerjaan</a></th>
             <th><a href="#">Tanggal Masuk</a></th>
             <th><a href="#">Tanggal Keluar</a></th>
			 <th rowspan="2"><a href="#">Aksi</a></th>
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
			$query = mysql_query("SELECT * 
								FROM t_anggota
								WHERE $kategori LIKE '%$cari%'
								ORDER BY kode_anggota ASC 
								LIMIT $posisi, $batas");
		}else{
			$query = mysql_query("SELECT * FROM t_anggota 
								ORDER BY kode_anggota ASC 
								LIMIT $posisi, $batas");
		}
	$no=$posisi+1;
	while($data=mysql_fetch_array($query)){
?>
    <tbody>
    	<tr>
			<td><?php echo $no++;?></td>
            <td><?php echo $data['kode_anggota'];?></td>
            <td><?php echo $data['nama_anggota'];?></td>
            <td><?php echo $data['pekerjaan'];?></td>
            <td><?php echo $data['tgl_masuk'];?></td>
            <td><?php echo $data['tgl_keluar'];?></td>
            <td align="center"><img src="img/user.png" title="Detail" width="16" height="16" /></td>
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
				$query2 = mysql_query("SELECT * 
									FROM t_anggota
									WHERE $kategori LIKE '%$cari%'
									ORDER BY kode_anggota ASC");
			}else{
				$query2 = mysql_query("SELECT * FROM t_anggota");
			}
            $jmldata=mysql_num_rows($query2);
            $jmlhalaman=ceil($jmldata/$batas);
			
                // previous link
				if($halaman == 1){ 
					echo '<span class="prn">&lt; Previous</span>&nbsp;';
                }else{
					$i = $halaman-1;
					echo '<a href="?pilih=3.1&halaman='.$i.'" class="prn" rel="nofollow" title="go to page '.$i.'">&lt; Previous</a>&nbsp;';
					echo '<span class="prn">...</span>&nbsp;';
				}	
                for($i = 1; $i <= $jmlhalaman && $i <= $jmlhalaman; $i++){ 
                    if(($halaman) == $i){ 
                        echo '<span>'.$i.'</span>&nbsp;'; 
                    }else{ 
                        echo '<a href=?pilih=3.1&halaman='.$i.'>'.$i.'</a>';
                    } 
                } 
				
                // next link 
                if($halaman < $jmlhalaman){ 
                    $next = ($halaman + 1); 
					echo '<span class="prn">...</span>&nbsp;';
                    echo '<a href=?pilih=3.1&halaman='.$next.' class="prn" rel="nofollow" title="go to page '.$next.'">Next &gt;</a>&nbsp;'; 
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
		<a href="laporan/cetak_laporan_anggota.php"><img src="images/cetak_word.png" width="32" height="32" title="cetak kartu anggota"></a>
		<a href="#"><img src="images/cetak_excel.png" width="32" height="32" title="cetak kartu anggota"></a>
		<a href="cetak.php"><img src="images/cetak_pdf.png" width="32" height="32" title="cetak kartu anggota"></a>
		<input type="button" name="back" id="button1" value="Kembali" onClick="self.history.back()"/>
	</div>
</div>

<?php
}
?>

</body>
