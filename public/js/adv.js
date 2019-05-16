(function(rootEl){
    var img1 = 'http://www.cunyucpc.com/img/shiping.png', img2="http://www.cunyucpc.com/img/ad.jpg";
    var art= [{
        title:'教你围巾的多种系法，有没有GET 到，美美的过冬天',
        address:'http://j.yoafj.com/h.ynciz4'
    },{
        title:'一件驼色大衣的3种搭配，原来这么穿又美又时髦',
        address:'http://z.oiax6.com/h.yn37Rm'
    }];
    var hotword = ['精华','热点'];
    var Box = document.createElement("div");
    Box.setAttribute('style','font-size:16px; overflow:hidden;background:#fff;margin-top:10px; ');
    var screen_w = window.screen.width;
  
    var imgBox = document.createElement("div");
    imgBox.setAttribute("style","float:left; width:15.47%;");
    var img_left = document.createElement("img");
    img_left.setAttribute("src",img1);
    img_left.setAttribute("style","display:block;width:100%;");
    imgBox.append(img_left);

    var artBox = document.createElement("ul");
    artBox.setAttribute("style","list-style:none; padding:0.5em 0 0.75em; width:62.13%; float:left; margin:0;");
    for(var i = 0; i<art.length;i++){
        var li= document.createElement("li");
        var span = document.createElement("span");
        span.setAttribute("style","display:inline-block;vertical-align:middle;font-size:0.75em;color:#ff5101;border:1px solid #ff5101; padding:1px 3px; border-radius:4px; line-height:1; box-sizing: border-box;");
        span.innerHTML = hotword[i];
        var a_el = document.createElement("a");
        a_el.classList = 'art_a'
        a_el.setAttribute("href",art[i].address) ;
        a_el.innerHTML = art[i].title;
        a_el.setAttribute("style"," display:inline-block;vertical-align:middle;width:81.4%;font-size:0.75em;color:#333333;white-space: nowrap;text-decoration: none; overflow:hidden; text-overflow: ellipsis;");
        a_el.st
        li.append(span);
        li.append(a_el);
        artBox.append(li);
    }
    var imgBox_right = document.createElement("div");
    imgBox_right.setAttribute("style","float:right; width:22.3%;");
    var img_right = document.createElement("img");
    img_right.setAttribute("src",img2);
    img_right.setAttribute("style","display:block;width:100%;");
    imgBox_right.append(img_right);

    Box.append(imgBox);
    Box.append(artBox);
    Box.append(imgBox_right);
    $(".fq-category8.fq-background-white.am-avg-sm-5.am-text-center").before($(Box));
    //document.getElementById(rootEl).append(Box);
})("taobao1");