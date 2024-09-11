export function createCookie(name, value, days) {
    let expires = "";
    if (days) {
        let date = new Date();
        date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + value + expires + "; path=/";
}

export function readCookie(name) {
    let nameEQ = name + "=";
    let ca = document.cookie.split(";");
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) === " ") c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

export function eraseCookie(name) {
    document.cookie = name + "=; Max-Age=-99999999;";
}

export function getUser(allUsers, id) {
    return allUsers.filter(user => user.id === id);
}

export function getAssignedPermissionArray(user) {
    let userPermissions = [];
    for (let i = 0; i < user.permissions.length; i++) {
        userPermissions.push(user.permissions[i].permission.permission);
    }
    return userPermissions;
}

export function userHasPermission(user, permissionName) {
    if (permissionName === null || permissionName === "") {
        return true;
    }
    if (user.is_system_admin) {
        return true;
    }
    return getAssignedPermissionArray(user).includes(permissionName) ? 1 : 0;
}
