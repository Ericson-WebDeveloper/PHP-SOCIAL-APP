

export const imageToBase64 = (element, callback) => {
    let file = element.files[0];
    let reader = new FileReader();

    reader.onloadend = function() {
        callback(reader.result);
    }
    reader.readAsDataURL(file);
}
