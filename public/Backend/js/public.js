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