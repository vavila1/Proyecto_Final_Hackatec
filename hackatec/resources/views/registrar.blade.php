<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Hackatec | Registro</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="/vendor/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">¡Registrate!</h1>
                                @if ($errors->any())
                                        @foreach ($errors->all() as $error)
                                            <p style="color:rgb(187, 9, 9)">*{{ $error }}</p>
                                        @endforeach    
                                @endif
                            </div>
                            <form class="user" method="POST" action="{{route('post_r')}}">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user" id="nombre"
                                            placeholder="Nombre" name="nombre">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user" id="apellido"
                                            placeholder="Apellido" name="apellido">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" id="correo"
                                        placeholder="Correo Electrónico" name="correo">
                                </div>
                                <div class="form-group row">
                                    <div class="col-12">
                                        <input type="password" class="form-control form-control-user"
                                            id="contra" placeholder="Contraseña" name="contra">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-6"></div>
                                    <div class="col-6">
                                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" onclick="myFunction()">
                                        <label class="form-check-label" for="defaultCheck1">
                                        Mostrar Contraseña
                                        </label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Registrar Cuenta
                                </button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="forgot-password.html">Forgot Password?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="{{route('login')}}">¿Ya tienes una cuenta? ¡Inicia sesión!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="/vendor/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="/vendor/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="/vendor/js/sb-admin-2.min.js"></script>
    <script type="text/javascript">
        function myFunction() {
  var x = document.getElementById("contra");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
    </script>

</body>

</html>