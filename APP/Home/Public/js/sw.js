
/*输入框错误状态*/
function inputStateError(id,msg) {
    $("#"+id).addClass('form-group');
    $("#"+id).addClass('has-error');
    $("#"+id).addClass('has-feedback');
    $("#"+id+" span:last").remove();
    var str="<span id=\"testhelp1\" class=\"help-block\">"+msg+"</span>";
    $("#"+id).append("<span class=\"glyphicon glyphicon-remove form-control-feedback\" aria-hidden=\"true\"></span>");
    $("#"+id).append(str);
}


/*输入框正确*/
function inputStateSuccess(id) {
    $("#"+id).addClass('form-group');
    $("#"+id).addClass('has-success');
    $("#"+id).addClass('has-feedback');
    $("#"+id+" span:last").remove();
    $("#"+id).append("<span class=\"glyphicon glyphicon-ok form-control-feedback\" aria-hidden=\"true\"></span>");
}

function inputReset(id) {
    $("#"+id).removeClass('has-error');;
    $("#"+id).removeClass('has-success');
    $("#"+id).removeClass('has-feedback');
    $("#"+id+">span").removeClass('glyphicon glyphicon-ok glyphicon-remove form-control-feedback');

}


/*验证码错误*/
function verifyStateError(id) {
    $("#" + id).addClass('form-group');
    $("#" + id).addClass('has-error');
    $("#" + id).addClass('has-feedback');
    $("#" + id + " span:last").remove();
    $("#" + id).append("<span class=\"glyphicon glyphicon-remove form-control-feedback\" aria-hidden=\"true\"></span>");
}
/*验证码正确*/
function verifyStateSuccess(id) {
    $("#" + id).addClass('form-group');
    $("#" + id).addClass('has-success');
    $("#" + id).addClass('has-feedback');
    $("#" + id + " span:last").remove();
    $("#" + id).append("<span class=\"glyphicon glyphicon-ok form-control-feedback\" aria-hidden=\"true\"></span>");
}

/*验证码正确*/
function verifyReset(id) {
    $("#"+id).removeClass('has-error');;
    $("#"+id).removeClass('has-success');
    $("#"+id).removeClass('has-feedback');
    $("#"+id+">span").removeClass('glyphicon glyphicon-ok glyphicon-remove form-control-feedback');

}

