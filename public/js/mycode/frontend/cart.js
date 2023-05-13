var submit = $('.submit');
submit.click(function () {
    $('.submit_cart').submit();
});

function subtraction(id, categorydetail_id) {
    let quantity = $('.quantity-' + id + '-' + categorydetail_id);
    if (quantity.val() > 1) {
        quantity.val(parseInt(quantity.val()) - 1);
    }
}
function plus(id, categorydetail_id) {
    let quantity = $('.quantity-' + id + '-' + categorydetail_id);
    quantity.val(parseInt(quantity.val()) + 1);
}