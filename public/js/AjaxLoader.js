class AjaxLoader
{
    constructor($offset,$limit)
    {
        this.offset = $offset;
        this.limit = $limit;
        this.empty = false;
        this.$triggerHeight = $(document).height() - (2 * $(window).height());
    }
    updateSize()
    {
        this.$triggerHeight = $(document).height() - (2 * $(window).height());
    }
    load($url, $destination){

    if($(window).scrollTop() >= this.$triggerHeight ){
        $.ajax({

            type: 'POST',
            url: $url,
            data: {offset: this.offset, limit : this.limit},

            beforeSend:function()
            {
               $(".spinner").css("display","block");
            },
            success: function (text) {
                if(text.length>0)
                {
                    $($destination).append(text);
                }
                else
                {
                    this.empty = true;
                }
            }.bind(this),
            complete:function(){
                this.updateSize();
                $(".spinner").css("display","none");
            }.bind(this)
        });
        this.offset += this.limit;
    }
}
}


