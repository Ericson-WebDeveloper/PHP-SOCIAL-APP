

export const successAlert = (message, position = "left") => {
    return Toastify({
        text: message,
        duration: 3000,
        close: true,
        gravity: "top", // `top` or `bottom`
        position: position, // `left`, `center` or `right`
        stopOnFocus: true, // Prevents dismissing of toast on hover
        style: {
            background: "linear-gradient(to right, #00b09b, #96c93d)",
        } // Callback after click
    }).showToast();
}

export const errorAlert = (message, position = "left") => {
    return Toastify({
        text: message,
        duration: 3000,
        close: true,
        gravity: "top", // `top` or `bottom`
        position: position, // `left`, `center` or `right`
        stopOnFocus: true, // Prevents dismissing of toast on hover
        style: {
            background: "linear-gradient(315deg, #3f0d12 0%, #a71d31 74%)",
        } // Callback after click
    }).showToast();
}