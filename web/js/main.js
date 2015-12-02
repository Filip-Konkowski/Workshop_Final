$(document).on("ready", function() {

    $(".showComment").on("click", function(event) {
        event.preventDefault();
        var idComment = (event.target.id);

        var path = $(this).attr("data-path");

        $.ajax({
            url: path,
            dataType: "json",
            success: function(result) {
                var commentsContent = "";
                for(var i= 0; i<result.length; i++) {
                    var currentComment = result[i];
                    commentsContent += '<div class="commentSingle well" data_id="' + currentComment.id
                            +'"> <b>Comment:</b> ' + currentComment.content +'</div> ';
                }
                $('.'+idComment).html(commentsContent);
            },
            error: function(xhr, tStatus, err) {
                console.log(xhr);
                console.log(tStatus);
                console.log(err);
                console.log("Error during AJAX request (" + tStatus + ")" + err);
            }
        });
    });
});

function ajaxData(request_method, args, async, callback) {
    var json= {}, async = !async ? false : true;
    $.ajax({
        url: "comment/viewComments/1", //jak dodać liczbe na koniec url
        type: request_method,
        data: args.data,
        dataType: "json",
        async: async
    });
    return json;
}


//var thisData = $(this);
//var request_method = thisData.attr("data-method");
//var sendAjaxData = {};
