var Common = {
  load : function(){
    var body= $('html').height();
    $('#loader').height(body);
  },
  wait : function() {
    var str = '<img src="global/img/loader.gif" id="progress" />';
    $('#main-content').prepend(str);
  },
  end : function(){
    $('#progress').remove();
  },
  clearDiv : function(div){
    div = div ? $(div).html('') : false;
  },
  removeDiv : function(div){
    div = div ? $(div).remove() : false;
  },
  bindLoading: function(id){
    $(id).removeClass('pre').addClass('post');
    $(id).val('');
  },
  unbindLoading: function(id, msg){
    $(id).removeClass('post').addClass('pre');
    $(id).val(msg);
  }
}
var MenuSetting = {
  create : function(){
    $('.menu').mouseover(function(){
      $(this).children('a').css('display', 'block');
    });
    $('.menu').mouseout(function(){
      $(this).children('a').css('display', 'none');
    });
  },
  resetButton : function(options){

    var str = '<div class="menu" style="margin-left:105px"><div id="newForm">New</div></div>';
    $(str).appendTo('#menubar');

      options : {
        form          : null
        iframe        : null
        hiddenId      : null
      }
    $('#newForm').click(function(){
      $(options.form)[0].reset();

      //clear hidden field
      options.hiddenId = null ? null : $(options.hiddenId).val('');

      //clear iframe
      if(options.iframe !== null){
        $(options.iframe).contents().find('body').html('');
      }

      //clear delete button
      $('#deleteButton').html('');

    });
  }
}
var Search = {
  onload : function(ajaxCall, form){
    $('#search_result').html('');
    $.get(ajaxCall, function(data){
      if(data){
        var list = '<ul id="search_ul">';

        for(var i=0;i<data.length;i++){
          list += '<li id="'+ data[i].k0+'">'+ data[i].k1+'</li>';
        }

        list += '</ul>';

        $('#search_result').append(list);
        $('#search_result ul li').click(function(){

          if(form !== undefined){
            $(form)[0].reset();
            $(form).validationEngine('hideAll');
          }

          var id = ($(this).attr('id'));
          refreshForm(id);
        });
      }
    });
  },
  filter : function(keyword, list){
    if((keyword && list) === undefined){
      keyword = $('#search').val();
      list = $('ul#search_ul > li');
    }
    for(var count = 0; count < list.length; count++){
      if(list[count].textContent.length < keyword.length){
        $(list[count]).hide();
      } else {
        if(list[count].textContent.substr(0, keyword.length).toLowerCase() === keyword.toLowerCase()){
          $(list[count]).show();
        } else {
          $(list[count]).hide();
        }
      }
    } //end for loop
  }
};

$(function(){
  Common.load();
  MenuSetting.create();
  $('#loader').remove();
  
  $('.nav > li').each(function(){
		
					if($(this).children('a').attr('href') == document.URL){
			
						$(this).addClass('active');
		
					}
				});

				// POSITION STATIC TWIPSIES
				$(window).bind( 'load resize', function () {
		  
					$('body > .topbar').scrollSpy();
		
					$(".twipsies a").each(function () {
						$(this)
						.twipsy({
							live: false
							, placement: $(this).attr('title')
							, trigger: 'manual'
							, offset: 2
						})
						.twipsy('show');
					});
				});
});