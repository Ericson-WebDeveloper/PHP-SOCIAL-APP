

export const imageToBase64 = (element, callback) => {
    let file = element.files[0];
    let reader = new FileReader();

    reader.onloadend = function() {
        callback(reader.result);
        // console.log('RESULT', reader.result)
    }
    reader.readAsDataURL(file);
}

// export default class HelperClass {
//     imageToBase64 = (element, callback) => {
//         let file = element.files[0];
//         let reader = new FileReader();

//         reader.onloadend = function() {
//             callback(reader.result);
//         }
//         reader.readAsDataURL(file);
//     }
// }