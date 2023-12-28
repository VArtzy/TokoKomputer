// ambil elemen
const noNota = document.getElementById("no-nota")
const pin = document.getElementById("pin")
const cekNota = document.getElementById("btn-cek")
const isiModal = document.getElementById("isi-modal")

// tambahksn event ketika tombol cek nota di klik
cekNota.addEventListener("click", function () {
    var xhr = new XMLHttpRequest()

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            isiModal.innerHTML = xhr.responseText
            noNota.value = ""
            pin.value = ""
        }
    }

    xhr.open(
        "GET",
        "ajax/ceknota.php?no_nota=" + noNota.value + "&pin=" + pin.value,
        true
    )
    xhr.send()
})
