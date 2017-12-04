function validasiPetugas(){
	// deklarasi variabel
	var nama_petugas = document.getElementById('nama_petugas');
	var alamat_petugas = document.getElementById('alamat_petugas');
	var no_telp = document.getElementById('no_telp');
	var jenis_kelamin = document.getElementById('jenis_kelamin');
	// pengecekan secara urut
	if(Huruf(nama_petugas, "Masukkan huruf untuk Nama")){
		if(HurufAngka(alamat_petugas, "Masukkan Alamat")){
			if(Angka(no_telp, "Masukkan Angka untuk Nomer Telepon")){
				if(Pilihan(jenis_kelamin, "Silahkan Pilih Grup")){
					return true;
				}
			}
		}
	}
	return false;
}

function validasiAnggota(){
	// deklarasi variabel
	var tanggal = document.getElementById('tanggal');
	var jam = document.getElementById('jam');
	var acara = document.getElementById('acara');
	var c_ruangan = document.getElementById('c_ruangan');
	var c_rapat = document.getElementById('c_rapat');
	var keterangan = document.getElementById('keterangan');
	
	// pengecekan secara urut
	if(Jam(jam, "Masukkan waktu yang valid (00:00)")){
		if(Pilihan(c_ruangan, "Silahkan Pilih Ruangan")){
			if(Pilihan(c_rapat, "Silahkan Pilih Jenis Rapat")){
				//if(Huruf(keterangan, "Masukkan Keterangan")){
					return true;
				//}
			}
		}
	}
	return false;
}

function validasiSimpan(){
	// deklarasi variabel
	var besar_simpan = document.getElementById('besar_simpan');
	
	// pengecekan secara urut
	if(Angka(besar_simpan, "Masukkan Angka!!")){
		return true;
	}
	return false;
}


// pengecekan
function notEmpty(param, pesan){
	if(param.value.length == 0){
		alert(pesan);
		param.focus();
		return false;
	}
	return true;
}

function Tanggal(param, pesan){
	var dateExpression = /^\d{1,2}\/\d{1,2}\/\d{4}$/;
	if(!param.value.match(dateExpression)){
		alert(pesan);
		param.focus();
		return false;
	}
	return true;
}

function Jam(param, pesan){
	var timeExpression = /^\d{1,2}:\d{2}([ap]m)?$/;
	if(!param.value.match(timeExpression)){
		alert(pesan);
		param.focus();
		return false;
	}
	return true;
}

function Angka(param, pesan){
	var numericExpression = /^[0-9]+$/;
	if(param.value.match(numericExpression)){
		return true;
	}else{
		alert(pesan);
		param.focus();
		return false;
	}
}

function Huruf(param, pesan){
	var alphaExp = /^[a-zA-Z]+$/;
	if(param.value.match(alphaExp)){
		return true;
	}else{
		alert(pesan);
		param.focus();
		return false;
	}
}

function HurufAngka(param, pesan){
	var alphaExp = /^[0-9a-zA-Z]+$/;
	if(param.value.match(alphaExp)){
		return true;
	}else{
		alert(pesan);
		param.focus();
		return false;
	}
}

function checkRadio (param, pesan) {
	var radios = param.value;
	for (var i=0; i <radios.length; i++) {
		if (radios[i].checked) {
			return true;
		}
	}
	return false;
} 

function lengthRestriction(param, min, max){
	var uInput = param.value;
	if(uInput.length >= min && uInput.length <= max){
		return true;
	}else{
		alert("Masukkan antara " +min+ " dan " +max+ " karakter");
		param.focus();
		return false;
	}
}

function Pilihan(param, pesan){
	if(param.value == ":: Pilih ::"){
		alert(pesan);
		param.focus();
		return false;
	}else{
		return true;
	}
}

function emailValidator(param, pesan){
	var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
	if(param.value.match(emailExp)){
		return true;
	}else{
		alert(pesan);
		param.focus();
		return false;
	}
}


function validPinjam(){
	var saldo 			= document.getElementById("besar_pinjamanan").value;
	var pinjam			= document.getElementById('keterangan').value;		
	if(saldo - pinjam < 0 ){
		if(confirm("Maaf! Pinjaman lebih besar dari Maksimal Pinjaman") == false ) 
		{
			document.getElementById('besar_pinjaman').value= "";
			document.getElementById('besar_pinjaman').focus();
			return; 
		}				
	}
}
function cekBagi()
{
	var pinjam			= document.getElementById('besar_pinjaman').value;
	var jum_angsur		= document.getElementById('lama_angsuran').value;
	if(!jum_angsur){
		document.getElementById("besar_angsuran").value = "";
	}else{
		var hasil = Math.ceil(pinjam/jum_angsur);
		document.getElementById("besar_angsuran").value = hasil;
	}
}
function getAngsur(){
	var pinjam			= document.getElementById('besar_pinjaman').value;
	var jum_angsur		= document.getElementById('lama_angsuran').value;
	if(!jum_angsur || !Number (jum_angsur) || jum_angsur < 1){ 
		document.getElementById('jum_angsur').value="";
		document.getElementById('jum_angsur').focus();
		document.getElementById('besar_angsuran').value="";
		alert("Jumlah angsur belum diisi!") ;
		return false;
	}if(pinjam - jum_angsur < 0){
		alert("Jumlah angsur harus lebih kecil dari Besar Pinjaman!!");	
		return false;
	}
	
	if(!jum_angsur){
		document.getElementById("besar_angsuran").value = "";
	}else{
		var hasil = Math.ceil(pinjam/jum_angsur);
		document.getElementById("besar_angsuran").value = hasil;
	}
}




function validateForm(){
	var okSoFar=true
	with (document.form){
	if (nama.value=="" && okSoFar){
		okSoFar=false
		alert("Masukkan Nama Lengkap Anda")
		nama.focus()
	}
	
	if (alamat.value=="" && okSoFar){
		okSoFar=false
		alert("Masukkan Alamat Lengkap Anda")
		alamat.focus()
	}
	
	var foundAt = email.value.indexOf("@",0)
	if (foundAt < 1 && okSoFar){
		okSoFar = false
		alert ("Silahkan tulis alamat email Anda yang VALID")
		email.focus()
	}
	
	var e1 = email.value
	var e2 = email2.value
	if (!(e1==e2) && okSoFar){
		okSoFar = false
		alert ("Masukkan lagi alamat email yang SAMA")
		email.focus()
	}
	
	if (username.value=="" && okSoFar){
		okSoFar=false
		alert("Masukkan Username Yang Anda Inginkan")
		username.focus()
	}
	
	if (password.value=="" && okSoFar){
		okSoFar=false
		alert("Masukkan Password Anda")
		password.focus()
	}
	
	var p1 = password.value
	var p2 = password2.value
	if (!(p1==p2) && okSoFar){
		okSoFar = false
		alert ("Password harus SAMA")
		password.focus()
	}
	
	if (okSoFar==true)  submit();
	}
}
