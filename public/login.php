<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <title>Login | aidi CMS</title>
  <style type="text/css">
       @font-face{
      font-family: 'Jenna Sue';
      src: url('assets/fonts/JennaSue.ttf');
    }
    @font-face{
      font-family: 'Source Sans Pro';
      src: url('assets/fonts/SourceSansPro-Regular.ttf');
    }
    body, form, input{
      font-family: 'Source Sans Pro';
    }
    #wrapper{
      background: #EDF4EF;
      padding: 2em;
      text-align: center;
      box-shadow: 0 2px 2px #b8c7ce;
    }
    h1{
      color: #32BF83;
      margin:0;
      text-shadow: 1px 1px #1B9360;
    }
    h2{
      font-family: 'Jenna Sue';
      margin:0 0 1.5em;
      color: #222d32;
    }
    .input-group{
      margin-bottom: 0.8em;
    }
    #notif{
      margin-left: 10px;
      display: none;
    }

  </style>
</head>
<body>

<div class="container" style="margin-top:10vh">
  <div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4" style="padding:2em">
      <div id="wrapper">
        <h1><span class="glyphicon glyphicon-tint"></span></h1>
        <h2>aidi CMS</h2>
        <div class="input-group">
          <span class="input-group-addon" id="basic-addon1"><i class="glyphicon glyphicon-envelope"></i></span>
          <input type="email" name="email" class="form-control" placeholder="Email" aria-describedby="basic-addon1">
        </div>
        <div class="input-group">
          <span class="input-group-addon" id="basic-addon1"><i class="glyphicon glyphicon-lock"></i></span>
          <input type="password" name="password" class="form-control" placeholder="Password" aria-describedby="basic-addon1">

        </div>
        <div class="pull-right">
          <a href="#" class="text-info">Lupa password ?</a>
        </div>
        <div class="clearfix"></div>
        <div class="input-group" style="margin-bottom:0">
          <button type="submit" class="btn btn-primary">Login</button>
          <span class="text-danger" id="notif">Maaf, login gagal !</span>
        </div>
      </div>
    </div>
    <div class="col-md-4"></div>
  </div>
</div>

<script type="text/javascript" src="assets/js/jquery.min.js"></script>
<script type="text/javascript">
  
  $('input').focus(function(event) {
    $(this).parent('div').removeClass('has-error');
    $('#notif').fadeOut('slow');
  });
  $('button').click(function(event) {
    var error = 0;
    $('#wrapper').find('input').each(function(index, el) {
     if($(this).val() === ''){
      $(this).parent('div').toggleClass('has-error');
      error += 1;
     }
    });
    if(error == 0){
        var email = $('input[name=email]').val(),
            password = $('input[name=password]').val();

      $.post('do-login.php', {email, password}, function(data, textStatus, xhr) {

        if(!data.result){
          $('input[name=email]').val('');
          $('input[name=password]').val('');
          
          $('#notif').fadeIn('slow');
        }
        else{
          window.location.href = 'http://cms.aidi/index.php/admin';
        }
      }, 'json');
    } 
  });
</script>

</body>
</html>