//funkce pro zasunutí a vysunutí uživatelské nabídky (velké okno)
function ToggleSlide()
{	
$(".user-icon").toggleClass("icon-down icon-up");
$(".account-menu-toggle").stop().slideToggle(100);
}
//funkce pro zasunutí a vysunutí uživatelské nabídky (malé okno)
function ToggleSlide_small()
{	
    $(".account-menu-toggle-small").stop().slideToggle(100);
}

//zajetí uživatelské nabídky při kliknutí jinam do okna
$(document).click(function() {
if($('.account-menu-toggle').css('display') === 'block')
{
    ToggleSlide();
}
if($('.account-menu-toggle-small').css('display') === 'block')
{
    ToggleSlide_small();
}
});
//Zajetí nabídky uživatelského profilo při změn
$(window).resize(function(){
    let timer;
    if(timer) {
        window.clearTimeout(timer);
    }
    timer = window.setTimeout(function() {
        $(".account-menu-toggle").slideUp(100);
        $(".account-menu-toggle-small").slideUp(100);
        $(".account-header i").removeClass("icon-up");
        $(".account-header i").addClass("icon-down");
    }, 20);
});


//ovládaní uživatelského menu pomocí tlačítek (šipek)
$(" .account-header").click(function (e) {
 	e.stopPropagation();
      e.preventDefault();
      ToggleSlide(this);
    });
$(".account-header a").click(function (e) {
    e.stopPropagation();
});

$(".user-toggle-menu").click(function (e) {
       $("#mainNavbar").collapse('hide');
       ToggleSlide_small();
        e.stopPropagation();
      e.preventDefault();
    });

$('div.message-hide').on("click",function()
{
    $(this).parent().slideUp(function() {
        this.remove()
    });

});





     
   
