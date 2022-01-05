$(document).ready(function(){
    $("input").attr("autocomplete", "off")
})
function ajaxReq (form) {
    $.ajax({
        url: form.uri,
        type: form.method,
        data: form.data,
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: () => {
            form.btn.html(form.btnLoadMsg)
            form.btn.attr("disabled", "true");
        },
        success: (res) => {
            form.btn.html(form.btnDefault)
            form.btn.removeAttr("disabled")
            form.result.html(res)
        },
        error: (err) => {
            form.btn.html(form.btnDefault)
            form.btn.removeAttr("disabled")
            form.result.html(`<div class="alert alert-danger alert-dismissible"> ${err.status} <br> ${err.statusText} <a href="javascript:void" data-bs-dismiss="alert" class="btn-close"></a></div>`)
        }
    })
}

function ajaxReqAlt (form) {
    $.ajax({
        url: form.uri,
        type: form.method,
        data: form.data,
        beforeSend: () => {
            form.btn.html(form.btnLoadMsg)
            form.btn.attr("disabled", "true");
        },
        success: (res) => {
            form.btn.html(form.btnDefault)
            form.btn.removeAttr("disabled")
            form.result.html(res)
        },
        error: (err) => {
            form.btn.html(form.btnDefault)
            form.btn.removeAttr("disabled")
            form.result.html(`<div class="alert alert-danger alert-dismissible"> ${err.status} <br> ${err.statusText} <a href="javascript:void" data-bs-dismiss="alert" class="btn-close"></a></div>`)
        }
    })
}