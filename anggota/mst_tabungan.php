<?php 
	include "config/conn.php";
	include "fungsi/fungsi.php";

	$kategori = ($kategori=$_POST['kategori'])?$kategori : $_GET['kategori'];
	$cari = ($cari = $_POST['input_cari'])? $cari: $_GET['input_cari'];
?>

<?php
	// **STYLE FORM
?>
<script language="javascript" type="text/javascript" src="js/niceforms.js"></script>
<script language="javascript" type="text/javascript" src="js/validasi.js"></script>
<link rel="stylesheet" type="text/css" href="css/theme1.css" />

</head>
<body>  
         	            
<div id="box">
<h3>Data Tabungan Anggota</h3>
<form action="<?php $_SERVER['PHP_SELF']?>" method="post">
    <select name="kategori">
        <option value="" selected="selected" disabled="disabled">Pilihan Kategori</option>
        <option value="kode_tabungan">Kode Tabungan</option>
		<option value="kode_anggota">Kode Anggota</option>
        <option value="nama_anggota">Nama Anggota</option>
    </select> 
    <input type="text" name="input_cari" value="<?php echo $cari ;?>">
    <input type="submit" value="Cari">
</form>
<table width="100%">
    <thead>
		<tr>
             <th><a href="#">No</a></th>
             <th><a href="#">Kode Tabungan</a></th>
             <th><a href="#">Nama Anggota</a></th>
             <th><a href="#">Jumlah Saldo</a></th>
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
			$query = mysqli_query($koneksi, "SELECT A.nama_anggota, T.* 
								FROM t_anggota A, t_tabungan T
								WHERE $kategori LIKE '%$cari%'
								AND A.kode_tabungan = T.kode_tabungan
								ORDER BY kode_anggota ASC 
								LIMIT $posisi, $batas");
		}else{
		$query=mysqli_query($koneksi, "SELECT A.nama_anggota, T.* 
							FROM t_anggota A, t_tabungan T
							WHERE A.kode_tabungan = T.kode_tabungan
							ORDER BY kode_anggota ASC 
							LIMIT $posisi, $batas");
		}
	$no=$posisi+1;
	while($data=mysqli_fetch_array($query, MYSQLI_ASSOC)){
?>
    <tbody>
    	<tr>
			<td><?php echo $no++;?></td>
            <td align="center"><?php echo $data['kode_tabungan'];?></td>
            <td><?php echo $data['nama_anggota'];?></td>
            <td align="center"><?php echo Rp($data['besar_tabungan']);?></td>
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
				$query2 = mysqli_query($koneksi, "SELECT A.nama_anggota, T.* 
									FROM t_anggota A, t_tabungan T
									WHERE $kategori LIKE '%$cari%'
									AND A.kode_tabungan = T.kode_tabungan
									ORDER BY kode_anggota ASC");
			}else{
				$query2 = mysqli_query($koneksi, "SELECT A.nama_anggota, T.* 
									FROM t_anggota A, t_tabungan T
									WHERE A.kode_tabungan = T.kode_tabungan
									ORDER BY kode_anggota ASC");
			}
            $jmldata=mysqli_num_rows($query2);
            $jmlhalaman=ceil($jmldata/$batas);
			
                // previous link
				if($halaman == 1){ 
					echo '<span class="prn">&lt; Previous</span>&nbsp;';
                }else{
					$i = $halaman-1;
					echo '<a href="?pilih=1.3&halaman='.$i.'" class="prn" rel="nofollow" title="go to page '.$i.'">&lt; Previous</a>&nbsp;';
					echo '<span class="prn">...</span>&nbsp;';
				}	
                for($i = 1; $i <= $jmlhalaman && $i <= $jmlhalaman; $i++){ 
                    if(($halaman) == $i){ 
                        echo '<span>'.$i.'</span>&nbsp;';
                    }else{ 
                        echo '<a href=?pilih=1.3&halaman='.$i.'>'.$i.'</a>';
                    } 
                } 
				
                // next link 
                if($halaman < $jmlhalaman){ 
                    $next = ($halaman + 1); 
					echo '<span class="prn">...</span>&nbsp;';
                    echo '<a href=?pilih=1.3&halaman='.$next.' class="prn" rel="nofollow" title="go to page '.$next.'">Next &gt;</a>&nbsp;'; 
                }else{
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
