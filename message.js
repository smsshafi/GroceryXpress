$(document).ready(function(){
			var product_id; 
			var image_url;

			$('#close_message').click(function(){
				$.unblockUI();
            })
            
            $('.product_image').click(function(){
                product_id = $(this).attr('id').split("_")[2];
                image_url = $(this).attr('src');
                $('#big_product_image').attr('src', image_url);
            })

			$('#big_product_image').load(function(){
				
				$('#message').show();
				$('#message_title').html($('#product_title_' + product_id).html()); 
                $('#message_description').html($('#product_description_' + product_id).html());
                $('#price').html($('#product_price_' + product_id).html());
				//var title_width = (800 - $('#big_product_image').width() - 70);
                //var desc_width = (800 - $('#big_product_image').width() - 50);
				//$('#message_title').css({'width': title_width});
				//$('#message_description').css({'width': desc_width});
				var top = ($(window).height() - $('#message img').height())/2;
                var left = (($(window).width() - 800)/2) + 4;
                $('#message').hide();
				top = top + "px";
				left = left + "px";
				$.blockUI({ message: $('#message'), css: {cursor: 'default', position: 'fixed', top: top, width: '800px', left: left}, overlayCSS: {cursor: 'default'}});
			})
			
			$('.product_title_td').click(function(){
				$(this).siblings(".product_image_td").children().click();
				
			})

		})
