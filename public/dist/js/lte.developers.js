/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


window.setTimeout(function () {
    $(".alert-success").fadeTo(500, 0).slideUp(500, function () {
        $(this).remove();
    });
    $(".alert-danger").fadeTo(500, 0).slideUp(500, function () {
        $(this).remove();
    });
    $(".alert-warning").fadeTo(500, 0).slideUp(500, function () {
        $(this).remove();
    });
    $(".alert-info").fadeTo(500, 0).slideUp(500, function () {
        $(this).remove();
    });
}, 5000);

$(document).ready(function(){
    $('.processing_btn').click(function (){
        $(this).html('<i class="fa fa-spinner fa-spin"></i> Processing...');
    });
    $('.loading_btn').click(function (){
        $(this).html('<i class="fa fa-spinner fa-spin"></i> Loading...');
    });
    $('.processing_btn_icon').click(function (){
        $(this).html('<i class="fa fa-spinner fa-spin"></i>');
    });
    $('.processing_btn_icon_append').click(function (){
        $(this).append('<i class="fa fa-spinner fa-spin pull-right"></i>');
    });
});
function showProcessingBtn(dataContainer)
{
    $(dataContainer).html('<i class="fa fa-spinner fa-spin"></i> Processing...');
}
function showToaster(type,heading,msg)
{
    if(type === "success")
    {
        toastr.success(heading,msg);
    }
    else if(type === "warning")
    {
        toastr.warning(heading,msg);
    }
    else if(type === "error")
    {
        toastr.error(heading,msg);
    }
}
