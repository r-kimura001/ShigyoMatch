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

export function alphaNumeric(str) {
  return str.match(/^([A-Z]|[a-z]|[0-9])+$/g)
}
export function between(str, min, max) {
  return str.length >= min && str.length <= max
}

export const OK = 200
export const CREATED = 201
export const DELETED = 204
export const INTERNAL_SERVER_ERROR = 500
export const UNPROCESSABLE_ENTITY = 422
export const UNAUTHORIZED = 401
export const NOT_FOUND = 404
export const BASE_STORAGE_URL = 'https://asset.shigyo-match.site'
export const BASE_URL = window.location.origin
export const MQL = window.matchMedia('(max-width: 768px)')
export const PER_PAGE = 12
export const CLIENT_HEIGHT = document.documentElement.clientHeight
export const CLIENT_WIDTH = document.documentElement.clientWidth

export const PROFESSIONS = {
  bengoshi: 1,
  shihoushoshi: 2,
  gyoseishoshi: 3,
  zeirishi: 4,
}
