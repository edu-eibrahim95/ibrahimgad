$(document).ready(function() {
    $.ajaxSetup({ cache: true }); // since I am using jquery as well in my app
    $.getScript('//connect.facebook.net/en_US/sdk.js', function () {
        // initialize facebook sdk
        FB.init({
            appId: '347969525656940', // replace this with your id
            status: true,
            cookie: true,
            version: 'v2.10'
        });

        // attach login click event handler
        $("#btn-login").click(function(){
            FB.login(processLoginClick, {scope:'user_managed_groups,public_profile,email,user_friends', return_scopes: true});  
        });
    });
});
// function to send uid and access_token back to server
// actual permissions granted by user are also included just as an addition
function processLoginClick (response) {    
    var uid = response.authResponse.userID;
    var access_token = response.authResponse.accessToken;
    var permissions = response.authResponse.grantedScopes;
    var data = { uid:uid, 
                 access_token:access_token, 
                 _token:$('meta[name="_token"]').attr('content'), // this is important for Laravel to receive the data
                 permissions:permissions 
               };        
    postData(window.location.href, data, "post");
}

// function to post any data to server
function postData(url, data, method) 
{
    method = method || "post";
    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", url);
    for(var key in data) {
        if(data.hasOwnProperty(key)) 
        {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", data[key]);
            form.appendChild(hiddenField);
         }
    }
    document.body.appendChild(form);
    form.submit();
}