// $(document).ready(function (){
//     $('#changeProduct').on('click', function (event) {
//         event.preventDefault();
//         let name = $('input[name="name"]').val();
//         let price = $('input[name="price"]').val();
//         let photo = $('img[src]').attr('src');
//         let select = $('select').val();
//         let newest = $('#new').prop('checked');
//         let sale = $('#sale').prop('checked');
//         let id = $('#ID').val();
//         $.ajax({
//             method: 'POST',
//             url: '/include/addDeleteChangeProduct.php',
//             data: {ID: id, name: name, price: price, photo: photo, select: select, new: newest, sale: sale}
//         })
//             .done(function (msg){
//                 alert(msg);
//                 $('section').prop('hidden', null);
//                 $('form').remove();
//             });
//     })
// })

$(document).ready(function (){
    $('#changeProduct').on('click', function (event) {
        event.preventDefault();
        let id = $('#ID').val();
        let photo = $('img[src]').attr('src');
        let form = document.querySelector("#change-add-product");
        let formData = new FormData(form);
        formData.append('ID', id);
        formData.append('photo', photo);
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "/include/addDeleteChangeProduct.php");
        xhr.responseType = "text";
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const resultText = xhr.responseText;
                console.log(resultText);
            }
        };
        xhr.send(formData);
    })
})
