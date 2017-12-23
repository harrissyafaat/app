<strong>PENCARIAN:</strong><br>  
<form action="<?$_SERVER['PHP_SELF']?>" method="post" name="pencarian" id="pencarian">  
  <input type="text" name="search" id="search">  
  <input type="submit" name="submit" id="submit" value="CARI">  
</form>  
  
<?php  
include "../config/conn.php";
  
// menampilkan data  
  
if ((isset($_POST['submit'])) AND ($_POST['search'] <> "")) {  
  $search = $_POST['search'];  
  $sql = mysqli_query($koneksi, "SELECT * FROM mst_anggota WHERE nama LIKE '%$search%' ") or die(mysql_error());  
  //menampilkan jumlah hasil pencarian  
  $jumlah = mysqli_num_rows($sql);   
  if ($jumlah > 0) {  
    echo '<p>Ada '.$jumlah.' data yang sesuai.</p>';  
     
        while ($res=mysqli_fetch_array($sql, MYSQLI_ASSOC)) {  
        $nomor++; echo $nomor.'. ';  
        echo $res[nama].'<br>';  
      }  
  }  
  else {  
   // menampilkan pesan zero data  
    echo 'Maaf, hasil pencarian tidak ditemukan.';  
  }  
}   
else { echo 'Masukkan dulu kata kuncinya';}  
?>