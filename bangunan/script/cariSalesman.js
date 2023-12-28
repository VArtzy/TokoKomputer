// ambil elemen
var keywords = document.getElementById("keywords")
var tombolcaris = document.getElementById("tombol-caris")
var containers = document.getElementById("containers")

// tambahksn event ketika keyword ditulis
keywords.addEventListener("keyup", function () {
    // buat objek ajax
    var xhr = new XMLHttpRequest()

    // cek kesiapan ajax
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            containers.innerHTML = xhr.responseText
        }
    }

    // eksekusi ajax
    xhr.open("GET", "ajax/salesman.php?keyword=" + keywords.value, true)
    xhr.send()
})
