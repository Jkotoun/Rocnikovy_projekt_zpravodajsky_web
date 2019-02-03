function toggleAside()
{
    $(".menu-toggle ").toggleClass("wrapped");
    $('aside').toggleClass("wrapped");
    $('main').toggleClass("wrapped");
    $('.menu-toggle span').toggleClass("icon-right icon-left")

}
$(".user").click(function (e) {
    e.stopPropagation();
    e.preventDefault();
    ToggleSlide(this);
});
$(".user a").click(function (e) {
    e.stopPropagation();
});
function ToggleSlide()
{
    $(".user-icon").toggleClass("icon-down icon-up");
    $(".account-menu-toggle").stop().slideToggle(100);
}
$(".toggle-icon").click(function () {
    toggleAside();
   });

   $(".icon-td").click(function () {
    $(this).parent().toggleClass("closed");
 $(this).toggleClass("icon-up icon-down");
   });

$(document).on("click","div.message-hide",function() {
    $(this).parent().slideUp(function () {
        this.remove()
    });
});
let timer;
$(window).on("resize",function(){
    if(timer) {
        window.clearTimeout(timer);
    }
    timer = window.setTimeout(function() {
        $(".account-menu-toggle").slideUp(100);
        $(".account-menu-toggle-small").slideUp(100);
        $(".user i").removeClass("icon-up");
        $(".user i").addClass("icon-down");
    }, 20);
});
$('.article-delete').on("click",function(e)
{

    if (!confirm("Opravdu chcete tento článek odstranit?")) {
        e.preventDefault();
    }
});
$('.user-delete').on("click",function(e)
{

    if (!confirm("Opravdu chcete uživatele odstranit?")) {
        e.preventDefault();
    }
});
$('.user-role').on("change",function(){

   let new_role = $(this).val();
   let user_id = $(this).attr("id");

    $.ajax({

        type: 'POST',
        url: 'roleChange',
        data: {role_name: new_role, user: user_id},
        success: function (data) {
                        data =JSON.parse(data);
            if(data.role)
            {
                $('.table-container').prepend(' <div class="error-message message">' + data.role + '<div class="message-hide"><span class="icon-cross"></span> </div> </div>');
            }
            else

            {
            $('.table-container').prepend('  <div class="success-message message">Uživatelská role úspěšně upravena<div class="message-hide"><span class="icon-cross"></span> </div> </div>')
                     }}
    });
});




