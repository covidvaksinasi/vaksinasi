<script type="text/javascript">
function Blank_TextField_Validator()
{
if (text_form.username.value == "")
{
   alert("Isi dulu username !");
   text_form.username.focus();
   return (false);
}
if (text_form.password.value == "")
{
   alert("Isi dulu password !");
   text_form.password.focus();
   return (false);
}
return (true);
}
-->
</script>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Login Admin</title>
      <link rel="stylesheet" href="aset/login/css/style.css">
</head>
<body>
</div></div>
<br><br><br>
<div class="formku">
   <div class="info">
    <h4> Login Admin</h4><br>
  </div>
  <form class="login-form" action="login.php" method="post" name="text_form" onsubmit="return Blank_TextField_Validator()">
<input type="text" name="username" id="username" placeHolder="&#xf007;  Username" style="font-family:Arial, FontAwesome" />
<input type="password" name="password" id="password" placeHolder="&#xf023;  Password" style="font-family:Arial, FontAwesome" />
<button type="submit" name="submit" class="button" onclick="return confirm('username dan password benar?')">Login</button>
  </form>
</div>
</body>

</html><script>
$('input[type="password"]').on('focus', () => {
  $('*').addClass('password');
}).on('focusout', () => {
  $('*').removeClass('password');
});;
</script>