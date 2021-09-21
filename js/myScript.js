
$(document).ready(function (){
    $('#changeProduct').on('click', function (event) {
        event.preventDefault();
        let id = $('#ID').val(),
            photo = $('img[src]').attr('src'),
            form = document.querySelector("#change-add-product"),
            formData = new FormData(form);
        formData.append('ID', id);
        formData.append('photo', photo);
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "/include/addChangeProduct.php");
        xhr.responseType = "text";
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const resultText = xhr.responseText;
                if (resultText == 1) {
                    $('section').prop('hidden', null);
                    $('form').remove();
                } else {
                    alert(resultText);
                }
            }
        };
        xhr.send(formData);
    })
})

$('.product-item__delete').click(function (event) {
    event.preventDefault();
    const idDelete = $(this).siblings('.product-item__id').text();
    let formData = new FormData();
    formData.append('ID', idDelete);
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "/include/deleteProduct.php");
    xhr.responseType = "text";
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const resultText = xhr.responseText;
            alert(resultText);
            if (!(resultText === "error deleting")) {
                $('#' + idDelete).remove();
            }
        }
    };
    xhr.send(formData);
})

document.addEventListener('DOMContentLoaded',function (){
    let links = document.querySelectorAll('a.filter__list-item');
    links.forEach(function (link) {
        link.addEventListener("click", function (event){
            event.preventDefault();
            link.classList.add('active');
        })
    })

    document.querySelector("#button_filter").addEventListener("click",function (event) {
        event.preventDefault();
        const url = '/include/products.php';
        let form = document.querySelector('#filter'),
            min = document.querySelector('.min-price').textContent,
            max = document.querySelector('.max-price').textContent,
            category = document.querySelector('a.filter__list-item.active').id,
            products = document.querySelector('#products'),
            formData = new FormData(form);
        formData.append('min', min);
        formData.append('max', max);
        formData.append('category', category);
        let xhr = new XMLHttpRequest();
        xhr.open("POST", url);
        xhr.responseType = "text";
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                products.innerHTML = xhr.response;
            }
        };
        xhr.send(formData);
    })
})
