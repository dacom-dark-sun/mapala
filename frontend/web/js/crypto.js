


function get_client_identy(){ //We need to get unique params which we will use like key for decrypt WIF later
    var client_identy = navigator.userAgent + (screen.width * screen.height); //we get userAgent and screen sized and use their combination
        client_identy = client_identy.replace(/[^a-zA-ZР-пр-џ0-9]/gim,'');   //delete special symbols from our identy-key

   return client_identy;
}
    



//This function encrypt private posting key with user identy key and put result in cookie. 
function put_key_to_cookie (name, user_pass){ 
    client_identy = get_client_identy(); //we take user identy
    var MattsRSAkey = cryptico.generateRSAKey(client_identy, 1024); //Generate RSA key with client identy.
    var MattsPublicKeyString = cryptico.publicKeyString(MattsRSAkey); //Generate public key from RSA.

    var EncryptionResult = cryptico.encrypt(user_pass, MattsPublicKeyString); //Encrypt posting key with public RSA key.
   
    EncryptionResult.cipher = window.btoa(EncryptionResult.cipher); //Encrypt result with base64
    setCookie(name, EncryptionResult.cipher, {"path": "/", "expires": 31536000}); //Put result in cookies.
 
return EncryptionResult;
    
}


//This function take encrypted posting key from cookies, decrypt it and return for sign transaction. 
function get_wif(name){
    client_identy = get_client_identy(); //Will use client identy for decrypt.
   
    var mpl_key_hash = getCookie(name); //Take encrypted key.
    if (mpl_key_hash){
        try {
            mpl_key_hash = mpl_key_hash.slice(0, -3) + '='; //Delete special symbols
            var mpl_key = window.atob(mpl_key_hash); //Decrypt base64.
            var MattsRSAkey = cryptico.generateRSAKey(client_identy, 1024); //Generate RSA key by user identy.
            var DecryptionResult = cryptico.decrypt(mpl_key, MattsRSAkey); //Decryption posting key with RSA key.
            return DecryptionResult;
            } catch (err) {
                alert('Oups. Something changed, your posting keys is wrong. Please, check it. ')
                //redirect to key page
            }

    } else {
      return false;
    }

 
    
}


//SET COOKIE

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





