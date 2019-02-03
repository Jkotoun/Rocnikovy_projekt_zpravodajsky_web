let comments = new AjaxLoader(10,10);

let timer;

let loader = function() {



    if(!comments.empty) {



        if (timer) {

            window.clearTimeout(timer);

        }

        timer = window.setTimeout(function () {

            comments.load("comments", "div.all-comments");

        }, 35);

    }

};

$(window).on("scroll" ,loader);

$(window).on("load",function () {

    if(window.location.hash) {

     let url = window.location.href;

        url= url.substring((url.indexOf("#")+1));

       let reply = false;

        if(url.includes("reply"))

        {

         reply = true;

         url = url.replace("reply","");

        }



            let interval = setInterval(

                function(){



                            if(comments.empty)

                            {

                                clearInterval(interval);

                            }

                            else

                            {

                                let comment = document.getElementById(url);

                                let contains_comment = document.querySelector("body").contains(comment);

                                if(contains_comment)

                                {

                                    if(reply)

                                    {

                                        $(comment).closest(".comment").find(".showReplies").trigger("click");

                                    }

                                   $("html, body").scrollTop($(comment).offset().top-($(window).height()/3));

                                    clearInterval(interval);

                                }

                                else

                                {



                                    $("html, body").scrollTop($(document).height() - $(window).height() - 50);

                                }

                            }

            },100);

    }

});

$(document).on('click', '.comment-reply-anchor', function(event){



    // Prevent default events

    event.preventDefault();

    // Animate the body (html page) to scroll to the referring element

    $('html, body').animate({

        scrollTop: $( $.attr(this, 'href') ).offset().top-($(window).height()/3)

    }, 300);



});

function rate(rating, comment_id)

{

    let result;

    $.ajax({

        type: 'POST',

        url: 'comment_rate',

        async:false ,

        data: {rating:rating, comment_id:comment_id},

        success: function (data) {

            data= JSON.parse(data);

                if(data.error)

                {

                result = false;

                window.location.href = "prihlaseni";

                }

            else {

                let comment = document.getElementById(comment_id);

                comment.querySelector(".number-likes").textContent = " " + data.likes;

                comment.querySelector(".number-dislikes").textContent = " " + data.dislikes;

                result =true;

            }

        }

    });



    return calledFromAjaxSuccess(result);

}

function calledFromAjaxSuccess(result) {

    if(result) {

        return true;

    } else {

        return false;

    }

}

$(document).on("click",".thumb-up",function()

{

    let result = rate("like", $(this).closest(".comment, .reply").attr("id"));

if(result) {

    $(this).parent().find(".thumb-down").removeClass("disliked");

    $(this)[0].classList.toggle("liked");

}

});

$(document).on("click",".thumb-down",function()

{

    let result =rate("dislike", $(this).closest(".comment, .reply").attr("id"));

    if(result) {

        $(this).parent().find(".thumb-up").removeClass("liked");

        $(this)[0].classList.toggle("disliked");

    }

});



$(document).on("click",".reply-button",function()

{





    $reply = $(this).closest(".comment").find(".reply-input");

   $reply.css("display","block");

   $reply.find("textarea").focus();



});

$(document).on("click",".hide-reply-button",function()

{

    $reply = $(this).closest(".reply-input");

    $reply.css("display","none");
    $reply.find("#new-reply-text").removeClass("form-error");
    $reply.parent().find('.form-error-text').empty();


});


$(document).on("click",function(e)

{

        if(e.target.className!=".comment-menu")

        {

            $(".comment-menu").hide();

        }

});



$(document).on("click",".comment-menu-icon",function(e)

{

    e.stopPropagation();

   $(".comment-menu").not($(this).find(".comment-menu")).hide();

    $(this).find(".comment-menu").toggle();

});

$(document).on("click",".delete-comment",function(){

    $.ajax({



        type: 'POST',

        url: 'commentDelete',

        data: {comment_id:($(this).closest(".reply, .comment ").attr("id"))},

        success: function (data) {



            data =JSON.parse(data);

            if(data.user)

            {

                alert(data.user);

            }

            else

            {


                $(this).closest(".reply, .comment").hide('fast', function(){

                   $replies_container = $(this).closest(".comment").find(".replies");
                    $(this).remove();
                    if(!$replies_container.html().replace(/\s/g, '').length)
                    {
                        $replies_container.parent().parent().find(".showReplies").css("display","none");
                        $replies_container.parent().parent().find(".hideReplies").css("display","none");
                    }
                }).bind(this);


            }



        }.bind(this)

    });

});

$(document).on("click",".showReplies",function()

{

   $(this).parent().find(".replies").css("display","block");

   $(this).css("display","none");

   $(this).parent().find(".hideReplies").css("display","block");

});



$(document).on("click",".hideReplies",function()

{

    $(this).parent().find(".replies").css("display","none");

    $(this).css("display","none");

    $(this).parent().find(".showReplies").css("display","block");

});

