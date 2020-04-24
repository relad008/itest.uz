import request from '@/utils/request';

export function accountList(page, perPage) {
    return request({
        url: `account/?page=${page}&per_page=${perPage}`,
        method: 'get'
    })
}
