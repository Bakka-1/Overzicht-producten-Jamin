<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jamin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .welcome-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            padding: 40px;
        }
        h1 {
            color: #333;
            margin-bottom: 10px;
        }
        .auth-links {
            position: absolute;
            top: 20px;
            right: 20px;
        }
        .auth-links a {
            margin-left: 15px;
            text-decoration: none;
            color: white;
            font-weight: bold;
        }
        .btn-custom {
            background-color: #667eea;
            border: none;
            padding: 12px 30px;
            font-size: 16px;
        }
        .btn-custom:hover {
            background-color: #764ba2;
        }
    </style>
</head>
<body>
    <div class="auth-links">
        @auth
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-link" style="color: white; text-decoration: none;">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Register</a>
        @endauth
    </div>

    <div class="welcome-container text-center" style="max-width: 600px;">
        <h1>🍬 Welkom bij Jamin!</h1>
        <p class="text-muted mb-4">Magazijnbeheer Systeem</p>
        
        <div class="row mt-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">📦 Leveranciers</h5>
                        <p class="card-text">Bekijk een overzicht van alle leveranciers en hun producten</p>
                        <a href="{{ route('leveranciers.index') }}" class="btn btn-custom btn-primary">Ga naar overzicht</a>
                    </div>
                </div>
            </div>
        </div>

        @guest
            <div class="mt-5 alert alert-info">
                <p>Je moet eerst <a href="{{ route('login') }}">inloggen</a> om het systeem te gebruiken.</p>
            </div>
        @endguest
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
