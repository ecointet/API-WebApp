/*
===== Web App To demonstrate tons of APIS
===== Built for demo purposes (by Postman)
===== Author: @ecointet (twitter)
*/

$("#intro").css({
    'background'    : 'url('+$("#company_background").val()+')'
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
          var txt = "Do you mean <a href='/?id="+data.name+"'><b>"+data.name+"</b></a> ?"
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
  var url = "/srv/remote-data.php?id="+$("#company_name").val();

  $.getJSON(url, function(data) {
    try {   
        console.log(data); //RESULT RAW

        $("#company_logo").val(data.logo);
        $("#company_background").val(data.background);
        $("#company_api").val(urldecode(data.api));
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

function GetApiResult01(url)
{

    $('#loading').fadeIn();
    refreshUserData();
    $('#button01').fadeOut("slow");

    var url = "/srv/remote-data.php?url="+url;

    if (!url.includes("mock"))
      url = url + $("#client_ip").val();

    console.log("API URL: ["+url+"]");

    try {
        $.getJSON(url, function( data ) {

            try {   
                console.log(data); //RESULT RAW

                var city = data.city;
                var photo = data.photo;

                $('#game01-result').html(city);
                $('#title').html(city);
                $('#description').html("is not far away from you!");
            
                $("#intro").css({
                    'background'    : 'url('+photo+')'
                }).animate({opacity: '0.3'}, "slow").animate({opacity: '1'}, "slow");
            }
            catch ({ name, message }) {
                console.log("error:" + name); // "TypeError"
                console.log("error desc: " + message); // "oops"
                $('#title').html("Oups.");
                $('#description').html("API Not working :( ");
                $("#intro").css({
                    'background'    : 'url('+$("#company_background").val()+')'
                });
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
    catch ({ name, message }) {
        console.log("error:" + name); // "TypeError"
        console.log("error desc: " + message); // "oops"
        $('#title').html("Oups.");
        $('#description').html("API Not working :( ");
        $("#intro").css({
            'background'    : 'url('+$("#company_background").val()+')'
        });
      }

    $('#loading').fadeOut();
    $('#button01').fadeIn("slow");
}

async function getUserIP() {
    try {
      const response = await fetch('https://api.ipify.org?format=json');
      const data = await response.json();
      console.log('User IP Address:', data.ip);
      $('#client_ip').val(data.ip);
    } catch (error) {
      console.error('Error fetching IP:', error);
    }
  }