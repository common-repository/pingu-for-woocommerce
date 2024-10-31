jQuery(document).ready(function(){
jQuery('.ffgg').hide();
		jQuery('.add_to_cart_button').live('click', function(){
				var rrrt = jQuery(this).attr("data-product_id");
				var nak_u = 'dddd';
				jQuery(this).replaceWith('<button  data-product_id="'+rrrt+'" class="my-az-rem rem_the'+rrrt+' button">Remove From Cart</button>');
				setTimeout(
					function() {
					jQuery.ajax({
							type: 'POST',
							url: ccjs,
							data: 'nak_u='+nak_u,
							success: function(response)
							{
								if (response === "yes")
								{	
									jQuery('.ffgg').hide();
									jQuery('.ffgg h2').text(fgtxt);
									jQuery("html, body").animate({ scrollTop: 0 }, "fast");
									jQuery('.ffgg').show();
								}
								else
								{
									jQuery('.ffgg').hide();
									jQuery('.ffgg h2').text(fgtxt);
									jQuery("html, body").animate({ scrollTop: 0 }, "fast");
									jQuery('.ffgg').show();
								}
							}
							});	
					},
					700);
				
				jQuery(".rem_the" + rrrt).click(function(){
						var product_id = jQuery(this).attr("data-product_id");					
						jQuery.ajax({
						type: 'POST',
						url: fgjs,
						data: 'the_pc='+product_id,
						success: function(response)
						{
							if (response === "Removed")
							{
								var nak_u = 'dddd';
								jQuery(".rem_the" + product_id).replaceWith('<a class="add_to_cart_button button product_type_simple" data-product_id="'+product_id+'" href="/hire/shop/?add-to-cart='+product_id+'">Add to cart</a>');
								setTimeout(
								function() {
								jQuery.ajax({
										type: 'POST',
										url: ccjs,
										data: 'nak_u='+nak_u,
										success: function(response)
										{
											if (response === "yes")
											{
												jQuery('.ffgg').hide();	
												jQuery('.ffgg h2').text('Removed successfully from Cart');	
												jQuery("html, body").animate({ scrollTop: 0 }, "fast");
												jQuery('.ffgg').show();
												
											}
											else
											{
												jQuery('.ffgg').hide();
											}
										}
										});	
								},
								500);
							}
							else
							{
								alert('Could Not Remove!')
							}
						}
						});
								
					});
				});
});