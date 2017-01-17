jQuery(document).ready(function () {

	var colorofline = ["#F2BB5A","#F2BB5A","#A3C500","#00A0CA","#7593CF","#F2BB5A"];
	//alert('color '+colorofline[$('#curmenu').val()]);
	$('hr').css('background-color',colorofline[Number($('#curmenu').val())]);
	$('#show-sidebar').bootstrapSwitch();
	$('#show-sidebar').on('switchChange.bootstrapSwitch', function (e,s) {
		$('div#main').toggleClass('sidebar-show');
		$('#show-sidebar').toggleClass('s-flip h-flip');
	});
	
	$('#allkag').bootstrapSwitch();
	$('#allkag').on('switchChange.bootstrapSwitch', function (e,s) {
            var $url = $(this).data('url'), $state = s ? 1 : 0 ;
            $.ajax({
                type: "POST",
                url: $url,
                data: 'state='+$state, 
                success: function(retdata){
                    if(retdata == 'ok') location.reload();
                }
            });
            
        });

        $(document).on('click', '.panel-heading span.clickable', function(e){
	var $this = $(this);
	if(!$this.hasClass('panel-collapsed')) {
		$this.parents('.panel').find('.panel-body').slideUp();
		$this.addClass('panel-collapsed');
		$this.find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
	} else {
		$this.parents('.panel').find('.panel-body').slideDown();
		$this.removeClass('panel-collapsed');
		$this.find('i').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
	}
	});        

});

