jQuery(document).ready(function($){
	
	$('.selectpicker', 'form[name="search-form"]').each(function(){	
		$lbl = $(this).prev('label')
		if($lbl.text()){
			$(this).prepend('<option selected="selected" value="0">'+$lbl.text()+'</option>');
			$lbl.remove()
		}
	})
	.selectpicker();
	function checkFilters(){
		$curFilters= new Array();
		$('.selectpicker', 'form[name="search-form"]').each(function(){
			if(parseInt($(this).val()) > 0) 
				$curFilters.push($(this).attr('id')+'-'+$(this).val())
		})
		$('.unsmd-item').removeClass('no-hidden');
	if($curFilters.length > 0){
			$('.unsmd-item-list').addClass('applyFilters');
			$('.unsmd-item.'+$curFilters.join('.')).addClass('no-hidden')
		}else{
			$('.unsmd-item-list').removeClass('applyFilters');			
		}
	}
	$('select#medio').change(function(){
		$cVal = parseInt($(this).val())
		if($cVal){
		$('.socialItem-'+$cVal).parents('.unsmd-item').addClass('medio-'+$cVal);
		}
checkFilters();
	});
	$('select#sede').change(function(){
		checkFilters();
	});
	/*$('#sede','.tx-unal-social-media-directory').change(function(){
		$elm=$('#facultad','.tx-unal-social-media-directory')
		if(!parseInt($(this).val())){
			$elm.empty().append(new Option('--Seleccione la sede--',0)).selectpicker('refresh').selectpicker('val', '0');
			return false
		}
		$.get('index.php',{'type':'785634','tx_unalsocialmediadirectory_unsmd[action]':'facultades','tx_unalsocialmediadirectory_unsmd[controller]':'Eid','tx_unalsocialmediadirectory_unsmd[sede]':$(this).val()},function(data){
			
			$elm.empty().append(new Option('--Seleccione la facultad--',0));
			$.each(data,function(){
				$elm.append(new Option(this.nombre,this.id))
			})
			$elm.selectpicker('refresh').selectpicker('val', '0');
		},'json')
	});*/
	
})


