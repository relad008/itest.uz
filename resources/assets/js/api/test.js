import request from '@/utils/request';

export function lastStatistics() {
    return request({
        url: 'test/statistics',
        method: 'get'
    })
}

export function direction(type, sub1, sub2, sub3) {
    return request({
        url: 'test/' + type + '/' + sub1 + '/' + sub2 + '/' + sub3,
        method: 'get'
    })
}

export function thematic(id) {
    return request({
        url: 'test/thematic/' + id,
        method: 'get'
    })
}

export function getResult(data) {
    return request({
        url: 'test/get-result',
        method: 'post',
        data: data
    })
}

export function thematicSelect() {
    return request({
        url: 'test/thematic-select',
        method: 'get'
    })
}