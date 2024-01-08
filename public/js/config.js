function showLoader() {
    document.getElementById("loader").classList.remove("d-none");
}
function hideLoader() {
    document.getElementById("loader").classList.add("d-none");
}

function successToast(msg) {
    Toastify({
        gravity: "top", // `top` or `bottom`
        position: "right", // `left`, `center` or `right`
        text: msg,
        duration: 2000,
        className: "mt-5",
        style: {
            background: "green",
        },
    }).showToast();
}

function errorToast(msg) {
    Toastify({
        gravity: "top", // `top` or `bottom`
        position: "right",
        duration: 2000, // `left`, `center` or `right`
        text: msg,
        className: "mt-5",
        style: {
            background: "red",
        },
    }).showToast();
}
