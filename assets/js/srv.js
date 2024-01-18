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

$("#company_logo").on("focus", function() {
  $("#company_logo").val("");
});
$("#company_background").on("focus", function() {
  $("#company_background").val("");
});
$("#company_api").on("focus", function() {
  $("#company_api").val("");
});

//AUTO-COMPLETE
$('#company_name').on('input', function() {
  if ($('#company_name').val().length > 1)
  {
  var url = "/srv/remote-data.php?id="+$("#company_name").val()+"%";
  //CLEAN CONFIG
  $('#company_logo').val("");
  $('#company_background').val("");
  //SEARCH COMPANY
  $.getJSON(url, function(data) {
    try {   
        console.log(data); //RESULT RAW

        if (data.name != undefined)
        {
          var txt = "Do you mean <a href='/"+data.name+"'><b>"+data.name+"</b></a> ?"
          $("#suggestion").html(txt);
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
          $('#company_option').removeAttr('selected').filter('[value='+data.opt+']').attr('selected', true);
          $('#company_option').val(data.opt);
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
    console.log( "Error to get the app/customer data" );
    $('#title').html("Oups.");
    $('#description').html("Can't refresh the App Data :( ");
  })
  .always(function() {
    console.log( "API stage: END" );
  });
}

function GetApiResult01()
{
  var url = encodeURI($('#company_api').val());

    //$('#loading').fadeIn();
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
                var description = data.description;
                var photo = data.photo;

                //Easter Egg. ("redirect" value in the json)
                if (data.redirect != undefined)
                  location.href = "https://" + data.redirect;

                $('#game01-result').html(city);
                $('#title').html(city);
                $('#description').html(description);
            
                $("#intro").css({
                    'background'    : 'linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),url('+photo+')',
                    'background-repeat': 'no-repeat',
                    'background-position': 'center',
                    'background-size': 'cover'
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
        })
        .done(function() {
            console.log( "API successfuly loaded" );
            
            //CHAT GPT OPTION (EXPERIMENTAL)
            if ($('#company_option').find(":selected").val() == "chatgpt_option")
            {
              clearInterval(refresh);
             // $('#loading').fadeIn();
              $('#button01').fadeOut("slow");
              var url = "/srv/remote-data.php?url=https://api.cointet.com/chatgpt/"+$('#title').html().replace(/\s/g, '');
              $.getJSON(url, function( data ) {
                  console.log("chatGPT URL:"+url);
                  console.log(data); //RESULT RAW
                  $('#description').html(data.answer);
                  $('#description').typewrite({
                    'delay': 50, //time in ms between each letter
                    'extra_char': '', //"cursor" character to append after each display
                    'trim': true, // Trim the string to type (Default: false, does not trim)
                    'callback': null // if exists, called after all effects have finished
                });
                  
              })
              .done(function() {
               

              })
              .always(function() {
             //   $('#loading').fadeOut();
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

  //  $('#loading').fadeOut();
    $('#button01').fadeIn("slow");
}

function CreateUserList(data)
{
  var result =[];

  for (i = 0; i < data.length; i++) {
    var txt = data[i].split("|");
    result.push({ label: txt[0], score: txt[1], country: txt[2], avatar: txt[3], rank: txt[4]});
  }

  return result;
}

function UpdateList()
{
  clearInterval(refresh);

  $('#title').html("");
  $('#description').html("<div class='corner1'><img style='float: left; margin: -5px;' src='/images/postman-request.png' width='30px'><span style='color:green; font-weight: bold;'> GET </span> <span style='color:grey; font-weight: thin;'>⇆ "+ $('#host_url').val() + "/" + $('#company_name').val()+" </span></div>");
  $('#button01').fadeOut("slow");
  $('#countdown').fadeIn("slow");

  

  clock.start($('#max_duration').val());
  //alert($('#host_url').val());

  $.get($('#host_url').val() + "/?id=" + $('#company_name').val() + "&dashboard=true")
  .done(function( data ) {

    var list = CreateUserList(data.split(";"));
    //console.log(list);
      
    //console.log(texts);
    refreshList(list);
    return true;
  })
  .fail(function( jqxhr, textStatus, error ) {
    var err = textStatus + ", " + error;
    console.log( "Request Failed: " + err );
});
}

function Explore(city)
{
    clearInterval(refresh);
    var url = encodeURI("https://api.cointet.com/explore/"+city.replace(/\s/g, ''));

    $('#loading').fadeIn();
    refreshUserData();
    $('#button01').fadeOut("slow");

    console.log("REMOTE API URL: ["+url+"]");

    try {
        $.getJSON(url, function( data ) {

            try {   
                console.log(data); //RESULT RAW

                if (data.city == undefined)
                    throw new Error('API Failed'); 
                  
                var city = data.city;
                var description = data.description;
                var photo = data.photo;

                $('#game01-result').html(city);
                $('#title').html(city);
                $('#description').html(description);
            
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
              var url = "/srv/remote-data.php?url=https://api.cointet.com/chatgpt/"+$('#title').html().replace(/\s/g, '');
              $.getJSON(url, function( data ) {
                  console.log("chatGPT URL:"+url);
                  console.log(data); //RESULT RAW
                  $('#description').html(data.answer);
                  $('#description').typewrite({
                    'delay': 50, //time in ms between each letter
                    'extra_char': '', //"cursor" character to append after each display
                    'trim': true, // Trim the string to type (Default: false, does not trim)
                    'callback': null // if exists, called after all effects have finished
                });
                  
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
    console.log( "Error to get the Client IP" );
   // $('#title').html("Oups.");
   // $('#description').html("API Not working :( ");
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

    return parts[0]+"/locate/"+$("#client_ip").val();
  }
  
  // Otherwise add Client IP
  if (url.includes("/locate"))
    return url+"/"+$("#client_ip").val();
  
  return url;
}

//ADVANCED CONFIG
$('#config').click(function () {
    
    $('#config_advanced').toggle("slow");
});

//EXPLORE MENU
$('#explore').click(function () {
  $('#explore_menu').toggle("slow");
  $('#explore').hide("slow");
});

//EXPLORE SEND
$('#explore_go').click(function () {
  Explore($('#city_explore').val());
  window.scrollTo(0, 0);
});