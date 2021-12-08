const editUserData = (userData, editedFields, callback) => {
    doPost("/service/user/editUserData.php", {userData: userData, editedFields: editedFields}, null,
        (e) => {
        callback(e);
    })
}