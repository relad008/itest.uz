import request from '@/utils/request';

export function sendClickInvoice(data) {
    return request({
        url: `pay/send-click-invoice`,
        method: 'post',
        data: data
    })
}

export function buyFromAccount(data) {
    return request({
        url: `pay/buy-from-account`,
        method: 'post',
        data: data
    })
}
