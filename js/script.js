$("#tag-list .tags").live("click", function(){
	console.log($(this).attr('name'));
	 var clicked_tag = $(this).attr('name');
	 var exist_flag =false;
	//select
	if ($(this).hasClass('unselected')){
		// prevent duplication
		$('#tag-for-input li span').each(function(){
				if ($(this).attr('name') == clicked_tag){
						exist_flag=true;
				}
		});
		if (!exist_flag){
			$('#tag-for-input').append('<li class="tag close" ><span name="'+$(this).attr('name')+'" class="tags unselected">'+$(this).attr('name')+'</li>');
		}
		$(this).removeClass('unselected');
		$(this).addClass('selected');
	}
	//unselect
	else if ($(this).hasClass('selected')){
		// remove unselected tag
		$('#tag-for-input li span').each(function(){
				if ($(this).attr('name') == clicked_tag){
					$(this).parent().remove();
				}
		});
		$(this).removeClass('selected');
		$(this).addClass('unselected');
	}
	// save posted tags in taglist array
	var flag=false;
	$('#store-tags').val('');
	$('#tag-for-input li span').each(function(){
			if (flag){
			$('#store-tags').val($('#store-tags').val() + ',');
			}
			$('#store-tags').val($('#store-tags').val() + $(this).attr('name'));
				flag=true;
	});
});

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

        $('#tag-list .tag').remove();
		$('#tag-list').append('<li class="tag close"><span name="'+keyWord+'" class="tags unselected">' +keyWord + '</span></li>');

        for (var i = 0; i < 10; i++)
        {
            $('#tag-list').append('<li class="tag close'+i+'"><span name="'+tagList1[i]._content+'" class="tags unselected">' +tagList1[i]._content + '</span></li>');
        }
    });
}


$(document).ready(function() {
    var len;

    $("#form-flickr").keyup(function(keyWord) {
    	var keyWord = $("#form-flickr-keyword").val();
    	getTags(keyWord);
		$('#suggest_tags').attr("data-collapsed","false");
        return false;
    });
});


function downloadImg() {
    $.getJSON("http://api.flickr.com/services/feeds/photos_public.gne?jsoncallback=?",
        {
            ids : "88261501@N05",
            tags: "",
            tagmode: "any",
            format: "json",
        },

        function(data){
          $.each(data.items, function(i,item){
           
         $("<img/>").attr({ 
          src: (item.media.m).replace("_m.jpg", "_s.jpg"),
          href: "http://google.com",
          alt: item.title,
        }).appendTo(".gallery").wrap("<div class='thumb'><a rel='external' href=\""+item.media.m+"\"></a></div>")  ;

            if ( i == 100 ) return false;
          });
		  
		}
	
    );
}

$(document).ready(function() {
        downloadImg();
	});
