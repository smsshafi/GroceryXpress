
function showUpdate(selector) {
        selector.parent().addClass('hidden');
        selector.parent().siblings('.tdupdate').removeClass('hidden');
        selector.parent().siblings('.tdupdate').children('.slquantity').attr('value', '1');
}

function showAdd(selector, callBack) {
        selector.parent().addClass('hidden');
        selector.parent().siblings('.tdadd').removeClass('hidden');
        if (typeof callback != 'undefined') {
                callBack();
        }
}

$(document).ready(function(){

    $('.sladd').click(function(){
        var currentselector = $(this);
        var thisid = $(this).attr('id');
        var thisidsplit = thisid.split("_");
        var product_id = thisidsplit[1];

        $.post('shoppinglisthandler.php?add=1', {product_id: product_id, user_id: user_id}, 
        function(response){
            var response_json = eval('(' + response + ')');
            showNotification(response_json.message);
            if (response_json.success) {
                    showUpdate(currentselector);
            }
        })
    })

	$('.slremove').click(function(){
                var currentselector = $(this);
                var thisid = $(this).attr('id');
		var thisidsplit = thisid.split("_");
                var product_id = thisidsplit[1];

		$.post('shoppinglisthandler.php?remove=1', {product_id: product_id, user_id: user_id}, 
                function(response){
                        var response_json = eval('(' + response + ')');
                        showNotification(response_json.message);
                        if (response_json.success) {
                                showAdd(currentselector);
                                if (UpdateSubTotal && Function == UpdateSubTotal.constructor) {
                                	UpdateSubTotal();
                                }
                        }

                })
        })

	$('.slincrement').click(function(){
                var currentselector = $(this);
                var thisid = $(this).attr('id');
                var thisidsplit = thisid.split("_");
                var product_id = thisidsplit[1];
        
                $.post('shoppinglisthandler.php?increment=1', {product_id: product_id, user_id: user_id}, 
                function(response){
                    var response_json = eval('(' + response + ')');
                        showNotification(response_json.message);
                        if (response_json.success) {
                                currentselector.siblings('.slquantity').attr('value', (parseInt(currentselector.siblings('.slquantity').attr('value')) + 1));
                                if (UpdateSubTotal && Function == UpdateSubTotal.constructor) {
                                	UpdateSubTotal();
                                }
                        }
                })
				
        })

        $('.sldecrement').click(function(){
		if (parseInt($(this).siblings('.slquantity').attr('value')) == 1) {
                    $(this).siblings('.slremove').click();
                }
                else {
                    var currentselector = $(this);
                    var thisid = $(this).attr('id');
                    var thisidsplit = thisid.split("_");
                    var product_id = thisidsplit[1];
    
                    $.post('shoppinglisthandler.php?decrement=1', {product_id: product_id, user_id: user_id}, 
                    function(response){
    					
                        var response_json = eval('(' + response + ')');
    			showNotification(response_json.message);
    			if (response_json.success) {
                            currentselector.siblings('.slquantity').attr('value', (parseInt(currentselector.siblings('.slquantity').attr('value')) - 1));
                            if (UpdateSubTotal && Function == UpdateSubTotal.constructor) {
                            	UpdateSubTotal();
                            }
                        }
                    })
                }
        })
})
