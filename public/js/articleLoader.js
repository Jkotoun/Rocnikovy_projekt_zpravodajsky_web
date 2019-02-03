let articleLoader = new AjaxLoader(10,10);
let timer;
this.loader = function() {
    if(!articleLoader.empty) {
        if (timer) {
            window.clearTimeout(timer);
        }
        timer = window.setTimeout(function () {
            articleLoader.load("articles", "section.articles");
        }, 35);
    }
};
$(window).on("scroll" ,this.loader);







