<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMt23cez/3paNdF+Z5pD1F1dT5V5z5F5z5F5z5" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<script>
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init();
    });
</script>
<style>
    .logout-btn {
        background-color: #dc3545;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 5px;
        font-size: 14px;
        transition: background-color 0.3s ease;
    }

    .logout-btn:hover {
        background-color: #c82333;
    }
</style>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">Projeto Web UTFPR</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($_SESSION['usuario'])): ?>
                        <li class="nav-item">
                            <a href="/index.php?action=logout" class="logout-btn">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="/views/auth/login.php">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="/views/auth/register.php">Registrar</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>