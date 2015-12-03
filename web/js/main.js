$(document).on("ready", function() {

    $(".showButton").on("click", function(event) {
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

                $("." + idComment + ".formComment").hide();
                $('.' + idComment + ".showComment").html(commentsContent).show();
            },
            error: function(xhr, tStatus, err) {
                console.log(xhr);
                console.log(tStatus);
                console.log(err);
                console.log("Error during AJAX request (" + tStatus + ")" + err);
            }
        });
    });

    $(".addComment").on("click", function(event) {
        event.preventDefault();
        var path = $(this).attr("data-path");
        var id = (event.target.id);

        $('.' + id + ".showComment").hide();
        $("." + id + ".formComment").load(path, function( response, status, xhr ) {
            if (status == "error") {
                var msg = "Sorry but there was an error: ";
                $("#error").html(msg + xhr.status + " " + xhr.statusText)
            }
        }).show();
    });
});
