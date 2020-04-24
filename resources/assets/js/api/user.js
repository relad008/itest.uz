import request from '@/utils/request';

export function userInfo() {
    return request({
        url: 'user/info',
        method: 'get'
    })
}

export function profileData() {
    return request({
        url: 'user/profile-data',
        method: 'get'
    })
}

export function changePassword(data) {
    return request({
        url: 'user/change-password',
        method: 'post',
        data  : data
    })
}

export function updateGeneral(data) {
    return request({
        url: 'user/update-general',
        method: 'post',
        data  : data
    })
}

export function updateDirection(data) {
    return request({
        url: 'user/update-direction',
        method: 'post',
        data  : data
    })
}