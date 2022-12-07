// ************************************************
// Shopping Cart API
// Created by 'Farrel Nikoson'
// cart : Array
// Item : Object/Class
// addItemToCart : Function
// removeItemFromCart : Function
// removeItemFromCartAll : Function
// clearCart : Function
// countCart : Function
// totalCart : Function
// listCart : Function
// saveCart : Function
// loadCart : Function
// ************************************************

var shoppingCart = (function () {
    // =============================
    // Private methods and propeties
    // =============================
    cart = []

    // Constructor
    function Item(id, name, price, stok, count) {
        this.id = id
        this.name = name
        this.price = price
        this.stok = stok
        this.count = count
    }

    function setCookie(name, value, days) {
        var expires = ""
        if (days) {
            var date = new Date()
            date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000)
            expires = "; expires=" + date.toUTCString()
        }
        document.cookie = name + "=" + (value || "") + expires + "; path=/"
    }
    function getCookie(name) {
        var nameEQ = name + "="
        var ca = document.cookie.split(";")
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i]
            while (c.charAt(0) == " ") c = c.substring(1, c.length)
            if (c.indexOf(nameEQ) == 0)
                return c.substring(nameEQ.length, c.length)
        }
        return null
    }

    // Save cart
    function saveCart() {
        setCookie("shoppingCart", JSON.stringify(cart), 7)
    }

    // Load cart
    function loadCart() {
        cart = JSON.parse(getCookie("shoppingCart"))
    }
    if (getCookie("shoppingCart") != null) {
        loadCart()
    }

    // =============================
    // Public methods and propeties
    // =============================
    var obj = {}

    // Add to cart
    obj.addItemToCart = function (id, name, price, stok, count) {
        for (var item in cart) {
            if (cart[item].name === name) {
                cart[item].count++
                saveCart()
                return
            }
        }
        var item = new Item(id, name, price, stok, count)
        cart.push(item)
        saveCart()
    }
    // Set count from item
    obj.setCountForItem = function (name, count) {
        for (var i in cart) {
            if (cart[i].name === name) {
                cart[i].count = count
                break
            }
        }
    }
    // Remove item from cart
    obj.removeItemFromCart = function (name) {
        for (var item in cart) {
            if (cart[item].name === name) {
                cart[item].count--
                if (cart[item].count === 0) {
                    cart.splice(item, 1)
                }
                break
            }
        }
        saveCart()
    }

    // Remove all items from cart
    obj.removeItemFromCartAll = function (name) {
        for (var item in cart) {
            if (cart[item].name === name) {
                cart.splice(item, 1)
                break
            }
        }
        saveCart()
    }

    // Clear cart
    obj.clearCart = function () {
        cart = []
        saveCart()
    }

    // Count cart
    obj.totalCount = function () {
        var totalCount = 0
        for (var item in cart) {
            totalCount += cart[item].count
        }
        return totalCount
    }

    // Total cart
    obj.totalCart = function () {
        var totalCart = 0
        for (var item in cart) {
            totalCart += cart[item].price * cart[item].count
        }
        return Number(totalCart.toFixed(2))
    }

    // List cart
    obj.listCart = function () {
        var cartCopy = []
        for (i in cart) {
            item = cart[i]
            itemCopy = {}
            for (p in item) {
                itemCopy[p] = item[p]
            }
            itemCopy.total = Number(item.price * item.count).toFixed(2)
            cartCopy.push(itemCopy)
        }
        return cartCopy
    }

    return obj
})()

// Trigers & event

document.querySelectorAll(".add-to-cart").forEach((a) => {
    a.addEventListener("click", (e) => {
        e.preventDefault()
        var id = Number(a.getAttribute("data-id"))
        var name = a.getAttribute("data-name")
        var price = Number(a.getAttribute("data-price"))
        var stok = Number(a.getAttribute("data-stok"))
        shoppingCart.addItemToCart(id, name, price, stok, 1)
        displayCart()
    })
})

tambahBarang = (e) => {
    e.preventDefault()
    var id = Number(e.target.getAttribute("data-id"))
    var name = e.target.getAttribute("data-name")
    var price = Number(e.target.getAttribute("data-price"))
    var stok = Number(e.target.getAttribute("data-stok"))
    shoppingCart.addItemToCart(id, name, price, stok, 1)
    displayCart()
}

document.querySelector(".btn-clear-cart").addEventListener("click", () => {
    shoppingCart.clearCart()
    displayCart()
})

function displayCart() {
    var cartArray = shoppingCart.listCart()
    var output = ""
    for (var i in cartArray) {
        output += `<div class="mb-4">
        <span>${cartArray[i].name}</span>
        <span class="badge badge-sm">${rupiah(cartArray[i].price)} *</span>
        <span class="badge badge-sm">${cartArray[i].count}</span>
        <span class="badge badge-success badge-sm">${rupiah(
            cartArray[i].total
        )}</span>
        <div>
        <button onclick="minusItem(event)" class="btn btn-success btn-sm minus-item" data-name="${
            cartArray[i].name
        }">-</button>
        <button onclick="plusItem(event)" class="btn btn-success btn-sm plus-item" data-name="${
            cartArray[i].name
        }" date-id="${cartArray[i].id}" date-price="${
            cartArray[i].price
        }" data-stok="${cartArray[i].stok}" data-count="${
            cartArray[i].count
        }">+</button>
        <button onclick="deleteItem(event)" class="btn btn-error btn-sm delete-item" data-name="${
            cartArray[i].name
        }">X</button>
        </div>
        </div>
        `
    }

    document.querySelector(".isi-modal").innerHTML = output
    document.querySelector(".indicator-item").textContent =
        shoppingCart.totalCount()
    document.querySelector(
        ".text-info-total"
    ).textContent = `${shoppingCart.totalCount()} Barang`
    document.querySelectorAll(".text-info-cart").forEach((t) => {
        t.textContent = `Subtotal: ${rupiah(shoppingCart.totalCart())}`
    })
}

minusItem = (e) => {
    var name = e.target.getAttribute("data-name")
    shoppingCart.removeItemFromCart(name)
    displayCart()
}

plusItem = (e) => {
    var name = e.target.getAttribute("data-name")
    var id = e.target.getAttribute("data-id")
    var price = e.target.getAttribute("data-price")
    var stok = e.target.getAttribute("data-stok")
    var count = e.target.getAttribute("data-count")
    displayCart()
}

deleteItem = (e) => {
    var name = e.target.getAttribute("data-name")
    shoppingCart.removeItemFromCartAll(name)
    displayCart()
}

const rupiah = (number) => {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
    }).format(number)
}

displayCart()

window.addEventListener("DOMContentLoaded", () => {
    const loadinDomContent = document.querySelector(".loading-dom-content")
    if (loadinDomContent) loadinDomContent.style.display = "none"
})
