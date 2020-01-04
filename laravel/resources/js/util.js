/**
 * クッキーの値を取得する
 * @param {String} searchKey 検索するキー
 * @returns {String} キーに対応する値
 */
export function getCookieValue(searchKey) {
  if (typeof searchKey === 'undefined') {
    return ''
  }

  let val = ''

  document.cookie.split(';').forEach(cookie => {
    const [key, value] = cookie.split('=')
    if (key === searchKey) {
      return (val = value)
    }
  })

  return val
}

export const OK = 200
export const CREATED = 201
export const DELETED = 204
export const INTERNAL_SERVER_ERROR = 500
export const UNPROCESSABLE_ENTITY = 422
export const UNAUTHORIZED = 419
export const NOT_FOUND = 404
export const STORAGE_URL = 'https://img.wakuwork.site/'
export const BASE_URL = window.location.origin
export const MQL = window.matchMedia('(max-width: 768px)')
export const CLIENT_HEIGHT = document.documentElement.clientHeight