function getCookie(cookieName) {
  cookieName += '=';
  let cookiesArray = decodeURIComponent(document.cookie).split(';');

  for(var i = 0; i < cookiesArray.length; i++) {
    var cookieString = cookiesArray[i].trim();

    if(cookieString.indexOf(cookieName) == 0) {
      return cookieString.substring(cookieName.length);
    }
  }

  return '';
}
