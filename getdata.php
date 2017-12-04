<?php	
	include "classdb.php";
	$q = new Mysql();	
	$no 	= $_GET[no];
	$ambil 	= $_GET[ambil];	
	$ktp 	= $_GET[ktp];
	
	if($ambil=="nama"){
	
		$q->eksekusi("select nama from mst_anggota where no_anggota = '$no'");
		$data = $q->get1obj();
		if($data->nama){?>
			<input type="text" name="nama" value="<?php echo $data->nama; ?>" id="namas" readonly  />
	<?php
		}else{ ?> 
			<input type="text" name="nama" id="namas" readonly>
	<?php
		}
	}elseif($ambil=="photo"){
		$q->eksekusi("select photo from mst_anggota where no_anggota = '$no'");
		$data = $q->get1obj();
		if($q->get_jum() > 0){
			if($data->photo){?>
				<img src="<?php echo $data->photo?>" />
			<?php 
			}else{?>
				<img src="img/who.gif" />
	<?php   }
		}
	}elseif($ambil =="angsur_ke"){
		$q->eksekusi("select count(ang.angsur_ke) as total from mst_angsur ang where ang.no_anggota= '$no' and kd_trans_pinjam = '$ktp' ");
		$data= $q->get1obj();
		$angsur_ke =$data->total + 1 ;
	?>	<input type="text" name="angsur_ke" value="<?php echo $angsur_ke; ?>" readonly />
	<?php
		
	}elseif($ambil =="jumlah_angsur"){
		$q->eksekusi("select jumlah_angsur from mst_pinjam where no_anggota= '$no' and kd_trans_pinjam='$ktp' ");
		$data= $q->get1obj();
		if($data->jumlah_angsur){?>
			<input type="text" name="jum_angsur" value="<?php echo $data->jumlah_angsur; ?>" readonly />
	<?php
		}else{ ?> 
			<input type="text" name="jum_angsur" readonly>
	<?php 
		}
	}elseif($ambil =="besar_angsur"){
		$q->eksekusi("select besar_angsur from mst_pinjam where no_anggota = '$no'");
		$data= $q->get1obj();
	?>	
			<input type="text" name="besarang" value="<?php echo $data->besar_angsur; ?>" readonly />
	<?php	
	}elseif($ambil == "besar_saldo"){
		$jns = $_GET[jns];
		$q->eksekusi("select sum(besar_simpan) as besar_simpan from mst_simpan where kd_jns_simpan = '$jns' and no_anggota = '$no' group by no_anggota");
		$data = $q->get1obj();
		$besar = ($data->besar_simpan > 0) ? $data->besar_simpan : 0;
	?>
			<input type="text" name="besar_saldo" value="<?php echo $besar;?>" readonly id="besar_saldos" />
	<?php		
	}elseif($ambil == "besarSimpanWajib"){
		$q->eksekusi("select * from mst_setting");
		$data = $q->get1obj();
		if($no == 2){ $a =  $data->besar_simpanan_wajib; ?>
			<input type="text" name="besar" value="<?php echo $a;?>" readonly id="besar" style="background:#FFFFCC" />
		<?php
		}else{ $a = ""; ?>
			<input type="text" name="besar" id="besar" />		
	<?php
		}
	}
	?>