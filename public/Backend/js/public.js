/**
 * Created by Jordan on 2017/2/8.
 */
//显示模态框
/**
 *
 * @param title 模态框的标题
 * @param dom_class 模态框的颜色：、''、modal-primary、modal-info、modal-warning、modal-success、modal-danger
 * @param html_data 显示的数据，可以写p、ul标签等
 * @param callback  点击确定按钮的回调函数，不传不会显示确定按钮；
 */
function modal_show(title,dom_class,html_data,callback){
    var modal = $('#modal-info');
    var info = $('#modal-info .modal-body');
    var  modalTitle = $('#modal-info .modal-title');
    var yesBtn =$('#yes-btn');

    modal.attr("class","modal "+dom_class);
    modalTitle.html(title);
    info.html(html_data);
    modal.modal('show');
    if(!dom_class){
        yesBtn.attr('class','btn btn-primary pull-left').next().attr('class','btn btn-primary');
    }
    if (Object.prototype.toString.call(callback)==='[object Function]'){
        yesBtn.show();
        yesBtn.click(function () {
            callback();
            modal.modal('hide');
            yesBtn.unbind();
            yesBtn.hide();
        });


        modal.on('hidden.bs.modal', function () {
            yesBtn.unbind();
        });
    }

}


function modal_success(html_data,isRefresh,time) {
    var modal = $('#modal-info');
    var info = $('#modal-info .modal-body');
    var  modalTitle = $('#modal-info .modal-title');
    var noBtn =$('#no-btn');

    modal.attr("class","modal modal-success");
    modalTitle.html('操作成功提示');
    info.html(html_data);
    modal.modal('show');
    var timeout = time ? time : 1500;
    if(typeof isRefresh == 'undefined' || typeof isRefresh == null)
    {
        isRefresh = true;
    }

    setTimeout(function () {
        if(isRefresh){window.location.reload();}
        modal.modal('hide');
    }, timeout);

    noBtn.click(function () {
        window.location.reload();
    });
}

/**
 * 显示内容为表单的模态框
 * @param title 模态框的标题
 * @param html_data 显示的视图
 * @param callback  点击确定按钮的回调函数，不传不会显示确定按钮；
 */
function modal_form(title,html_data,callback){
    var modal = $('#modal-form');
    var info = $('#modal-form .modal-body');
    var  modalTitle = $('#modal-form .modal-title');
    var submitBtn =$('#btn-submit');

    modal.attr("class","modal");
    modalTitle.html(title);
    if (html_data) info.html(html_data);
    modal.modal('show');

    if (Object.prototype.toString.call(callback)==='[object Function]'){
        submitBtn.show();
        submitBtn.click(function () {
            if ( callback() ) {
                modal.modal('hide');
                submitBtn.unbind();
            }

        });

        modal.on('hidden.bs.modal', function () {
            submitBtn.unbind();
        });
    }
}

function modal_form_colse(){
    $('#modal-form').modal('hide');
}

//仿php urlencode
function urlencode(str) {
    str = (str + '').toString();

    return encodeURIComponent(str)
        .replace(/!/g, '%21')
        .replace(/'/g, '%27')
        .replace(/\(/g, '%28')
        .replace(/\)/g, '%29')
        .replace(/\*/g, '%2A')
        .replace(/%20/g, '+');
}

//仿php urldecode
function urldecode(str) {
    var ret = "";
    for(var i=0;i<str.length;i++) {
        var chr = str.charAt(i);
        if(chr == "+") {
            ret += " ";
        }else if(chr=="%") {
            var asc = str.substring(i+1,i+3);
            if(parseInt("0x"+asc)>0x7f) {
                ret += decodeURI("%"+ str.substring(i+1,i+9));
                i += 8;
            }else {
                ret += String.fromCharCode(parseInt("0x"+asc));
                i += 2;
            }
        }else {
            ret += chr;
        }
    }
    return ret;
}

function nl2br (str, is_xhtml) {
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
}

/**
 * 去掉str左边的指定的字符split
 */
function ltrim(str, split) {
    return (str.substring(0, 1)==split)?str.substring(1):str;
}

/**
 * 去掉str右边的指定的字符split
 */
function rtrim(str, split) {
    return (str.substring(str.length-1)==split)?str.substring(0,str.length-1):str;
}