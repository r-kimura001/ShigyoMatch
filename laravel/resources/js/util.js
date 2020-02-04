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
export function dateReplace(datetime) {
  const now = new Date()
  const createDate = new Date(datetime)
  const diff = now - createDate
  const minutes = Math.floor(diff / 1000 / 60)
  const hours = Math.floor(diff / 1000 / 60 / 60)
  const days = Math.floor(diff / 1000 / 60 / 60 / 24)

  if(minutes < 1){
    return 'たった今'
  }else if(hours < 1){
    return `約${minutes}分前`
  }else if(days < 1){
    return `約${hours}時間前`
  }else if(now.getFullYear() > createDate.getFullYear()){
    const year = createDate.getFullYear()
    const month = createDate.getMonth() + 1
    const date = createDate.getDate()
    return `${year}年${month}月${date}日`
  }else{
    const month = createDate.getMonth() + 1
    const date = createDate.getDate()
    const hour = createDate.getHours()
    const minute = createDate.getMinutes()
    return `${month}月${date}日 ${hour}:${minute}`
  }
}
export function isNew(datetime) {
  const limitDays = 1
  const now = new Date()
  const createDate = new Date(datetime)
  const diff = now - createDate
  const days = Math.floor(diff / 1000 / 60 / 60 / 24)

  return days <= limitDays
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
