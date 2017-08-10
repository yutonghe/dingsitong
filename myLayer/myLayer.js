;(function($,window,document,undefined){
    var layerIndex = 0;
    var wd_h = $(window).height();
    var wd_w = $(window).width();
    var cover_open = true;
    //默认配置项
    var defaults = {
        title: '标题',            //标题
        content: '',			 //弹框内容
        width: '500px',          //弹框宽度
        height: '300px',         //弹框高度
        btnCount: 2,			 //按钮数
        btns: ['确定', '取消'],   //按钮
        yes:function(){},        //确定
        no:function(){},         //取消
        complete:function(){},   //弹框后回调
        callback:function(){},   //关闭后回调
    };

    function Plugin(options){
        this.options = $.extend({}, defaults, options);
        this._index = layerIndex;
        this._move = false;
        this._init(this);
    };

    Plugin.prototype._init = function(that){
        var layerNode = '<div class="mylayer mylayer'+that._index+'" id="mylayer'+that._index+'" style="width:'+that.options.width+';height:'+that.options.height+'">';
        layerNode += '<div class="layer-title-b">';
        layerNode += '<span class="layer-title">'+that.options.title+'</span>';
        layerNode += '<span class="layer-title-close pull-right" title="关闭"></span></div>';
        layerNode += '<div class="layer-content">'+that.options.content+'</div>';
        if(that.options.btnCount){
            layerNode += '<div class="layer-btns">';
            layerNode += '<a href="javascript:;" class="btn btn-yellow yes">'+that.options.btns[0]+'</a>';
            if(that.options.btnCount > 1) {
                layerNode += '<a href="javascript:;" class="btn btn-default no">' + that.options.btns[1] + '</a>';
            }
            layerNode += '</div>';
        }
        layerNode += '</div>';
        if(cover_open){
            layerNode += '<div class="layer-cover"></div>';
            cover_open = false;
        }
        $('body .mylayer').addClass('hide');
        $('body').append(layerNode);
        //完成
        that.options.complete(that._index);
        //定位
        that.w = $('#mylayer'+that._index).width();
        that.h = $('#mylayer'+that._index).height();
        that.setPosition(that);
        $(window).resize(function () {
            wd_h = $(window).height();
            wd_w = $(window).width();
            that.setPosition(that);
        });

        //拖曳
        $('#mylayer'+that._index+' .layer-title-b').on("mousedown",function(e){
            e.preventDefault();
            $(this).css("cursor", "move");
            that._move = true;
            that.x = e.pageX - parseInt($('#mylayer'+that._index).css("left"));
            that.y = e.pageY - parseInt($('#mylayer'+that._index).css("top"));
        }).on('mouseup', function(){
            $('#mylayer'+that._index+' .layer-title-b').css("cursor", "inherit");
        });
        $(document).mousemove(function(e){
            if(that._move){
                var l = e.pageX - that.x;
                var t = e.pageY - that.y;
                if(l < 0){l = 0;}else if(l > (wd_w - that.w)){l = (wd_w - that.w);}
                if(t < 0){t = 0;}else if(t > (wd_h - that.h)){t = (wd_h - that.h);}
                $('#mylayer'+that._index).css({top:t, left:l});
            }
        }).mouseup(function(){
            that._move = false;
        });
        //关闭按钮
        $('#mylayer'+that._index+' .layer-title-close').on('click', function(e){
            e.preventDefault();
            that.close(that);
        });
        //确定
        $('#mylayer'+that._index+' .yes').on('click', function(e){
            e.preventDefault();
            var re = that.options.yes(that._index);
            if(re !== false){
                that.close(that);
            }
        });
        //取消
        $('#mylayer'+that._index+' .no').on('click', function(e){
            e.preventDefault();
            that.options.no(that._index);
            that.close(that);
        });
        layerIndex ++;
    };

    Plugin.prototype.setPosition = function(that){
        var nodeObj = $('#mylayer'+that._index);
        var l = (wd_w - that.w)/2;
        var t = (wd_h - that.h)/2;
        nodeObj.css({'left': (l > 0 ? l : 0), top:(t>0?t:0)});
    };

    Plugin.prototype.close = function(that){
        $('#mylayer'+that._index).remove();
        that.options.callback();
        var len = $('body .mylayer').length;
        if(len > 0){
            $('body .mylayer:last').removeClass('hide');
        }else{
            $('.layer-cover').remove();
            cover_open = true;
        }
    };

    jQuery.myLayer = function (options) {
        new Plugin(options);
    };

})(jQuery,window,document);