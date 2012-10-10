function getTags(keyWord) {

	// set initial variables
	var keyWord = keyWord;
	var tagList1 = [];
    var tagss = [];

    var apiKey = '8feb459f9cd322658556e3a761867c46';

    //http://api.flickr.com/services/rest/?method=flickr.tags.getRelated&api_key=8feb459f9cd322658556e3a761867c46&tag=london
    $.getJSON('http://api.flickr.com/services/rest/?method=flickr.tags.getRelated&api_key=' + apiKey + '&tag=' + keyWord + '&format=json&nojsoncallback=1', function(json) {
        //alert("callback executed as response recieved");
    	$(json).each(function(index) {
	        tagList1.push(this.tags.tag);
    	});

        tagList1 = tagList1[0];
        len = tagList1.length;

        $('.tag').remove();
        $('#tag-list .ui-block-a').remove();
        $('#tag-list .ui-block-b').remove();

        for (var i = 0; i < 10; i++)
        {
			if (i%2 ===0)	{
			            $('#tag-list').append('<div class="ui-block-a"><li class="tag close'+i+'"><span class="tags">' +tagList1[i]._content + '</span></li></div>');
			}else{
			            $('#tag-list').append('<div class="ui-block-b"><li class="tag close'+i+'"><span class="tags">' +tagList1[i]._content + '</span></li></div>');
			}
        }
        $('.tag').draggable({revert: true});

    });
    	    
}

$(document).ready(function() {

    var len;

    $("#form-flickr").keyup(function(keyWord) {
    	var keyWord = $("#form-flickr-keyword").val();
    	getTags(keyWord);

        return false;
    });

    $('#upload').droppable({
                    accept: 'li',
                    drop: function(event, ui) {
                        $(ui.draggable).css({top: '0px', left: '0px'}).appendTo('#upload ul');
                    }
                });

    $('#load').droppable({
                    accept: 'li',
                    drop: function(event, ui) {
                        $(ui.draggable).css({top: '0px', left: '0px'}).appendTo('#load ul');
                    }
                });

    document.getElementById('files').addEventListener('change', handleFileSelect, false);
});

$('#files').live("change", function(event){
        handleFileSelect;
    });

$(".close").live("click", function(event){
    var cls = $(this).attr('class');
    var temp;
    for (var i = 0; i < len; i++)
        {
            if (cls.indexOf('close' + i)>=0)
                temp = i;
        }
    //alert(temp);
    $('.close' + temp).remove();
    return false;
});



