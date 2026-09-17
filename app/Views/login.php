<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - Taller de Confección</title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>

<body class="bg-light">

    <div class="container">

        <div class="row justify-content-center align-items-center vh-100">

            <div class="col-md-5 col-lg-4">

                <div class="card shadow">

                    <div class="card-body p-4">

                        <div class="text-center mb-4">

                            <h2>Taller de Confección</h2>

                            <p class="text-muted">
                                Municipalidad de Pirapó
                            </p>

                        </div>

                        <form action="<?= base_url('login/ingresar') ?>" method="post">
                            <div class="mb-3">

                                <label class="form-label">
                                    Usuario
                                </label>

                                 <input
                                    type="text"
                                    name="nombre_usuario"
                                    class="form-control"
                                    placeholder="Ingrese su usuario"
                                    required
                                > 

                            </div>

                            <div class="mb-3">

                                <label class="form-label">
                                    Contraseña
                                </label>

                                <input
                                    type="password"
                                    name="contrasena"
                                    class="form-control"
                                    placeholder="Ingrese su contraseña"
                                    required
                                >

                            </div>

                            <button
                                type="submit"
                                class="btn btn-primary w-100"
                            >
                                Ingresar
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>