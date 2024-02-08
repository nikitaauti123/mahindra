export const  successMsg = function (msg){
    return toastr.success(msg);
}

export const failMsg = function (msg, options = {}){
    toastr.options = options;
    toastr.error(msg);
    return toastr;
}

export const  infoMsg = function (msg){
    return toastr.info(msg);
}