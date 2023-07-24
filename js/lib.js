function redirect(url)
{
    location.href = url;
}

$(document).ready(function () {


    if($('#page').length > 0)
    {
        $('#page').keypress(function (e) {
            if( (e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode == 13) )
            {
                var page = parseInt($(this).val().trim());
                var totalPage = parseInt($(this).attr('data-total-page'));
                if(page <= 0)
                    page = 1;
                if(e.keyCode == 13)
                {
                    if(page <= totalPage)
                    {
                        var url = $(this).attr('data-url');
                        redirect(url+'&page='+page);
                    }
                    else
                        $('#page').popover('show');
                }
            }
            else
                return false;
        });
    }


    if($('#limit').length > 0)
    {
        $('#limit').change(function(){
            var limit = $(this).val();
            var url = $(this).attr('data-url');
            redirect(url+'&limit='+limit);
        });
    }


    $('[data-toggle="tooltip"]').tooltip();

    $('#cart-btn').click(function(){
        $('#cart-box').toggle();
    });

    $('body > *').click(function (evt) {
        if(evt.target.id == "cart-btn")
            return;
        if($(evt.target).closest('#cart-btn').length)
            return;
        if(evt.target.id == "cart-box")
            return;
        if($(evt.target).closest('#cart-box').length)
            return;

        $('#cart-box').hide();
    });

    $('#top-menu').superfish();


    $('.btn-view-product').click(getAjaxViewPro);

    $('.btn-add-cart').click(addToCart);

    $('#add-cart-num').click(addToCartByNum);

});


function validateEmail(email)
{
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}


function getAjaxViewPro()
{
    var id =parseInt($(this).attr('data-pro-id'));
    if(id > 0)
    {
        var product_title = $('#product-modal-title');
        var product_img = $('#product-modal-img');
        var product_desc = $('#product-modal-desc');
        $('#product-modal').modal('show');
        $('#product-modal-loading').html('لطفا صبر کنید ...');
        product_title.html('');
        product_img.html('');
        product_desc.html('');
        $.post('ajax.php',{'id':id,'do':'getProAjax'},function(data){

            var data2 = JSON.parse(data);
            if(data2['status'] == 1)
            {
                $('#product-modal-loading').hide();
                product_title.html(data2['title']);
                product_img.html(data2['img']);
                product_desc.html(data2['desc']);
            }
            else
            {
                $('#product-modal-loading').html('خطای رخ داده است');
            }
        });
    }
}


function addToCart() {
    var pro_id = $(this).attr('data-id');
    var p = {'do':'addToCart','id':pro_id};
    $.post('ajax.php',p,function (data) {
        var data2 = JSON.parse(data);
        if(data2['status'] == 'ok')
        {
            updateCart();
            addItemCartToTbl(data2['row'],data2['check_id']);
        }
    });
}

function updateCart() {
    $.post('ajax.php',{'do':'getUpdateCart'},function (data) {
        var data2 = JSON.parse(data);
        $('#cart-count').text(data2['count']);
        $('#cart-price').text(data2['price']);
    });
}

function addItemCartToTbl(html,check_id) {
    
    $('#cart-item-list').find('#cart-no-item').remove();
    var obj = $('#cart-item-list').find('#cart-pro-'+check_id);
    if(obj.length > 0)
        obj.remove();
    $('#cart-item-list').append(html);
}



function addToCartByNum() {
    var pro_id = $(this).attr('data-id');
    var num = $('#num').val();
    var p = {'do':'addToCart','id':pro_id,'num':num};
    $.post('ajax.php',p,function (data) {
        var data2 = JSON.parse(data);
        if(data2['status'] == 'ok')
        {
            updateCart();
            addItemCartToTbl(data2['row'],data2['check_id']);
        }
    });
}
