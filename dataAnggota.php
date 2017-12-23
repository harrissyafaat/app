<?php 
	include "config/conn.php";
?>
<link rel="stylesheet" type="text/css" href="css/theme1.css" />
<SCRIPT LANGUAGE="JavaScript">
<!-- Begin
function sendValue (s){
	var selvalue = s.value;
	window.opener.document.getElementById('kode_anggota').value = selvalue;
	window.opener.document.getElementById('nama_anggota').value = selvalue;
	//alert(selvalue);
	window.close();
}
//  End -->
</script>

</head>
<body>  
         	            
<div id="box">
<h3>Data Anggota</h3>          

<form name="form">
<table width="100%">
    <thead>
		<tr>
             <th>No</th>
             <th>Kode Anggota</th>
             <th>Nama Anggota</th>
             <th>Pekerjaan</th>
             <th>Tanggal Masuk</th>
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
		$query=mysqli_query($koneksi, "SELECT * FROM t_anggota 
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
			<td><input type="button" value="<?php echo $data['kode_anggota'];?>" onClick="sendValue(this);"></td>		
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
</form>
	</div>
</body>


