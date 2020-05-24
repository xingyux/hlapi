// JavaScript Document
$(function(){
	var time_price={'1':'200','3':'500','6':'800','12':'1200','24':'2200','36':'3000'}//年份对应的服务器价格
	$('.all').click(function(){
		
		if($(this).attr('checked')){
			$('.choose').attr('checked','true')
			count_price();
		}else{
			$('.choose').removeAttr('checked');
			$('.total').html('￥0.00')
		}
		
	})
	$('.product_name input').click(function(){
		var result=0;
		var total_price=0;
		$('.product_name input').each(function(index, element) {
            if($(this).attr('checked')){
				result++;
				if(isNaN(Number($(this).parent().siblings().find('.num').attr('value')))){
					alert('请输入正确的购买数')	
				}else{
					total_price+=Number($(this).parent().siblings().find('.price').text())*Number($(this).parent().siblings().find('.num').attr('value'));
				}
			}
        });
		total_price=total_price.toFixed(2)
		$('.total').html('￥'+total_price)
		if(result==$('.product_name input').length){
			$('.all').attr('checked','true')
		}else{
			$('.all').removeAttr('checked')
		}
	})
	$('.num').keyup(function(){
		if(isNaN(Number($(this).attr('value')))||Number($(this).attr('value'))==0){
			$(this).attr('value','1')
		}else{
			count_price()
		}
		
	})
	
	/*删除*/
	$('.delete').click(function(){
		$(this).parents('table').remove();
		if($('.shopping_main_wrap table').length==1){
			$('.car_empty').css('display','block')	
		}
		count_price()
	})
	$('.time_all').change(function(){
		var val=$(this).attr('value');
		$('.product_name input').each(function(index, element) {
            if($(this).attr('checked')){
				$(this).parents('table').find('.time_choose').attr('value',val);
				$(this).parents('table').find('.time_choose option').each(function(index, element) {
                   if($(this).attr('value')==val){
					   $(this).attr('selected','true')
				   }
                });
				$(this).parents('table').find('.price').html(time_price[val]);
			}
        });
		count_price()	
	})
	$('.time_choose').change(function(){
		$(this).parents('table').find('.price').html(time_price[$(this).attr('value')]);
		count_price()	
	})
	$('.empty').click(function(){
		$('.shopping_main_wrap table').not('table:first').remove();
		$('.car_empty').css('display','block')	
	})	
})

function count_price(){
	var total_price=0;	
		$('.product_name input').each(function(index, element) {
			if($(this).attr('checked')){
				total_price+=Number($(this).parent().siblings().find('.price').text())*Number($(this).parent().siblings().find('.num').attr('value'))
			}
        });
		total_price=total_price.toFixed(2);
		$('.total').html('￥'+total_price)
}