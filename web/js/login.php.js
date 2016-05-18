/*-- ถ้าจำผู้ใช้งานในระบบ จะมีฟิลด์จำนวนวันโผล่ขึ้นมา --*/

$("document").ready(function () {
    $('#loginform-rememberme').click(function () {
        $(".field-loginform-daterememberme").toggle(this.checked);
    });

});