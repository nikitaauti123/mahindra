export const  successMsg = function (msg){
    return toastr.success(msg);
}

export const failMsg = function (msg){
    return toastr.error(msg);
}

export const  infoMsg = function (msg){
    return toastr.info(msg);
}