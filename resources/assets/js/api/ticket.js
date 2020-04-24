import request from '@/utils/request';

export function ticketList(type, page, perPage) {
    return request({
        url: `ticket/?type=${type}&page=${page}&per_page=${perPage}`,
        method: 'get'
    })
}

export function ticketCreate(data) {
    return request({
        url: `ticket/`,
        method: 'post',
        data: data
    })
}

export function ticketClose(data) {
    return request({
        url: `ticket/close`,
        method: 'post',
        data: data
    })
}

export function ticketSend(data) {
    return request({
        url: `ticket/send`,
        method: 'post',
        data: data
    })
}

export function ticketMessages(id, page) {
    return request({
        url: `ticket/${id}/messages/?page=${page}`,
        method: 'get'
    })
}
