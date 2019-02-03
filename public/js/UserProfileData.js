let userComments = new AjaxLoader(10,10);
let timer;
this.loader = function() {

    if(!userComments.empty) {
        if (timer) {
            window.clearTimeout(timer);
        }
        timer = window.setTimeout(function () {
            userComments.load("userComments", "div.user-comments");
        }, 35);
    }
};
$(window).on("scroll" ,this.loader);