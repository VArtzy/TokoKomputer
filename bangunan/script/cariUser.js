// ambil elemen
var keyword = document.getElementById("keyword")
var tombolcari = document.getElementById("tombol-cari")
var container = document.getElementById("container")

// tambahksn event ketika keyword ditulis
keyword.addEventListener("keyup", function () {
    // buat objek ajax
    var xhr = new XMLHttpRequest()

    // cek kesiapan ajax
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            container.innerHTML = xhr.responseText
        }
    }

    // eksekusi ajax
    xhr.open("GET", "ajax/user.php?keyword=" + keyword.value, true)
    xhr.send()
})
