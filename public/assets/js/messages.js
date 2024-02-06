export const  successMsg = function (msg){
    return toastr.success(msg);
}

export const failMsg = function (msg){
    toastr.error(msg);
    return toastr;
}

export const  infoMsg = function (msg){
    return toastr.info(msg);
}