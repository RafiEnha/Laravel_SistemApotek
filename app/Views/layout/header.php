<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1">

    <title>Tes Kemampuan Programming Natusi</title>

    <!-- Bootstrap CSS -->
    <link
        rel="stylesheet"
        href="/assets/bootstrap/css/bootstrap.min.css">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .app-navbar {
            height: 56px;
        }

        .app-sidebar {
            --bs-offcanvas-width: 260px;
            top: 56px;
            bottom: 0;
            height: auto;
        }

        .sidebar-link {
            padding: 10px 12px;
            border-radius: 8px;
            margin-bottom: 4px;
        }

        .sidebar-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
    </style>

</head>

<body>


    <!-- Navbar -->

    <nav class="navbar navbar-light bg-dark border-bottom app-navbar">

        <div class="container-fluid">

            <button
                class="btn btn-dark text-white"
                type="button"
                data-bs-toggle="offcanvas"
                data-bs-target="#sidebar"
                aria-controls="sidebar">
                ☰
            </button>

            <span class="navbar-brand mb-0 h1 ms-3 text-white">

                Sistem Apotek

            </span>

        </div>

    </nav>