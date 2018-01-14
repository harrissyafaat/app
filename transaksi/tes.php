<form action="<?php $_SERVER['PHP_SELF']?>" method="post">
    <select name="kategori">
        <option value="" selected="selected" disabled="disabled">Pilih Anggota</option>
        <option value="kode_anggota">Kode Anggota</option>
        <option value="nama_anggota">Nama Anggota</option>
    </select> 
    <input type="text" name="input_cari" value="<?php echo $cari;?>"><input type="submit" value="Cari">
</form>             

<table width="100%">
    <thead>
		<tr>
             <th><a href="#">No</a></th>
             <th><a href="#">Kode Anggota</a></th>
             <th><a href="#">Nama Anggota</a></th>
             <th><a href="#">Pekerjaan</a></th>
             <th><a href="#">Tanggal Masuk</a></th>
             <th colspan="3"><a href="">Aksi</a></th>
       	</tr>	
    </thead>
<?php
if ($_GET['aksi'] == ""){
	$batas=10;
	$halaman=$_GET['halaman'];
	if(empty($halaman)){
		$posisi=0;
		$halaman=1;
	}else{
		$posisi=($halaman-1)*$batas;
	}
	if($kategori!=""){
		$query = mysqli_query($koneksi, "SELECT * 
						FROM t_anggota
						WHERE $kategori LIKE '%$cari%'
						ORDER BY kode_anggota ASC 
						LIMIT $posisi, $batas");
	} else {
		$query=mysqli_query($koneksi, "SELECT * FROM t_anggota 
						ORDER BY kode_anggota ASC 
						LIMIT $posisi, $batas");
	}
	$no=$posisi+1;

	while($data=mysqli_fetch_array($query)){

?>
    <tbody>
    	<tr>
			<td><?php echo $no++;?></td>
            <td align="center"><?php echo $data['kode_anggota'];?></td>
            <td><?php echo $data['nama_anggota'];?></td>
            <td><?php echo $data['pekerjaan'];?></td>
            <td align="center"><?php echo $data['tgl_masuk'];?></td>
            <td align="center">
	<a href=index.php?pilih=2.1&aksi=simpan&kode_anggota=<?php echo $data['kode_anggota'];?>><img src="images/simpan.png" title="Simpan" width="30" height="30" /></a>
	<a href=index.php?pilih=2.1&aksi=pinjam&kode_anggota=<?php echo $data['kode_anggota'];?>><img src="images/pinjam.png" title="Pinjam" width="30" height="30" /></a>
    <a href=index.php?pilih=2.1&aksi=angsur&kode_anggota=<?php echo $data['kode_anggota'];?>><img src="images/angsur.png" title="Angsur" width="30" height="30" /></a>
			</td>
        </tr> 
	</tbody>   
<?php
	} //tutup while
?>
	<tr class="paging">
            <td colspan="12">
         <?php
            // PAGING
           if($kategori!=""){
				$query2 = mysqli_query($koneksi, "SELECT * 
									FROM t_anggota
									WHERE $kategori LIKE '%$cari%'
									ORDER BY kode_anggota ASC");
			}else{
				$query2 = mysqli_query($koneksi, "SELECT * FROM t_anggota");
			}
            $jmldata=mysqli_num_rows($query2);
            $jmlhalaman=ceil($jmldata/$batas);
			
                // previous link
				if($halaman == 1){ 
					echo '<span class="prn">&lt; Previous</span>&nbsp;';
                }else{
					$i = $halaman-1;
					echo '<a href="?pilih=2.1&halaman='.$i.'" class="prn" rel="nofollow" title="go to page '.$i.'">&lt; Previous</a>&nbsp;';
					echo '<span class="prn">...</span>&nbsp;';
				}	
                for($i = 1; $i <= $jmlhalaman && $i <= $jmlhalaman; $i++){ 
                    if(($halaman) == $i){ 
                        echo '<span>'.$i.'</span>&nbsp;'; 
                    }else{ 
                        echo '<a href=?pilih=2.1&halaman='.$i.'>'.$i.'</a>';
                    } 
                } 
				
                // next link 
                if($halaman < $jmlhalaman){ 
                    $next = ($halaman + 1); 
					echo '<span class="prn">...</span>&nbsp;';
                    echo '<a href=?pilih=2.1&halaman='.$next.' class="prn" rel="nofollow" title="go to page '.$next.'">Next &gt;</a>&nbsp;'; 
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
	<?php } ?>