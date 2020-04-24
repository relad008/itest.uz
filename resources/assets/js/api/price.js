import request from '@/utils/request';

export function priceList() {
    return request({
        url: `price`,
        method: 'get'
    })
}
