/*
===== Web App To demonstrate tons of APIS
===== Built for demo purposes (by Postman)
===== Author: @ecointet (twitter)
*/

$("#intro").css({
    'background'    : 'linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),url('+$("#company_background").val()+')',
    'background-repeat': 'no-repeat',
    'background-position': 'center',
    'background-size': 'cover'
});

$('#company_name').on('input', function() {
  if ($('#company_name').val().length >= 2)
  {
  var url = "/srv/remote-data.php?id="+$("#company_name").val()+"%";

  $.getJSON(url, function(data) {
    try {   
        console.log(data); //RESULT RAW

        if (data.name != undefined)
        {
          var txt = "Do you mean <a href='/"+data.name+"'><b>"+data.name+"</b></a> ?"
         $("#suggestion").html(txt);
          console.log(" detected: "+txt);
      }
    }
    catch ({ name, message }) {
        console.log("error:" + name); // "TypeError"
        console.log("error desc: " + message); // "oops"
      }
  })
  .done(function() {
      console.log( "API successfuly loaded" );
    })
    .fail(function() {
      console.log( "error" );
      $('#title').html("Oups.");
      $('#description').html("API Not working :( ");
    })
    .always(function() {
      console.log( "API stage: END" );
    });
      
    }
   
  
});

function urldecode(url) {
  return decodeURIComponent(url.replace(/\+/g, ' '));
}

function refreshUserData()
{
  GetClientIP();

  var url = "/srv/remote-data.php?id="+$("#company_name").val();

  $.getJSON(url, function(data) {
    try {   
        console.log(data); //RESULT RAW
        if (data.logo && data.background)
        {
          $("#company_logo").val(data.logo);
          $("#company_background").val(data.background);
          $("#company_api").val(urldecode(data.api));
          $('#company_option').removeAttr('selected').filter('[value='+data.option+']').attr('selected', true);
          $('#company_option').val(data.option);
        }
    }
    catch ({ name, message }) {
        console.log("error:" + name); // "TypeError"
        console.log("error desc: " + message); // "oops"
      }
})
.done(function() {
    console.log( "API successfuly loaded" );
  })
  .fail(function() {
    console.log( "error" );
    $('#title').html("Oups.");
    $('#description').html("API Not working :( ");
  })
  .always(function() {
    console.log( "API stage: END" );
  });
}

function GetApiResult01()
{
  var url = encodeURI($('#company_api').val());

    $('#loading').fadeIn();
    refreshUserData();
    $('#button01').fadeOut("slow");
 
    //REFORMAT IP Params
    url = reformatIP(url);
    url = "/srv/remote-data.php?url="+url;

    console.log("CURRENT IP: ["+$("#client_ip").val()+"]");
    console.log("REMOTE API URL: ["+url+"]");

    try {
        $.getJSON(url, function( data ) {

            try {   
                console.log(data); //RESULT RAW

                if (data.city == undefined)
                    throw new Error('API Failed'); 
                  
                var city = data.city;
                var photo = data.photo;

                $('#game01-result').html(city);
                $('#title').html(city);
                $('#description').html("is not far away from you!");
            
                $("#intro").css({
                    'background'    : 'linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),url('+photo+')',
                    'background-repeat': 'no-repeat',
                    'background-position': 'center',
                    'background-size': 'cover'
                }).animate({opacity: '0.3'}, "slow").animate({opacity: '1'}, "slow");
            }
            catch ({ name, message }) {
                console.log("error:" + name); // "TypeError"
                console.log("error desc: " + message); // "oops"
                $('#title').html("Oups.");
                $('#description').html("API Not working :( ");
                $("#intro").css({
                    'background'    : 'linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),url('+$("#company_background").val()+')',
                    'background-repeat': 'no-repeat',
                    'background-position': 'center',
                    'background-size': 'cover'
                });
              }
        })
        .done(function() {
            console.log( "API successfuly loaded" );
            
            //CHAT GPT OPTION (EXPERIMENTAL)
            if ($('#company_option').find(":selected").val() == "chatgpt_option")
            {
              $('#loading').fadeIn();
              $('#button01').fadeOut("slow");
              var url = "/srv/remote-data.php?url=https://api.gcp.cointet.com/chatgpt/"+$('#title').html().replace(/\s/g, '');
              $.getJSON(url, function( data ) {
                  console.log("chatGPT URL:"+url);
                  console.log(data); //RESULT RAW
                  $('#description').html(data.answer);
              })
              .done(function() {
               

              })
              .always(function() {
                $('#loading').fadeOut();
                $('#button01').fadeIn("slow");
              })
            }
          
          })
          .fail(function() {
            console.log( "error" );
            $('#title').html("Oups.");
            $('#description').html("API Not working :( ");
          })
          .always(function() {
            console.log( "API stage: END" );
          });
    }
    catch ({ name, message }) {
        console.log("error:" + name); // "TypeError"
        console.log("error desc: " + message); // "oops"
        $('#title').html("Oups.");
        $('#description').html("API Not working :( ");
        $("#intro").css({
            'background'    : 'linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),url('+$("#company_background").val()+')',
            'background-repeat': 'no-repeat',
            'background-position': 'center',
            'background-size': 'cover'
        });
      }

    $('#loading').fadeOut();
    $('#button01').fadeIn("slow");
}

function GetClientIP()
{

  var url = encodeURI("https://api.ipify.org/?format=json");
  $.getJSON(url, function(data) {
    try {   
        console.log("GET CLIENT IP: " + data.ip); //RESULT RAW

        $("#client_ip").val(data.ip);
    }
    catch ({ name, message }) {
        console.log("error:" + name); // "TypeError"
        console.log("error desc: " + message); // "oops"
      }
})
.done(function() {
    console.log( "API successfuly loaded" );
  })
  .fail(function() {
    console.log( "error" );
    $('#title').html("Oups.");
    $('#description').html("API Not working :( ");
  })
  .always(function() {
    console.log( "API stage: END" );
  });

}

function reformatIP(url) {
  //is a Mock Server - do nothing
  if (url.includes("mock"))
    return url;
  
  var parts = url.split("/locate/");
  console.log("parts:" + parts);
  //is a prod Server - reformat and add client IP
  if (parts.length > 1) {
    //IS Valid IP, do nothing
    var pattern = /^([0-9]{1,3}\.){3}[0-9]{1,3}$/;
    if (pattern.test(parts[1]))
      return url;
  }
  
  // Otherwise add Client IP
  return parts[0]+"/locate/"+$("#client_ip").val();
}
