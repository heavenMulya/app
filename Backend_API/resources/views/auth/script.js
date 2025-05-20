
function get_token(){
    const token=localStorage.getItem('authToken')
        $.ajax({
            url: 'http://127.0.0.1:9000/', 
            type: 'POST',
            data: {},
            headers:{
                'Authorization':'Bearer'+token
            },
            success: function(response) {
                //const token=response.token;
                //localStorage.setItem('authToken',token);
               
                //console.log(token);     
            },
            error: function(error) {
                console.log("error")
                
            }
        });
   
}
