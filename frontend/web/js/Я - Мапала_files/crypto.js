/**
 *  @author Eugene Terentev <eugene@terentev.net>
 */







function get_client_identy(){
    var client_identy = navigator.userAgent + (screen.width * screen.height); 
     console.log(client_identy);
     client_identy = client_identy.replace(/[^a-zA-ZА-Яа-я0-9]/gim,'');
 //   var user_pass = "P5KjN3cFEY1bzMsioEqGqZAh8wv67nDiYQJtTBiNj9PLn8SPWnSv";
  //  console.log(key);
   return client_identy;
}
    





function put_key_to_cookie (name, user_pass){
    client_identy = get_client_identy();
    var MattsRSAkey = cryptico.generateRSAKey(client_identy, 1024);
    var MattsPublicKeyString = cryptico.publicKeyString(MattsRSAkey);

    var EncryptionResult = cryptico.encrypt(user_pass, MattsPublicKeyString);
   
    EncryptionResult.cipher = window.btoa(EncryptionResult.cipher);
    setCookie(name, EncryptionResult.cipher, {"path": "/", "expires": 31536000});
 
return EncryptionResult;
    
}



function get_wif(name){
    client_identy = get_client_identy();
   
    var mpl_key_hash = getCookie(name);
    if (mpl_key_hash){
        try {
            mpl_key_hash = mpl_key_hash.slice(0, -3) + '=';
            var mpl_key = window.atob(mpl_key_hash);
            var MattsRSAkey = cryptico.generateRSAKey(client_identy, 1024);
            var DecryptionResult = cryptico.decrypt(mpl_key, MattsRSAkey);
            return DecryptionResult;
            } catch (err) {
                alert('Oups. Something changed, your posting keys is wrong. Please, check it. ')
                //redirect to key page
            }

    } else {
      return false;
    }

 
    
}




function setCookie(name, value, options) {
  options = options || {};

  var expires = options.expires;

  if (typeof expires == "number" && expires) {
    var d = new Date();
    d.setTime(d.getTime() + expires * 1000);
    expires = options.expires = d;
  }
  if (expires && expires.toUTCString) {
    options.expires = expires.toUTCString();
  }

  value = encodeURIComponent(value);

  var updatedCookie = name + "=" + value;

  for (var propName in options) {
    updatedCookie += "; " + propName;
    var propValue = options[propName];
    if (propValue !== true) {
      updatedCookie += "=" + propValue;
    }
  }

  document.cookie = updatedCookie;
}

function nospace(str) { 

    var VRegExp = new RegExp(/^(\s|\u00A0)+/g); 

    var VResult = str.replace(VRegExp, ''); 

return VResult 

}

function getCookie(name) {
  var value = "; " + document.cookie;
  var parts = value.split("; " + name + "=");
  if (parts.length == 2) return parts.pop().split(";").shift();
}

function deleteCookie(name) {
  setCookie(name, "", {"path": "/",
    'expires': -1
  })
}





