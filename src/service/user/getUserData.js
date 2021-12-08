const getUserData = (email, callback) => {
    doPost("/service/user/getUserDataService.php", {email: email}, null, (e) => {
        callback(e);
    });
}
