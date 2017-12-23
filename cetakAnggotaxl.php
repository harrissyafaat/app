<?php
header("Expires: Mon, 26 Jul 2001 05:00:00 GMT");
header("Last-Modified:". gmdate("D, d M Y H:i:s") . "GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Cache-Control: private");
header("Content-Type: application/vnd.ms-excel; name='excel'");
header("Content-disposition: attachment; filename=Data Anggota.xls");
 
	include "config/conn.php";
	include "fungsi/fungsi.php";

	$aksi=$_GET[aksi];
	$cari = $_POST['cari'];
?>

<?php
	// **STYLE FORM
?>
<script language="javascript" type="text/javascript" src="js/niceforms.js"></script>
<link rel="stylesheet" type="text/css" href="css/theme1.css" />

<style type="text/css">
/*---Paging specific styling----*/     
	.paging { padding:10px 0px 0px 0px; text-align:center; font-size:11px;}
	.paging.display{text-align:right;}
	.paging a, .paging span {padding:2px 8px 2px 8px; font-weight :normal}
	.paging span {font-weight:bold; color:#000; font-size:11px; }
	.paging a, .paging a:visited {color:#000; text-decoration:none; border:1px solid #dddddd;}
	.paging a:hover { text-decoration:none; background-color:#6C6C6C; color:#fff; border-color:#000;}
	.paging span.prn { font-size:13px; font-weight:normal; color:#aaa; }
	.paging a.prn, .paging a.prn:visited { border:2px solid #dddddd;}
	.paging a.prn:hover { border-color:#000;}
	.paging p#total_count{color:#aaa; font-size:12px; font-weight: normal; padding-left:18px;}
	.paging p#total_display{color:#aaa; font-size:12px; padding-top:10px;}
		
</style>


</head>

<table width="100%">
    <thead>
		<tr>
             <th><a href="#">No<img src="img/arrow_down_mini.gif" width="16" height="16" align="absmiddle" /></a></th>
             <th><a href="#">Kode Anggota</a></th>
             <th><a href="#">Nama Anggota</a></th>
             <th><a href="#">Pekerjaan</a></th>
             <th><a href="#">Tanggal Masuk</a></th>
             <th colspan="3"><a href=><img src="img/user_add.png" title="Add user" width="16" height="16" /></a></th>
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
		$query=mysql_query($koneksi, "SELECT * FROM t_anggota 
							WHERE nama_anggota like '%".$cari."%' 
							ORDER BY kode_anggota ASC 
							LIMIT $posisi, $batas");
		$no=$posisi+1;
		
	while($data=mysqli_fetch_array($query, MYSQLI_ASSOC)){
?>
    <tbody>
    	<tr>
			<td><?php echo $no++;?></td>
            <td><?php echo $data['kode_anggota'];?></td>
            <td><?php echo $data['nama_anggota'];?></td>
            <td><?php echo $data['pekerjaan'];?></td>
            <td><?php echo $data['tgl_masuk'];?></td>
            <td align="center">
	<a href=index.php?pilih=1.2&aksi=ubah&kode_anggota=<?php echo $data['kode_anggota'];?>><img src="img/user.png" title="Show profile" width="16" height="16" /></a>
	<a href=index.php?pilih=1.2&aksi=ubah&kode_anggota=<?php echo $data['kode_anggota'];?>><img src="img/user_edit.png" title="Edit user" width="16" height="16" /></a>
    <a href=index.php?pilih=1.2&aksi=hapus&kode_anggota=<?php echo $data['kode_anggota'];?>><img src="img/user_delete.png" title="Delete user" width="16" height="16" /></a>
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
            $query2=mysqli_query($koneksi, "SELECT * FROM t_anggota WHERE nama_anggota like '%".$cari."%'");
            $jmldata=mysqli_num_rows($query2);
            $jmlhalaman=ceil($jmldata/$batas);
			
                // previous link
				if($halaman == 1){ 
					echo '<span class="prn">&lt; Previous</span>&nbsp;';
                }else{
					$i = $halaman-1;
					echo '<a href="?pilih=1.2&halaman='.$i.'" class="prn" rel="nofollow" title="go to page '.$i.'">&lt; Previous</a>&nbsp;';
					echo '<span class="prn">...</span>&nbsp;';
				}	
                for($i = 1; $i <= $jmlhalaman && $i <= $jmlhalaman; $i++){ 
                    if(($halaman) == $i){ 
                        echo '<span>'.$i.'</span>&nbsp;'; 
                    }else{ 
                        echo '<a href=?pilih=1.2&halaman='.$i.'>'.$i.'</a>';
                    } 
                } 
				
                // next link 
                if($halaman < $jmlhalaman){ 
                    $next = ($halaman + 1); 
					echo '<span class="prn">...</span>&nbsp;';
                    echo '<a href=?pilih=1.2&halaman='.$next.' class="prn" rel="nofollow" title="go to page '.$next.'">Next &gt;</a>&nbsp;'; 
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